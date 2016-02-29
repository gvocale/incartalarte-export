<?php snippet('header') ?>


<?php $posts = db::select('alfa_posts', '*'); ?>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<h4>posts <strong><?php echo $posts->count() ?></strong></h4>

<?php $posts = $posts->filterBy("post_type","product")->limit(100); ?>
<?php echo '<pre>'; print_r($posts); echo '</pre>'; ?>


<?php snippet('footer') ?>