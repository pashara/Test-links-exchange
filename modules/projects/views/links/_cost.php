<?= $form->field($model, 'value')->textInput(
    [
        'name'=>'ProjectLinksCost['.$model->currency_id.']',
        'class'=>'costField form-control',
        'type'=>'number',
        'step'=>'0.01',
    ]
)->label($model->currencyName->code)?>