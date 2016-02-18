<?php snippet('header') ?>


<?php $term_relationships = db::select('alfa_term_relationships', '*'); ?>
<?php $terms = db::select('alfa_terms', '*'); ?>
<?php $posts = db::select('alfa_posts', '*'); ?>


<h2>Posts <strong><?php echo $posts->count() ?></strong></h2>

<?php foreach ($posts->limit(2000) as $post): ?>
	<?php if ($post->post_type != "attachment" AND $post->post_type != "page" ): ?>
		<li style="margin-top: 1rem">
			<p><strong>ID</strong> <?php echo $post->ID() ?></p>
			<p><strong>post_title</strong> <?php echo $post->post_title(); ?>	</p>
			<p><strong>post_content</strong> <?php echo $post->post_content(); ?>	</p>
			<p><strong>post_name</strong> <?php echo $post->post_name(); ?>	</p>
			<p><strong>guid</strong> <?php echo $post->guid(); ?>	</p>
			<p><strong>post_type</strong> <?php echo $post->post_type(); ?>	</p>
			<p><strong>post_parent</strong> <?php echo $post->post_parent(); ?>	</p>
			
			<?php $term_id = $term_relationships->filterBy('object_id', $post->ID())->first()->object_id(); ?>
			<?php $term_taxonomy_id = $term_relationships->filterBy('object_id', $post->ID())->first()->term_taxonomy_id(); ?>
			<p><strong>term_id</strong> <?php echo $term_id ?>	</p>
			<p><strong>term_taxonomy_id</strong> <?php echo $term_taxonomy_id ?>	</p>
			<?php $term_count = $terms->count() ?>
			<p><strong>term_count </strong> <?php echo $term_count ?></p>
			<p><strong>Category Name </strong><?php $category_name = $terms->filterBy('term_id',$term_taxonomy_id)->first()->name() ?><?php echo $category_name ?></p>
			<p><strong>Category Slug </strong><?php $category_slug = $terms->filterBy('term_id',$term_taxonomy_id)->first()->slug() ?><?php echo $category_slug ?></p>
			<hr>
		</li>
	<?php endif ?>
<?php endforeach ?>


<?php snippet('footer') ?>