<?php snippet('header') ?>


<?php $terms = db::select('alfa_terms', '*'); ?>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<h4>terms <strong><?php echo $terms->count() ?></strong></h4>

<?php $terms = $terms ?>
<?php echo '<pre>'; print_r($terms); echo '</pre>'; ?>


<?php snippet('footer') ?>