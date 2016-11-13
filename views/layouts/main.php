<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    if (!Yii::$app->user->isGuest) {
        NavBar::begin([
            'options' => ['class' => 'navbar-inverse navbar-fixed-top'],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Home', 'url' => Yii::$app->homeUrl],
                ['label' => 'Users', 'url' => ['/user/index']],
                ['label' => 'Transaction', 'url' => ['/usertransactions/index']],
                ['label' => 'Posts', 'url' => ['/post/index']],
                ['label' => 'Approval', 'url' => ['/post/approval']],
                ['label' => 'Bulk Email', 'url' => ['/newsletter/index']],
//                ['label' => 'Views', 'url' => ['/postview/index']],
                ['label' => 'Payment', 'url' => ['/userpayment/index']],
                ['label' => 'FAQ', 'url' => ['/faq/index']],
                ['label' => 'Sys Emails', 'url' => ['/emailtemplate/index']],
                ['label' => 'Sent Emails', 'url' => ['/useremail/index']],
                ['label' => 'Categories', 'url' => ['/category/index']],
                ['label' => 'Country', 'url' => ['/country/index']]
            ],
        ]);
        NavBar::end();
    }
    ?>
    <div class="container">
        <?=
        Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
        ?>
        <?= $content ?>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; HangShare <?= date('Y') ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
