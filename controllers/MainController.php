<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

use app\models\User;

class MainController extends \yii\web\Controller
{


    public function beforeAction($action)
    {

        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        return $this->render('index');
    }



}
