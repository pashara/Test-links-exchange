<? use app\modules\projects\models\ProjectLinksCost;
use app\modules\projects\models\Requirements;
use yii\bootstrap\Tabs;
use yii\helpers\Html;

?>
<div class="form-group"  style="position:relative">


    <? if(!($models['links']->id)){?>
    <style>
        div.disAbleItems{
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #ccc;
            z-index: 100;
            opacity: 0.8;
            text-align: center;
            font-size: 26px;
            vertical-align: middle;
            line-height: 100px;
        }
    </style>
    <div class="disAbleItems">
        Доступно после сохранения
    </div>
    <? }?>

    <?= $form->field($models['links'], 'enable')->dropDownList([0=>'Отключено',1=>'Включено'],['onchange'=>'$("#currencyTabs>li:first>a").text($(this).find("option:selected").text())']) ?>




    <?php

$js = <<< 'SCRIPT'
    $('input[data-toggle="tooltip"],select[data-toggle="tooltip"]').tooltip({
        placement: "left",
        trigger: "focus"
    });
    $('label[data-toggle="tooltip"]').tooltip({
        placement: "left",
        trigger: "hover"
    });
SCRIPT;
$this->registerJs($js);




    if($models['requirements'])
        foreach($models['requirements'] as $requirementModel) {
            echo $requirementModel->render($form, $requirementModel);
        }

     $currencyItems = [];

    if($models['cost'])
        foreach($models['cost'] as $costModel) {
            $active = (($models['links']->default_currency == $costModel->info->id) ? true : false);

            $currencyItems[] = [
                'label' => $costModel->info->title,
                'headerOptions' => ['id' => 'currency_'.$costModel->info->id],
                'content' => $form->field($costModel, 'value')->textInput(['maxlength' => 4,'enableAjaxValidation'=>true,'enableClientValidation'=>false, 'class'=>'form-control costField '.(($active)?'default':'')]),
                'active' => $active,
            ];
        }



    echo Tabs::widget([
        'items' => $currencyItems,
        'id'=>'currencyTabs',

    ]);
    ?>

<? if(($models['links']->id)){?>
<style>
    .form-group.requirement{
        position: relative;
    }
    .form-group.requirement s{
        text-decoration: none;
        color:red;
    }
    .form-group .requirements{
        position: relative;
        border: 1px solid;
        padding: 5px;
        margin-bottom: 5px;
    }
    .form-group .requireBlock{
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #ccc;
        opacity: 0.5;
        z-index: 10;
    }

</style>


    <div id="totalCount">
        Итого:<b><?=Yii::$app->formatter->format($models['links']->total,['decimal'])?></b>
    </div>
    <?}?>
</div>




<?php
$script = <<< JS
    function updateCost(){
        var default_currency = $('#projectlinks-default_currency').val();
        var commonSumm = 0.0;
        $(".costField").each(function () {
            if($(this).is("input[type='checkbox']") || $(this).is("input[type='radio']")){
                if($(this).is(":checked")){
                    commonSumm += parseFloat($(this).attr('data-'+default_currency));
                }
            }
            if($(this).is("input[type='text']") || $(this).is("input[type='number']")){
                if(!isNaN(parseFloat($(this).val()))){
                    if($(this).hasClass("default"))
                        commonSumm += parseFloat($(this).val().replace(",","."));
                }
            }
        });
        $("#totalCount>b").text(commonSumm.toFixed(2));
    }
    
    
    $('.costField,#projectlinks-default_currency').on('change',function(){
        updateCost();
    });
    
    
    
    $('#projectlinks-default_currency').on('change',function(){
        $("#currencyTabs").parent().find(".tab-content>.tab-pane.active input").removeClass("default");
        $("#currencyTabs>li#currency_"+$(this).find("option:selected").val()+">a").trigger("click");
        $("#currencyTabs").parent().find(".tab-content>.tab-pane.active input").addClass("default");
    });
    updateCost();
    
    
    /*$("#links-form").on("ajaxComplete", function (event, messages) {
        var errorCssClass = $(this).data().yiiActiveForm.settings.errorCssClass;
        var successCssClass = $(this).data().yiiActiveForm.settings.successCssClass;
        //console.log(messages);
        $.each($("#links-form").find( 'div.requirement.'+errorCssClass ),function(index, value){
            $(this).removeClass(errorCssClass);
            $(this).find('div.help-block').text('');
        });
        $.each(messages.responseJSON,function(index, value){
            if ( $("#links-form").find( '.field-requirements-'+index ).length != 0  ) {
                $("#links-form").find( '.field-requirements-'+index).addClass(errorCssClass);
                $("#links-form").find( '.field-requirements-'+index+' div.help-block').text(value);
           }
        });
      //var attributes = $(this).data().attributes; // to get the list of attributes that has been passed in attributes property
      //var settings = $(this).data().settings; // to get the settings
    });
    */
    
    
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);

?>