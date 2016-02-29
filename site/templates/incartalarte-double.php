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

<?php $posts = $posts->limit(10)->filterBy("ID", "4") ?>
<?php echo '<pre>'; print_r($posts); echo '</pre>'; ?>

<hr style="height:1px; width: 100%; background: green; margin: 20px">

<h4>term_relationships <strong><?php echo $term_relationships->count() ?></strong></h4>

<?php $term_relationships = $term_relationships ?>
<?php echo '<pre>'; print_r($term_relationships); echo '</pre>'; ?>

<hr style="height:1px; width: 100%; background: green; margin: 20px">

<h4>terms <strong><?php echo $terms->count() ?></strong></h4>

<?php $terms = $terms->limit(10) ?>
<?php echo '<pre>'; print_r($terms); echo '</pre>'; ?>

<hr style="height:1px; width: 100%; background: green; margin: 20px">

<h4>postmeta <strong><?php echo $postmeta->count() ?></strong></h4>

<?php $postmeta = $postmeta->limit(10) ?>
<?php echo '<pre>'; print_r($postmeta); echo '</pre>'; ?>


<hr style="height:1px; width: 100%; background: green; margin: 20px">

<?php foreach ($limited_posts as $post): ?>
	<hr style="height:1px; width: 100%; background: red; margin: 20px">
	<?php $corrected_guid = str_replace("it//", "it/", $post->guid()); ?>
	<?php foreach ($post as $field => $value): ?>
		<?php if(!empty($value)): ?>
			<li style="margin-top: 0.2em; list-style: none">
				<strong><?php echo $field ?></strong> <?php echo $value ?>
			</li>
		<?php endif ?>
	<?php endforeach ?>
	<li style="margin-top: 0.2em; list-style: none">
		<strong>corrected_guid </strong><?php echo $corrected_guid ?>
	</li>

	<hr style="height:1px; width: 100%; background: green; margin: 20px">


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