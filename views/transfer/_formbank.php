<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

if (isset($data)):
    $obj = json_decode($data->info);
    ?>
    <h3>Bank Info</h3>
    <ul>
        <li><b>Name : </b><?= $obj->name ?></li>
        <li><b>account : </b><?= $obj->account ?></li>
        <li><b>bank_name : </b><?= $obj->bank_name ?></li>
        <li><b>bank_branch : </b><?= $obj->bank_branch ?></li>
        <li><b>bank_branch : </b><?= $obj->bank_branch ?></li>
        <li><b>IBAN : </b><?= $obj->IBAN ?></li
    </ul>

<?php endif; ?>