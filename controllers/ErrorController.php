<?php

namespace app\controllers;

use app\models\Url;
use Yii;
use yii\web\Controller;

class ErrorController extends Controller
{
    /**
     * Получаем ссылку (проверяем)
     * @param $link
     * @return bool|string
     */
    public function getShortLink($link)
    {
        if (preg_match('/^[0-9a-zA-Z]{5}$/i',(string)$this->module->requestedRoute)){
            $result = Url::findOne(['short_url'=>$this->module->requestedRoute]);
            if ($result) {
                return $result->url;
            }
        }
        return FALSE;
    }


    /**
     * Обрабатываем исключение
     * @return string
     */
    public function actionError()
    {
        $link = $this->getShortLink($this->module->requestedRoute);
        if ($link) {
            Yii::$app->response->redirect($link);
            return $this->render('redirect');
        }

        return $this->render('error');
    }
}