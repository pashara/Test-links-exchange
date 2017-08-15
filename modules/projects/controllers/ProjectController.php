<?php

namespace app\modules\projects\controllers;

use app\modules\projects\models\ProjectToCategories;
use Yii;
use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
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
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();
        $modelCategories = new ProjectToCategories(['scenario' => ProjectToCategories::SCENARIO_MULTI_CREATE]);
        $validate1 = false;
        $validate2 = false;


        if($model->load(Yii::$app->request->post())) {
            $validate1 = $model->validate();
            $modelCategories->category_id_array = Yii::$app->request->post()['category_id_array'];
            $validate2 = $modelCategories->validate();
        }

        if($validate1 && $validate2){
            $model->save();
            ProjectToCategories::multiInsertUnsafe($modelCategories->category_id_array, $model->id);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelCategories' => $modelCategories,
            ]);
        }
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelCategories = new ProjectToCategories(['scenario' => ProjectToCategories::SCENARIO_MULTI_UPDATE]);
        $validate1 = false;
        $validate2 = false;

        if(isset(Yii::$app->request->post()['category_id_array']))
            $modelCategories->category_id_array =Yii::$app->request->post()['category_id_array'];
        else {
            foreach(ProjectToCategories::find()->select('category_id')->where(['project_id' => $model->id])->asArray()->all() as $item_id){
                $modelCategories->category_id_array[] = $item_id['category_id'];
            }
        }

        if($model->load(Yii::$app->request->post())) {
            $modelCategories->project_id = $model->id;
            $validate1 = $model->validate();
            $validate2 = $modelCategories->validate();
        }

        if ($validate1 && $validate2) {
            $model->save();
            ProjectToCategories::multiInsertUnsafe($modelCategories->category_id_array, $modelCategories->project_id);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelCategories' => $modelCategories,
            ]);
        }
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
