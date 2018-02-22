<?php

namespace app\controllers;

use Yii;
use app\models\Url;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Url();
        return $this->render('index',['model'=>$model]);
    }


}
