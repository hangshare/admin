<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PostComments */

$this->title = 'Create Post Comments';
$this->params['breadcrumbs'][] = ['label' => 'Post Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
