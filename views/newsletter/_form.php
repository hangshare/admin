<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailQueue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4">
    <?php $form = ActiveForm::begin(['id' => 'previewEmail']); ?>
    <?= $form->field($model, 'type')->dropDownList($model->typeStr) ?>
    <?= $form->field($model, 'subject')->textInput() ?>
    <div id="NewsLetter" style="display: none">
        <?= $form->field($model, 'postNum')->textInput() ?>
        <?= $form->field($model, 'postType')->dropDownList($model->postTypeStr) ?>
        <div id="customSelect" style="display: none">
            <?= $form->field($model, 'SelectedPosts')->textInput() ?>
        </div>
    </div>
    <div id="customEmail" style="display: none">
        <?= $form->field($model, 'body')->textarea() ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="col-md-8">
    <div id="prev-content">
    </div>
</div>