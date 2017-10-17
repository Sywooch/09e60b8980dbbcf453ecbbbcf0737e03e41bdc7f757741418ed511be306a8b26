<?php

namespace app\modules\news\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CategorySearch represents the model behind the search form of `app\modules\news\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['published'], 'integer'],
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
        $query = Category::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'defaultOrder' => [
			        //'published' => SORT_DESC,
			        'id' => SORT_ASC,
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
            'published' => $this->published,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
?>
