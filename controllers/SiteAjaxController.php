<?php
/**
 * Created by PhpStorm.
 * User: Пользователь
 * Date: 16.02.2018
 * Time: 12:18
 */

namespace app\controllers;



use app\models\Url;
use Yii;
use yii\web\Controller;
use yii\web\Response;



class SiteAjaxController extends Controller
{

    public $time_cache = 1800; //60*30 минут = 1800 секунд - время кэширования запроса
    public $out = ['error'=>true, 'msg'=>'Неизвестно','code'=>FALSE];

    public function init(){
        Yii::$app->response->format = Response::FORMAT_JSON;;
    }

    /**
     * Забираем данные из кэш
     * @param $input
     * @return array|bool
     */
    public function getCacheData($input)
    {
        return Yii::$app->cache->get($input);
    }

    /**
     * Записываем данные в кэш
     * @param $input
     * @param $data
     * @return mixed
     */
    public function setCacheData($input,$data)
    {
        return Yii::$app->cache->set($input, $data, $this->time_cache);
    }

    public function getDataModel($model)
    {
        return ['id'=>$model->id,'url'=>$model->url,'short_url'=>$model->short_url,'date_create'=>$model->date_create];
    }


    /**
     * Получаем данные или генерируем в базу записываем в базу (магический метод конечно получился но в рамках данный задачи не вижу смысла разносить функционал)
     * @return array
     */
    public function actionGetShortUrl(){
        if (Yii::$app->request->isPost){
            $key = Yii::$app->request->post('output')['url'];
            $cache = $this->getCacheData($key);

            if ($cache) {
                return ['error'=>false, 'msg'=>$cache, 'cache'=>true];
            }
            $url = Url::findOne(['url'=>Yii::$app->request->post('output')['url']]);
            if ($url) {
                $this->setCacheData($key, $this->getDataModel($url));
                return ['error'=>false,'msg'=>$url, 'cache'=>false];
            } else {
                $model = new Url;
                $model->setAttribute('url',Yii::$app->request->post('output')['url']);
                if ($model->validate()) {
                    $model->save();
                    $this->setCacheData($key,$this->getDataModel($model));
                    return ['error'=>false, 'msg'=>$model, 'cache'=>false];
                }
            }
        }
        return $this->out;
    }
}