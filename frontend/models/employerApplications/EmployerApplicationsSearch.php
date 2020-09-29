<?php

namespace frontend\models\employerApplications;

use common\models\EmployerApplications;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EmployerApplicationsSearch represents the model behind the search form of `dsbedutech\models\EmployerApplications`.
 */
class EmployerApplicationsSearch extends EmployerApplications
{

    public $all_wage;
    public $app_title;
    public $parent_name;
    public $cmp_name;
    public $designation;
    public $pre_ind;
    public $city_name;
    public $app_type;
    public $org_ind;
    public $position;
    public $creator;
    public $creator_enc_id;
    public $country_id;
    public $created_on;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['all_wage', 'id', 'application_number', 'is_sponsored', 'is_featured', 'for_careers', 'is_deleted', 'application_for'], 'integer'],
            [['created_on', 'country_id', 'creator_enc_id', 'creator', 'position', 'org_ind', 'parent_name', 'app_type', 'city_name', 'designation', 'pre_ind', 'cmp_name', 'app_title', 'application_enc_id', 'organization_enc_id', 'application_type_enc_id', 'slug', 'description', 'title', 'designation_enc_id', 'type', 'preferred_industry', 'interview_process_enc_id', 'timings_from', 'timings_to', 'joining_date', 'last_date', 'experience', 'preferred_gender', 'published_on', 'image', 'image_location', 'created_on', 'created_by', 'last_updated_on', 'last_updated_by', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = EmployerApplications::find()->alias('z');
        $query->joinWith(['applicationTypeEnc a'], false);
        $query->joinWith(['applicationSkills aa' => function ($aa) {
            $aa->joinWith(['skillEnc aa1']);
        }], false);
        $query->joinWith(['applicationPlacementLocations b' => function ($a) {
            $a->joinWith(['locationEnc c' => function ($b) {
                $b->joinWith(['cityEnc d' => function ($d) {
                    $d->joinWith(['stateEnc d1' => function ($d1) {
                        $d1->joinWith(['countryEnc d2']);
                    }]);
                }]);
            }]);
        }], false);
        $query->joinWith(['title0 e' => function ($aa) {
            $aa->joinWith(['categoryEnc f']);
            $aa->joinWith(['parentEnc g']);
        }], false);
        $query->joinWith(['organizationEnc h' => function ($h) {
            $h->joinWith(['industryEnc s']);
        }], false);
        $query->joinWith(['designationEnc j'], false);
        $query->joinWith(['preferredIndustry k'], false);
        $query->joinWith(['applicationEducationalRequirements l'], false);
        $query->joinWith(['applicationJobDescriptions m'], false);
        $query->joinWith(['applicationOptions n' => function ($n) {
            $n->joinWith(['currencyEnc n1']);
        }], false);
        $query->joinWith(['applicationUnclaimOptions nn' => function ($nn) {
            $nn->joinWith(['currencyEnc nn1']);
        }], false);
        $query->joinWith(['unclaimedOrganizationEnc o'], false);
        $query->joinWith(['applicationPlacementCities p' => function ($p) {
            $p->joinWith(['cityEnc q' => function ($q) {
                $q->joinWith(['stateEnc v' => function ($v) {
                    $v->joinWith(['countryEnc u']);
                }]);
            }]);
        }], false);
        $query->joinWith(['createdBy r'], false);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'key' => 'application_enc_id',
            'pagination' => [
                'pageSize' => 200,
            ],
            'sort' => ['defaultOrder' => ['created_on' => SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['all_wage'] = [
            'asc' => ['n.fixed_wage' => SORT_ASC],
            'desc' => ['a.fixed_wage' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['country_id'] = [
            'asc' => ['u.country_enc_id' => SORT_ASC],
            'desc' => ['u.country_enc_id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['app_type'] = [
            'asc' => ['a.name' => SORT_ASC],
            'desc' => ['a.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['app_title'] = [
            'asc' => ['f.name' => SORT_ASC],
            'desc' => ['f.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['parent_name'] = [
            'asc' => ['g.name' => SORT_ASC],
            'desc' => ['g.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['cmp_name'] = [
            'asc' => ['h.name' => SORT_ASC, 'o.name' => SORT_ASC],
            'desc' => ['h.name' => SORT_DESC, 'o.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['designation'] = [
            'asc' => ['j.designation' => SORT_ASC],
            'desc' => ['j.designation' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['pre_ind'] = [
            'asc' => ['k.industry' => SORT_ASC],
            'desc' => ['k.industry' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['city_name'] = [
            'asc' => ['d.name' => SORT_ASC, 'q.name' => SORT_ASC],
            'desc' => ['d.name' => SORT_DESC, 'q.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['org_ind'] = [
            'asc' => ['d.name' => SORT_ASC, 's.industry' => SORT_ASC],
            'desc' => ['d.name' => SORT_DESC, 's.industry' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['position'] = [
            'asc' => ['d.name' => SORT_ASC, 'n.positions' => SORT_ASC],
            'desc' => ['d.name' => SORT_DESC, 'n.positions' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['creator'] = [
            'asc' => ['r.first_name' => SORT_ASC],
            'desc' => ['r.first_name' => SORT_DESC],
        ];

        // Lets do the same with country now
//        $dataProvider->sort->attributes['createdBy'] = [
//            'asc' => ['ab.first_name' => SORT_ASC],
//            'desc' => ['ab.first_name' => SORT_DESC],
//        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'z.application_number' => $this->application_number,
            'z.timings_from' => $this->timings_from,
            'z.timings_to' => $this->timings_to,
            'z.joining_date' => $this->joining_date,
            'z.last_date' => $this->last_date,
            'z.is_sponsored' => $this->is_sponsored,
            'z.is_featured' => $this->is_featured,
            'z.application_for' => $this->application_for,
            'z.for_careers' => $this->for_careers,
            'z.published_on' => $this->published_on,
            'z.last_updated_on' => $this->last_updated_on,
            'z.is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'z.application_enc_id', $this->application_enc_id])
            ->andFilterWhere(['like', 'z.organization_enc_id', $this->organization_enc_id])
            ->andFilterWhere(['like', 'z.application_type_enc_id', $this->application_type_enc_id])
            ->andFilterWhere(['like', 'z.slug', $this->slug])
            ->andFilterWhere(['like', 'z.description', $this->description])
            ->andFilterWhere(['like', 'z.title', $this->title])
            ->andFilterWhere(['like', 'z.designation_enc_id', $this->designation_enc_id])
            ->andFilterWhere(['like', 'z.type', $this->type])
            ->andFilterWhere(['like', 'z.preferred_industry', $this->preferred_industry])
            ->andFilterWhere(['like', 'z.interview_process_enc_id', $this->interview_process_enc_id])
            ->andFilterWhere(['like', 'z.experience', $this->experience])
            ->andFilterWhere(['like', 'z.preferred_gender', $this->preferred_gender])
            ->andFilterWhere(['like', 'z.image', $this->image])
            ->andFilterWhere(['like', 'z.image_location', $this->image_location])
            ->andFilterWhere(['like', 'z.created_by', $this->created_by])
            ->andFilterWhere(['like', 'z.created_on', $this->created_on])
            ->andFilterWhere(['like', 'z.last_updated_by', $this->last_updated_by])
            ->andFilterWhere(['like', 'z.status', $this->status])
            ->andFilterWhere(['like', 'a.name', $this->app_type])
            ->andFilterWhere(['like', 'f.name', $this->app_title])
            ->andFilterWhere(['like', 'g.name', $this->parent_name])
            ->andFilterWhere(['like', 's.industry', $this->org_ind])
            ->andFilterWhere(['like', 'z.created_on', $this->created_on])
            ->andFilterWhere(['or',
                ['like', 'h.name', $this->cmp_name],
                ['like', 'o.name', $this->cmp_name],
            ])
            ->andFilterWhere(['or',
                ['like', 'r.first_name', $this->creator],
                ['like', 'r.last_name', $this->creator],
            ])
            ->andFilterWhere(['or',
                ['like', 'n.fixed_wage', $this->all_wage],
                ['like', 'n.min_wage', $this->all_wage],
                ['like', 'n.max_wage', $this->all_wage],
            ])
            ->andFilterWhere(['like', 'k.industry', $this->pre_ind])
            ->andFilterWhere(['like', 'j.designation', $this->designation])
            ->andFilterWhere(['like', 'r.user_enc_id', $this->creator_enc_id])
            ->andFilterWhere(['like', 'u.country_enc_id', $this->country_id])
            ->andFilterWhere(['or',
                ['like', 'd.name', $this->city_name],
                ['like', 'q.name', $this->city_name],
            ]);

        return $dataProvider;
    }
}
