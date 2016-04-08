<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

if (isset($data)) {
    $obj = json_decode($data->info);
    echo '<h3>PayPal Email</h3>';
    echo $obj->email;
}
?>
