<?php

namespace api\modules\v4\models;

use common\models\FinancerRewards;
use common\models\FinancerRewardsOption;
use common\models\spaces\Spaces;
use mysql_xdevapi\Exception;
use yii\base\Model;
use common\models\Utilities;
use Yii;

class FinancerRewardsForm extends model
{
    public $loan_product_enc_id;
    public $name;
    public $short_description;
    public $image;
    public $start_date;
    public $end_date;
    public $terms;
    public $game_type;
    public $reward_options;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['loan_product_enc_id', 'name'], 'required'],
            [['short_description', 'image', 'start_date', 'end_date', 'status', 'game_type', 'terms', 'reward_options'], 'safe'],
            [['name', 'short_description'], 'trim'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    public function addReward($user)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $reward = new FinancerRewards();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $reward->financer_rewards_enc_id = $utilitiesModel->encrypt();
            $reward->financer_enc_id = $user->organization_enc_id;
            $reward->name = $this->name;
            $reward->loan_product_enc_id = $this->loan_product_enc_id;
            $reward->short_description = $this->short_description;
            $reward->start_date = $this->start_date;
            $reward->end_date = $this->end_date;
            $reward->status = !empty($this->status) ? $this->status : 'Active';
            $reward->game_type = !empty($this->game_type) ? $this->game_type : 'Wheel';
            $reward->terms = $this->terms;
            if (!empty($this->image)) {
                $reward->image = Yii::$app->getSecurity()->generateRandomString() . '.' . $this->image->extension;
                $reward->image_location = Yii::$app->getSecurity()->generateRandomString() . '/';
                $base_path = Yii::$app->params->upload_directories->form_apps->financer_rewards->image . $reward->image_location . $reward->image;

                $this->fileUpload($this->image, $base_path);
            }
            $reward->created_by = $user->user_enc_id;
            $reward->created_on = date('Y-m-d H:i:s');

         if (!$reward->save()){
                $transaction->rollBack();
                throw new \Exception(json_encode($reward->getErrors()));
            }
//              $reward_options = json_decode($this->reward_options, true);
            $reward_options = $this->reward_options;
            if (!empty($reward_options)) {
                foreach ($reward_options as $val) {
                    $reward_options = new FinancerRewardsOption();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $reward_options->financer_rewards_option_enc_id = $utilitiesModel->encrypt();
                    $reward_options->financer_rewards_enc_id = $reward->financer_rewards_enc_id;
                    $reward_options->option_name = $val['option_name'];
                    $reward_options->is_eligible = $val['is_eligible'];
                    $reward_options->background_color = !empty($val['background_color']) ? $val['background_color'] : null;
                    $reward_options->sequence = $val['sequence'];
                    $reward_options->text_color = !empty($val['text_color']) ? $val['text_color'] : null;
                    $reward_options->created_by = $user->user_enc_id;
                    $reward_options->created_on = date('Y-m-d H:i:s');
                    if (!$reward_options->save()) {
                        $transaction->rollBack();
                        throw new \Exception(json_encode($reward_options->getErrors()));
                    }
                }
            }

            $transaction->commit();
            return ['status' => 201, 'message' => 'Successfully Added'];


        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'Some Internal Server Error', 'error' => json_decode($exception->getMessage(), true)];
        }
    }

    private function fileUpload($image, $base_path)
    {
        $type = $image->type;

        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path, "public", ['params' => ['contentType' => $type]]);
        if (!$result) {
            throw new \Exception('error while uploading image');
        }
    }

}