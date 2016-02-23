<?php snippet('header') ?>


<?php $term_relationships = db::select('alfa_term_relationships', '*'); ?>
<?php $terms = db::select('alfa_terms', '*'); ?>
<?php $posts = db::select('alfa_posts', '*'); ?>
<?php $postmeta = db::select('alfa_postmeta', '*'); ?>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<h4>Posts <strong><?php echo $posts->count() ?></strong></h4>

<?php $filtered = $posts->filterBy('ID',"15230") ?>
<?php foreach ($filtered as $post): ?>
		<li style="margin-top: 1rem">
			<?php print_r($post) ?>
		</li>
<?php endforeach ?>

<?php $filtered = $posts->filterBy('post_parent',"15230") ?>
<?php foreach ($filtered as $post): ?>
		<li style="margin-top: 1rem">
			<?php print_r($post) ?>
		</li>
<?php endforeach ?>

<h4>term_relationships <strong><?php echo $term_relationships->count() ?></strong></h4>

<?php $filtered = $term_relationships->filterBy('object_id',"15230") ?>
<?php foreach ($filtered as $post): ?>
		<li style="margin-top: 1rem">
			<?php print_r($post) ?>
		</li>
<?php endforeach ?>


<h4>Terms <strong><?php echo $terms->count() ?></strong></h4>

<?php $filtered = $terms->filterBy('term_id',"2") ?>
<?php foreach ($filtered as $post): ?>
		<li style="margin-top: 1rem">
			<?php print_r($post) ?>
		</li>
<?php endforeach ?>


<?php $filtered = $terms->filterBy('term_id',"685") ?>
<?php foreach ($filtered as $post): ?>
		<li style="margin-top: 1rem">
			<?php print_r($post) ?>
		</li>
<?php endforeach ?>


<?php $filtered = $terms->filterBy('term_id',"688") ?>
<?php foreach ($filtered as $post): ?>
		<li style="margin-top: 1rem">
			<?php print_r($post) ?>
		</li>
<?php endforeach ?>

<h4>postmeta <strong><?php echo $postmeta->count() ?></strong></h4>

<?php $filtered = $postmeta->filterBy('post_id',"15230") ?>
<?php foreach ($filtered as $post): ?>
		<li style="margin-top: 1rem">
			<?php print_r($post) ?>
		</li>
<?php endforeach ?>

<?php snippet('footer') ?>