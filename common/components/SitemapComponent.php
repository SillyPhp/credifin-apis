<?php

namespace common\components;

use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\Users;
use Yii;
use yii\base\Component;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;
use yii\helpers\FileHelper;
//use yii\helpers\Json;
use yii\helpers\Url;

class SitemapComponent extends Component {

    public function Generate()
    {
        $tmpPath = Yii::getAlias('@runtime/sitemapGenerate');
        FileHelper::removeDirectory($tmpPath);
        FileHelper::createDirectory($tmpPath . '/sitemap');
        $sitemap = new Sitemap($tmpPath . '/sitemap/item.xml');
        $sitemap->setMaxUrls(5000);
        $this->addUrls($sitemap);
        $sitemap->write();
        $sitemapIndex = new Index($tmpPath . '/sitemap.xml');
        $sitemapFiles = $sitemap->getSitemapUrls(Url::to('/sitemap/', true));
        foreach ($sitemapFiles as $sitemapFile) {
            $sitemapIndex->addSitemap($sitemapFile);
        }
        $sitemapIndex->write();

//        Copy prepared sitemap files to @webroot
        $sitemapFilePath = Yii::getAlias('@rootDirectory/sitemap.xml');
        $sitemapIndexPath = Yii::getAlias('@rootDirectory/sitemap');
        if (file_exists($sitemapFilePath)) {
            unlink($sitemapFilePath);
        }
        FileHelper::removeDirectory($sitemapIndexPath);
        copy($tmpPath . '/sitemap.xml', $sitemapFilePath);
        FileHelper::copyDirectory($tmpPath . '/sitemap', $sitemapIndexPath);
        FileHelper::removeDirectory($tmpPath);
    }

//    public function Generate()
//    {
////        $tmpPath = Yii::getAlias('@runtime/sitemapGenerate');
////        FileHelper::removeDirectory($tmpPath);
////        FileHelper::createDirectory($tmpPath . '/sitemap');
//        $sitemap = new Sitemap(Yii::getAlias('@rootDirectory' . '/sitemap/item.xml'));
////        $sitemap->setMaxUrls(50000);
//        $this->addUrls($sitemap);
//        $sitemap->write();
//        $sitemapIndex = new Index(Yii::getAlias('@rootDirectory/sitemap' . '/sitemap.xml'));
//        $sitemapFiles = $sitemap->getSitemapUrls(Url::to('/sitemap/', true));
//        foreach ($sitemapFiles as $sitemapFile) {
//            $sitemapIndex->addSitemap($sitemapFile);
//        }
//        $sitemapIndex->write();
//        //Copy prepared sitemap files to @webroot
////        $sitemapFilePath = Yii::getAlias('@rootDirectory/sitemap/sitemap.xml');
////        $sitemapIndexPath = Yii::getAlias('@rootDirectory/sitemap');
////        if (file_exists($sitemapFilePath)) {
////            unlink($sitemapFilePath);
////        }
////        FileHelper::removeDirectory($sitemapIndexPath);
////        copy($tmpPath . '/sitemap.xml', $sitemapFilePath);
////        FileHelper::copyDirectory($tmpPath . '/sitemap', $sitemapIndexPath);
////        FileHelper::removeDirectory($tmpPath);
/// $sitemap->addItem($url, time(), Sitemap::DAILY, 0.3);
//    }

    private function addUrls(Sitemap $sitemap)
    {
        $sitemap->addItem(Url::to('/', true), null, Sitemap::ALWAYS, 1);
        $baseUrls = [
            'site/about-us', 'site/contact-us','site/index'
        ];
        $orgdata = $this->AddOrgUrls();
        $userdata = $this->AddUserUrls();
        $applicationdata = $this->AddApplicationUrls();
        foreach($orgdata as $d){
            $sitemap->addItem(Url::toRoute($d['slug'], true), null, null, null);
        }
        foreach($userdata as $ud){
            $sitemap->addItem(Url::toRoute($ud['username'], true), null, null, null);
        }
        foreach($applicationdata as $ad){
            $sitemap->addItem(Url::toRoute($ad['application'], true), null, null, null);
        }
        foreach ($baseUrls as $baseUrl) {
            $sitemap->addItem(Url::toRoute($baseUrl, true), null, null, null);
        }
    }

    private function AddOrgUrls(){
        return Organizations::find()
            ->select(['CONCAT("/", slug) slug'])
            ->where(['is_deleted' => 0, 'status' => 'Active'])
            ->asArray()
            ->all();
    }

    private function AddUserUrls(){
        return Users::find()
            ->alias('a')
            ->select(['CONCAT("/", a.username) username'])
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active'])
            ->joinWith(['userTypeEnc b' => function ($b){
                $b->andWhere(['b.user_type' => 'Individual'], false);
            }], false)
            ->asArray()
            ->all();
    }

    private function AddApplicationUrls(){
        return EmployerApplications::find()
            ->alias('a')
            ->select(['(CASE WHEN b.name = "Jobs" THEN CONCAT("/job/", a.slug) ELSE CONCAT("/internship/", a.slug) END) as application'])
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active'])
            ->joinWith(['applicationTypeEnc b'], false)
            ->asArray()
            ->all();
    }

}