<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\Project */

$this->title = Yii::t('projects', 'Create Project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('projects', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelCategories' => $modelCategories,
    ]) ?>

</div>
