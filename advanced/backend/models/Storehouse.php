<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "storehouse".
 *
 * @property int $id
 * @property string|null $bh 编号
 * @property string|null $name 仓库名称
 * @property string|null $status 状态
 */
class Storehouse extends \yii\db\ActiveRecord
{
    //设置excel导出的最大条数
  const EXCEL_SIZE=10000;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bh', 'name', 'status'], 'string'],
      //  [['bh','name'],'require','message'=>'不能为空']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bh' => '编号',
            'name' => '仓库名称',
            'status' => '状态',
        ];
    }

    /**
     * 查询所有仓库
     */
    public function getAllStore(){
        return self::find()->select(['id','bh','name','status'])->where(['status'=>'启用'])->all();
    }


    /**
     * 查询所有的仓库名称和编号
     */
    public  function statistics()
    {
        //excel一次导出条数
       // $storeModel=new Storehouse();
        $store =self::find()->select(['id','bh','name','status'])->where(['status'=>'启用'])->all();


        $store = ArrayHelper::index($store, null, 'id');
        file_put_contents('D:/test3.txt',$store['0']['id']);
        //声明一个数组
        $company=[];
        foreach ($store as $key=>$v){
            if(empty($key)){
                continue;
            }else{
                $number=count($v);
                $company=Storehouse::find()->where(['id'=>$key])->select(['name','bh'])->one();
                $name=$company['name'];
                $bh=$company['bh'];

                $company[]=[
                    'bh'=>$bh,
                    'name'=>$name


                ];
            }
        }
       return $company;
    }



    /**
     * 获取id最大值
     */
    public static function getMaxId(){
        return self::find()->select(['id'])->orderBy('id desc')->all();

    }


}
