<?php
namespace backend\controllers;

use app\models\Storehouse;
use app\models\UserForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\UploadForm;
use yii\web\UploadedFile;
use kasoft\jstree\JsTree;
use app\models\TreeModel;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
          //  Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->render('register', [
                'model' => $model,
            ]);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *重置密码
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }






    public  function  actionRegister(){
        $userData=new UserForm();

        $userDetail=$userData->getAllUser();

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }





        return $this->render('register',
            [
                'userDetail'=>$userDetail,
                'model' => $model
            ]);
    }


    public function  actionDeleteUser($userId){

        $user = UserForm::findOne(['id'=>$userId,'status'=>1]);
        if(!$user){
            return json_encode([
                'code' => 1,
                'msg' => "用户不存在,请刷新页面",
            ]);
        }else{
            $user->status = '2';
            $user->save();
        }



        return json_encode([
            'code' => 0,
            'msg' => "操作成功",
        ]);
    }

    /**新增用户
     * @return false|string
     * @throws \Throwable
     * @throws \yii\base\Exception
     */
    public function actionAddUser(){

        $model=new UserForm();

        $model->attributes = \Yii::$app->request->post();
        //加密后的密码
        $hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);
        $model->password_hash=$hash;
        $model->status='10';

        $res = $model->insert();


        /**
         * 验证密码
         *
         */
        /**
         * $password   要验证的明文密码
         * $hash     加密后的hash字符串
         */
        //  Yii::$app->getSecurity()->validatePassword($password, $hash);


        return json_encode([
            'code' => 0,
            'msg' => "操作成功",
        ]);



    }


    /**
     * 仓库设置  显示所有仓库列表
     */

    public function actionStoreHouse(){

        $model=new Storehouse();
        $storeDetail=$model->getAllStore();
        return $this->render('storehouse',['storeDetail'=>$storeDetail]);


    }


    public function actionAddStore(){

        file_put_contents('D:/test1.txt',55555);
        $model=new Storehouse();
        file_put_contents('D:/test1.txt',44444);
        $model->attributes = \Yii::$app->request->post();

        if($model->validate()){
            file_put_contents('D:/test1.txt',6666);
            var_dump(3333);
             $model->status='启用';
            $res = $model->insert();
            return json_encode([
                'code' => 0,
                'msg' => '操作成功',
            ]);
        }else{

            file_put_contents('D:/test1.txt',222222);

            return json_encode([
                'code' => 1,
                'msg' => $model->errors,
            ]);
        }






    }

    /**
     * 修改仓库
     */
    public function actionChangeStore(){
        $id= \Yii::$app->request->post('id');
        $model = Storehouse::find()->where(['id'=>$id])->one();
        file_put_contents('D:/testid.txt',$id);
        if($model){
            $model->bh = \Yii::$app->request->post('bh');
            $model->name =\Yii::$app->request->post('name');
            file_put_contents('D:/testid.txt',$model->bh);
            if($model->validate()){

            $model->save();

            return json_encode([
                'code' => 0,
                'msg' => '修改成功',
            ]);
            }else{
                $model->save();
                return json_encode([
                    'code' => 0,
                    'msg' => '修改成功',
                ]);
            }
        }else{
            return json_encode([
                'code' => 1,
                'msg' => '该数据不存在，请刷新页面',
            ]);
        }

    }


    /**
     * 删除仓库
     */
    public function actionDeleteStore($storeId){

        $storeModel = Storehouse::findOne(['id'=>$storeId,'status'=>'启用']);
        if(!$storeModel){
            return json_encode([
                'code' => 1,
                'msg' => "用户不存在,请刷新页面",
            ]);
        }else{
            $storeModel->status = '删除';
            $storeModel->save();
        }

        return json_encode([
            'code' => 0,
            'msg' => "操作成功",
        ]);
    }




    public function actionStoreIn()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }

        return $this->render('storeExportIn', ['model' => $model]);
    }

/*
 *物料大类
 */
    public function actionSupplier()
    {



        return $this->render('supplierlist');
    }

    /**
     * 物料字典
     */
    public function actionMaterialDictionary(){


           $tree = new \kasoft\jstree\JsTree([
            'modelName'=>'app\models\Tree',    // * Namespace of the Model
            'modelPropertyId' => 'id',                       // * 主键
            'modelPropertyParentId' => 'parentid',          // * Parent ID for tree items
            'modelPropertyPosition' => 'position',          // *for sorting items
            'modelPropertyName' => 'name',                  // * Fieldname to show
            'modelFirstParentId' => NULL,                   // * ID for the Tree to start
            'modelPropertyType' => 'type',                  // Item type (for Icon and jsTree rights)
            //'controllerId' => 'index',                      // Controler Actions which should handle everything
            'jstreeDiv' => '#jstree',                       // DIV where the Tree will be displayed
            'jstreeIcons' => false,                         // Show Icons or not
            'jstreePlugins' => ["contextmenu", "dnd",],   // Plugins to be load
            'jstreeType' => [                               // jsTree Type Options
        "#" => [
            "max_children" => -1,
            "max_depth" => -1,
            "valid_children" => -1,
            "icon" => "glyphicon glyphicon-th-list"
        ],
        "default" => [
            "icon" => "glyphicon glyphicon-question-sign"
        ],
    ]
        ]);

        if (isset($_REQUEST["easytree"])) {
            $tree->treeaction();
            Yii::$app->end();

        }
        file_put_contents('D:/test1.txt','生成属状图');


        return $this->render('materialdictionary');

    }


//    public function actionSupplier(){
//        $query = TreeModel::find();
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => false
//        ]);
//
//        return $this->render('supplierlist', [
//            'dataProvider' => $dataProvider
//        ]);
//
//}
}
