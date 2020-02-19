<?php

namespace frontend\controllers;



use app\models\UserForm;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;





class UserController extends Controller
{

    public $enableCsrfValidation = false;


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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

    public  function beforeAction ($action){
        $this->enableCsrfValidation=false;
        return parent::beforeAction($action);
    }

    public function init()
    {
        $this->enableCsrfValidation = false;
    }


    /**
     *
     */

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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @return string 获得所有用户
     */

    public  function  actionRegister(){
        $userData=new UserForm();

        $userDetail=$userData->getAllUser();



        return $this->render('register',['userDetail'=>$userDetail]);
    }


    public function  actionDeleteUser($userId){

        file_put_contents("D:/text.txt",'112');

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

    /**
     * @return false|string  新增用户
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


    public function actionValidateView()
    {
        $model = new UserForm();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }


    public function actionSave()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $params = Yii::$app->request->post();
        $model = $this->findModel($params[id]);

        if (Yii::$app->request->isPost && $model->load($params)) {
            return ['success' => $model->save()];
        }
        else{
            return ['code'=>'error'];
        }
    }





}
