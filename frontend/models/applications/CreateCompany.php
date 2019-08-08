<?php
namespace frontend\models\applications;
use common\models\UnclaimedOrganizations;
use common\models\Usernames;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Utilities;

class CreateCompany extends Model
{
  public $logo;
  public $name;
  public $email;
  public $website;
  public $type;
  public $contact;
  public $description;

  public function formName()
  {
      return '';
  }

  public function rules()
  {
      return [
          [['name','type'],'required'],
          [['email','contact','website','type','description'],'safe'],
          [['website'], 'url', 'defaultScheme' => 'http'],
          [['name'],'string','max'=>50],
          [['contact'],'string','max'=>15],
          [['name','email','website','description'],'trim'],
          ['email','email'],
          [['logo'], 'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024, 'extensions' => 'png, jpg, gif'],
      ];
  }

  public function save()
  {
      $model = new UnclaimedOrganizations();
      $utilitiesModel = new Utilities();
      $utilitiesModel->variables['string'] = time() . rand(100, 100000);
      $model->organization_enc_id = $utilitiesModel->encrypt();
      $model->organization_type_enc_id = $this->type;
      $model->email = $this->email;
      $model->website = $this->website;
      $model->phone = $this->contact;
      $utilitiesModel->variables['name'] = $this->name.rand(1000, 100000);
      $utilitiesModel->variables['table_name'] = UnclaimedOrganizations::tableName();
      $utilitiesModel->variables['field_name'] = 'slug';
      $slug = $utilitiesModel->create_slug();
      $slug_replace_str = str_replace("-","",$slug);
      $model->slug = $slug_replace_str;
      $model->name = $this->name;
      $model->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id : null);
      $model->initials_color = '#73ef9c';
      $model->status = 1;
      if (!empty($this->logo)):
      $model->logo = $utilitiesModel->encrypt() . '.' . $this->logo->extension;
      $model->logo_location = Yii::$app->getSecurity()->generateRandomString();
      $base_path = Yii::$app->params->upload_directories->unclaimed_organizations->logo_path . $model->logo_location;
      if (!is_dir($base_path)) {
          if (!mkdir($base_path, 0755, true)) {
              return false;
          }
          $source_path = $base_path . DIRECTORY_SEPARATOR . $model->logo;
          $destinationPath = Yii::$app->params->empower_youth->upload_directories->unclaimed_organizations->logo_path . $model->logo_location;
          if (!$this->logo->saveAs($source_path)|| !Yii::$app->utilities->recurseCopy($source_path, $destinationPath, $model->logo)) {
              return false;
          }
      }
      endif;
      if ($model->save())
      {
          $username = new Usernames();
          $username->username = $slug_replace_str;
          $username->assigned_to = 3;
          if (!$username->save())
          {
              return false;
          }
          return true;
      }
      else
      {
          return false;
      }

  }
}