<?php


class FrontendController extends Controller
{
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->condition = "published=1";
		$criteria->addCondition( "EXISTS (SELECT nid FROM {{news_data}} WHERE {{news_data}}.nid = t.id and  {{news_data}}.language=:lang and {{news_data}}.title != '' )" );
		$criteria->params= array(':lang'=> Yii::app()->request->getParam('language') );

		$criteria->with = array( 'news_data' => array('condition' => "title != ''") );
		$criteria->order = 'published_date desc, id desc';

		#$news = News::model()->with(array('news_data' => array('condition' => "title != ''"))
		$news = News::model()->findAll($criteria);

		echo JSON::encode($news);
		Yii::app()->end();

	}

	public function actionView($id)
	{
		$getNews = News::model()->with('news_data')->findByPK($id);
		echo JSON::encode($getNews);
		Yii::app()->end();

	}


}


