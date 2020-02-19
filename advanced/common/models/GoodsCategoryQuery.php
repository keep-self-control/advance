<?php
/**
 * Created by PhpStorm.
 * User: STT
 * Date: 2020/1/20
 * Time: 17:50
 */

namespace common\models;


use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsBehavior;

class GoodsCategoryQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            'tree'=>[
                'class'=>NestedSetsBehavior::className(),
                'leftAttribute'=>'left key',
                'rightAttribute'=>'right key',
                'depthAttribute'=>'deep'
            ]
        ];
    }


    //重写find方法
    public static function  find(){
        return new GoodsCategoryQuery(get_called_class());
    }

}