<?php snippet('header') ?>


<?php $postmeta = db::select('alfa_postmeta', '*'); ?>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<h4>postmeta <strong><?php echo $postmeta->count() ?></strong></h4>

<?php $postmeta = $postmeta->limit(1000) ?>
<?php echo '<pre>'; print_r($postmeta); echo '</pre>'; ?>


<?php snippet('footer') ?>