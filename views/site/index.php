<?php
/* @var $this yii\web\View */

$this->title = 'HangShare';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="row">
                <div class="well text-center">
                    <h2>Can Take</h2>
                    <span class="mo">$<?= $cantake ?></span>
                </div>
                <div class="well text-center">
                    <h2>Money Generated</h2>
                    <span class="mo">$<?= $totalMoney ?></span>
                </div>
                <div class="well text-center">
                    <h2>Total Users</h2>
                    <span class="mo"><?= number_format($totalUsers) ?></span>
                </div>
                <div class="well text-center">
                    <h2>Total Posts</h2>
                    <span class="mo"><?= number_format($totalPosts) ?></span>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <h2>Tools</h2>
            <ul class="list-inline">
                <li><a href="https://www.hangshare.com/site/flush" class="btn btn-danger">Flush Cache</a></li>
            </ul>
        </div>
        <div class="row">
            <h3>Users</h3>
            <div id="usersg" style="width: 100%; height: 400px;"><div id="loading" class="text-center"><img src="http://traversepakistan.com/static/images/loading.gif" /></div></div>
        </div>
        <div class="row">
            <h3>Posts</h3>
            <div id="postsg" style="width: 100%; height: 400px;"><div id="loading" class="text-center"><img src="http://traversepakistan.com/static/images/loading.gif" /></div></div>
        </div>
    </div>
</div>