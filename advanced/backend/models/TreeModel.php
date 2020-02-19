<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tree_test".
 *
 * @property int $id
 * @property int|null $parentid
 * @property string $name
 * @property int|null $position
 * @property int|null $type
 * @property string|null $index
 */
class TreeModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tree_test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentid', 'position', 'type'], 'default', 'value' => null],
            [['parentid', 'position', 'type'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['index'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentid' => 'Parentid',
            'name' => 'Name',
            'position' => 'Position',
            'type' => 'Type',
            'index' => 'Index',
        ];
    }


}
