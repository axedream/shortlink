<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url".
 *
 * @property int $id
 * @property string $url
 * @property string $short_url
 * @property string $date_create
 */
class Url extends \yii\db\ActiveRecord
{

    public $date = false;

    public function init()
    {
        $this->date = new \DateTime();
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_create'], 'safe'],
            [['url'], 'required'],
            [['url'],'match','pattern'=>'/^(https?:\/\/){1}([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/i'],
            [['url'], 'string', 'max' => 255],

            [['short_url'], 'string', 'max' => 20],
            [['short_url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Полная ссылка (http(s):// обязательно)',
            'short_url' => 'Короткая ссылка',
            'date_create' => 'Дата создания',
        ];
    }

    public function generateShortLink(){
        return substr(md5($this->date->format('Y-m-d H:i:s').rand(0,10000)),0 ,5);
    }

    public function generateDateTime(){
        return $this->date->format('Y-m-d H:i:s');
    }

    public function beforeSave($insert)
    {
        $this->short_url   = ($this->generateShortLink()) ? $this->generateShortLink() : false;
        $this->date_create = ($this->generateDateTime()) ? $this->generateDateTime() : false;
        return parent::beforeSave($insert);
    }
}