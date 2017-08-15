<?
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
//var_dump($model);
?>


<div class="blog-post">
    <h2 class="blog-post-title"><?= Html::encode($model['title']) ?></h2>
    <p class="blog-post-meta">December 23, 2013 by <a href="#">Jacob</a></p>

    <p><strong>ID:</strong><?=$model['id']?></p>
    <p><strong>ALIAS:</strong><?=$model['alias']?></p>
    <p><strong>TOTAL:</strong><?=$model['total']?></p>
    <p><strong>DONE:</strong><?=$model['done']?></p>

</div>
