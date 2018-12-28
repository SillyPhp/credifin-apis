<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%freelancers_data}}".
 *
 * @property int $id Primary Key
 * @property string $freelancer_data_enc_id Freelancer Data Encrypted ID
 * @property string $first_name First Name
 * @property string $last_name Last Email
 * @property string $email Email
 * @property string $phone Phone
 * @property string $job_type Job Type
 * @property string $portfolio Portfolio
 * @property string $description Description
 * @property string $skills Skills
 * @property string $created_on On which date Freelancer information was added to database
 */
class FreelancersData extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%freelancers_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['freelancer_data_enc_id', 'first_name', 'last_name', 'email', 'phone', 'job_type', 'description', 'skills', 'created_on'], 'required'],
            [['description', 'skills'], 'string'],
            [['created_on'], 'safe'],
            [['freelancer_data_enc_id', 'portfolio'], 'string', 'max' => 100],
            [['first_name', 'last_name', 'email', 'job_type'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['freelancer_data_enc_id'], 'unique'],
        ];
    }

}
