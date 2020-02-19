<?php

namespace backend\controllers;



use yii\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\TreeTest;
use app\models\Materialdictionary;
use app\models\UserForm;





class TreeController extends Controller
{




    public function actionIndex() {


        return $this->render('index');
    }


    public function  actionGetInfo(){
     //name 暂时没有用，以后用id替换，测试开发阶段，先查询所有的物料字典
      $name= Yii::$app->request->post('name');

      //获取数据
     $model=Materialdictionary::find()->asArray()->all();
    // $modelDetail=$model->findAllData();
// var_dump($modelDetail[0]['id']) ;
//        echo $modelDetail[0]['ccck'];

      //  var_dump(json_encode($model)) ;



   return json_encode($model,true);








    }

}
