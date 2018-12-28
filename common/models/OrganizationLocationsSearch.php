<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrganizationLocations;

class OrganizationLocationsSearch extends OrganizationLocations {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'sequence', 'is_deleted'], 'integer'],
            [['location_enc_id', 'organization_enc_id', 'location_name', 'email', 'description', 'website', 'phone', 'address', 'postal_code', 'city_enc_id', 'created_on', 'created_by', 'last_updated_on', 'last_updated_by', 'status'], 'safe'],
            [['latitude', 'longitude'], 'number'],
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
        $query = OrganizationLocations::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'sequence' => $this->sequence,
            'created_on' => $this->created_on,
            'last_updated_on' => $this->last_updated_on,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'location_enc_id', $this->location_enc_id])
                ->andFilterWhere(['like', 'organization_enc_id', $this->organization_enc_id])
                ->andFilterWhere(['like', 'location_name', $this->location_name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'website', $this->website])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'postal_code', $this->postal_code])
                ->andFilterWhere(['like', 'city_enc_id', $this->city_enc_id])
                ->andFilterWhere(['like', 'created_by', $this->created_by])
                ->andFilterWhere(['like', 'last_updated_by', $this->last_updated_by])
                ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

}
