<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\ProjectLinks */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('projects', 'Project Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-links-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('projects', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('projects', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('projects', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'project_id',
            'title',
            'alias:ntext',
        ],
    ]) ?>

</div>
