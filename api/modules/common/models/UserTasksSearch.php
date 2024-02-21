<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserTasks;

class UserTasksSearch extends UserTasks {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'is_completed', 'is_deleted'], 'integer'],
            [['user_task_enc_id', 'name', 'assigned_to', 'status', 'created_on', 'created_by', 'last_updated_on', 'last_updated_by'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = UserTasks::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'key' => 'user_task_enc_id',
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_completed' => $this->is_completed,
            'is_deleted' => $this->is_deleted,
            'created_on' => $this->created_on,
            'last_updated_on' => $this->last_updated_on,
        ]);

        $query->andFilterWhere(['like', 'user_task_enc_id', $this->user_task_enc_id])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'assigned_to', $this->assigned_to])
                ->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'created_by', $this->created_by])
                ->andFilterWhere(['like', 'last_updated_by', $this->last_updated_by]);

        return $dataProvider;
    }

}
