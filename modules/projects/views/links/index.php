<?php

use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\projects\models\ProjectLinksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('links', 'Project Links');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-links-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('links', 'Create Project Links'), ['create','project_id'=>@$_GET['ProjectLinksSearch']['project_id']], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'project_id',
            'title',
            'alias:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{start_link}',
                'buttons' => [
                    'start_link' => function ($url,$model,$key) {
                        return Html::a('Действие', $url);
                    },
                ],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
