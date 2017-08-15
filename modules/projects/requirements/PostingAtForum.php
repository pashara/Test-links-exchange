<?php

namespace app\modules\projects\requirements;

use app\modules\projects\models\LinksRequirements;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

class PostingAtForum extends RequirementsModel
{



    public $value;
    public $id = 1;
    public $list = [0 => 'Форумы', 1 => 'Доски объявлений', 2 => 'Отзовики'];
    public $cost = [
        0=>[parent::RUB=>20,parent::USD=>10,parent::UAH=>25],
        1=>[parent::RUB=>10,parent::USD=>5,parent::UAH=>14],
        2=>[parent::RUB=>5,parent::USD=>1,parent::UAH=>6],
    ];

    public function __construct(array $config = [],$selectedItemsNames)
    {
        parent::__construct($config);
    }

    public function getSQLSuitableLinksIDs(){
        if(empty($this->value))
            return true;
        $in = '(';
        if(is_array($this->value))
            for($i = 0; $i<count($this->value); $i++){
                $in.= (($i == 0)?'':',').$this->value[$i];
            }
        $in.= ')';

        return 'SELECT lr.link_id FROM {{%links_requirements}} lr
                WHERE lr.value in '.$in.' AND lr.requirement_id = '.$this->id.'
                GROUP BY lr.link_id';
                //HAVING count(1)='.count($this->value);
    }


    public function loadData($data){
        $this->value = $data['value'];
    }


    /**
     *
     * Override, потому что работает с массивом
     */
    public function loadDataFromDB(){
        if($this->link_id) {
            $models = LinksRequirements::find()->where(['link_id' => $this->link_id])->andWhere(['requirement_id' => $this->id])->all();
            foreach($models as $model) {
                $this->value[] = $model->value;
            }
        }
    }

    public function saveByLinkID($link_id){
        if($this->getValue()) {
            if ($this->id != null) {
                foreach($this->getValue() as $value) {
                    $model = new LinksRequirements();
                    $model->link_id = $link_id;
                    $model->requirement_id = $this->id;
                    $model->value = [$value];
                    $model->save();
                }
            }
        }
    }


    public function getValue(){
        return $this->value;
    }

    public function render($form,$model){




        return $form->field($model, 'value', [
                            'template' => "<div class='col-sm-3'>{label}</div><div class='col-sm-7'>\n{input}</div>\n{hint}\n{error}",
                        ])
                        ->inline()
                        ->checkboxList($this->list, [

                            'item' => function($index, $label, $name, $checked, $value) {
                                $checked = $checked ? 'checked' : '';
                                $data = '';
                                if(isset($this->cost[$index])){
                                    foreach($this->cost[$index] as $key=>$value){
                                        $data.="data-".$key."='".$value."'";
                                    }
                                }

                                return "<label class='checkbox-inline'><input type='checkbox' {$checked} name='{$name}' value='{$index}' class='costField' $data > {$label}</label>";
                                //return "<label class='checkbox col-md-4' style='font-weight: normal;'><input type='checkbox' {$checked} name='{$name}' value='{$value}'>{$label}</label>";
                            }
                        ]);



        return $form->field($model, 'value')->checkboxlist($this->list,['class'=>'costField',
        'item' =>
                function ($index, $label, $name, $checked, $value) {


                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'id'=>$name,
                        'label' => '<label for="' . $name . '">' . $label . '</label>',
                        'data'=>$this->cost[$index],
                        'labelOptions' => [
                            'class' => 'ckbox ckbox-primary col-md-4',
                        ],
                        //'template'=>'<div class="checkbox"><label><input type="checkbox" name="PostingAtForum[value][]" value="0"> Форумы</label></div>',
                        //'id' => $label,
                    ]);
                },
            'itemOptions'=>[
                'template'=>'<div class="item">{input}{label}</div>'
            ],
        ]);
 //       return $form->field($model, 'value')->checkbox(['data'=>$this->cost,'class'=>'costField']);
    }


    public function attributeLabels() {
        return [
            'value' => 'Постить на',
        ];
    }

    public function rules()
    {
        return [
            [['value'], 'each', 'rule' => ['integer']],
        ];
    }

}
