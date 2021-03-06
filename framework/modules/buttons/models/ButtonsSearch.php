<?php

namespace app\modules\buttons\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ButtonsSearch represents the model behind the search form of `app\modules\buttons\models\Buttons`.
 */
class ButtonsSearch extends Buttons {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'section', 'section_id', 'published'], 'integer'],
            [['title', 'url', 'telephone', 'image', 'created_at', 'updated_at'], 'safe'],
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
        $query = Buttons::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 150,
            //'pageSizeLimit' => [0, 3],
            ]
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
            'section' => $this->section,
            'published' => $this->published,
            'section_id' => $this->section_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'url', $this->url])
                ->andFilterWhere(['like', 'telephone', $this->telephone])
                ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }

}
