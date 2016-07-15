<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Faq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faq-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'categoryId')->dropDownList($model::$CategoryStr) ?>
    <?= $form->field($model, 'question')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'answer')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->checkbox() ?>
    <?= $form->field($model, 'published')->checkbox() ?>
    <?= $form->field($model, 'lang')->dropDownList(['ar' => 'Arabic', 'en' => 'English'], ['prompt' => '']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
