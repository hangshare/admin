<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPostView */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Views';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'userId',
                'label' => 'User Name/ID',
                'format' => 'raw',
                'value' => function ($data) {
                    if (!isset($data->user))
                        return '<i>Guest</i>';
                    return Html::a($data->user->name, 'http://www.hangshare.com/user/' . $data->userId, [
                                'target' => '_blank'
                    ]);
                },
                    ],
                    [
                        'attribute' => 'postId',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if (!isset($data->post))
                                return '<i>Deleted Post</i>';
                            return Html::a($data->post->title, 'http://www.hangshare.com/explore/' . $data->post->id . '?title=' . urlencode($data->post->title), [
                                        'target' => '_blank'
                            ]);
                        },
                            ],
                            'ip',
                            [
                                'attribute' => 'ip_info',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (empty($data->ip_info))
                                        return '';
                                    $obj = json_decode($data->ip_info);
                                    if (isset($obj->ip)) {
                                        if (isset($obj->country)) {
                                            $row = '<table>' .
                                                    '<tr><td> <strong>IP : </strong>' . $obj->ip . '</td></tr>' .
                                                    '<tr><td> <strong>COUNTRY : </strong>' . $obj->country . '</td></tr>' .
                                                    '<tr><td> <strong>Hostname : </strong>' . $obj->hostname . '</td></tr>' .
                                                    '<tr><td> <strong>city : </strong>' . $obj->city . '</td></tr>' .
                                                    '<tr><td> <strong>region : </strong>' . $obj->region . '</td></tr>' .
                                                    '</table>';
                                        } else {
                                            $row = '<table>' .
                                                    '<tr><td> <strong>IP : </strong>' . $obj->ip . '</td></tr>' .
                                                    '<tr><td> <strong>country_code : </strong>' . $obj->country_code . '</td></tr>' .
                                                    '<tr><td> <strong>country_name : </strong>' . $obj->country_name . '</td></tr>' .
                                                    '<tr><td> <strong>region_code : </strong>' . $obj->region_code . '</td></tr>' .
                                                    '<tr><td> <strong>region_name : </strong>' . $obj->region_name . '</td></tr>' .
                                                    '<tr><td> <strong>zip_code : </strong>' . $obj->zip_code . '</td></tr>' .
                                                    '<tr><td> <strong>time_zone : </strong>' . $obj->time_zone . '</td></tr>' .
                                                    '<tr><td> <strong>latitude : </strong>' . $obj->latitude . '</td></tr>' .
                                                    '<tr><td> <strong>longitude : </strong>' . $obj->longitude . '</td></tr>' .
                                                    '<tr><td> <strong>metro_code : </strong>' . $obj->metro_code . '</td></tr>' .
                                                    '</table>';
                                        }
                                    } else {
                                        $row = $data->ip_info;
                                    }
                                    return $row;
                                }
                            ],
                            [
                                'attribute' => 'user_agent',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (empty($data->user_agent))
                                        return '';
                                    $obj = json_decode($data->user_agent);
                                    $row = '<table>';
                                    if (isset($obj->REQUEST_TIME))
                                        $row.= '<tr><td> <strong>REQUEST_TIME : </strong>' . date('Y-m-d h:i:s', $obj->REQUEST_TIME) . '</td></tr>';
                                    if (isset($obj->HTTP_USER_AGENT))
                                        $row.='<tr><td> <strong>HTTP_USER_AGENT : </strong>' . $obj->HTTP_USER_AGENT . '</td></tr>';
                                    if (isset($obj->HTTP_ACCEPT_LANGUAGE))
                                        $row.= '<tr><td> <strong>HTTP_ACCEPT_LANGUAGE : </strong>' . $obj->HTTP_ACCEPT_LANGUAGE . '</td></tr>';
                                    if (isset($obj->HTTP_REFERER))
                                        $row.= '<tr><td> <strong>HTTP_REFERER : </strong>' . $obj->HTTP_REFERER . '</td></tr>';
                                    if (isset($obj->REQUEST_METHOD))
                                        $row.='<tr><td> <strong>REQUEST_METHOD : </strong>' . $obj->REQUEST_METHOD . '</td></tr>';
                                    $row.='</table>';
                                    return $row;
                                }
                            ],
                            'price',
                            'created_at',
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}'
                            ],
                        ],
                    ]);
                    ?>

</div>
