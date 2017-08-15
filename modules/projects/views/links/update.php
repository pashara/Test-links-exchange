<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\ProjectLinks */

$this->title = Yii::t('projects', 'Update {modelClass}: ', [
    'modelClass' => 'Project Links',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('projects', 'Project Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('projects', 'Update');
?>
<div class="project-links-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'models' => $models,
    ]) ?>

</div>
