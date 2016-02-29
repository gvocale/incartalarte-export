<?php snippet('header') ?>


<?php $term_relationships = db::select('alfa_term_relationships', '*'); ?>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<h4>term_relationships <strong><?php echo $term_relationships->count() ?></strong></h4>

<?php $term_relationships = $term_relationships ?>
<?php echo '<pre>'; print_r($term_relationships); echo '</pre>'; ?>


<?php snippet('footer') ?>