<?php
/********************************
* Created by GoldenEye.
* ICQ 285652 / email : slims.alex@gmail.com
* WEB: http://scriptsweb.ru
* copyright 2010 - 2015
********************************/
namespace app\modules\news\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

	class CommentsSearch extends Comments {

		public $title;
		public $published;
		/**
		 * @inheritdoc
		 */
		public function scenarios()
		{
			// bypass scenarios() implementation in the parent class
			return Model::scenarios();
		}

		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return  [
				[['status'], 'safe']
			];
		}

		public function search($params)
		{
			$query = Comments::find()->with('news');

			$this->load($params);

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
					'sort' => ['defaultOrder' => ['status' => SORT_ASC, 'id' => SORT_DESC]],
				'pagination' => ['pageSize' => 5]
			]);

			if ($this->load($params) && !$this->validate()) {
				return $dataProvider;
			}
			
			return $dataProvider;
		}
		
		
		
		


	}

?>