<?php snippet('header') ?>


<?php $term_relationships = db::select('alfa_term_relationships', '*'); ?>
<?php $terms = db::select('alfa_terms', '*'); ?>
<?php $posts = db::select('alfa_posts', '*'); ?>
<?php $postmeta = db::select('alfa_postmeta', '*'); ?>


<h2>Posts <strong><?php echo $posts->count() ?></strong></h2>
<h2>postmeta <strong><?php echo $postmeta->count() ?></strong></h2>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<?php foreach ($posts as $counter => $post): ?>
	<?php if ($counter > 0 AND $counter < 1000 AND $post->post_type != "attachment" AND $post->post_type != "page" ): ?>
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
			<?php foreach ($terms->filterBy('term_id',$term_taxonomy_id) as $term): ?>
				<p><strong>Categoria </strong><?php echo $term->name ?> <?php echo $term->slug ?> </p>
			<?php endforeach ?>
			<?php foreach ($postmeta->filterBy('post_id',$term_taxonomy_id) as $meta): ?>
				<?php print_r($meta);?>
			<?php endforeach ?>
			<?php foreach ($posts->filterBy('post_parent',$post->ID()) as $image): ?>
				<p><strong>image url with doulbe // </strong><?php echo $image->guid() ?></p>
			<?php endforeach ?>

			<?php foreach ($postmeta->filterBy('post_id',$post->ID()) as $image): ?>
				<p><strong>image url </strong><?php print_r($image) ?></p>
			<?php endforeach ?>
			<hr style="height: 2px; background-color: red; width: 100%">
		</li>
		<?php try {

			// Remove <img> tag from post content
			$img_tag = '/<img(.*)\/>/';
			$img_tag_replacement = "";
			preg_match_all($img_tag, $post->post_content(), $img_tag_matches);
			$cleaned_post_content = str_replace($img_tag_matches[0], $img_tag_replacement, $post->post_content());

			$newPage = page('collezione')->children()->create($post->post_name(), 'project', array(
				'id'     => $post->ID(),
				'guid' => $post->post_name(),
				'wordpress-guid'      => $post->guid(),
				'Titolo'      => $post->post_title(),
				'Descrizione'      => $cleaned_post_content,
				'Tag'      => $category_name,
				));
			echo "The page " . $post->post_title() . " has been created \n";
			echo $newPage->root() . "\n";

			// Save and rename all images linked in content
			$img_url = '/http.*jpg/';
			preg_match_all($img_url, $post->post_content, $img_url_matches);
			$n = 0;

			// Save main image
			foreach ($posts->filterBy('post_parent',$post->ID()) as $image) {
				echo $image->guid() . " is being saved \n";
				$n++;
				file_put_contents($newPage->root() . DS . $post->post_name() . "-" . $n . ".jpg", fopen($image->guid(), 'r'));
			};

			// Save main image from altrnate link in post meta

			foreach ($postmeta->filterBy('post_id',$post->ID()) as $image) {
				$image_url = "http://www.incartalarte.it/wp-content/uploads/" . $image->meta_value();
				echo $image_url . " is being saved \n";
				$n++;
				file_put_contents($newPage->root() . DS . $post->post_name() . "-" . $n . ".jpg", fopen($image_url, 'r'));
			};

			// Save other images linked into content
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
	<?php endif ?>
<?php endforeach ?>


<?php snippet('footer') ?>