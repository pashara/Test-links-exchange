<?php

use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\projects\models\ProjectLinksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('links', 'Project Links');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('links', 'Project Links'),
    'url' => ['/projects/links/index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-links-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'link_title',
                'value' => 'link.title'
            ],
            [
                'attribute' => 'link_alias',
                'value' => 'link.alias'
            ],
            [
                'attribute' => 'link_allow_once',
                'value' => 'link.allow_once'
            ],
            [
                'attribute' => 'link_number',
                'value' => 'link.number'
            ],
            [
                'attribute' => 'date_start',
                'value' => 'date_start',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_start',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Select issue date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ]),
            ],
            [
                'attribute' => 'date_end',
                'value' => 'date_end',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_end',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Select issue date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ]),
            ],
            [
                'attribute' => 'link_enable',
                'filter'=>['0'=>'Отключена','1'=>'Доступна'],
                'content' => function($data){return ($data->link->enable == 0)?'Отключена':'Доступна';},
                'visible' => true,
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
