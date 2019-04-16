<?php

namespace account\models\templates;

class TemplateQuestionnaire extends \common\models\QuestionnaireTemplates {

    private $questionnaireType;
    private $limit;
    private $pageNumber;
    private $where = [];
    private $orderBy = [];

    private function __setOptions($options = []) {
        if ($options) {
            $this->limit = ((int) $options['limit']) ? $options['limit'] : NULL;
            $this->pageNumber = ((int) $options['pageNumber']) ? $options['pageNumber'] : 1;
            $this->where = ($options['where']) ? $options['where'] : [];
            $this->orderBy = ($options['orderBy']) ? $options['orderBy'] : [];
            $this->questionnaireType = ($options['questionnaireType']) ? $options['questionnaireType'] : NULL;
        }
    }

    public function getQuestionnaire($options = []) {
        $this->__setOptions($options);
        $questionnaire = self::find()
            ->alias('a')
            ->select(['questionnaire_enc_id id', 'questionnaire_name', 'questionnaire_for','is_bookmared'])
            ->joinWith(['bookmarkedQuestionnaireTemplates b'],false)
            ->where(['is_deleted' => 0]);

        if ($this->questionnaireType) {
            $questionnaire->andWhere(['like', 'questionnaire_for', '"' . $this->questionnaireType . '"']);
        }

        if ($this->where) {
            $questionnaire->andWhere($this->where);
        }

        $total = $questionnaire->count();

        if ($this->limit) {
            $offset = ($this->pageNumber - 1) * $this->limit;
            $questionnaire->limit($this->limit)
                ->offset($offset);
        }

        if ($this->orderBy) {
            $questionnaire->orderBy($this->orderBy);
        }

        return [
            'total' => $total,
            'data' => $questionnaire->asArray()->all(),
        ];
    }

}
