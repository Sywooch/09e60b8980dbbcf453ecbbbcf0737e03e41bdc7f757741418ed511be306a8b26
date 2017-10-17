<?php

namespace app\modules\communication\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\communication\models\Communication;

/**
 * communicationSearch represents the model behind the search form of `app\modules\communication\models\communication`.
 */
class CommunicationSearch extends Communication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'pin', 'status'], 'integer'],
            [['text','is_pin', 'created_at', 'updated_at'], 'safe'],
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
        $query = communication::find()->with('user');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'pagination' => [
		        'pageSize' => 5,
		        //'pageSizeLimit' => [0, 3],
	        ],
	        'sort' => [
		        'defaultOrder' => [
			        'id' => SORT_DESC,
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'pin_main' => $this->pin,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

	    if($this->is_pin){
		    $query->where('pin = 1');
	    }

	    $query->andwhere('status = :status', [':status' => self::STATUS_ACTIVE]);
        $query->andFilterWhere(['like', 'text', $this->text]);
        return $dataProvider;
    }
}
