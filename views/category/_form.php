<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="category-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'اخبار اقتصادية']) ?>

    <?= $form->field($model, 'url_link')->textInput(['maxlength' => true, 'placeholder' => 'اخبار-اقتصادية']) ?>


    <?php echo $form->field($model, 'lang')->hiddenInput(['value' => $_GET['lang']])->label(false) ?>

    <?php
    if (isset($_GET['par'])) {
        $model->parent = $_GET['par'];
    }
    echo $form->field($model, 'parent')->dropDownList(ArrayHelper::map(Category::find()
        ->where(['parent' => null, 'lang' => $_GET['lang']])
        ->all(), 'id', 'title'), ['prompt' => ' Main Category']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
