<?php

namespace app\modules\users\controllers;

use app\modules\users\models\UsersBalance;
use yii\web\Controller;
use yii;

/**
 * RegistrationController implements the CRUD actions for Users model.
 */
class BalanceController extends Controller {

    /**
     * @inheritdoc
     */

    public function actionPay($number = 0) {
        $balance = new UsersBalance();
        return $balance->addInBalance(1,1);
    }




}
