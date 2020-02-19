<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tree".
 *
 * @property int $id
 * @property int|null $root
 * @property int $lft
 * @property int $rgt
 * @property int $lvl
 * @property string $name
 * @property string|null $icon
 * @property int $icon_type
 * @property bool $active
 * @property bool $selected
 * @property bool $disabled
 * @property bool $readonly
 * @property bool $visible
 * @property bool $collapsed
 * @property bool $movable_u
 * @property bool $movable_d
 * @property bool $movable_l
 * @property bool $movable_r
 * @property bool $removable
 * @property bool $removable_all
 * @property bool $child_allowed
 */
class Tree extends \kartik\tree\models\Tree
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['root', 'lft', 'rgt', 'lvl', 'icon_type'], 'default', 'value' => null],
            [['root', 'lft', 'rgt', 'lvl', 'icon_type'], 'integer'],
            [[ 'name'], 'required'],
            [['active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all', 'child_allowed'], 'boolean'],
            [['name'], 'string', 'max' => 60],
            [['icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'lvl' => 'Lvl',
            'name' => 'Name',
            'icon' => 'Icon',
            'icon_type' => 'Icon Type',
            'active' => 'Active',
            'selected' => 'Selected',
            'disabled' => 'Disabled',
            'readonly' => 'Readonly',
            'visible' => 'Visible',
            'collapsed' => 'Collapsed',
            'movable_u' => 'Movable U',
            'movable_d' => 'Movable D',
            'movable_l' => 'Movable L',
            'movable_r' => 'Movable R',
            'removable' => 'Removable',
            'removable_all' => 'Removable All',
            'child_allowed' => 'Child Allowed',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TreeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TreeQuery(get_called_class());
    }
}
