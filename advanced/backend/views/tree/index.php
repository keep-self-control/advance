
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


$this->title = '物料字典';
$this->params['breadcrumbs'][] = $this->title;
$urlManager = Yii::$app->urlManager;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no,minimal-ui" />
    <title>页面左右结构（其中一端自适应）</title>
    <style type="text/css">
        /*右边*/



        /*左边*/
        .my-box-left2{
            width: 150px;
            height: 100%;
            float: left;
          //  background-color: red;
        }
        .my-box-right2{
            overflow: hidden;
            /*overflow:auto*/
            height: 100%;
            overflow-x: scroll;
        }

        #wrap{word-break:break-all;
            width: 200%; overflow:auto;}
    </style>
</head>
<body>

<div class="">
    <div class="my-box-left2">
        <?= \liyuze\ztree\ZTree::widget([
            'id' => 'treeDemo',	//自定义id
            'setting' => '{
			view: {
				dblClickExpand: false,
				showLine: false
			},
			callback: {
			beforeClick: getCurrentNode,
				onClick: onClick
			}
		}',
            'nodes' => '[
			{ name:"父节点1 - 展开", open:true,
				children: [
					{ name:"父节点11 - 折叠",
						children: [
							{ name:"叶子节点111"},
							{ name:"叶子节点112"},
							{ name:"叶子节点113"},
							{ name:"叶子节点114"}
						]},
					{ name:"父节点12 - 折叠",
						children: [
							{ name:"叶子节点121"},
							{ name:"叶子节点122"},
							{ name:"叶子节点123"},
							{ name:"叶子节点124"}
						]},
					{ name:"父节点13 - 没有子节点", isParent:true}
				]
			}
		]'
        ]);
        ?>
    </div>
    <div class="my-box-right2">
        <div class="" id="wrap">


            <button type="button" class="btn btn-primary  " data-toggle="modal" data-target="#myModal"
                    url="<?= $urlManager->createUrl(['user/add-user']) ?>">
                新增物料
            </button>
            <table width="90%" class="table" id="detail">
                <tr>
                    <th>大类</th>
                    <th>物料编号</th>
                    <th>物料名称</th>
                    <th>规格型号</th>
                    <th>单价</th>
                    <th>单位</th>
                    <th>装配单价</th>
                    <th>成托单价</th>


                    <th>库存上限</th>
                    <th>库存下限</th>
                    <th>采购周期</th>
                    <th>是否重复</th>
                    <th>图号</th>
                    <th>货位编号</th>
                    <th>储存仓库</th>

                    <th>换算系数</th>

                    <th>最新单价</th>
                    <th>输入码</th>
                    <th>启用标志</th>
                    <th>存货核算</th>

                    <th>维护日期</th>
                </tr>






            </table>


        </div>
    </div>
</div>
</body>
</html>










<script>
    function onClick(e,treeId, treeNode) {

        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.expandNode(treeNode);


    }

    function getCurrentNode(treeId, treeNode) {
        curNode = treeNode;
        zTreeOnClick(curNode,treeId);
    }


    function zTreeOnClick(treeNode,treeId){
        //此处编写需要完成的业务逻辑代码，实现你想要的 主内容的框架进行页面跳转
      //  alert(treeNode['name']);
     //   $('#detail').val(treeNode['name']);

        var name=treeNode['name'];
var tr="";
       // $("#detail").remove();
        $('.add').children().remove();

        $.ajax({
            url : '<?= Yii::$app->urlManager->createUrl('tree/get-info')?>',
            dataType: "text",
            type:"post",
            data:{"name":name},
            success: function (res) {
                var obj = JSON.parse(res);//获取数据


               for( var i=0;i<obj.length;i++){
                    tr="<tr class='add'>" +
                       "<th>"+obj[i]['dlmc']+"</th>" +
                       "<th>"+obj[i]['wlbh']+"</th>" +
                       "<th>"+obj[i]['wlmc']+"</th>" +
                       "<th>"+obj[i]['ggxh']+"</th>" +
                       "<th>"+obj[i]['dj']+"</th>" +
                       "<th>"+obj[i]['jldw']+"</th>" +
                       "<th>"+obj[i]['zpdj']+"</th>" +
                       "<th>"+obj[i]['ctdj']+"</th>" +


                       "<th>"+obj[i]['kcsx']+"</th>" +
                       "<th>"+obj[i]['kcxx']+"</th>" +
                       "<th>"+obj[i]['cgzq']+"</th>" +
                       "<th>"+obj[i]['sfcf']+"</th>" +
                       "<th>"+obj[i]['th']+"</th>" +
                       "<th>"+obj[i]['hwbh']+"</th>" +
                       "<th>"+obj[i]['ccck']+"</th>" +

                       "<th>"+obj[i]['hsxs']+"</th>" +

                       "<th>"+obj[i]['zxdj']+"</th>" +
                       "<th>"+obj[i]['srm']+"</th>" +
                       "<th>"+obj[i]['qybz']+"</th>" +
                       "<th>"+obj[i]['chhs']+"</th>" +

                       "<th>"+obj[i]['whrq']+"</th>" +
                       "</tr>";
                   $("#detail").append(tr);

               }


            }
        });





    }
</script>