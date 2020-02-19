<?php

namespace backend\controllers;
use app\models\Storehouse;
use yii\web\UrlManager;
use yii\web\Controller;
use yii\helpers\FileHelper;
use Yii;
use yii\BaseYii;

/**
 *  created by stt
 * 2020/1/10
 *
 * 上传文件的控制器
 */
class UploadController extends Controller
{
    public $enableCsrfValidation = false;

    public function init(){
        $this->enableCsrfValidation = false;
    }

    /**
     * 上传仓库
     */
    public  function  actionUploadStore(){
        $name = $_FILES['fileArray']['name'];

        if ($_FILES["fileArray"]["error"] > 0)
        {
            echo '错误'.$_FILES["fileArray"]["error"] . "<br>";
        }
        else
        {


           $uploaddir=  "E:/download/upload/";//上传文件的路径


          //  $folder = 'test';
            is_dir($uploaddir) OR mkdir($uploaddir, 0777, true);

           // echo '上传文件路径'.$uploaddir;

                if (file_exists($uploaddir . $_FILES["fileArray"]["name"]))
                {
                    return json_encode([
                        'code' => 2,
                        'msg' => '上传失败,文件已存在',
                    ]);
                }
                else
                {
                     //如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    move_uploaded_file($_FILES["fileArray"]["tmp_name"], $uploaddir . $_FILES["fileArray"]["name"]);

                    $path=$uploaddir . $_FILES["fileArray"]["name"];
                    $data = \moonland\phpexcel\Excel::import($path); // $config is an optional
                   // echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                     $dataUp=json_encode($data,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

                    foreach (json_decode($dataUp,true) as $value){
                        $storeHouse=new Storehouse();//实例化仓库对象
                        $storeHouse->bh=$value['bh'];
                        $storeHouse->name=$value['name'];
                        $storeHouse->status='启用';
                       if($storeHouse->insert()){

                       }else{
                           return json_encode([
                               'code' => 1,
                               'msg' => $storeHouse->errors,
                           ]);
                       }

                    }
                    unlink($uploaddir . $_FILES["fileArray"]["name"]);

                    return json_encode([
                        'code' => 0,
                        'msg' => '导入成功',
                    ]);

                }


        }


         // echo  Yii::$app->runAction('site/store-house');

//        $model=new Storehouse();
//        $storeDetail=$model->getAllStore();
//        return $this->render('storehouse',['storeDetail'=>$storeDetail]);
    }






}
