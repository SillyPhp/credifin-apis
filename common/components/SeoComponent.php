<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\Seo;
use yii\helpers\Url;

class SeoComponent extends Component
{
    public function setSeoByRoute($route, $object)
    {
        if ($route) {
            $seoDetails = Seo::find()
                ->where([
                    "route" => $route,
                    "status" => 1,
                    "is_deleted" => 0,
                ])
                ->one();

            if ($seoDetails) {
                $object->view->title = $seoDetails->title;
                if ($seoDetails->featured_image) {
                    $image = $seoDetails->featured_image;
                } else {
                    $image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
                }
                $object->view->params['seo_tags'] = [
                    'rel' => [
                        'canonical' => Url::to(Yii::$app->request->url,true),
                    ],
                    'name' => [
                        'keywords' => $seoDetails->keywords,
                        'description' => $seoDetails->description,
                        'twitter:card' => $seoDetails->twitter_card,
                        'twitter:title' => $seoDetails->twitter_title,
                        'twitter:description' => $seoDetails->description,
                        'twitter:site' => '@' . Yii::$app->params->social->twitter->username,
                        'twitter:creator' => '@' . Yii::$app->params->social->twitter->username,
                        'twitter:image' => $image,
                        'robots' => 'follow',
                    ],
                    'property' => [
                        'og:locale' => 'en',
                        'og:type' => 'website',
                        'og:site_name' => Yii::$app->params->site_name,
                        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
                        'og:title' => $seoDetails->og_title,
                        'og:description' => $seoDetails->og_description,
                        'og:image' => $image,
                        'fb:app_id' => Yii::$app->params->social->facebook->appId,
                    ],
                ];
            }
        }
        return false;
    }

}