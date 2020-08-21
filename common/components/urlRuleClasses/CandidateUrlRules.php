<?php

namespace common\components\urlRuleClasses;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use Yii;

class CandidateUrlRules extends BaseObject implements UrlRuleInterface
{
    public $mode;
    public $verb;
    public $suffix;
    public $normalizer;
    public $host;
    public $pattern;
    protected $placeholders = [];
    public $defaults = [];
    private $_routeParams = [];
    private $_routeRule;
    public $route;
    public $name;
//    /**
//     * Set [[mode]] with this value to mark that this rule is for URL parsing only.
//     */
//    const PARSING_ONLY = 1;
    /**
     * Set [[mode]] with this value to mark that this rule is for URL creation only.
     */
    const CREATION_ONLY = 2;

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'candidates/index') {
            if (isset($params['locations'], $params['skills'])) {
                return $params['locations'] . '/' . $params['skills'];
            } elseif (isset($params['skills'])) {
                return $params['skills'];
            }
        }
        return false; // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
//        $params = explode('/', $pathInfo);
        print_r($pathInfo);exit();
//        $pattrens = 'candidates-in-<locations:[0-9a-zA-Z\-]+>/skills-<skills:[0-9a-zA-Z\-]+>';
        $pattrens = '/\bfilter\b/i';
//        $matches = [
//            'skills' => NULL,
//            'locations' => NULL,
//        ];
//        $pattrens = '/^(&[' . $symbolsForReference . ']+)/';
//        if (preg_match('candidates-in-<locations:[0-9a-zA-Z\-]+>/skills-<skills:[0-9a-zA-Z\-]+>', $pathInfo, $matches)) {
        if (preg_match($pattrens, $pathInfo, $matches)) {
            print_r($matches);
            exit();

        }
        print_r($pathInfo);
        exit();
        return false; // this rule does not apply

//        if ($this->mode === self::CREATION_ONLY) {
//            return false;
//        }
//
//        if (!empty($this->verb) && !in_array($request->getMethod(), $this->verb, true)) {
//            return false;
//        }
//
//        $suffix = (string)($this->suffix === null ? $manager->suffix : $this->suffix);
//        $pathInfo = $request->getPathInfo();
//        $normalized = false;
//        if ($this->hasNormalizer($manager)) {
//            $pathInfo = $this->getNormalizer($manager)->normalizePathInfo($pathInfo, $suffix, $normalized);
//        }
//
//        if ($suffix !== '' && $pathInfo !== '') {
//            $n = strlen($suffix);
//            if (substr_compare($pathInfo, $suffix, -$n, $n) === 0) {
//                $pathInfo = substr($pathInfo, 0, -$n);
//                if ($pathInfo === '') {
//                    // suffix alone is not allowed
//                    return false;
//                }
//            } else {
//                return false;
//            }
//        }
//
//        if ($this->host !== null) {
//            $pathInfo = strtolower($request->getHostInfo()) . ($pathInfo === '' ? '' : '/' . $pathInfo);
//        }
//
//        $this->pattern = '/\bcandidates-in\b/i';
//        if (!preg_match($this->pattern, $pathInfo, $matches)) {
//            return false;
//        }
//
//        $matches = $this->substitutePlaceholderNames($matches);
//
//        foreach ($this->defaults as $name => $value) {
//            if (!isset($matches[$name]) || $matches[$name] === '') {
//                $matches[$name] = $value;
//            }
//        }
//        $params = $this->defaults;
//        $tr = [];
//        foreach ($matches as $name => $value) {
//            if (isset($this->_routeParams[$name])) {
//                $tr[$this->_routeParams[$name]] = $value;
//                unset($params[$name]);
//            } elseif (isset($this->_paramRules[$name])) {
//                $params[$name] = $value;
//            }
//        }
//        if ($this->_routeRule !== null) {
//            $route = strtr($this->route, $tr);
//        } else {
//            $route = $this->route;
//        }
//
//        Yii::debug("Request parsed with URL rule: {$this->name}", __METHOD__);
//
//        if ($normalized) {
//            // pathInfo was changed by normalizer - we need also normalize route
//            return $this->getNormalizer($manager)->normalizeRoute([$route, $params]);
//        }
//
//        return [$route, $params];
    }

    protected function hasNormalizer($manager)
    {
        return $this->getNormalizer($manager) instanceof UrlNormalizer;
    }

    protected function getNormalizer($manager)
    {
        if ($this->normalizer === null) {
            return $manager->normalizer;
        }

        return $this->normalizer;
    }
    protected function substitutePlaceholderNames(array $matches)
    {
        foreach ($this->placeholders as $placeholder => $name) {
            if (isset($matches[$placeholder])) {
                $matches[$name] = $matches[$placeholder];
                unset($matches[$placeholder]);
            }
        }

        return $matches;
    }
    private function trimSlashes($string)
    {
        if (strncmp($string, '//', 2) === 0) {
            return '//' . trim($string, '/');
        }

        return trim($string, '/');
    }
}