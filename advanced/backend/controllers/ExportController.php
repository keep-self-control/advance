<?php

namespace backend\controllers;



 use app\models\Storehouse;
 use moonland\phpexcel\Excel;
 use yii\helpers\BaseFileHelper;
 use yii\web\Controller;
 use PHPExcel;






class ExportController extends Controller
{

    /**
     * 导出仓库
     */

    public function actionStoreOut(){
        $list=Storehouse::find()->orderBy('id asc')->asArray()->all();
       // $path=Yii::getAlias('@webroot').'/tep/'.date('Y-m');
        $path='C:/Users/DELL/Desktop/'.date('Y-m');
        BaseFileHelper::createDirectory($path);
        $fileName='_'.date("YmdHis".time());
        Excel::export([
            'models'=>$list,
            'fileName'=>$fileName,
            'savePath'=>$path,
            'asAttachment'=>false,
            'columns'=>['id','bh','name'],
            'headers'=>[
                'id'=>'id',
                'bh'=>'编号',
                'name'=>'仓库名称'
            ]
        ]);

        return json_encode([
            'code' => 0,
            'msg' => '导出成功，导出路径为'.$path,
        ]);
    }








}
