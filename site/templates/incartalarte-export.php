<?php snippet('header') ?>

<?php $postmeta = db::select('alfa_postmeta', '*'); ?>
<?php $posts = db::select('alfa_posts', '*'); ?>
<?php $term_relationships = db::select('alfa_term_relationships', '*'); ?>
<?php $terms = db::select('alfa_terms', '*'); ?>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<!-- Post (contenuto del post) -->
<?php $post = $posts->filterBy('ID',"9357")->first() ?>

<!-- <?php echo '<pre>'; print_r($post); echo '</pre>'; ?> -->

<hr class="" style="height: 1px; width: 100%; background:red; margin: 2rem 0;"></hr>

<?php foreach ($post as $key => $value): ?>
	<?php if(!empty($value)): ?>
		<li><strong><?php echo $key ?> </strong><?php echo $value ?></li>
	<?php endif ?>
<?php endforeach ?>
<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>
<!-- Terms Relationship (codice categoria) -->
<?php $term_relationships = $term_relationships->filterBy('object_id',"9357") ?>
<?php foreach ($term_relationships as $term_relationship): ?>
	<li><strong>term_taxonomy_id </strong><?php echo $term_relationship->term_taxonomy_id() ?></li>
	<!-- Terms (nome categoria) -->
	<?php $term = $terms->filterBy('term_id',$term_relationship->term_taxonomy_id())->first() ?>
	<!-- <?php echo '<pre>'; print_r($term); echo '</pre>'; ?> -->
	<li><strong>name </strong><?php echo $term->name() ?></li>
	<li><strong>slug </strong><?php echo $term->slug() ?></li>
	<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>
<?php endforeach ?>
<!-- Post meta (informazioni varie) -->
<?php $metas = $postmeta->filterBy('post_id',"9357") ?>
<?php foreach ($metas as $meta): ?>
	<!-- <?php echo '<pre>'; print_r($meta); echo '</pre>'; ?> -->
	<?php if(!empty($meta->meta_value())): ?>
		<li><strong><?php echo $meta->meta_key() ?> </strong><?php echo $meta->meta_value() ?></li>
		<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>
	<?php endif ?>
<?php endforeach ?>
<hr class="" style="height: 1px; width: 100%; background:red; margin: 2rem 0;"></hr>

<!-- Post (contenuto del post) -->
<?php $post = $posts->filterBy('ID',"9358") ?>
<?php echo '<pre>'; print_r($post); echo '</pre>'; ?>
<?php foreach ($post as $key => $value): ?>
	<?php if(!empty($value)): ?>
		<li><strong><?php echo $key ?> </strong><?php echo $value ?></li>
	<?php endif ?>
<?php endforeach ?>
<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>
<!-- Terms Relationship (codice categoria) -->
<?php $term_relationships = $term_relationships->filterBy('object_id',"9357") ?>
<?php foreach ($term_relationships as $term_relationship): ?>
	<li><strong>term_taxonomy_id </strong><?php echo $term_relationship->term_taxonomy_id() ?></li>
	<!-- Terms (nome categoria) -->
	<?php $term = $terms->filterBy('term_id',$term_relationship->term_taxonomy_id())->first() ?>
	<!-- <?php echo '<pre>'; print_r($term); echo '</pre>'; ?> -->
	<li><strong>name </strong><?php echo $term->name() ?></li>
	<li><strong>slug </strong><?php echo $term->slug() ?></li>
	<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>
<?php endforeach ?>
<!-- Post meta (informazioni varie) -->
<?php $metas = $postmeta->filterBy('post_id',"9357") ?>
<?php foreach ($metas as $meta): ?>
	<!-- <?php echo '<pre>'; print_r($meta); echo '</pre>'; ?> -->
	<?php if(!empty($meta->meta_value())): ?>
		<li><strong><?php echo $meta->meta_key() ?> </strong><?php echo $meta->meta_value() ?></li>
		<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>
	<?php endif ?>
<?php endforeach ?>
<hr class="" style="height: 1px; width: 100%; background:red; margin: 2rem 0;"></hr>


<?php snippet('footer') ?>