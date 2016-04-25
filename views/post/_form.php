<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">
    <form method="post" action="<?= Yii::$app->urlManager->createUrl('//post/inc') ?>">
        <lable>Add Views</lable>
        <input name="views" type="text" class="form-control">
        <lable>View Price</lable>
        <input name="price" type="text" class="form-control">
        <input name="id" type="hidden" value="<?= $model->id ?>">
        <input name="userId" type="hidden" value="<?= $model->userId ?>">
        <input type="submit" class="btn btn-primary" value="Add">
    </form>
</div>
