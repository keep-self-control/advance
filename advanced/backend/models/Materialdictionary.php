<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "materialdictionary".
 *
 * @property int $id id
 * @property string|null $dlbh 大类编号
 * @property string|null $dlmc 大类名称
 * @property string|null $wlbh 物料编号
 * @property string|null $wlmc 物料名称
 * @property string|null $ggxh 规格型号
 * @property float|null $dj 单价
 * @property string|null $jldw 计量单位
 * @property float|null $zpdj 装配单价
 * @property float|null $ctdj 成托单价
 * @property int|null $kcsx 库存上限
 * @property int|null $kcxx 库存下限
 * @property float|null $cgzq 采购周期
 * @property int|null $sfcf 是否重复
 * @property string|null $th 图号
 * @property string|null $hwbh 货位编号
 * @property string|null $ccck 储存仓库
 * @property float|null $hsxs 换算系数
 * @property string|null $qybz 启用标志
 * @property string|null $srm 输入码
 * @property string|null $chhs 存货核算
 * @property string|null $whrq 维护日期
 */
class Materialdictionary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'materialdictionary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dj', 'zpdj', 'ctdj', 'cgzq', 'hsxs'], 'number'],
            [['kcsx', 'kcxx', 'sfcf'], 'default', 'value' => null],
            [['kcsx', 'kcxx', 'sfcf'], 'integer'],
            [['whrq'], 'safe'],
            [['dlbh', 'dlmc', 'wlbh', 'jldw', 'hwbh', 'ccck'], 'string', 'max' => 20],
            [['wlmc', 'ggxh', 'srm'], 'string', 'max' => 255],
            [['th'], 'string', 'max' => 25],
            [['qybz', 'chhs'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'dlbh' => '大类编号',
            'dlmc' => '大类名称',
            'wlbh' => '物料编号',
            'wlmc' => '物料名称',
            'ggxh' => '规格型号',
            'dj' => '单价',
            'jldw' => '计量单位',
            'zpdj' => '装配单价',
            'ctdj' => '成托单价',
            'kcsx' => '库存上限',
            'kcxx' => '库存下限',
            'cgzq' => '采购周期',
            'sfcf' => '是否重复',
            'th' => '图号',
            'hwbh' => '货位编号',
            'ccck' => '储存仓库',
            'hsxs' => '换算系数',
            'qybz' => '启用标志',
            'srm' => '输入码',
            'chhs' => '存货核算',
            'whrq' => '维护日期',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MaterialdictionaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaterialdictionaryQuery(get_called_class());
    }

    /**
     * 查询所有字段
     */
    public function  findAllData(){
        return self::find()->all();
    }
}
