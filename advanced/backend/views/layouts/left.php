<?php
//use mdm\admin\components\MenuHelper;
//use dmstr\widgets\Menu;

use mdm\admin\components\MenuHelper;

use dmstr\widgets\Menu;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
<!--        <div class="user-panel">-->
<!--            <div class="pull-left image">-->
<!--                <img src="--><?//= $directoryAsset ?><!--/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>-->
<!--            </div>-->
<!--            <div class="pull-left info">-->
<!--                <p>Alexander Pierce</p>-->
<!---->
<!--                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
<!--            </div>-->
<!--        </div>-->

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

 <?=
 dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [

                    [ 'label' => '基础数据',
                        'icon' => 'file-code-o',
                        'url'=>'#',
                        'items'=>[['label' => '用户注册', 'icon' => 'file-code-o', 'url' => ['site/register'],],
                            ['label' => '往来单位', 'icon' => 'dashboard', 'url' => '#',
                                'items'=>[
                                    ['label' => '物料大类', 'icon' => 'file-code-o', 'url' => ['site/supplier'],],
                                    ['label' => '物料字典', 'icon' => 'dashboard', 'url' => ['tree/index'],],

                                ]

                                ],
                            ['label' => '仓库设置', 'icon' => 'file-code-o', 'url' => ['site/store-house'],]
                            ],


                        ],
                    ['label' => '导入excel', 'icon' => 'dashboard', 'url' => ['site/store-in']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        )


//Menu::widget([
//        'options'=>['class'=>'sidebar-menu'],
//        'items'=>MenuHelper::getAssignedMenu(Yii::$app->user->id),
//])


 ?>





    </section>

</aside>
