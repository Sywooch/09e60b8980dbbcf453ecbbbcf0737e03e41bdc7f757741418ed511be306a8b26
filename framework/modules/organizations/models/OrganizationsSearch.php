<?php

namespace app\modules\organizations\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * OrganizationsSearch represents the model behind the search form of `app\modules\organizations\models\Organizations`.
 */
class OrganizationsSearch extends Organizations
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order'], 'integer'],
            [['name', 'published', 'description', 'image', 'category_id'], 'safe'],
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
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Organizations::find()->with('category');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'pagination' => [
		        'pageSize' => 30,
		        //'pageSizeLimit' => [0, 3],
	        ],
	        'sort' => [
		        'defaultOrder' => [
			        'category_id' => SORT_ASC,
			        'order' => SORT_ASC,

		        ]
	        ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'published' => $this->published,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image]);

	    //if((int) $this->category_id != 0){
		 //   $query->andwhere('FIND_IN_SET( :category, category_id)')->addParams([':category' => $this->category_id]);
	    //}

        return $dataProvider;
    }
}
