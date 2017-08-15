<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\ProjectLinks */

$this->title = Yii::t('links', 'Create Project Links');
$this->params['breadcrumbs'][] = ['label' => Yii::t('links', 'Project Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-links-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'models' => $models,
    ]) ?>

</div>
