<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\MainTable;


class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * @return int
     */
    public function actionSaveData()
    {
        $data = new MainTable();
        return $data->saveData();
    }

}
