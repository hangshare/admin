<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserTransactions */
/* @var $form yii\widgets\ActiveForm */
$s3FormDetails = getS3Details('hangshare.admin');

function getS3Details($s3Bucket, $region = 'us-east-1', $acl = 'public-read') {
    $awsKey = 'AKIAIXXCGXOS77W753RQ';
    $awsSecret = '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';
    $algorithm = "AWS4-HMAC-SHA256";
    $service = "s3";
    $date = gmdate("Ymd\THis\Z");
    $shortDate = gmdate("Ymd");
    $requestType = "aws4_request";
    $expires = "86400";
    $successStatus = "201";
    $url = "http://s3.amazonaws.com/{$s3Bucket}/";
    $scope = [
        $awsKey,
        $shortDate,
        $region,
        $service,
        $requestType
    ];
    $credentials = implode('/', $scope);
    $policy = [
        'expiration' => gmdate('Y-m-d\TG:i:s\Z', strtotime('+6 hours')),
        'conditions' => [
            ['bucket' => $s3Bucket],
            ['acl' => $acl],
            ['starts-with', '$key', ''],
            ['starts-with', '$Content-Type', ''],
            ['success_action_status' => $successStatus],
            ['x-amz-credential' => $credentials],
            ['x-amz-algorithm' => $algorithm],
            ['x-amz-date' => $date],
            ['x-amz-expires' => $expires],
        ]
    ];
    $base64Policy = base64_encode(json_encode($policy));
    $dateKey = hash_hmac('sha256', $shortDate, 'AWS4' . $awsSecret, true);
    $dateRegionKey = hash_hmac('sha256', $region, $dateKey, true);
    $dateRegionServiceKey = hash_hmac('sha256', $service, $dateRegionKey, true);
    $signingKey = hash_hmac('sha256', $requestType, $dateRegionServiceKey, true);
    $signature = hash_hmac('sha256', $base64Policy, $signingKey);
    $inputs = [
        'Content-Type' => '',
        'acl' => $acl,
        'success_action_status' => $successStatus,
        'policy' => $base64Policy,
        'X-amz-credential' => $credentials,
        'X-amz-algorithm' => $algorithm,
        'X-amz-date' => $date,
        'X-amz-expires' => $expires,
        'X-amz-signature' => $signature
    ];

    return compact('url', 'inputs');
}
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
    $(function () {
        input = document.getElementById("attach_file");
        input.onchange = function () {
            if (input.files && input.files[0]) {
                $('#submit').prop("disabled", "disabled");
                formData = new FormData();
<?php foreach ($s3FormDetails['inputs'] as $name => $value) { ?>
                    formData.append("<?= $name; ?>", "<?= $value; ?>");
<?php } ?>
                formData.append("key", input.files[0].name);
                formData.append("file", input.files[0]);

                $.ajax({
                    url: '<?= $s3FormDetails['url']; ?>',
                    type: 'POST',
                    data: formData,
                    crossDomain: true,
                    contentType: false,
                    processData: false,
                    dataType: 'xml',
                    success: function (xml, status, data) {
                        s3File = $(data.responseXML).find('PostResponse').find("Location").text();
                        $('#s3loc').val(s3File);
                        console.log($(data.responseXML).find('PostResponse').find("Bucket").text());
                        console.log($(data.responseXML).find('PostResponse').find("Key").text());
                        $('#submit').prop('disabled', false);
                    }
                });
            }
        };
    });
</script>
<div class="well">
    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>
    <div class="form-group">
        <div class="row">
            <?php
            if (!empty($model->image))
                echo Html::img($model->image);
            ?>
            <label>Upload Invoice Image</label>
            <?= Html::fileInput('invoice', null, ['id' => 'attach_file']); ?>
            <?= Html::hiddenInput('s3loc', $model->image, ['id' => 's3loc']); ?>
        </div>
        <div class="row">
            <label>PayPal Transaction ID</label>
            <?= Html::textInput('paypal_transaction_Id'); ?>
        </div>
        <?= Html::submitButton('Invoice User', ['id' => 'submit', 'class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
