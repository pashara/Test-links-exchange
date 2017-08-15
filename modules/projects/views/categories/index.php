<?php

use app\modules\projects\models\ProjectCategories;
use kartik\tree\TreeView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\projects\models\ProjectCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('projects', 'Project Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-categories-index">


    <?php
    echo TreeView::widget([
        // single query fetch to render the tree
        'query'             => ProjectCategories::find()->addOrderBy('root, lft'),
        'headingOptions'    => ['label' => Yii::t('projects', 'Project Categories')],
        'isAdmin'           => true,                       // optional (toggle to enable admin mode)
        'displayValue'      => 1,                           // initial display value
        //'softDelete'      => true,                        // normally not needed to change
        'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
    ]);
    ?>

</div>
