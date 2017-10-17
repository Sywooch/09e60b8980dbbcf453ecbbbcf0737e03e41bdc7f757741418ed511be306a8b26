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

	class NewsSearch extends News {

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
				[['title','published'], 'safe']
			];
		}

		public function search($params, $type = null)
		{
			$query = News::find()->joinWith('data');

			$this->load($params);

			if($type == 'published')
				$query->andWhere(['=', 'published', self::STATUS_ACTIVE]);
			elseif($type == 'new')
				$query->andWhere(['=', 'published', self::STATUS_NEW]);
			elseif($type == 'hidden')
				$query->andWhere(['=', 'published', self::STATUS_HIDDEN]);

			$query->FilterWhere(['like', 'title', $this->title]);

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
					'sort' => ['defaultOrder' => ['type' => SORT_DESC, 'id' => SORT_DESC]],
				'pagination' => ['pageSize' => 5]
			]);

			if ($this->load($params) && !$this->validate()) {
				return $dataProvider;
			}
			
			return $dataProvider;
		}
		
		
		
		


	}

?>