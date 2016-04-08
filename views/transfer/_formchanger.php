<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

if (isset($data)):
    $obj = json_decode($data->info);
?>


<h3>Bank Info</h3>
<ul>
    <li><b>Name : </b><?= $obj->name ?></li>
    <li><b>phone : </b><?= $obj->phone ?></li>
    <li><b>address : </b><?= $obj->address ?></li>
    <li><b>cashier_name : </b><?= $obj->cashier_name ?></li>
</ul>
<?php endif; ?>