<?php

namespace app\modules\projects\controllers;

use Yii;
use app\modules\projects\models\ProjectCategories;
use app\modules\projects\models\ProjectCategoriesSearch;
use yii\bootstrap\Tabs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for ProjectCategories model.
 */
class CategoriesController extends Controller
{
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
        ];
    }

    /**
     * Lists all ProjectCategories models.
     * @return mixed
     */
    public function actionIndex()
    {

        //var_dump(Yii::$app->formatter->format(15.66, ['integer', 3]));
        //var_dump(Yii::$app->formatter->format(15.66, ['decimal', 2]));


        return $this->render('index');



    }


}
