<?php

namespace app\modules\projects\controllers;

use app\models\Currency;
use app\modules\projects\models\LinksProcessing;
use app\modules\projects\models\LinksProcessingSearch;
use app\modules\projects\models\LinksRequirements;
use app\modules\projects\models\ProjectLinks;
use app\modules\projects\models\ProjectLinksCost;
use app\modules\projects\models\ProjectLinksSearch;
use app\modules\projects\models\Requirements;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LinksController implements the CRUD actions for ProjectLinks model.
 */
class LinksController extends Controller {
    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all ProjectLinks models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProjectLinksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectLinks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProjectLinks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($project_id) {
        $models['links'] = new ProjectLinks();
        $models['links']->project_id = $project_id;
        $models['links']->enable = 0;
        $models['links']->done = 0;

        if ($models['links']->load(Yii::$app->request->post()) && $models['links']->validate()) {
            $models['links']->save();
            return $this->redirect(['update', 'id' => $models['links']->id]);
        } else {
            return $this->render('create', [
                'models' => $models,
            ]);
        }
    }

    /**
     * Updates an existing ProjectLinks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $models['links'] = $this->findModel($id);
        $models['cost'] = [];
        foreach (Currency::find()->where(['allow_to_input' => 1])->all() as $currency) {
            $className = 'app\models\currency\Currency' . $currency->code;
            $currencyModel = new $className;
            $currencyModel->link_id = $models['links']->id;
            $currencyModel->getInfoWithLink();
            $models['cost'][$currency->code] = $currencyModel;
        }

        foreach (Requirements::find()->where(["enable" => 1])->orderBy("sort")->all() as $requirement) {
            $models['requirements'][$requirement->name] = new $requirement->class([], []);
            $models['requirements'][$requirement->name]->link_id = $models['links']->id;
            $models['requirements'][$requirement->name]->loadDataFromDB();
        }


        /*********************************************************
         *************** Load DATA from POST *********************
         *********************************************************/
        if (Yii::$app->request->post()) {

            $models['links']->title = Yii::$app->request->post()['ProjectLinks']['title'];
            $models['links']->default_currency = Yii::$app->request->post()['ProjectLinks']['default_currency'];
            $models['links']->alias = Yii::$app->request->post()['ProjectLinks']['alias'];
            $models['links']->number = Yii::$app->request->post()['ProjectLinks']['number'];


            foreach ($models['requirements'] as $key => $value) {
                $models['requirements'][$key]->loadData(Yii::$app->request->post()[ucfirst($key)]);
            }
            foreach ($models['cost'] as $key => $value) {

                if ($models['links']->default_currency == $models['cost'][$key]->getInfo()->id) {
                    $models['cost'][$key]->scenario = $models['cost'][$key]::SCENARIO_DEFAULT_CURRENCY;
                }
                $models['cost'][$key]->loadData(Yii::$app->request->post()['Currency' . $key]);
            }

        }


        $validated = false;
        if (Yii::$app->request->post()) {
            $validated = true;
            /******************* Validation *************************/
            $validated = $validated & Model::validateMultiple([$models['links']]);

            if ($models['requirements'])
                foreach ($models['requirements'] as $requirementModel)
                    $validated = $validated & Model::validateMultiple([$requirementModel]);

            if ($models['cost'])
                foreach ($models['cost'] as $costModel)
                    $validated = $validated & Model::validateMultiple([$costModel]);

        }

        if ($validated) {
            $models['links']->save();

            ProjectLinksCost::deleteAll(['link_id' => $models['links']->id]);
            if ($models['cost'])
                foreach ($models['cost'] as $cost) {
                    $cost->saveByLinkID($models['links']->id);
                }

            LinksRequirements::deleteAll(['link_id' => $models['links']->id]);
            if ($models['requirements'])
                foreach ($models['requirements'] as $requirements) {
                    $requirements->saveByLinkID($models['links']->id);
                }

            return $this->redirect(['view', 'id' => $models['links']->id]);
        }


        /********************* Render ****************************/
        return $this->render('update', [
            'models' => $models,
        ]);

    }


    public function actionStart_link($id) {
        $model = $this->findModel($id);

        $linkProcess = new LinksProcessing();
        $linkProcess->generateNewProcess($model);



        if ($linkProcess->save()) {
            var_dump($linkProcess->getErrors());
            //return $this->redirect(['index']);
        } else {
            var_dump($linkProcess->getErrors());
            return 0;
        }
    }



    public function actionMy_processed_links(){
        $searchModel = new LinksProcessingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('my_processed_links', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionSearch_links(){


        $requirements = [];
        $queryWHERE = '';
        foreach (Requirements::find()->where(["enable" => 1,'show_at_search'=>1])->orderBy("sort")->all() as $requirement) {
            $requirements[$requirement->name] = new $requirement->class([], []);
            $requirements[$requirement->name]->link_id = 1;
            $requirements[$requirement->name]->loadData(Yii::$app->request->get()[ucfirst($requirement->name)]);
            $sqlAnswer = $requirements[$requirement->name]->getSQLSuitableLinksIDs();
            if($sqlAnswer !== true) {
                $queryWHERE .= ' AND id IN('.$sqlAnswer.')';

            }
        }


        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM {{%project_links}} WHERE enable=0'.$queryWHERE)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM {{%project_links}} WHERE enable=0 '.$queryWHERE,
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'title',
                    'view_count',
                    'created_at',
                ],
            ],
        ]);
        $dataProvider->pagination->setPageSize(2);



        return $this->render('search_links', [
            'dataProvider' => $dataProvider,
            'requirements' => $requirements,
        ]);
    }


    /**
     * Deletes an existing ProjectLinks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectLinks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectLinks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProjectLinks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
