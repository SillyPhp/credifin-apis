<?php
namespace common\models;

/**
 * This is the model class for table "{{%drop_resume_choice_titles}}".
 *
 * @property int $id Primary Key
 * @property string $choice_enc_id Applied Title Encrypted ID
 * @property string $assigned_category_enc_id Foreign Key to  Assigned  Titles
 * @property string $title_for
 * @property string $created_on On which date  Titile information was added to database
 * @property string $created_by By which User  Title information was added
 * @property string $last_updated_on On which date  Title information was updated
 * @property string $last_updated_by By which User  Title information was updated
 * @property int $is_deleted Application Status (0 as active, 1 as Deleted)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property AssignedCategories $assignedCategoryEnc
 */
class DropResumeChoiceTitles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%drop_resume_choice_titles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'choice_enc_id', 'assigned_category_enc_id', 'title_for', 'created_by'], 'required'],
            [['id', 'is_deleted'], 'integer'],
            [['title_for'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['choice_enc_id', 'assigned_category_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['choice_enc_id'], 'unique'],
            [['id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategoryEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }
}
