<?php snippet('header') ?>


<?php $posts = db::select('alfa_posts', '*'); ?>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<h4>posts <strong><?php echo $posts->count() ?></strong></h4>

<?php $posts = $posts->filterBy("ID","9357"); ?>
<?php echo '<pre>'; print_r($posts); echo '</pre>'; ?>

<hr style="height:1px; width: 100%; background: green; margin: 20px">

<?php $posts = db::select('alfa_posts', '*'); ?>

<?php $posts = $posts->filterBy("ID","9357"); ?>
<?php echo '<pre>'; print_r($posts); echo '</pre>'; ?>

<hr style="height:1px; width: 100%; background: green; margin: 20px">

<?php $postmeta = db::select('alfa_postmeta', '*'); ?>

<h4>postmeta <strong><?php echo $postmeta->count() ?></strong></h4>

<?php $postmeta = $postmeta->filterBy("post_id", "9357"); ?>
<?php echo '<pre>'; print_r($postmeta); echo '</pre>'; ?>


<?php snippet('footer') ?>