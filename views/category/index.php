<?php
use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
$articlesurl = Yii::t('app', 'articles-url');
?>
<div class="category-index">
    <div class="row">
        <?php
        $mainMenu = [];
        foreach ($menu as $menuData) {
            if ($menuData->parent) {
                $mainMenu[$menuData->parent]['sub'][] = ['id' => $menuData->id, 'title' => $menuData->title, 'url' => $menuData->url_link,
                    'lang' => $menuData->lang
                ];
            } else {
                $mainMenu[$menuData->id] = ['id' => $menuData->id, 'title' => $menuData->title, 'url' => $menuData->url_link,
                    'lang' => $menuData->lang
                ];
            }
        }
        ?>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="pull-left">English Category</h2>
                    <div class="pull-right">
                        <?= Html::a('Add Category', ['create', 'lang' => 'en'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <hr/>
            <ul style="font-size: 20px;">
                <?php foreach ($mainMenu as $mData) : ?>
                    <?php
                    if ($mData['lang'] == 'en') : ?>
                        <li <?php if (isset($mData['sub'])): ?><?php endif; ?>>
                            <a style="font-weight: bold;"
                               href="<?= "https://www.hangshare.com/articles/{$mData['url']}" ?>"><?= $mData['title'] ?></a>
                            <?= Html::a(' (Add)', ['create', 'par' => $mData['id'], 'lang' => 'en']) ?>
                            <?= Html::a(' (Edit)', ['update', 'id' => $mData['id'], 'lang' => 'en']) ?>
                            <?=
                            Html::a(' (delete)', ['delete', 'id' => $mData['id']], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete the category?',
                                    'method' => 'post'
                                ]
                            ])
                            ?>
                            <?php if (isset($mData['sub'])): ?>
                                <ul class="supdropdown">
                                    <?php foreach ($mData['sub'] as $submenu) : ?>
                                        <li><?php echo Html::a($submenu['title'], "https://www.hangshare.com/articles/{$mData['url']}/{$submenu['url']}"); ?>
                                            <?= Html::a(' (Edit)', ['update', 'id' => $submenu['id'],'lang'=>'en']) ?>
                                            <?=
                                            Html::a(' (delete)', ['delete', 'id' => $submenu['id'],'lang'=>'en'], [
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete the category?',
                                                    'method' => 'post',
                                                ]
                                            ])
                                            ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="pull-left">Arabic Category</h2>
                    <div class="pull-right">
                        <?= Html::a('Add Category', ['create', 'lang' => 'ar'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <hr/>
            <ul style="font-size: 20px;">
                <?php foreach ($mainMenu as $mData) : ?>
                    <?php if ($mData['lang'] == 'ar') : ?>
                        <li <?php if (isset($mData['sub'])): ?><?php endif; ?>>
                            <a style="font-weight: bold;"
                               href="<?= "https://www.hangshare.com/مواضيع/{$mData['url']}" ?>"><?= $mData['title'] ?></a>
                            <?= Html::a(' (Add)', ['create', 'par' => $mData['id'], 'lang' => 'ar']) ?>
                            <?= Html::a(' (Edit)', ['update', 'id' => $mData['id'], 'lang' => 'ar']) ?>
                            <?=
                            Html::a(' (delete)', ['delete', 'id' => $mData['id']], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete the category?',
                                    'method' => 'post',
                                ]
                            ])
                            ?>
                            <?php if (isset($mData['sub'])): ?>
                                <ul class="supdropdown">
                                    <?php foreach ($mData['sub'] as $submenu) : ?>
                                        <li><?php echo Html::a($submenu['title'], "https://www.hangshare.com/مواضيع/{$mData['url']}/{$submenu['url']}"); ?>
                                            <?= Html::a(' (Edit)', ['update', 'id' => $submenu['id'], 'lang' => 'ar']) ?>
                                            <?=
                                            Html::a(' (delete)', ['delete', 'id' => $submenu['id'], 'lang' => 'ar'], [
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete the category?',
                                                    'method' => 'post',
                                                ]
                                            ])
                                            ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>