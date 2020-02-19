<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\UserForm;
use yii\bootstrap\Modal;

use yii\data\Pagination;//分页
use yii\bootstrap\ActiveForm;
use app\controllers\UserController;


$this->title = '仓库列表';
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


        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            新增仓库
        </button>
        <a type="button" class="btn btn-success export " url="<?= $urlManager->createUrl(['export/store-out']) ?>">
            导出
        </a>

        <button type="button" class="btn btn-success"  onclick="uploadFile()">
            导入
        </button>


        <table width="90%" class="table">
            <tr>
                <th>id</th>
                <th>序号</th>
                <th>仓库名称</th>
                <th>状态</th>
                <th>操作</th>
            </tr>

            <?php
            foreach ($storeDetail as $value) {

                ?>

                <tr>
                    <td><?php echo $value->id; ?></td>
                    <td><?php echo $value->bh; ?></td>
                    <td><?php echo $value->name; ?></td>
                    <td><?php echo $value->status; ?></td>
                    <td>

                <span class="ml-2">
                 <a class="btn btn-sm refuse btn-danger apply-status-btn"
                    href="<?= $urlManager->createUrl(['site/delete-store', 'storeId' => $value['id']]) ?>"
                 >删除</a>
                 </span>

                 <span class="ml-2">
                    <button class="btn btn-sm btn-info apply-status-btn"    onclick="setStore(<?=$value->id?>,'<?=$value->bh?>','<?=$value->name?>')">修改</button>
                 </span>


                    </td>
                </tr>

                <?php
            } ?>


        </table>

    </div>
</div>
</body>


<!--新增仓库信息模态框-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">添加仓库</h4>

            </div>


            <div class="modal-body">
                <form id="userform" name="user" action="<?= $urlManager->createUrl(['site/add-store']) ?>" method="post">
                    <div class="form-group">
                        <label for="username" class="control-label">仓库编号:</label>
                        <input type="text" class="form-control" id="username" name="bh" >
                    </div>
                    <div class="form-group">
                        <label for="password_hash" class="control-label">仓库名称:</label>
                        <input type="text" class="form-control" id="password_hash" name="name">
                    </div>


                    <div class="text-right">
                        <span id="returnMessage" class="glyphicon"> </span>
                        <button type="button" class="btn btn-default right" data-dismiss="modal">关闭</button>

                        <button type="button" class="btn btn-primary save " data-option="add">保存</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>



<!--修改用户信息模态框-->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">修改仓库</h4>
            </div>
            <div class="modal-body">
                <form id="changeUser" name="Storehouse" action="<?= $urlManager->createUrl(['site/change-store']) ?>" method="post">

                    <div class="form-group">
                        <label for="id"   class="control-label" >id:</label>
                        <input type="text"   class="form-control" id="id2" name="id"   value="">
                    </div>

                    <div class="form-group">
                        <label for="bh" class="control-label">仓库编号:</label>
                        <input type="text" class="form-control"   name="bh" id="bh" value="">

                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">仓库名称:</label>
                        <input type="text" class="form-control" id="name" name="name" value="">
                    </div>




                    <div class="text-right">
                        <span id="returnMessage" class="glyphicon"> </span>
                        <button type="button" class="btn btn-default right"   data-dismiss="modal" >关闭</button>

                        <button type="button" class="btn btn-primary change "  >保存</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>

<!--上传文件的表单-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">上传文件</h4>
            </div>


            <div class="modal-body">
                <form action="<?= $urlManager->createUrl(['upload/upload-store']) ?>" method="post" enctype="multipart/form-data" id="import">
                    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

                    <div class="form-group">
                        <label for="id"   class="control-label" >文件名：</label>

                        <input type="file" name='tables_a' id="tables">
                        <input type="hidden" name='tables' id='tables_2'>
                    </div>

<!--                    <input type="submit" name="submit" value="提交">-->
                    <div class="text-right">
                        <span id="returnMessage" class="glyphicon"> </span>
                        <button type="button" class="btn btn-default right"   data-dismiss="modal" >关闭</button>

                        <button  class="btn btn-primary import "  >保存</button>
<!--                        <input type="submit" name="submit" value="提交">-->
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    /*
    *上传文件
    */

    function uploadFile() {
        //1 跳出模态框

        $('#myModal3').modal('show');
    }


    function setStore(id,bh,name) {
       $('#myModal2').modal('show');
        //设置表单的字段
        $('#bh').val(bh);
        $('#name').val(name);
        $('#id2').val(id);

    }


    /**
     * 删除仓库
     */
    $(document).on("click", ".refuse", ".apply-status-btn", function () {

        var url = $(this).attr("href");



        $.myConfirm({
            content: "是否删除删除该仓库？",
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
     * 新增仓库按钮
     */
    $(document).on('click', ".save", ".btn-primary", function () {

        var form = $('#userform');
        // var action = form.attr("action");
        var btn = $(this);


        btn.btnLoading("正在提交");


        $.myConfirm({
            content: "是否新增仓库？",
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

    /**
     * 修改仓库
     */
    $(document).on('click', ".change", ".btn-primary", function () {

        var form = $('#changeUser');

        var btn = $(this);


        btn.btnLoading("正在提交");


        $.myConfirm({
            content: "是否修改仓库？",
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


    /**
     * 导出仓库
     */
    $(document).on("click", ".export", function () {

        var url = $(this).attr("url");



        $.myConfirm({
            content: "是否导出？",
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
     * 导入仓库
     */
    $(document).on("click", ".import", function () {


        var form = $('#import');



        var btn = $(this);
        var fileArray = document.getElementById('tables').files[0];
        var formData = new FormData();
        formData.append("fileArray", fileArray)

        btn.btnLoading("正在上传");


        $.myConfirm({
            content: "是否上传excel？",
            confirm: function () {
                $.myLoading();
                $.ajax({
                    url: form.attr("action"),
                    type: form.attr("method"),
                    processData: false,
                    dataType: "json",
                    data: formData,
                    async:false, //这是重要的一步，防止重复提交的
                    cache: false, //设置为false，上传文件不需要缓存。
                    contentType: false,//设置为false,因为是构造的FormData对象,所以这里设置为false。
                    processData: false,//设置为false,因为data值是FormData对象，不需要对数据做处理。
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




