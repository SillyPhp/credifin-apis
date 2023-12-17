<?php
namespace common\models\credit;
use common\models\CreditLoanApplicationReports;
use common\models\CreditRequestedData;
use common\models\CreditResponseData;
use JonnyW\PhantomJs\Client;
use yii\helpers\Url;
use common\models\spaces\Spaces;
use Yii;
class Process
{
    private static $sourceUrl = [
      "CIBIL" =>"/script/credit-cibil-html",
      "EQUIFAX" =>"/script/credit-equifax",
      "CRIF" =>"/script/credit-crif",
    ];
    public static function EquifaxCrReport($data, $userId)
    {
        $source = 'EQUIFAX';
        if($fetch = self::fetchPreviousReports($data, $source)){
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            if (!empty($fetch['file_url'])){
                $parsedUrl = parse_url($fetch['file_url']);
                $path = $parsedUrl['path'];
                $path = ltrim($path, '/');
                $url = $my_space->signedURL($path, "15 minutes");
                return [
                    "code" => 200,
                    "status" => true,
                    "message" => 'success',
                    "PdfLink" => $url,
                    "filename" => $fetch['filename']
                ];
            }else{
                $get = [
                    'loan_app_enc_id'=>$data['loan_app_enc_id'],
                    'loan_co_app_enc_id'=>$data['loan_co_app_enc_id'],
                    'source'=>$source
                    ];
                $options = [
                    'method'=>'POST',
                    'url'=>Url::to(self::$sourceUrl[$source], 'https'),
                    'source'=>$source
                ];
              return  self::generatePDF($get,$fetch['response_enc_id'],$options);
            }
        }
        $requestedArray = [
            "RequestHeader" => [
                "CustomerId" => Yii::$app->params->credit->equifax->phf->dev->custId,
                "UserId" => Yii::$app->params->credit->equifax->phf->dev->UserId,
                "Password" => Yii::$app->params->credit->equifax->phf->dev->Password,
                "MemberNumber" => Yii::$app->params->credit->equifax->phf->dev->MemberNumber,
                "SecurityCode" => Yii::$app->params->credit->equifax->phf->dev->securityDigit,
                "CustRefField" => Yii::$app->security->generateRandomString(8),
                "ProductCode" => [
                    "PCS"
                ]
            ],
            "RequestBody" => [
                "InquiryPurpose" => $data['inquiryPurpose'],
                "TransactionAmount" => $data['transectionAmount'],
                "FirstName" => $data['firstName'],
                "MiddleName" => $data['middleName'],
                "LastName" => $data['lastName'],
                "InquiryAddresses" => $data['address'],
                "InquiryPhones" => $data['phones'],
                "IDDetails" => $data['iddetails'],
                "DOB" => $data['dob'],
                "Gender" => $data['gender']
            ],
            "Score" => [
                [
                    "Type" => "ERS",
                    "Version" => "4.0"
                ]
            ]
        ];
        $ch = curl_init(Yii::$app->params->credit->equifax->phf->dev->endPoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestedArray));
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
        if (isset($response['CCRResponse']['CIRReportDataLst'][0]['Error'])) {
            return [
                "code" => 500,
                "message" => "Missing Information in Request",
                "status" => false,
                "response" => $response['CCRResponse']['CIRReportDataLst'][0]['Error'],
            ];
        } else {
            if (isset($response['CCRResponse']) && !empty($response['CCRResponse'])) {
                return self::saveDetails($data, $userId, $response, $source);
            } else {
                return [
                    "code" => 500,
                    "message" => "No Credit information found of this user or may be server issue on equifax side please check after some time",
                    "status" => false,
                    "response" => "No Credit information found of this user or may be server issue on equifax side please check after some time",
                ];
            }
        }
    }

    private static function saveDetails($data, $userId, $response, $source,$docId=null,$token=null)
    {
        $transaction = Yii::$app->db->beginTransaction();
        unset($data['tokenValue']);
        try {
            //transection properties start//
            $model = new CreditRequestedData();
            $model->request_enc_id = Yii::$app->security->generateRandomString(12);
            $model->request_source = $source;
            $model->request_body = gzcompress(json_encode($data));
            $model->created_by = $userId;
            if (!$model->save()) {
                $transaction->rollBack();
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
            } else {
                $Creditresponse = new CreditResponseData();
                $Creditresponse->response_enc_id = Yii::$app->security->generateRandomString(12);
                $Creditresponse->request_enc_id = $model->request_enc_id;
                $Creditresponse->response_body = gzcompress(json_encode($response));
                $Creditresponse->created_by = $userId;
                if (!$Creditresponse->save()) {
                    $transaction->rollBack();
                    throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($Creditresponse->errors, 0, false)));
                } else {
                    $credit_report = new CreditLoanApplicationReports();
                    $credit_report->report_enc_id = Yii::$app->security->generateRandomString(12);
                    $credit_report->loan_app_enc_id = $data['loan_app_enc_id'];
                    $credit_report->response_enc_id = $Creditresponse->response_enc_id;
                    $credit_report->created_by = $userId;
                    $credit_report->loan_co_app_enc_id = (!empty($data['loan_co_app_enc_id']) ? $data['loan_co_app_enc_id'] : null);
                    if (!$credit_report->save()) {
                        $transaction->rollBack();
                        throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($credit_report->errors, 0, false)));
                    } else {
                        $transaction->commit();
                        $options = [
                            'method'=>'POST',
                            'url'=>Url::to(self::$sourceUrl[$source], 'https'),
                            'source'=>$source
                        ];
                        if ($source=="EQUIFAX"):
                            $res = [
                                'loan_app_enc_id'=>$credit_report->loan_app_enc_id,
                                'loan_co_app_enc_id'=>(($credit_report->loan_co_app_enc_id)?$credit_report->loan_co_app_enc_id:null),
                                'source'=>$source
                            ];
                        elseif ($source=="CIBIL"):
                            $res = [
                                "id"=>$docId,
                                "token"=>$token
                            ];
                        elseif ($source=="CRIF"):
                            $res = [
                                'loan_app_enc_id'=>$credit_report->loan_app_enc_id,
                                'loan_co_app_enc_id'=>(($credit_report->loan_co_app_enc_id)?$credit_report->loan_co_app_enc_id:null),
                                'source'=>$source
                            ];
                            endif;
                        return self::generatePDF($res, $Creditresponse->response_enc_id,$options);
                    }
                }
            }
        } catch (\Exception $exception) {
            //transection properties end//
            $transaction->rollBack();
            return [
                "code" => 500,
                "message" => $exception->getMessage(),
                "status" => false,
            ];
        }
    }

    private static function generatePDF($content, $responseID,$options)
    {
        $root = Yii::$app->params->phantom->path;
        $client = Client::getInstance();
        $p = $root . '/bin/phantomjs';
        $client->getEngine()->setPath($p);
        $request = $client->getMessageFactory()->createPdfRequest();
        $response = $client->getMessageFactory()->createResponse();
        $client->getEngine()->addOption('--ssl-protocol=any');
        $client->getEngine()->addOption('--ignore-ssl-errors=true');
        $client->getEngine()->addOption('--web-security=false');
        $request->setMethod($options['method']);
        $request->setUrl($options['url']);
        $request->setRequestData($content); // Set post or get data
        $fileName = Yii::$app->security->generateRandomString(8) . '.pdf';
        $savePath = $root . '/api/bin/credit/woJYaiektm/' . $fileName;
        $request->setOutputFile($savePath);
        $request->setFormat('A4');
        $request->setOrientation('landscape');
        if ($options['source']=="CIBIL"):
            $request->setPaperSize(1200,900);
        endif;
        if ($options['source']=="CRIF"):
            $request->setPaperSize(1400,900);
        endif;
        $request->setMargin('1cm');
        $client->send($request, $response);
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($request->getOutputFile(), "files/loans/credit-documents/woJYaiektm/" . $fileName, "private", ['params' => ['ContentDisposition' => ""]]);
        unlink($request->getOutputFile());
        if ($response->getStatus() === 200) {
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            self::SavePDfFile($result['ObjectURL'], $fileName, $responseID);
            $parsedUrl = parse_url($result['ObjectURL']);
            $path = $parsedUrl['path'];
            $path = ltrim($path, '/');
            $url = $my_space->signedURL($path, "15 minutes");
            return [
                "code" => 200,
                "status" => true,
                "message" => 'success',
                "PdfLink" => $url,
                "filename" => $fileName
            ];
        } else {
            return [
                "code" => 500,
                "status" => false,
                "message" => 'failed to generate PDF On Server Side,Data has been saved to database',
            ];
        }
    }

    private static function SavePDfFile($url, $filename, $id)
    {
        $model = CreditResponseData::findOne(['response_enc_id' => $id]);
        $model->file_url = $url;
        $model->filename = $filename;
        $model->save();
    }

    public static function fetchPreviousReports($option, $source)
    {
        $currentDateMinus30Days = date('Y-m-d', strtotime('-30 days'));
        $query = [];
        if (!empty($option['loan_app_enc_id']) && !empty($option['loan_co_app_enc_id'])) {
            $query = CreditLoanApplicationReports::find()
                ->alias('a')
                ->select(['a.id', 'b.response_enc_id', 'b.response_body','c.request_enc_id', 'a.report_enc_id', 'b.file_url', 'b.filename', 'a.created_on'])
                ->innerJoinWith(['responseEnc b' => function ($x) use ($source) {
                    $x->innerJoinWith(['requestEnc c' => function ($x) use ($source) {
                        $x->andWhere(['c.request_source' => $source]);
                    }], false);
                }], false)
                ->andWhere(['>=', 'b.created_on', $currentDateMinus30Days])
                ->andWhere([
                    'a.loan_app_enc_id' => $option['loan_app_enc_id'],
                    'a.loan_co_app_enc_id' => $option['loan_co_app_enc_id'],
                    'a.is_deleted' => 0
                ])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->one();
        }
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public static function CibilCrReport($params, $userId){
        $source = 'CIBIL';
        if($fetch = self::fetchPreviousReports($params, $source)) {
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            if (!empty($fetch['file_url'])) {
                $parsedUrl = parse_url($fetch['file_url']);
                $path = $parsedUrl['path'];
                $path = ltrim($path, '/');
                $url = $my_space->signedURL($path, "15 minutes");
                return [
                    "code" => 200,
                    "status" => true,
                    "message" => 'success',
                    "PdfLink" => $url,
                    "filename" => $fetch['filename']
                ];
            } else {
                $doc = json_decode($fetch['response_body'], true);
                $doc  = self::searchForKey($doc,'Document');
                $res =self::getCibilToken();
                if ($res['status']){
                    $options = [
                        'method' => 'POST',
                        'url' => Url::to(self::$sourceUrl[$source], 'https'),
                        'source'=>$source
                    ];
                    $res = [
                        "id"=>$doc[0]['Id'],
                        "token"=>$res['token']
                    ];
                    return self::generatePDF($res, $fetch['response_enc_id'], $options);
                }
            }
        }
        $res =self::getCibilToken();
        if ($res['status']){
            return self::getCibilReport($params,$res['token'],$userId,$source);
        }else{
            return [
                "code" => 500,
                "status" => false,
                "message" => 'Unable to generate token',
            ];
        }
    }

    private static function getCibilReport($data,$token,$userId,$source){
        $purpose = null;
        if (isset($data['inquiryPurpose'])&&!empty($data['inquiryPurpose'])):
            $purpose = $data['inquiryPurpose'];
        else:
            $purpose = '05';
        endif;

        $jayParsedAry = [
            "RequestInfo" => [
                "SolutionSetName" => "GO_Phf_Leasing_AGSS",
                "ExecuteLatestVersion" => "true"
            ],
            "Fields" => [
                "Applicants" => [
                    "Applicant" => [
                        "ApplicantType" => $data['Applicant']['ApplicantType'],
                        "ApplicantFirstName" => $data['Applicant']['ApplicantFirstName'],
                        "ApplicantMiddleName" => $data['Applicant']['ApplicantMiddleName'],
                        "ApplicantLastName" => $data['Applicant']['ApplicantLastName'],
                        "DateOfBirth" => $data['Applicant']['DateOfBirth'],
                        "Gender" => $data['Applicant']['Gender'],
                        "Identifiers" => $data['Applicant']['Identifiers'],
                        "Telephones" => $data['Applicant']['Telephones'],
                        "Addresses" =>$data['Applicant']['Addresses'],
                        "Services" => [
                            "Service" => [
                                "Id" => "CORE",
                                "Operations" => [
                                    "Operation" => [
                                        [
                                            "Name" => "ConsumerCIR",
                                            "Params" => [
                                                "Param" => [
                                                    [
                                                        "Name" => "CibilBureauFlag",
                                                        "Value" => "false"
                                                    ],
                                                    [
                                                        "Name" => "Amount",
                                                        "Value" => $data['transectionAmount']
                                                    ],
                                                    [
                                                        "Name" => "Purpose",
                                                        "Value" => $purpose
                                                    ],
                                                    [
                                                        "Name" => "ScoreType",
                                                        "Value" => "16"
                                                    ],
                                                    [
                                                        "Name" => "MemberCode",
                                                        "Value" => Yii::$app->params->credit->cibil->phf->dev->memberCode
                                                    ],
                                                    [
                                                        "Name" => "Password",
                                                        "Value" => Yii::$app->params->credit->cibil->phf->dev->memberPassword
                                                    ],
                                                    [
                                                        "Name" => "FormattedReport",
                                                        "Value" => "true"
                                                    ],
                                                    [
                                                        "Name" => "GSTStateCode",
                                                        "Value" => "03"
                                                    ]
                                                ]
                                            ]
                                        ],
                                        [
                                            "Name" => "IDV",
                                            "Params" => [
                                                "Param" => [
                                                    [
                                                        "Name" => "IDVerificationFlag",
                                                        "Value" => "True"
                                                    ],
                                                    [
                                                        "Name" => "ConsumerConsentForUIDAIAuthentication",
                                                        "Value" => "N"
                                                    ],
                                                    [
                                                        "Name" => "GSTStateCode",
                                                        "Value" => "03"
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "ApplicationData" => [
                    "GSTStateCode" => "03",
                    "Services" => [
                        "Service" => [
                            "Id" => "CORE",
                            "Skip" => "N",
                            "Consent" => "true"
                        ]
                    ]
                ]
            ]
        ];
        $ch = curl_init(Yii::$app->params->credit->cibil->phf->dev->endpointReportUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($jayParsedAry));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type:application/json",
            "Authorization:Bearer $token",
        ]);
        $response = curl_exec($ch);
        $response = json_decode($response,true);
        $error = self::searchForKey($response,'Errors');
        curl_close($ch);
        if (isset($error)&&!empty($error)) {
            return [
                "code" => 500,
                "message" => "Missing Information in Request",
                "status" => false,
                "response" => $error
            ];
        } else {
            $doc = self::searchForKey($response,'Document');
            if (isset($doc[0]['Id']) && !empty($doc[0]['Id'])) {
                return self::saveDetails($data, $userId, $response, $source,$doc[0]['Id'],$token);
            } else {
                return [
                    "code" => 500,
                    "message" => "No Credit information found of this user or may be server issue on cibil side please check after some time",
                    "status" => false,
                    "response" => "No Credit information found of this user or may be server issue on cibil side please check after some time",
                ];
            }
        }
    }
    private static function getCibilToken(){
        try{
            $ch = curl_init(Yii::$app->params->credit->cibil->phf->dev->endpointTokenUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=password&username='.Yii::$app->params->credit->cibil->phf->dev->username.'&password='.Yii::$app->params->credit->cibil->phf->dev->password);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
            ]);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);
            if (isset($response['access_token'])){
                return [
                    "status"=>true,
                    "token"=>$response['access_token']
                ];
            }else{
                return [
                    "code" => 500,
                    "status" => false,
                    "message" => 'Unable to generate token',
                ];
            }
        }catch (\Exception $exception){
            return [
                "code" => 500,
                "status" => false,
                "message" => $exception->getMessage(),
            ];
        }
    }
    private static function searchForKey($array, $key) {
        $results = array();
        if (is_array($array)) {
            foreach ($array as $subarray) {
                if (is_array($subarray)) {
                    if (array_key_exists($key, $subarray)) {
                        $results[] = $subarray[$key];
                    } else {
                        $results = array_merge($results, self::searchForKey($subarray, $key));
                    }
                }
            }
        }

        return $results;
    }

    public static function CrifCrReport($params, $userId)
    {
        $source = 'CRIF';
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        if($fetch = self::fetchPreviousReports($params, $source)){
            if (!empty($fetch['file_url'])){
                $parsedUrl = parse_url($fetch['file_url']);
                $path = $parsedUrl['path'];
                $path = ltrim($path, '/');
                $url = $my_space->signedURL($path, "15 minutes");
                return [
                    "code" => 200,
                    "status" => true,
                    "message" => 'success',
                    "PdfLink" => $url,
                    "filename" => $fetch['filename']
                ];
            }else{
                $get = [
                    'loan_app_enc_id'=>$params['loan_app_enc_id'],
                    'loan_co_app_enc_id'=>$params['loan_co_app_enc_id'],
                    'source'=>$source
                ];
                $options = [
                    'method'=>'POST',
                    'url'=>Url::to(self::$sourceUrl[$source], 'https'),
                    'source'=>$source
                ];
                return  self::generatePDF($get,$fetch['response_enc_id'],$options);
            }
        }
        $crifuserId = Yii::$app->params->credit->crif->phf->dev->UserId;
        $password = Yii::$app->params->credit->crif->phf->dev->Password;
        $Mbrid = Yii::$app->params->credit->crif->phf->dev->Mbrid;
        $SMbrid = Yii::$app->params->credit->crif->phf->dev->SMbrid;
        $productType = Yii::$app->params->credit->crif->phf->dev->productType;
        $productVersion = Yii::$app->params->credit->crif->phf->dev->productVersion;
        $reqVolType = Yii::$app->params->credit->crif->phf->dev->reqVolType;
        $currentDate = date('d-m-Y');
        $data = preg_replace('/\s*\R\s*/', ' ', trim($params['data']));
        $requestedXml = "<REQUEST-REQUEST-FILE><HEADER-SEGMENT><SUB-MBR-ID>$SMbrid</SUB-MBR-ID><INQ-DT-TM>$currentDate</INQ-DT-TM><REQ-VOL-TYP>C01</REQ-VOL-TYP><REQ-ACTN-TYP>SUBMIT</REQ-ACTN-TYP><TEST-FLG>N</TEST-FLG><AUTH-FLG>Y</AUTH-FLG><AUTH-TITLE>USER</AUTH-TITLE><RES-FRMT>XML/HTML</RES-FRMT><MEMBER-PRE-OVERRIDE>N</MEMBER-PRE-OVERRIDE><RES-FRMT-EMBD>Y</RES-FRMT-EMBD><LOS-NAME></LOS-NAME><LOS-VENDER></LOS-VENDER><LOS-VERSION>1.0</LOS-VERSION><MFI><INDV>false</INDV><SCORE>false</SCORE><GROUP>false</GROUP></MFI><CONSUMER><INDV>false</INDV><SCORE>false</SCORE></CONSUMER><IOI>true</IOI></HEADER-SEGMENT>$data</REQUEST-REQUEST-FILE>";
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => Yii::$app->params->credit->crif->phf->dev->endpointUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "requestXML: $requestedXml",
                "userId: $crifuserId",
                "password: $password",
                "mbrid: $Mbrid",
                "productType: $productType",
                "productVersion: $productVersion",
                "reqVolType: $reqVolType",
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($response);
        $responseJson = json_encode($xml);
        $responseJsonDecode = json_decode($responseJson,TRUE);
        $error = self::searchForKey($responseJsonDecode, 'ERROR');
        $report = self::searchForKey($responseJsonDecode, 'PRINTABLE-REPORT');
        if (isset($error[0]) && !empty($error[0])) {
            return [
                "code" => 422,
                "message" => "Some Information is not Correct in Request",
                "status" => false,
                "response" => $error[0]
            ];
        }else if (isset($report[0]['FILE-NAME'])&&!empty($report[0]['FILE-NAME'])) {
            return self::saveDetails($params, $userId, $response, $source);
        }else{
            return [
                "code" => 500,
                "message" => "Server Side Issue in Crif Report",
                "status" => false,
                "response" => "Server Side Issue in Crif Report"
            ];
        }
    }
}