<?php

namespace app\modules\users;

/**
 * users module definition class
 */
class Module extends \yii\base\Module
{
    public $defaultRoute = 'Login';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\users\controllers';

    /**
     * @inheritdoc
     */


    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
