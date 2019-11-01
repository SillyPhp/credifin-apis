<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%contributer_collaborator}}".
 *
 * @property int $id
 * @property string $contributer_collaborator_enc_id
 * @property string $name name of contributer
 * @property string $email email of contributer
 * @property string $youtube_channel channel link
 * @property string $comment any comment
 * @property int $is_deleted is_deleted 0 is false 1 is true
 */
class ContributerCollaborator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contributer_collaborator}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contributer_collaborator_enc_id', 'name', 'email', 'youtube_channel'], 'required'],
            [['name', 'email', 'youtube_channel','comment'], 'trim'],
            [['is_deleted'], 'integer'],
            [['contributer_collaborator_enc_id', 'name', 'youtube_channel'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['comment'], 'string', 'max' => 250],
        ];
    }


}
