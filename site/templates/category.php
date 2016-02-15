<?php snippet('header') ?>


<?php $wp_term_relationships = db::select('wp_term_relationships', '*'); ?>
<?php $wp_terms = db::select('wp_terms', '*'); ?>
<?php $wp_posts = db::select('wp_posts', '*'); ?>

<h2>Liquorvitae Posts</h2>
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


				<?php try {

					// Remove <img> tag from post content
					$img_tag = '/<img(.*)\/>/';
					$img_tag_replacement = "";
					preg_match_all($img_tag, $post->post_content(), $img_tag_matches);
					$cleaned_post_content = str_replace($img_tag_matches[0], $img_tag_replacement, $post->post_content());

					$newPage = page('collezione')->children()->create($post->post_name(), 'project', array(
						'object_id'     => $each->object_id(),
						'post_name' => $post->post_name(),
						'guid'      => $post->guid(),
						'post_title'      => $post->post_title(),
						'post_content'      => $cleaned_post_content,
						'tag'      => $term_name->name(),
						));
					echo "The page " . $post->post_title() . " has been created \n";
					echo $newPage->root() . "\n";

					// Save and rename all images linked in content
					$img_url = '/http.*jpg/';
					preg_match_all($img_url, $post->post_content, $img_url_matches);
					$n = 0;
					foreach ($img_url_matches[0] as $img_url_match) {
						echo $img_url_match . " is being saved \n";
						$n++;
						file_put_contents($newPage->root() . DS . $post->post_name() . "-" . $n . ".jpg", fopen($img_url_match, 'r'));
					};
				}

				catch(Exception $e) {

					echo "The page " . $post->post_title() . " has not been created <br><br>";
  				// optional error message: $e->getMessage();
				};

				?>
			</li>
		<?php endif ?>
	<?php endforeach ?>
</ul>




<?php snippet('footer') ?>