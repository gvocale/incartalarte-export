<?php snippet('header') ?>


<?php $wp_term_relationships = db::select('wp_term_relationships', '*'); ?>

<?php $wp_terms = db::select('wp_terms', '*'); ?>

<?php $wp_posts = db::select('wp_posts', '*'); ?>


<h2>Liquorvitae Posts</h2>
<ul class="alfa_posts">
	<?php foreach($wp_term_relationships as $each): ?>
		<?php if ($post = $wp_posts->filterBy('ID', $each->object_id())->first()): ?>
			<li style="margin-top: 1rem">
				<p><strong>object_id</strong> <?php echo $each->object_id() ?></p>
				<p><strong>term_taxonomy_id</strong> <?php echo $each->term_taxonomy_id() ?></p>
				<p><strong>post_name</strong> <?php echo $post->post_name(); ?>	</p>
				<p><strong>guid</strong> <?php echo $post->guid(); ?>	</p>
				<p><strong>post_title</strong> <?php echo $post->post_title(); ?>	</p>
				<p><strong>post_content</strong> <?php echo $post->post_content(); ?>	</p>
				<?php $term_name = $wp_terms->filterBy('term_id', $each->term_taxonomy_id())->first(); ?>
				<p><strong>term_name</strong> <?php echo $term_name->name(); ?></p>
			</li>


			<?php try {
				$newPage = $page->children()->create($post->post_name(), 'project', array(
					'object_id'     => $each->object_id(),
					'post_name' => $post->post_name(),
					'guid'      => $post->guid(),
					'post_title'      => $post->post_title(),
					'post_content'      => $post->post_content(),
					'tag'      => $term_name->name(),
					));
				echo 'The page has been created';
			} 

			catch(Exception $e) {

				echo 'The user could not be created';
  // optional error message: $e->getMessage();

			} ?>

		<?php endif ?>

	<?php endforeach ?>
</ul>




<?php snippet('footer') ?>