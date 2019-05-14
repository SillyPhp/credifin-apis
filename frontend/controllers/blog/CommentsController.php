<?php

namespace frontend\controllers\blog;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use yii\helpers\Url;
use common\models\Posts;
use common\models\PostComments;

class CommentsController extends Controller
{

    public function actionGetParentComments()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $q = Yii::$app->request->post('param');

            $post = Posts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $result = PostComments::find()
                ->alias('a')
                ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END img'])
                ->joinWith(['userEnc b'], false)
                ->where(['a.reply_to' => NULL])
                ->andWhere(['a.post_enc_id' => $post['post_enc_id']])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($result as $r) {
                $a = PostComments::find()
                    ->where(['reply_to' => $r['comment_enc_id']])
                    ->andWhere(['post_enc_id' => $r['post_enc_id']])
                    ->andWhere(['is_deleted' => 0])
                    ->exists();
                if ($a) {
                    $result[$i]['hasChild'] = true;
                } else {
                    $result[$i]['hasChild'] = false;
                }
                $i++;
            }

            return [
                'status' => 200,
                'result' => $result
            ];
        }
    }

    public function actionGetChildComments()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $q = Yii::$app->request->post('param');
            $parent = Yii::$app->request->post('parent');

            $post = Posts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $result = PostComments::find()
                ->alias('a')
                ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END img'])
                ->joinWith(['userEnc b'], false)
                ->where(['a.reply_to' => $parent])
                ->andWhere(['a.post_enc_id' => $post['post_enc_id']])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            return [
                'status' => 200,
                'result' => $result
            ];
        }
    }

    public function actionParentComment()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $comment = Yii::$app->request->post('comment');
            $q = Yii::$app->request->post('param');

            $post = Posts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $current_user = Yii::$app->user->identity->user_enc_id;

            if ($a = $this->saveComment($comment, $post['post_enc_id'], $current_user, NULL)) {
                $user_info = [
                    'logo' => Yii::$app->user->identity->image,
                    'username' => Yii::$app->user->identity->username,
                    'path' => Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image,
                    'color' => Yii::$app->user->identity->initials_color,
                    'name' => Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name,
                    'comment_enc_id' => $a
                ];
                return [
                    'status' => 200,
                    'user_info' => $user_info
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }

        }

    }

    public function actionChildComment()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $comment = Yii::$app->request->post('reply');
            $reply_id = Yii::$app->request->post('parent_id');
            $q = Yii::$app->request->post('param');

            $post = Posts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $current_user = Yii::$app->user->identity->user_enc_id;

            if ($a = $this->saveComment($comment, $post['post_enc_id'], $current_user, $reply_id)) {
                $user_info = [
                    'logo' => Yii::$app->user->identity->image,
                    'username' => Yii::$app->user->identity->username,
                    'path' => Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image,
                    'color' => Yii::$app->user->identity->initials_color,
                    'name' => Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name,
                    'comment_enc_id' => $a
                ];
                return [
                    'status' => 200,
                    'user_info' => $user_info
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }
        }
    }

    private function saveComment($comment, $post_enc_id, $current_user, $reply_id = NULL)
    {
        $commentModel = new PostComments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $commentModel->comment_enc_id = $utilitiesModel->encrypt();
        $commentModel->comment = $comment;
        $commentModel->reply_to = $reply_id;
        $commentModel->post_enc_id = $post_enc_id;
        $commentModel->user_enc_id = $current_user;
        $commentModel->created_on = date('Y-m-d H:i:s');
        if ($commentModel->save()) {
            return $commentModel->comment_enc_id;
        } else {
            return false;
        }
    }

}