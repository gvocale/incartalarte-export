<?php snippet('header') ?>


<?php $wp_term_relationships = db::select('wp_term_relationships', '*'); ?>

<h2>Liquorvitae Posts</h2>
<ul class="alfa_posts">
	<?php foreach($wp_term_relationships as $each): ?>
		<li style="margin-top: 1rem">
			<p><strong>object_id</strong> <?php echo $each->object_id() ?></p>
			<p><strong>term_taxonomy_id</strong> <?php echo $each->term_taxonomy_id() ?></p>
		</li>
		<?php $category = $site->page('test')->children()->filterBy('giovanni', $each->object_id()); ?>
		<?php echo $category->count(); ?>
		<?php foreach ($category as $singola): ?>
		<?php echo $singola->Post_title(); ?>
		<?php endforeach ?>
	<?php endforeach ?>
</ul>




<?php snippet('footer') ?>