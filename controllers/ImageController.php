<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 27.05.18
 * Time: 23:51
 */

namespace app\controllers;


use yii\web\Controller;

class ImageController extends Controller
{
    public function actionGet($path = null)
    {
        $defaultPath = \Yii::getAlias('@webroot/book.jpg');

        if (!$path || !file_exists($path = \Yii::getAlias('@app/upload/') . $path)) {
            $path = $defaultPath;
        }

        $fileExtension = pathinfo($path, PATHINFO_EXTENSION);
        header("Content-type: image/$fileExtension");

        echo file_get_contents($path);
    }

}