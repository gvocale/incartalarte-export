<?php snippet('header') ?>

<?php db::insert('comments', array(
	'name'    => 'Bastian',
	'email'   => 'bastian@getkirby.com',
	'comment' => 'This is my first comment',
	'date'    => 'NOW()',
	)); ?>

	<?php $wp_posts = db::select('wp_posts', '*'); ?>

	<h2>Liquorvitae Posts</h2>
	<ul class="alfa_posts">
		<?php foreach($wp_posts as $each): ?>
			<?php if (!empty($each->post_content())): ?>
				<li style="margin-top: 1rem">
					<p><strong>ID</strong> <?php echo $each->ID() ?></p>
					<p><strong>post_name</strong> <?php echo $each->post_name() ?></p>
					<p><strong>guid</strong> <?php echo $each->guid() ?></p>
					<p><strong>post_title</strong> <?php echo $each->post_title() ?></p>
					<p><strong>post_content</strong> <?php echo $each->post_content() ?></p>
				</li>
				<?php try {
					$newPage = $page->children()->create($each->post_name(), 'project', array(
						'giovanni'     => $each->ID(),
						'post_name' => $each->post_name(),
						'guid'      => $each->guid(),
						'post_title'      => $each->post_title(),
						'post_content'      => $each->post_content(),
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