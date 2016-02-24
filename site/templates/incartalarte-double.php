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

<?php $post = $posts->filterBy('ID',"15230")->first() ?>
<?php foreach ($post as $field => $value): ?>
	<li style="margin-top: 1rem">
		<strong><?php echo $field ?></strong> <?php echo $value ?>
	</li>
<?php endforeach ?>

<hr style="height:10px; width: 100%; background: red; margin: 20px">

<?php $post_parent = $posts->filterBy('post_parent',$post->ID())->first() ?>
<?php foreach ($post_parent as $field => $value): ?>
	<li style="margin-top: 1rem">
		<strong><?php echo $field ?></strong> <?php echo $value ?>
	</li>
<?php endforeach ?>

<hr style="height:10px; width: 100%; background: red; margin: 20px">

<h4>term_relationships <strong><?php echo $term_relationships->count() ?></strong></h4>

<?php $term_relationships = $term_relationships->filterBy('object_id',$post->ID()) ?>
<?php foreach ($term_relationships as $term_relationship): ?>
	<?php foreach ($term_relationship as $field => $value): ?>
		<li style="margin-top: 1rem">
			<strong><?php echo $field ?></strong> <?php echo $value ?>
			<?php $terms = $terms->filterBy('term_id',$term_relationship->term_taxonomy_id()) ?>
			<?php print_r($terms->first()) ?>
		</li>
	<?php endforeach ?>
<?php endforeach ?>

<hr style="height:10px; width: 100%; background: red; margin: 20px">


<h4>Terms <strong><?php echo $terms->count() ?></strong></h4>

<?php $terms = $terms->filterBy('term_id',"2") ?>
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