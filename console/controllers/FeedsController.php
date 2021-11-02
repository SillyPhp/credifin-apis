<?php
namespace console\controllers;
use common\models\ApplicationPlacementCities;
use common\models\ApplicationTypes;
use common\models\ApplicationUnclaimOptions;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Utilities;
use common\models\RandomColors;
use common\models\EmployerApplications;
use common\models\UnclaimedOrganizations;
use common\models\Usernames;
use frontend\models\xml\ApplicationFeeds;
use yii\helpers\Url;
use Yii;
use yii\console\Controller;

class FeedsController extends Controller {
    public function actionXmlFeeds($offset = 0, $limit = 3000,$type='Jobs')
    {
        $params = [];
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['type'] = $type;
        $obj = new ApplicationFeeds();
        $objects = $obj->getApplications($params);
        $dom = new \DOMDocument();
        $dom->encoding = 'utf-8';
        $dom->xmlVersion = '1.0';
        $dom->formatOutput = true;
        $base_path = Url::to('@rootDirectory/files/xml');
        $xml_file_name = $type.'-Feeds.xml';
        $root = $dom->createElement('jobs');
        $i = time().rand(100, 100000);
        foreach ($objects as $object)
        {
            $node = $dom->createElement('job');
            $attr_node_id = new \DOMAttr('id', $i++);
            $node->setAttributeNode($attr_node_id);
            $name = $node->appendChild($dom->createElement('link'));
            $name->appendChild($dom->createCDATASection($object['link']));

            $name = $node->appendChild($dom->createElement('name'));
            $name->appendChild($dom->createCDATASection($object['name']));

            $name = $node->appendChild($dom->createElement('region'));
            $name->appendChild($dom->createCDATASection($object['city'].', '.$object['country']));

            $name = $node->appendChild($dom->createElement('salary'));
            $name->appendChild($dom->createCDATASection($object['salary']));

            $name = $node->appendChild($dom->createElement('description'));
            $name->appendChild($dom->createCDATASection($object['description'].'<br>'.$object['education_req']));

            $name = $node->appendChild($dom->createElement('apply_url'));
            $name->appendChild($dom->createCDATASection($object['link']));

            $name = $node->appendChild($dom->createElement('company'));
            $name->appendChild($dom->createCDATASection($object['organization_name']));

            $name = $node->appendChild($dom->createElement('pubdate'));
            $name->appendChild($dom->createCDATASection($object['pubdate']));

            $name = $node->appendChild($dom->createElement('updated'));
            $name->appendChild($dom->createCDATASection($object['updated']));

            $name = $node->appendChild($dom->createElement('expire'));
            $name->appendChild($dom->createCDATASection($object['expire']));

            $name = $node->appendChild($dom->createElement('type'));
            $name->appendChild($dom->createCDATASection($object['type']));
            $root->appendChild($node);
        }
        $dom->appendChild($root);
        $dom->save($base_path.DIRECTORY_SEPARATOR.$xml_file_name);
        echo "$xml_file_name has been successfully created";
    }
    public function actionFetchMuse($start,$end)
    {
        echo $this->muse($start,$end);
    }
    public function actionFetchGit($start,$end)
    {
        echo $this->git($start,$end);
    }
    private function git($start,$end)
    {
        $type = ApplicationTypes::findOne(['name' => 'Jobs']);
        $othr = Categories::findOne(['name'=>'Others']);
        for($i=$start;$i<=$end;$i++){
            $page = $i;
            $url = "https://jobs.github.com/positions.json?page=".$page;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $header = [
                'Accept: application/json, text/plain, */*',
                'Content-Type: application/json;charset=utf-8',
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $results = curl_exec($ch);
            $results = json_decode($results, true);
            if (isset($results)&&count($results)>0){
                foreach ($results as $result)
                {
                    $r = EmployerApplications::find()
                        ->where(['source'=>2])
                        ->andWhere(['unique_source_id'=>strval($result['id'])])
                        ->one();
                    if (empty($r))
                    {
                        $employerApplication = new EmployerApplications();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $employerApplication->application_enc_id = $utilitiesModel->encrypt();
                        $employerApplication->application_number = rand(1000, 10000) . time();
                        $employerApplication->application_type_enc_id = $type->application_type_enc_id;
                        $employerApplication->published_on = date('Y-m-d H:i:s');
                        $employerApplication->image = '1';
                        $employerApplication->status = 'Active';
                        $category_execute = Categories::find()
                            ->alias('a')
                            ->where(['name' => $result['title']]);
                        $chk_cat = $category_execute->asArray()->one();
                        if (empty($chk_cat)) {
                            $categoriesModel = new Categories;
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
                            $categoriesModel->name = $result['title'];
                            $utilitiesModel->variables['name'] = $result['title'];
                            $utilitiesModel->variables['table_name'] = Categories::tableName();
                            $utilitiesModel->variables['field_name'] = 'slug';
                            $categoriesModel->slug = $utilitiesModel->create_slug();
                            $categoriesModel->created_by = null;
                            if ($categoriesModel->save()) {
                                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $employerApplication, 'Jobs',$result['company'],$result['name'],null,null,$othr->category_enc_id);
                            } else {
                                print_r($categoriesModel->getErrors());
                            }
                        } else {
                            $chk_assigned = $category_execute
                                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                                ->andWhere(['b.parent_enc_id' => null])
                                ->andWhere(['b.assigned_to' => 'Jobs'])
                                ->asArray()
                                ->one();
                            if (empty($chk_assigned)) {
                                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $employerApplication, 'Jobs',$result['company'],$result['title'],null,null,$othr->category_enc_id);
                            } else {
                                $employerApplication->title = $chk_assigned['assigned_category_enc_id'];
                                $utilitiesModel->variables['name'] = $result['company'] . '-' . $chk_assigned['name'];
                                $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
                                $utilitiesModel->variables['field_name'] = 'slug';
                                $employerApplication->slug = $utilitiesModel->create_slug();
                            }
                        }
                        $employerApplication->type = $result['type'];
                        $employerApplication->preferred_gender = '0';
                        $employerApplication->timings_from = date("H:i:s", strtotime("9:00"));
                        $employerApplication->timings_to = date("H:i:s", strtotime("5:00"));
                        $employerApplication->joining_date = date('Y-m-d H:i:s');
                        $employerApplication->last_date = date('Y-m-d', strtotime(' + 56 days'));
                        $employerApplication->created_on = date('Y-m-d H:i:s');
                        $employerApplication->created_by = null;
                        $employerApplication->source = 2;
                        $employerApplication->unique_source_id = strval($result['id']);
                        $chk_com = UnclaimedOrganizations::find()
                            ->select(['organization_enc_id'])
                            ->where(['name' => $result['company']])
                            ->one();
                        if (!empty($chk_com)) :
                            $employerApplication->unclaimed_organization_enc_id = $chk_com->organization_enc_id;
                        else:
                            $model = new UnclaimedOrganizations();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $model->organization_enc_id = $utilitiesModel->encrypt();
                            $model->organization_type_enc_id = null;
                            $utilitiesModel->variables['name'] = $result['company'].rand(10, 1000);
                            $utilitiesModel->variables['table_name'] = UnclaimedOrganizations::tableName();
                            $utilitiesModel->variables['field_name'] = 'slug';
                            $slug = $utilitiesModel->create_slug();
                            $slug_replace_str = str_replace("-", "", $slug);
                            $model->slug = $slug;
                            $model->website = $result['company_url'];
                            $model->name = $result['company'];
                            $model->source = 1;
                            $model->created_by = null;
                            $model->initials_color = RandomColors::one();
                            $model->status = 1;
                            if ($model->save()) {
                                $username = new Usernames();
                                $username->username = $slug_replace_str;
                                $username->assigned_to = 3;
                                if (!$username->save()) {
                                    print_r($username->getErrors());
                                }
                                $employerApplication->unclaimed_organization_enc_id = $model->organization_enc_id;
                            }
                        endif;
                        if ($employerApplication->save()) {
                            $unclaimOptions = new ApplicationUnclaimOptions();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $unclaimOptions->unclaim_options_enc_id = $utilitiesModel->encrypt();
                            $unclaimOptions->application_enc_id = $employerApplication->application_enc_id;
                            $unclaimOptions->job_url = $result['url'];
                            $unclaimOptions->job_level = null;
                            $unclaimOptions->created_on = date('Y-m-d H:i:s');;
                            $unclaimOptions->created_by = null;
                            if (!$unclaimOptions->save()) {
                                print_r($unclaimOptions->getErrors()  );
                            }
                            $placementCity = new ApplicationPlacementCities();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $placementCity->placement_cities_enc_id = $utilitiesModel->encrypt();
                            $placementCity->application_enc_id = $employerApplication->application_enc_id;
                            $placementCity->location_name = $result['location'];
                            $placementCity->created_on = date('Y-m-d H:i:s');
                            $placementCity->created_by = null;
                            if (!$placementCity->save()) {
                                print_r($placementCity->getErrors());
                            }
                        }
                        else{
                            print_r($employerApplication->getErrors());
                        }
                    }
                }
            }
            else
            {
                break;
            }
        }
        echo 'success';
    }
    private function muse($start,$end)
    {
        $type = ApplicationTypes::findOne(['name' => 'Jobs']);
        $othr = Categories::findOne(['name'=>'Others']);
        $muse_key = 'ecc017e088bb50fd3d47686f1a669033492e98111bbe1c60084214e48b45fe07';
        for($i=$start;$i<=$end;$i++){
            $page = $i;
            $url = "https://www.themuse.com/api/public/jobs?api_key=" . $muse_key . "&page=" . $page;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $header = [
                'Accept: application/json, text/plain, */*',
                'Content-Type: application/json;charset=utf-8',
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
            $result = json_decode($result, true);
            if (isset($result['results'])&&count($result['results']>0)){
                foreach ($result['results'] as $result)
                {
                    $r = EmployerApplications::find()
                        ->where(['source'=>3])
                        ->andWhere(['unique_source_id'=>strval($result['id'])])
                        ->one();
                    if (empty($r))
                    {
                        $employerApplication = new EmployerApplications();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $employerApplication->application_enc_id = $utilitiesModel->encrypt();
                        $employerApplication->application_number = rand(1000, 10000) . time();
                        $employerApplication->application_type_enc_id = $type->application_type_enc_id;
                        $employerApplication->published_on = date('Y-m-d H:i:s',strtotime($result['publication_date']));
                        $employerApplication->image = '1';
                        $employerApplication->status = 'Active';
                        $category_execute = Categories::find()
                            ->alias('a')
                            ->where(['name' => $result['name']]);
                        $chk_cat = $category_execute->asArray()->one();
                        if (empty($chk_cat)) {
                            $categoriesModel = new Categories;
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
                            $categoriesModel->name = $result['name'];
                            $utilitiesModel->variables['name'] = $result['name'];
                            $utilitiesModel->variables['table_name'] = Categories::tableName();
                            $utilitiesModel->variables['field_name'] = 'slug';
                            $categoriesModel->slug = $utilitiesModel->create_slug();
                            $categoriesModel->created_by = null;
                            if ($categoriesModel->save()) {
                                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $employerApplication, 'Jobs',$result['company']['name'],$result['name'],3,$result['short_name'],$othr->category_enc_id);
                            } else {
                                print_r($categoriesModel->getErrors());
                            }
                        } else {
                            $chk_assigned = $category_execute
                                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                                ->andWhere(['b.parent_enc_id' => null])
                                ->andWhere(['b.assigned_to' => 'Jobs'])
                                ->asArray()
                                ->one();
                            if (empty($chk_assigned)) {
                                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $employerApplication, 'Jobs',$result['company']['name'],$result['name'],3,$result['short_name'],$othr->category_enc_id);
                            } else {
                                $employerApplication->title = $chk_assigned['assigned_category_enc_id'];
                                $employerApplication->slug = $result['short_name'];
                            }
                        }
                        $employerApplication->type = 'Full Time';
                        $employerApplication->preferred_gender = '0';
                        $employerApplication->timings_from = date("H:i:s", strtotime("9:00"));
                        $employerApplication->timings_to = date("H:i:s", strtotime("5:00"));
                        $employerApplication->joining_date = date('Y-m-d H:i:s');
                        $employerApplication->last_date = date('Y-m-d', strtotime(' + 56 days'));
                        $employerApplication->created_on = date('Y-m-d H:i:s');
                        $employerApplication->created_by = null;
                        $employerApplication->source = 3;
                        $employerApplication->unique_source_id = strval($result['id']);
                        $chk_com = UnclaimedOrganizations::find()
                            ->select(['organization_enc_id'])
                            ->where(['name' => $result['company']['name']])
                            ->one();
                        if (!empty($chk_com)) :
                            $employerApplication->unclaimed_organization_enc_id = $chk_com->organization_enc_id;
                        else:
                            $model = new UnclaimedOrganizations();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $model->organization_enc_id = $utilitiesModel->encrypt();
                            $model->organization_type_enc_id = null;
                            $model->slug = $result['company']['short_name'];
                            $slug_replace_str = str_replace("-", "", $result['company']['short_name']);
                            $model->website = null;
                            $model->name = $result['company']['name'];
                            $model->source = 2;
                            $model->created_by = null;
                            $model->initials_color = RandomColors::one();
                            $model->status = 1;
                            if ($model->save()) {
                                $username = new Usernames();
                                $username->username = $slug_replace_str;
                                $username->assigned_to = 3;
                                if (!$username->save()) {
                                    print_r($username->getErrors());
                                }
                                $employerApplication->unclaimed_organization_enc_id = $model->organization_enc_id;
                            }
                        endif;
                        if ($employerApplication->save()) {
                            $unclaimOptions = new ApplicationUnclaimOptions();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $unclaimOptions->unclaim_options_enc_id = $utilitiesModel->encrypt();
                            $unclaimOptions->application_enc_id = $employerApplication->application_enc_id;
                            $unclaimOptions->job_url = $result['refs']['landing_page'];
                            $unclaimOptions->job_level = (($result['levels'][0]['name'])?$result['levels'][0]['name']:null);
                            $unclaimOptions->created_on = date('Y-m-d H:i:s');;
                            $unclaimOptions->created_by = null;
                            if (!$unclaimOptions->save()) {
                                print_r($unclaimOptions->getErrors());
                            }
                            if (!empty($result['locations'])) {
                                foreach ($result['locations'] as $city) {
                                    $placementCity = new ApplicationPlacementCities();
                                    $utilitiesModel = new Utilities();
                                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                                    $placementCity->placement_cities_enc_id = $utilitiesModel->encrypt();
                                    $placementCity->application_enc_id = $employerApplication->application_enc_id;
                                    $placementCity->location_name = $city['name'];
                                    $placementCity->created_on = date('Y-m-d H:i:s');
                                    $placementCity->created_by = null;
                                    if (!$placementCity->save()) {
                                        print_r($placementCity->getErrors());
                                    }
                                }
                            }

                        }
                        else{
                            print_r($employerApplication->getErrors());
                        }
                    }
                }
            }
            else
            {
                break;
            }
        }
        echo 'success';
    }
    private function addNewAssignedCategory($category_id, $employerApplication, $typ,$company,$title,$source=null,$short_name=null,$cid)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->assigned_to = $typ;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = null;
        $assignedCategoryModel->parent_enc_id = $cid;
        $assignedCategoryModel->status = 'Pending';
        if ($assignedCategoryModel->save()) {
            if ($source==3){
                $employerApplication->slug = $short_name;
            }
            else
            {
                $utilitiesModel->variables['name'] =  $company. '-' . $title;
                $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $employerApplication->slug = $utilitiesModel->create_slug();
            }
            $employerApplication->title = $assignedCategoryModel->assigned_category_enc_id;
        } else {
            print_r($assignedCategoryModel->getErrors());
        }
    }
}