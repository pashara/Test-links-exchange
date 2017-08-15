<?php

namespace app\modules\users\controllers;

use app\models\Settings;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `users` module
 */
class LoginController extends Controller
{

    public function behaviors()
    {
        return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => false,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ];
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {



        /*$role = Yii::$app->authManager->createRole('default');
        $role->description = 'Обычный авторизированный пользователь';
        Yii::$app->authManager->add($role);
*/
        /*$auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('admin');
        $auth->assign($authorRole, 1);*/

        /*$permit = Yii::$app->authManager->createPermission('deleteUser');
        $permit->description = 'Право удалять пользователя';
        Yii::$app->authManager->add($permit);*/


        return $this->render('index');
    }
}
