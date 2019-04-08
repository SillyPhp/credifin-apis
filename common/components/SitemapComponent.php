<?php

namespace common\components;

use Yii;
use yii\base\Component;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;
use yii\helpers\FileHelper;
use yii\db\Query;
use yii\helpers\Url;
use common\models\ApplicationTypes;
use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\Users;
use common\models\UserTypes;

class SitemapComponent extends Component
{

    public function generate()
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

    private function addUrls(Sitemap $sitemap)
    {
        $sitemap->addItem(Url::to('/', true), null, Sitemap::ALWAYS, 1);
        $baseUrls = [
            '/employers',
            '/about-us',
            '/contact-us',
            '/jobs',
            '/internships',
        ];
        $orgdata = $this->AddOrgUrls();
//        $userdata = $this->AddUserUrls();
        $applicationdata = $this->AddApplicationUrls();
        foreach ($orgdata as $d) {
            $sitemap->addItem(Url::toRoute($d['slug'], true), null, null, null);
        }
//        foreach ($userdata as $ud) {
//            $sitemap->addItem(Url::toRoute($ud['username'], true), null, null, null);
//        }
        foreach ($applicationdata as $ad) {
            $sitemap->addItem(Url::toRoute($ad['application'], true), null, null, null);
        }
        foreach ($baseUrls as $baseUrl) {
            $sitemap->addItem(Url::toRoute($baseUrl, true), null, null, null);
        }
    }

    public function AddOrgUrls()
    {
        $query = (new Query())
            ->from([Organizations::tableName()])
            ->select(['CONCAT("/", slug) slug'])
            ->where(['is_deleted' => 0, 'status' => 'Active'])
            ->orderBy('id');

        foreach ($query->batch() as $org) {
            return $org;
        }
    }

    private function AddUserUrls()
    {
        $query = (new Query())
            ->from(['a' => Users::tableName()])
            ->select(['CONCAT("/", a.username) username'])
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active'])
            ->leftJoin(['b' => UserTypes::tableName()], 'a.user_type_enc_id = b.user_type_enc_id')
            ->orderBy('a.id');

        foreach ($query->batch() as $users) {
            return $users;
        }
    }

    private function AddApplicationUrls()
    {
        $query = (new Query())
            ->from(['a' => EmployerApplications::tableName()])
            ->select(['(CASE WHEN b.name = "Jobs" THEN CONCAT("/job/", a.slug) ELSE CONCAT("/internship/", a.slug) END) as application'])
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active'])
            ->leftJoin(['b' => ApplicationTypes::tableName()], 'a.application_type_enc_id = b.application_type_enc_id')
            ->orderBy('a.id');

        foreach ($query->batch() as $applications) {
            return $applications;
        }
    }

}