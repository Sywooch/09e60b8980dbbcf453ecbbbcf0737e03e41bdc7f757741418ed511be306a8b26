<?php

/* * ******************************
 * Created by GoldenEye.
 * ICQ 285652 / email : slims.alex@gmail.com
 * WEB: http://scriptsweb.ru
 * copyright 2010 - 2015
 * ****************************** */

namespace app\modules\news\models;

use app\modules\news\Module;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 * @property integer $id
 * @property integer $published
 * @property string $image
 * @property string $category_id
 * @property Data $data
 */
class News extends ActiveRecord {

    const TYPE_DEFAULT = 1;         # Default news
    const TYPE_FIXED = 2;           # Stick news
    const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 99;

    public static function tableName() {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function rules() {
        return [
            ['created_author', 'default', 'value' => \Yii::$app->user->getId(), 'on' => 'insert'],
            ['type', 'default', 'value' => self::TYPE_DEFAULT],
            [['published', 'type', 'category_id', 'seo_title', 'seo_description', 'seo_keywords', 'video_url', 'source_url'], 'safe'],
        ];
    }

    function attributeLabels() {
        return [
            'id' => Module::t('index', 'id'),
            'project' => Module::t('index', 'project'),
            'server' => Module::t('index', 'server'),
            'published' => Module::t('index', 'published'),
            'published_date' => Module::t('index', 'published_date'),
            'seo_title' => Module::t('index', 'seo.title'),
            'seo_description' => Module::t('index', 'seo.description'),
            'seo_keywords' => Module::t('index', 'seo.keywords'),
            'comments' => Module::t('index', 'comments.count'),
            'created_at' => Module::t('index', 'created.date'),
            'created_author' => Module::t('index', 'created.author'),
            'updated_at' => Module::t('index', 'updated.date'),
            'updated_author' => Module::t('index', 'updated.author'),
            'pic_url' => Module::t('index', 'pic.url'),
            'pic_loc' => Module::t('index', 'pic.loc'),
            'video_url' => Module::t('index', 'video.url'),
            'source_url' => Module::t('index', 'source.url'),
            'language' => Module::t('index', 'language'),
            'title' => Module::t('index', 'title'),
            'text' => Module::t('index', 'text'),
            'description' => Module::t('index', 'description'),
            'type' => Module::t('index', 'type'),
            'category_id' => Module::t('index', 'Раздел'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getData() {
        return $this->hasMany(Data::className(), ['nid' => 'id'])->indexBy('language');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage() {
        return $this->hasMany(NewsImage::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments() {
        return $this->hasMany(Comments::className(), ['news_id' => 'id'])
                        ->select('id, news_id, author,comment, created_at')
                        ->where(['status' => Comments::STATUS_ACTIVE])->orderBy('created_at desc');
    }

    /**
     * return News published status
     * @param $status
     * @return string
     */
    public function getPublished($status) {
        return $status == 1 ? Module::t('index', 'enabled') : Module::t('index', 'disabled');
    }

    public static function getNewsCategory($category = null) {
        if ($category !== null) {
            return Category::find()->select('title')
                            ->where('id = :id', [':id' => $category])
                            ->distinct(true)->asArray()
                            ->scalar();
        }
        $category = Category::find()
                ->where('published = :published', [':published' => Category::STATUS_ACTIVE])
                ->distinct(true)->asArray()
                ->all();
        return ArrayHelper::map($category, 'id', 'title');
    }

    public static function getNewsTypes($type = null) {
        $types = [
            self::TYPE_DEFAULT => Module::t('types', self::TYPE_DEFAULT),
            self::TYPE_FIXED => Module::t('types', self::TYPE_FIXED)
        ];
        if (is_null($type))
            return $types;
        else
            return $types[$type];
    }

    public static function getNewsStatus() {
        return [
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_HIDDEN => 'Скрыта',
        ];
    }

    public static function getStatusName($published) {
        if ($published == self::STATUS_HIDDEN)
            return 'Скрыта';
        if ($published == self::STATUS_NEW)
            return 'Входящая';
        if ($published == self::STATUS_ACTIVE)
            return 'Активна';
        return '';
    }

}

?>