<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\models\TransferMethod;

$this->title = $model->name;
?>
<div class="container m-t-25">
    <div class="row">
        <div class="col-md-4">
            <div class="clr-gray-dark">
                <a href="<?php echo Yii::$app->urlManager->createUrl(['user/update', 'id' => $model->id]); ?>">
                    <div style="padding: 0 20px;">
                        <h1><?php echo $model->name; ?></h1>
                    </div>
                    <div class="panel-footer">
                        <div style="display: table; margin: 0 auto;">
                            <span> Edit User Settings <i class="fa fa-gear pull-left m-t-3"></i></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <a class="dsp--b" href="<?php echo Yii::$app->urlManager->createUrl(['/user/payment']); ?>">
                <div class="panel panel-default text-center clr-gray-dark">
                    <div class="carda__body pdn--as text-center">
                        <div class="row no-gutter">
                            <div class="col-sm-6 clr-greenflat text-center ">
                                <h4 class="mrg--vt text-center">
                                    Total Amount
                                </h4>
                                <span class="text-mega text-center"><span dir="rtl">$<?= money_format('%i',$model->userStats->available_amount); ?></span></span>
                            </div>
                            <div class="col-sm-6 text-center">
                                <h4 class="mrg--vt text-center">
                                    Amount ready for transaction  
                                </h4>
                                <span class="clr-bluewood text-mega text-center"><span dir="rtl">$<?= number_format($model->userStats->cantake_amount, 3); ?></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer bg-white text-meta text-zeta text-right-xs">
                        <div class="row no-gutter">
                            <div class="col-xs-12">
                                <div class="font-18 pull-left m-t-8 col-xs-6 text-center">                            <span>المشاهدات غير المدفوعة: <i class="fa f-progress"></i></span>
                                    <b class="clr-bluewood"><span dir="rtl"><?php echo number_format($model->userStats->post_views); ?></span></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <h4>Transaction Methods</h4>
            <?php
            $tr = TransferMethod::find()->where('userId = ' . $model->id)->all();
            foreach ($tr as $data) {
                $obj = json_decode($data->info);
                echo '<ul class="list-unstyled">';
                if ($data->type == 1) {
                    echo '<li>PayPal</li>';
                    echo '<li><ul><li>' . $obj->email . '</li></ul></li>';
                }
                if ($data->type == 2) {
                    echo '<li>Bank</li>';
                    echo '<li><ul>';
                    echo '<li><b>Name : </b>' . $obj->name . '</li>';
                    echo '<li><b>Account : </b>' . $obj->account . '</li>';
                    echo '<li><b>Bank Name : </b>' . $obj->bank_name . '</li>';
                    echo '<li><b>Bank Branch : </b>' . $obj->bank_branch . '</li>';
                    echo '<li><b>IBAN : </b>' . $obj->IBAN . '</li>';
                    echo '</ul></li>';
                }
                if ($data->type == 3) {
                    echo '<li>Exchange</li>';
                    echo '<li><ul>';
                    echo '<li><b>Name : </b>' . $obj->name . '</li>';
                    echo '<li><b>Phone : </b>' . $obj->phone . '</li>';
                    echo '<li><b>Address : </b>' . $obj->address . '</li>';
                    echo '<li><b>Cashier Name : </b>' . $obj->cashier_name . '</li>';
                    echo '</ul></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="clr-gray-dark">
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                    <div data-ui="slimScroll" class="panel" style="overflow: hidden; width: auto;">
                        <div class="col-md-12" style="padding: 20px;">
                            <ul class="list-unstyled">
                                <li><b> Date of birth : </b><?php echo $model->dob; ?></li>
                                <li><b> Sex : </b><?php echo $model->gender == 1 ? 'Male' : 'Female'; ?></li>
                                <li><b> Total Views : </b><?php echo number_format($model->userStats->post_total_views); ?></li>
                                <li><b> Number of articles : </b><?php echo number_format($model->userStats->post_count); ?></li>
                                <li><b> Sign Up Date  : </b><?php echo date('d-m-Y', strtotime($model->created_at)); ?></li>
                                <li><b> Location : </b>
                                    <?php
                                    if (isset($model->country) && $model->country != 0 && isset($model->location))
                                        echo $model->location->name_ar;
                                    else
                                        echo 'Not Spesified';
                                    ?></li>
                            </ul>
                            <b>About : </b>
                            <p>
                                <?php
                                if (empty($model->bio)) {
                                    echo 'No info';
                                } else {
                                    echo Html::encode($model->bio);
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>