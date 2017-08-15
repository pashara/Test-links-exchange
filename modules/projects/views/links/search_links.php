<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
?>


<?php $form = ActiveForm::begin([
    'action' =>['/projects/links/search_links'],
    'method' => 'get',
    'id'=>'links-form',
    'enableClientValidation'=>false,
    'enableAjaxValidation'=>false,
    'options' => ['data-pjax' => false]

]); ?>


    <?
    foreach($requirements as $requirementModel) {
        echo $requirementModel->render($form, $requirementModel);
    }
    ?>
<?= Html::submitButton('Подобрать', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
<?
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_search_links',
]);