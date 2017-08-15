<?php

use app\models\Tree;
use app\modules\projects\models\ProjectCategories;
use dosamigos\ckeditor\CKEditor;
use kartik\tree\TreeView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    ul.categories_list{
        list-style-type: none;
        padding-left: 0px;
    }
    ul.categories_list label {
        width: 100%;
        margin-left: -13px;
        padding-left: 20px;
    }
    ul.categories_list ul{
        list-style-type: none;
        padding-left: 15px;
    }
</style>

<link href="/assets/8c7074b9/css/kv-tree.css" rel="stylesheet">
<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

    <?=$modelCategories->checkBoxFields([
            //'list_class'=>'kv-tree',
            //'li_template'=>'<li class="kv-tree"><div class="kv-tree-list" tabindex="-1">
             //       <div class="kv-node-indicators">{checkbox}</div>
             //       <div class="kv-node-detail kv-focussed" tabindex="-1">{label}</div>
             //       </div></li>'
    ]);?>


    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>


    <div class="form-group">
        <?=HTML::a("Ссылки к проекту",['/projects/links/index/','ProjectLinksSearch[project_id]'=>$model->id]);?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('projects', 'Create') : Yii::t('projects', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
