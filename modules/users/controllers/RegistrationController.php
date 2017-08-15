<?php

namespace app\modules\users\controllers;

use app\models\Settings;
use Yii;
use app\modules\users\models\Users;
use app\modules\users\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * RegistrationController implements the CRUD actions for Users model.
 */
class RegistrationController extends Controller
{

    public $defaultAction = 'create';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create','success'],
                        'allow' => true,
                        'roles' => ['?','admin'],
                    ],
                    [
                        'actions' => ['create','success'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password = md5(Users::$passwordSalt.$model->password_input);
            $model->save();
            return $this->redirect(['success']);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSuccess()
    {
        return "УСПЕХ";
    }

}
