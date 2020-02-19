<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "storehouse".
 *
 *  文件上传类
 */
class UploadForm extends Model
{
    public $file;

    public function rules()
    {
     return [
         [['file'],'file'],
     ];

    }


}
