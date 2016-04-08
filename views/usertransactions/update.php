<style>
    .currentPayment{
        background-color: rgba(12, 109, 136, 0.38);
        padding: 10px;
    }
</style>
<?php

use yii\helpers\Html;
use app\models\TransferMethod;

/* @var $this yii\web\View */
/* @var $model app\models\UserTransactions */

$this->title = 'Update User Transactions: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-transactions-update">
    <h2>User Info</h2>
    <ul class="list list-unstyled">
        <li><b>Name : </b> <?php echo $model->user->name; ?></li>
        <li><b>Amount : </b> <?php echo $model->amount; ?></li>
        <li><b>Transaction Status : </b> <?php echo $model->status ? '<span class="label label-success">Received</span>' : '<span class="label label-warning">Processing</span>'; ?></li>
        <li><b>Request Date/Time : </b> <?php echo $model->created_at; ?></li>
    </ul>
    <br><br>
    <h2>Transaction Methods</h2>
    <?php
    $tr = TransferMethod::find()->where('userId = ' . $model->userId)->all();

    foreach ($tr as $data) {
        $obj = json_decode($data->info);
        echo '<ul class="list-unstyled">';
        if ($data->type == 1) {
            if ($model->user->transfer_type == 1) {
                echo '<div class="currentPayment">';
            }
            echo '<li>PayPal</li>';
            echo '<li><ul><li>' . $obj->email . '</li></ul></li>';
            if ($model->user->transfer_type == 1) {
                echo '</div>';
            }
        }
        if ($data->type == 2) {
            if ($model->user->transfer_type == 2) {
                echo '<div class="currentPayment">';
            }
            echo '<li>Bank</li>';
            echo '<li><ul>';
            echo '<li><b>Name : </b>' . $obj->name . '</li>';
            echo '<li><b>Account : </b>' . $obj->account . '</li>';
            echo '<li><b>Bank Name : </b>' . $obj->bank_name . '</li>';
            echo '<li><b>Bank Branch : </b>' . $obj->bank_branch . '</li>';
            echo '<li><b>IBAN : </b>' . $obj->IBAN . '</li>';
            echo '</ul></li>';
            if ($model->user->transfer_type == 2) {
                echo '</div>';
            }
        }
        if ($data->type == 3) {
            if ($model->user->transfer_type == 3) {
                echo '<div class="currentPayment">';
            }
            echo '<li>Exchange</li>';
            echo '<li><ul>';
            echo '<li><b>Name : </b>' . $obj->name . '</li>';
            echo '<li><b>Phone : </b>' . $obj->phone . '</li>';
            echo '<li><b>Address : </b>' . $obj->address . '</li>';
            echo '<li><b>Cashier Name : </b>' . $obj->cashier_name . '</li>';
            if ($model->user->transfer_type == 3) {
                echo '</div>';
            }
            echo '</ul></li>';
        }
        echo '</ul>';
    }
    ?>

    <?php
    if (!$model->status)
        echo $this->render('_form', ['model' => $model])
        ?>
</div>
