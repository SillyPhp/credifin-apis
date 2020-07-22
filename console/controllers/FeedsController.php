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
        $type = 'Jobs';
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
            $child_node_slug = $dom->createElement('link', '<![CDATA['.$object['link'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('name', '<![CDATA['.$object['name'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('region', '<![CDATA['.$object['city'].', '.$object['country'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('salary', '<![CDATA['.$object['salary'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('description', '<![CDATA['.$object['description'].'<br>'.$object['education_req'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('apply_url', '<![CDATA['.$object['link'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('company', '<![CDATA['.$object['organization_name'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('pubdate', '<![CDATA['.$object['pubdate'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('updated', '<![CDATA['.$object['updated'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('expire', '<![CDATA['.$object['expire'].']]>');
            $node->appendChild($child_node_slug);
            $child_node_slug = $dom->createElement('type', '<![CDATA['.$object['type'].']]>');
            $node->appendChild($child_node_slug);
            $root->appendChild($node);
        }
        $dom->appendChild($root);
        $dom->save($base_path.DIRECTORY_SEPARATOR.$xml_file_name);
        echo "$xml_file_name has been successfully created";
    }
}