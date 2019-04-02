<?php

namespace common\components;

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
//        $tmpPath = Yii::getAlias('@runtime/sitemapGenerate');
//        FileHelper::removeDirectory($tmpPath);
//        FileHelper::createDirectory($tmpPath . '/sitemap');
        $sitemap = new Sitemap(Yii::getAlias('@rootDirectory' . '/sitemap/item.xml'));
//        $sitemap->setMaxUrls(50000);
        $this->addUrls($sitemap);
        $sitemap->write();
        $sitemapIndex = new Index(Yii::getAlias('@rootDirectory/sitemap' . '/sitemap.xml'));
        $sitemapFiles = $sitemap->getSitemapUrls(Url::to('/sitemap/', true));
        foreach ($sitemapFiles as $sitemapFile) {
            $sitemapIndex->addSitemap($sitemapFile);
        }
        $sitemapIndex->write();
        //Copy prepared sitemap files to @webroot
//        $sitemapFilePath = Yii::getAlias('@rootDirectory/sitemap/sitemap.xml');
//        $sitemapIndexPath = Yii::getAlias('@rootDirectory/sitemap');
//        if (file_exists($sitemapFilePath)) {
//            unlink($sitemapFilePath);
//        }
//        FileHelper::removeDirectory($sitemapIndexPath);
//        copy($tmpPath . '/sitemap.xml', $sitemapFilePath);
//        FileHelper::copyDirectory($tmpPath . '/sitemap', $sitemapIndexPath);
//        FileHelper::removeDirectory($tmpPath);
    }

    private function addUrls(Sitemap $sitemap)
    {
        $sitemap->addItem(Url::to('/', true), null, Sitemap::ALWAYS, 1);
        $baseUrls = [
            'site/about-us', 'site/contact-us','site/index'
        ];
        foreach ($baseUrls as $baseUrl) {
            $sitemap->addItem(Url::toRoute($baseUrl, true), null, Sitemap::WEEKLY, 0.2);
        }
//        foreach ($this->getDocUrls() as $docsUrl) {
//            // TODO different prio per version
//            $sitemap->addItem(Url::to($docsUrl, true), null, Sitemap::DAILY, 0.3);
//        }
        //news
//        $sitemap->addItem(Url::toRoute(['news/index'], true), null, Sitemap::HOURLY, 0.3);
//        foreach (News::find()->latest()->published()->asArray()->each(100) as $news) {
//            $url = Url::to(['news/view', 'id' => $news['id'], 'name' => $news['slug']], true);
//            $updateTime = strtotime($news['updated_at'] ?? $news['created_at']);
//            $sitemap->addItem($url, $updateTime, null, 0.3);
//        }
        // wiki
//        foreach (Wiki::find()->latest()->each(1000) as $wiki) {
//            /** @var Wiki $wiki */
//            $url = Url::to($wiki->getUrl(), true);
//            $updateTime = strtotime($wiki['updated_at'] ?? $wiki['created_at']);
//            $sitemap->addItem($url, $updateTime, null, 0.3);
//        }
        // extensions
//        foreach (Extension::find()->latest()->each(1000) as $extension) {
//            /** @var Extension $extension */
//            $url = Url::to($extension->getUrl(), true);
//            $updateTime = strtotime($extension['updated_at'] ?? $extension['created_at']);
//            $sitemap->addItem($url, $updateTime, null, 0.3);
//        }
    }

    public function AddOrgUrls($url){
        $sitemap = new Sitemap(Yii::getAlias('@rootDirectory' . '/sitemap/item.xml'));
        $sitemap->addItem($url, time(), Sitemap::DAILY, 0.3);
//        $this->addUrls($sitemap);
        $sitemap->write();
        $sitemapIndex = new Index(Yii::getAlias('@rootDirectory/sitemap' . '/sitemap.xml'));
        $sitemapFiles = $sitemap->getSitemapUrls(Url::to('/sitemap/', true));
        foreach ($sitemapFiles as $sitemapFile) {
            $sitemapIndex->addSitemap($sitemapFile);
        }
        $sitemapIndex->write();
    }

}