<?php snippet('header') ?>

<?php $postmeta = db::select('alfa_postmeta', '*'); ?>
<?php $posts = db::select('alfa_posts', '*'); ?>
<?php $term_relationships = db::select('alfa_term_relationships', '*'); ?>
<?php $terms = db::select('alfa_terms', '*'); ?>
<?php $terms_array = (array) $terms ?>
<?php $terms_array = $terms_array['data'] ?>

<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//OR
set_time_limit(300); //If set to zero, no time limit is imposed. ?>

<?php $new_post = [] ?>

<!-- Post (contenuto del post) -->
<?php $post = $posts->filterBy('ID',"9357")->first() ?>
<?php foreach ($post as $key => $value): ?>
	<?php $new_post["$key"] = "$value"; ?>
<?php endforeach ?>

<?php echo '<pre>'; print_r($new_post); echo '</pre>'; ?>

<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>


<!-- Terms Relationship (Category Number) -->
<?php $term_relationships = $term_relationships->filterBy('object_id',$post->ID()) ?>
<?php $term_relationships_array = (array) $term_relationships ?>
<?php $term_relationships_array = $term_relationships_array['data'] ?>


<?php $category_number = [] ?>
<?php $category_name = [] ?>
<?php $category_slug = [] ?>
<?php foreach ($term_relationships_array as $category): ?>
	<?php $category_number[] = $category->term_taxonomy_id() ?>
<?php endforeach ?>
<p><strong>Category Number</strong></p>
<?php echo '<pre>'; print_r($category_number); echo '</pre>'; ?>

<?php $category_number_value =  rtrim(implode(',', $category_number), ','); ?>

<?php $new_post["category_number"] = "$category_number_value" ?>


<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>

<p><strong>Category Name & slug</strong></p>

<?php foreach ($category_number as $each): ?>
	<?php $term = $terms->filterBy('term_id', $each) ?>
	<?php $term = $term->first() ?>
	<?php $category_name[] = $term->name() ?>
	<?php $category_slug[] = $term->slug() ?>	
<?php endforeach ?>

<?php echo '<pre>'; print_r($category_name); echo '</pre>'; ?>
<?php echo '<pre>'; print_r($category_slug); echo '</pre>'; ?>

<?php $category_name_value =  rtrim(implode(',', $category_name), ','); ?>

<?php $new_post["category_name"] = "$category_name_value" ?>

<?php $category_slug_value =  rtrim(implode(',', $category_slug), ','); ?>

<?php $new_post["category_slug"] = "$category_slug_value" ?>

<?php echo '<pre>'; print_r($new_post); echo '</pre>'; ?>

<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>

<!-- Post meta (informazioni varie) -->
<?php $metas = $postmeta->filterBy('post_id',$post->ID()) ?>
<?php foreach ($metas as $meta): ?>
	<?php $new_post["$meta->meta_key()"] = "$meta->meta_value()"; ?>
<?php endforeach ?>

<p><strong>Post Meta added to $new_post</strong></p>

<?php echo '<pre>'; print_r($new_post); echo '</pre>'; ?>

<hr class="" style="height: 1px; width: 100%; background:red; margin: 2rem 0;"></hr>


<!-- Post Attachment -->
<?php $post_attachment = $posts->filterBy('ID',"9358") ?>
<?php $attachment = (array) $post_attachment->first(); ?>
<?php echo '<pre>'; print_r($attachment); echo '</pre>'; ?>

<?php foreach ($attachment as $attachment_each): ?>
	<?php $new_post["attachment_post_title"] = "$attachment_each->post_title()"; ?>
	<?php $new_post["attachment_post_name"] = "$attachment_each->post_name()"; ?>
	<?php $new_post["attachment_guid"] = "$attachment_each->guid()"; ?>
<?php endforeach ?>

<hr class="" style="height: 1px; width: 100%; background:red; margin: 2rem 0;"></hr>

<?php echo '<pre>'; print_r($new_post); echo '</pre>'; ?>

<?php try {

	// Remove <img> tag from post content
	$img_tag = '/<img(.*)\/>/';
	$img_tag_replacement = "";
	preg_match_all($img_tag, $post->post_content(), $img_tag_matches);
	$cleaned_post_content = str_replace($img_tag_matches[0], $img_tag_replacement, $post->post_content());

	$newPage = page('incartalarte-export')->children()->create($new_post->post_name(), 'project', $new_post);
	echo "The page " . $new_post->post_name() . " has been created \n";
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

	echo $e->getMessage();

	echo $e;

	echo "The page " . $new_post->post_name() . " has not been created <br><br>";
  				// optional error message: $e->getMessage();
}; ?>

<?php echo '<pre>'; print_r($newPage); echo '</pre>'; ?>

<?php snippet('footer') ?>