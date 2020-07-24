<?php
namespace console\controllers;
use frontend\models\xml\ApplicationFeeds;
use yii\helpers\Url;
use Yii;
use yii\console\Controller;

class FeedsController extends Controller {
    public function actionXmlFeeds($offset = 0, $limit = 3000,$type='Jobs')
    {
        $params = [];
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['type'] = $type;
        $obj = new ApplicationFeeds();
        $objects = $obj->getApplications($params);
        $dom = new \DOMDocument();
        $dom->encoding = 'utf-8';
        $dom->xmlVersion = '1.0';
        $dom->formatOutput = true;
        $base_path = Url::to('@rootDirectory/files/xml');
        $xml_file_name = $type.'-Feeds.xml';
        $root = $dom->createElement('jobs');
        $i = time().rand(100, 100000);
        foreach ($objects as $object)
        {
            $node = $dom->createElement('job');
            $attr_node_id = new \DOMAttr('id', $i++);
            $node->setAttributeNode($attr_node_id);
            $name = $node->appendChild($dom->createElement('link'));
            $name->appendChild($dom->createCDATASection($object['link']));

            $name = $node->appendChild($dom->createElement('name'));
            $name->appendChild($dom->createCDATASection($object['name']));

            $name = $node->appendChild($dom->createElement('region'));
            $name->appendChild($dom->createCDATASection($object['city'].', '.$object['country']));

            $name = $node->appendChild($dom->createElement('salary'));
            $name->appendChild($dom->createCDATASection($object['salary']));

            $name = $node->appendChild($dom->createElement('description'));
            $name->appendChild($dom->createCDATASection($object['description'].'<br>'.$object['education_req']));

            $name = $node->appendChild($dom->createElement('apply_url'));
            $name->appendChild($dom->createCDATASection($object['link']));

            $name = $node->appendChild($dom->createElement('company'));
            $name->appendChild($dom->createCDATASection($object['organization_name']));

            $name = $node->appendChild($dom->createElement('pubdate'));
            $name->appendChild($dom->createCDATASection($object['pubdate']));

            $name = $node->appendChild($dom->createElement('updated'));
            $name->appendChild($dom->createCDATASection($object['updated']));

            $name = $node->appendChild($dom->createElement('expire'));
            $name->appendChild($dom->createCDATASection($object['expire']));

            $name = $node->appendChild($dom->createElement('type'));
            $name->appendChild($dom->createCDATASection($object['type']));
            $root->appendChild($node);
        }
        $dom->appendChild($root);
        $dom->save($base_path.DIRECTORY_SEPARATOR.$xml_file_name);
        echo "$xml_file_name has been successfully created";
    }
}