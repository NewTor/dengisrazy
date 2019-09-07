<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\MainTable;

/**
 * Default controller
 */
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
     * Экшн сохранения данных
     * @return string
     */
    public function actionSaveData()
    {
        $data = new MainTable();
        return $data->saveData();
    }

}
