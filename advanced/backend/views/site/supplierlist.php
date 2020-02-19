<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use leandrogehlen\treegrid\TreeGrid;
use kartik\tree\TreeViewInput;
use app\models\Tree;
use kartik\tree\TreeView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Treetests';
$this->params['breadcrumbs'][] = $this->title;




echo TreeView::widget([
    // single query fetch to render the tree
    'query'             => Tree::find()->addOrderBy('root, lft'),
    'headingOptions'    => ['label' => '大类'],
    'rootOptions' => ['label'=>'<span class="text-primary">Products</span>'],
    'topRootAsHeading' => true,
    'fontAwesome' => true,
    'isAdmin'           => true,                       // optional (toggle to enable admin mode)
    'displayValue'      => 1,                           // initial display value
   'iconEditSettings'=> [

        'show' => 'list',

        'listData' => [

            'folder' => 'Folder',

            'file' => 'File',

            'mobile' => 'Phone',

            'bell' => 'Bell',

        ]

    ],


    'softDelete'      => true,                        // normally not needed to change
   'cacheSettings'   => ['enableCache' => true]      // normally not needed to change


]);


?>

<!--<div class="jstree-form">-->
<!--TREE-->
<!--<div id="jstree"></div>-->
<!--<div class="result"></div>-->
<!--</div>-->



