<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use app\models\UserForm;
use yii\bootstrap\Modal;

use yii\data\Pagination;//分页
use yii\bootstrap\ActiveForm;
use app\controllers\UserController;


$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
$urlManager = Yii::$app->urlManager;

?>

<head>
    <script src="<?= Yii::$app->request->baseUrl ?>/css/js/common.js"></script>

</head>

<style type="text/css">


    td {
        height: 30px;
    }

    h1, h2, h3 {
        font-size: 12px;
        margin: 0;
        padding: 0;
    }

    .table {
        border: 1px solid #cad9ea;
        color: #666;
    }

    .table th {
        background-repeat: repeat-x;
        height: 30px;
    }

    .table td, .table th {
        border: 1px solid #cad9ea;
        padding: 0 1em 0;
    }

    .table tr.alter {
        background-color: #f5fafe;
    }
</style>


<body>
<div id="main" class="wrap">

    <div class="site-about">


        <button type="button" class="btn btn-primary  " data-toggle="modal" data-target="#myModal"
                url="<?= $urlManager->createUrl(['user/add-user']) ?>">
            新增用户
        </button>
        <table width="90%" class="table">
            <tr>
                <th>用户账号</th>
                <th>姓名</th>
                <th>密码</th>

                <th>操作</th>
            </tr>

            <?php
            foreach ($userDetail as $value) {

                ?>

                <tr>
                    <td><?php echo $value->id; ?></td>
                    <td><?php echo $value->username; ?></td>
                    <td><?php echo $value->password_hash; ?></td>
                    <td>

                <span class="ml-2">
                 <a class="btn btn-sm refuse btn-danger apply-status-btn"
                    href="<?= $urlManager->createUrl(['user/delete-user', 'userId' => $value['id']]) ?>"
                 >删除</a>
                 </span>

                        <span class="ml-2">
                    <a class="btn btn-sm btn-info apply-status-btn"
                       href="<?= $urlManager->createUrl(['user/change-user', 'id' => $value['id']]) ?>">修改</a>

                    </td>
                </tr>

                <?php
            } ?>


        </table>

    </div>
</div>
</body>


<!--新增用户信息模态框-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">添加用户</h4>
            </div>
            <div class="modal-body">
<!--                <form id="userform" name="user" action="--><?//= $urlManager->createUrl(['site/add-user']) ?><!--" method="post">-->
<!--                    <div class="form-group">-->
<!--                        <label for="username" class="control-label">用户名:</label>-->
<!--                        <input type="text" class="form-control" id="username" name="username">-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label for="password_hash" class="control-label">密码:</label>-->
<!--                        <input type="text" class="form-control" id="password_hash" name="password_hash">-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label for="phone" class="control-label">邮箱:</label>-->
<!--                        <input type="text" class="form-control" id="email" name="email">-->
<!--                    </div>-->
<!---->
<!--                    <div class="text-right">-->
<!--                        <span id="returnMessage" class="glyphicon"> </span>-->
<!--                        <button type="button" class="btn btn-default right" data-dismiss="modal">关闭</button>-->
<!--                        <!--                        <button id="submitBtn" type="button" class="btn btn-primary save" οnclick="add_info()" >提交</button>-->-->
<!--                        <!--                        <button class="" οnclick="" >提交</button>-->-->
<!--                        <button type="button" class="btn btn-primary save ">保存</button>-->
<!--                    </div>-->
<!--                </form>-->

                <div class="row">
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<!--修改用户信息模态框-->


<script type="text/javascript">


    /**
     * 删除用户
     */
    $(document).on("click", ".refuse", ".apply-status-btn", function () {

        var url = $(this).attr("href");

        alert(url);

        $.myConfirm({
            content: "是否删除删除该用户？",
            confirm: function () {
                $.myLoading();
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function (res) {

                        $.myLoadingHide();
                        $.myAlert({
                            content: res.msg,
                            confirm: function () {
                                if (res.code == 0) {
                                    location.reload();
                                }

                            }
                        });
                    }
                });
            }
        });
        return false;
    });


    /**
     * 新增用户
     */
    // $(document).on("click","#",".show-rules-modal",function () {
    //
    //     var url = $(this).attr("url");
    //
    //     // var form = document.getElementById('updateform');
    //
    //     //form.submit();
    //
    //     // $("#myModal").on("hidden.bs.modal", function() {
    //     //     $(this).removeData("bs.modal");
    //     // });
    //
    //
    //
    //
    // })

    $(document).on('click', ".save", ".btn-primary", function () {

        var form = $('#userform');
        // var action = form.attr("action");
        var btn = $(this);

        btn.btnLoading("正在提交");


        $.myConfirm({
            content: "是否新增用户？",
            confirm: function () {
                $.myLoading();
                $.ajax({
                    url: form.attr("action"),
                    type: form.attr("method"),
                    dataType: "json",
                    data: form.serialize(),
                    success: function (res) {

                        $.myLoadingHide();
                        $.myAlert({
                            content: res.msg,
                            confirm: function () {
                                if (res.code == 0) {
                                    location.reload();
                                }

                            }
                        });
                    }
                });
            }
        });


    });





</script>




