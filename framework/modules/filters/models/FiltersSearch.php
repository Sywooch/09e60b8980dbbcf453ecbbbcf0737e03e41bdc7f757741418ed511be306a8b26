<?php

namespace app\modules\filters\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CategorySearch represents the model behind the search form of `app\modules\filters\models\Category`.
 */
class FiltersSearch extends Filters
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'published', 'category_id'], 'integer'],
            [['title', 'image'], 'safe'],
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
        $query = Filters::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'defaultOrder' => [
			        //'published' => SORT_DESC,
			        'parent_id' => SORT_ASC,
			        //'id' => SORT_DESC,
		        ]
	        ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'parent_id' => $this->parent_id,
            'published' => $this->published,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
