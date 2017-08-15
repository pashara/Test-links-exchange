<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\users\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
    ]); ?>

    <?= $form->field($model, 'username',['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'email',['enableAjaxValidation' => true])->input('email')->hint('Please enter your e-mail adress') ?>



    <?/*
    echo $form->field($model, 'group_id')->dropDownList([
    '0' => 'Рабочий',
    '1' => 'Работодатель',
    ],[
        'prompt' => 'Выберите тип аккаутнта'
    ]);*/
    ?>

    <?= $form->field($model, 'password_input')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
