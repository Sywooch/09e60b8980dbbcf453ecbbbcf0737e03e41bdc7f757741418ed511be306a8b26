<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class ClientsSearch extends Clients
{
    public $fio;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activate', 'status'], 'integer'],
            [
                [
                    'first_name', 'middle_name',
                    'last_name', 'email', 'phone',
                    'password_hash', 'salt',
                    'auth_key', 'profile', 'password_reset_token', 'auth_id', 'auth_service',
                    'auth_url',
                    'fio'
                ], 'safe'],
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
        $query = Clients::find();

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
            'activate' => $this->activate,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->fio])
            ->orFilterWhere(['like', 'middle_name', $this->fio])
            ->orFilterWhere(['like', 'last_name', $this->fio])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'salt', $this->salt])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'profile', $this->profile])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'auth_id', $this->auth_id])
            ->andFilterWhere(['like', 'auth_service', $this->auth_service])
            ->andFilterWhere(['like', 'auth_url', $this->auth_url]);

        return $dataProvider;
    }
}
