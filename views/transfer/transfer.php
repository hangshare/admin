<?php  $this->title = 'طريقة تحويل النقود'; ?>
<h1>طرق تحويل النقود لك</h1>
<p>الرجاء اختيار الطريقة التي تناسبكم لتحويل النقود لكم من خلالها.</p>
<br>
<ul class="list list-inline">
    <li><a id="paypal" href="javascript:void(0);" class="btn <?php echo ($this->params['user']->transfer_type == 1 || $this->params['user']->transfer_type == 0) ? 'btn-warning' : 'btn-default'; ?> showclick">PayPal</a></li>
    <li><a id="bank" href="javascript:void(0);" class="btn <?php echo $this->params['user']->transfer_type == 2 ? 'btn-warning' : 'btn-default'; ?> showclick">حوالة بنكية</a></li>
    <li><a id="moneychanger" href="javascript:void(0);" class="btn <?php echo $this->params['user']->transfer_type == 3 ? 'btn-warning' : 'btn-default'; ?> showclick">حوالة شخصية (من خلال صراف)</a></li>
</ul>
<br>
<?php
$paypal = null;
$bank = null;
$moneychanger = null;
foreach ($model as $data) {
    if ($data->type == 1)
        $paypal = $data;
    if ($data->type == 2)
        $bank = $data;
    if ($data->type == 3)
        $moneychanger = $data;
}
?>
<div id="paypal_form" <?php echo ($this->params['user']->transfer_type == 1 || $this->params['user']->transfer_type == 0) ? '' : 'style="display: none;"'; ?>>
    <?= $this->render('//transfer/_formpaypal', ['data' => $paypal]); ?>
</div>
<div id="bank_form" <?php echo $this->params['user']->transfer_type != 2 ? 'style="display: none;"' : ''; ?>>
    <?= $this->render('//transfer/_formbank', ['data' => $bank]); ?>
</div>
<div id="moneychanger_form" <?php echo $this->params['user']->transfer_type != 3 ? 'style="display: none;"' : ''; ?>>
    <?= $this->render('//transfer/_formchanger', ['data' => $moneychanger]); ?>
</div>