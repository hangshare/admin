<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PostView */

$this->title = 'Create Post View';
$this->params['breadcrumbs'][] = ['label' => 'Post Views', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
