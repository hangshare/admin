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
        <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>
        <p class="pull-right"><?= Html::a('Add Category', ['create'], ['class' => 'btn btn-success']) ?></p>
    </div>
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
            <ul>
                <?php foreach ($mainMenu as $mData) : ?>
                    <?php
                    if ($mData['lang'] == 'en') : ?>
                        <li <?php if (isset($mData['sub'])): ?><?php endif; ?>>
                            <a href="<?= "https://www.hangshare.com/articles/{$mData['url']}" ?>"><?= $mData['title'] ?></a>
                            <?= Html::a(' (Edit)', ['update','id'=>$mData['id']])?>
                            <?php if (isset($mData['sub'])): ?>
                                <ul class="supdropdown">
                                    <?php foreach ($mData['sub'] as $submenu) : ?>
                                        <li><?php echo Html::a($submenu['title'], "https://www.hangshare.com/articles/{$mData['url']}/{$submenu['url']}"); ?>
                                            <?= Html::a(' (Edit)', ['update','id'=>$submenu['id']])?>
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
            <ul>
                <?php foreach ($mainMenu as $mData) : ?>
                    <?php if ($mData['lang'] == 'ar') : ?>
                        <li <?php if (isset($mData['sub'])): ?><?php endif; ?>>
                            <a href="<?= "https://www.hangshare.com/مواضيع/{$mData['url']}" ?>"><?= $mData['title'] ?></a>
                            <?php
                            //echo
//                            Html::a('(delete)', 'delete', [
//                                'data' => [
//                                    'confirm' => 'Are you sure you want to delete the category?',
//                                    'method' => 'post',
//                                ]
//                            ])
                            ?>
                            <?= Html::a(' (Edit)', ['update','id'=>$mData['id']])?>
                            <?php if (isset($mData['sub'])): ?>
                                <ul class="supdropdown">
                                    <?php foreach ($mData['sub'] as $submenu) : ?>
                                        <li><?php echo Html::a($submenu['title'], "https://www.hangshare.com/مواضيع/{$mData['url']}/{$submenu['url']}"); ?>
                                            <?= Html::a(' (Edit)', ['update','id'=>$submenu['id']]) ?>
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