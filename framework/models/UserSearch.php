<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','profile'], 'integer'],
            [['account_name'], 'string'],
            [['account_name', 'password', 'salt', 'first_name', 'last_name', 'account_email', 'admin_name', 'admin_type', 'projects', 'servers'], 'safe'],
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
        $query = User::find()->where(['status' => self::STATUS_ACTIVE]);

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
            'profile' => $this->profile,
        ]);

        $query->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'salt', $this->salt])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'account_email', $this->account_email])
            ->andFilterWhere(['like', 'admin_name', $this->admin_name])
            ->andFilterWhere(['like', 'admin_type', $this->admin_type])
            ->andFilterWhere(['like', 'projects', $this->projects])
            ->andFilterWhere(['like', 'servers', $this->servers]);

        return $dataProvider;
    }
}
