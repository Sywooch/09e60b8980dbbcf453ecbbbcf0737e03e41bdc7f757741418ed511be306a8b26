<?php

namespace app\modules\shares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SharesSearch represents the model behind the search form of `app\modules\shares\models\Shares`.
 */
class SharesSearch extends Shares
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'published', 'pin_main', 'pin_poster', 'pin_filter'], 'integer'],
            [['name', 'description', 'address', 'image',  'category_id', 'telephone', 'url', 'url_video', 'url_descrition', 'end_at', 'created_at', 'updated_at'], 'safe'],
            [['price'], 'number'],
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
        $query = Shares::find()->with('category');

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
            'price' => $this->price,
            'published' => $this->published,
            'pin_main' => $this->pin_main,
            'pin_poster' => $this->pin_poster,
            'pin_filter' => $this->pin_filter,
            'end_at' => $this->end_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'url_video', $this->url_video])
            ->andFilterWhere(['like', 'url_descrition', $this->url_descrition]);

        return $dataProvider;
    }
}
