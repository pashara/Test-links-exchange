<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $models['links'] app\modules\projects\models\ProjectLinks */
/* @var $form yii\widgets\ActiveForm */




?>
<style>
    .form-group.required>label:first-child:after{
        content: "*"; /* Добавляемый текст */
        color: #FF0000; /* Цвет текста */
        font-size: 90%; /* Размер шрифта */
        margin: 5px;
    }
</style>
<?if($models['links']->id){?>
    <?=$models['links']->done.'/'.$models['links']->number;?>
<?}?>
<div class="project-links-form">
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
        'id'=>'links-form',
        'enableClientValidation'=>true,
        'enableAjaxValidation'=>false,
         'options' => ['data-pjax' => true]

    ]); ?>

    <?= $form->field($models['links'], 'default_currency')->dropDownList(ArrayHelper::map(\app\models\Currency::find()->where(['allow_to_input'=>1])->all(),'id','title'),
        [
            'title' => 'В какой валюте ',
            'data-toggle' => 'tooltip',
        ]) ?>

    <?= $form->field($models['links'], 'title')->textInput([
            'maxlength' => 80,
            'title' => 'Краткое название ссылки',
            'data-toggle' => 'tooltip',
            ]) ?>

    <?= $form->field($models['links'], 'alias')->textInput([
            'maxlength' => 30,
            'title' => 'Tooltip content',
            'data-toggle' => 'tooltip',
            ]) ?>

    <?= $form->field($models['links'], 'number')->textInput([
            'maxlength' => 4,
            'title' => 'Tooltip content',
            'data-toggle' => 'tooltip',
            'enableClientValidation'=>true,
        ]) ?>

    <?= $form->field($models['links'], 'done')->hiddenInput([
            'maxlength' => 4,
            'disabled' => true,
            'title' => 'Tooltip content',
            'data-toggle' => 'tooltip',
        ])->label(false)->hint('Должно быть больше или равно '.$models['links']->done) ?>



    <?if(!$models['links']->id){?>
        <div class="form-group">
            <?= Html::submitButton($models['links']->isNewRecord ? Yii::t('projects', 'Create') : Yii::t('projects', 'Update'), ['class' => $models['links']->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?}?>







    <? echo $this->render('_form_afterSave', [
        'models' => $models,
        'form' => $form,
    ]) ?>


    <?if($models['links']->id){?>
        <div class="form-group">
            <?= Html::submitButton($models['links']->isNewRecord ? Yii::t('projects', 'Create') : Yii::t('projects', 'Update'), ['class' => $models['links']->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?}?>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
