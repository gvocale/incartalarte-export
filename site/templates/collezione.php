<?php snippet('header') ?>

<?php $wp_term_relationships = db::select('wp_term_relationships', '*'); ?>
<?php $wp_terms = db::select('wp_terms', '*'); ?>
<?php $wp_posts = db::select('wp_posts', '*'); ?>

<ul class="alfa_posts">
	<?php foreach($wp_term_relationships->limit(30) as $each): ?>
		<?php if ($post = $wp_posts->filterBy('ID', $each->object_id())->first() AND $post->post_title() != ""): ?>
			<li style="margin-top: 1rem">
				<p><strong>object_id</strong> <?php echo $each->object_id() ?></p>
				<p><strong>term_taxonomy_id</strong> <?php echo $each->term_taxonomy_id() ?></p>
				<p><strong>post_name</strong> <?php echo $post->post_name(); ?>	</p>
				<p><strong>guid</strong> <?php echo $post->guid(); ?>	</p>
				<p><strong>post_title</strong> <?php echo $post->post_title(); ?>	</p>
				<p><strong>post_content</strong> <?php echo $post->post_content(); ?>	</p>
				<?php $term_name = $wp_terms->filterBy('term_id', $each->term_taxonomy_id())->first(); ?>
				<p><strong>term_name</strong> <?php echo $term_name->name(); ?></p>

				<?php $img_url = '/^<img(.*)\/>/'; ?>
				<?php $replacement = "gio" ?>
				<?php $replaced_copy = "" ?>
				<?php preg_match_all($img_url, $post->post_content(), $img_url_matches); ?>
				<?php print_r($img_url_matches) ?>
				<?php $post_content = str_replace($img_url_matches[0], $replacement, $post->post_content(), $count); ?>
				<p><strong>count</strong> <?php echo $count ?>	</p>
				<p><strong>count</strong> <?php echo $post_content ?>	</p>
			</li>
		<?php endif ?>
	<?php endforeach ?>
</ul>


<?php snippet('footer') ?>