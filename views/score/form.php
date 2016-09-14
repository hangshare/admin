<form action="#" method="POST">
    <ul class="list-inline star-rating">
        <li><i class="glyphicon glyphicon-star rate <?php echo $model->score >= 1 ? 'on' : ''; ?>" rel="1"></i></li>
        <li><i class="glyphicon glyphicon-star rate <?php echo $model->score >= 2 ? 'on' : ''; ?>" rel="2"></i></li>
        <li><i class="glyphicon glyphicon-star rate <?php echo $model->score >= 3 ? 'on' : ''; ?>" rel="3"></i></li>
        <li><i class="glyphicon glyphicon-star rate <?php echo $model->score >= 4 ? 'on' : ''; ?>" rel="4"></i></li>
        <li><i class="glyphicon glyphicon-star rate <?php echo $model->score >= 5 ? 'on' : ''; ?>" rel="5"></i></li>
    </ul>
    <input type="hidden" class="rateval" name="stars" value="<?= $model->score; ?>"/>
    <input type="hidden" class="postId" name="id" value="<?= $model->id; ?>"/>
</form>