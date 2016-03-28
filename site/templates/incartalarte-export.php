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
<div style="background-color: hsla(320, 100%, 50%, 0.2)">

	<h2>$post</h2>
	<!-- Post (contenuto del post) -->
	<?php $post = $posts->filterBy('ID',"9357")->first() ?>
	<?php foreach ($post as $key => $value): ?>
		<?php $new_post["$key"] = "$value"; ?>
	<?php endforeach ?>

	<?php echo '<pre>'; print_r($new_post); echo '</pre>'; ?>

	<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>

</div>
<div style="background-color: hsla(270, 100%, 50%, 0.2)">
	<h2>$term_relationships (Category Number)</h2>
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

	<?php $category_number_value =  rtrim(implode(', ', $category_number), ', '); ?>

	<?php $new_post["category_number"] = "$category_number_value" ?>
</div>

<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>

<div style="background-color: hsla(253, 100%, 50%, 0.2)">
	<h2>Category Name & slug</h2>

	<?php foreach ($category_number as $each): ?>
		<?php $term = $terms->filterBy('term_id', $each) ?>
		<?php $term = $term->first() ?>
		<?php $category_name[] = $term->name() ?>
		<?php $category_slug[] = $term->slug() ?>	
	<?php endforeach ?>

	<?php echo '<pre>'; print_r($category_name); echo '</pre>'; ?>
	<?php echo '<pre>'; print_r($category_slug); echo '</pre>'; ?>

	<?php $category_name_value =  rtrim(implode(', ', $category_name), ', '); ?>

	<?php $new_post["category_name"] = "$category_name_value" ?>

	<?php $category_slug_value =  rtrim(implode(', ', $category_slug), ', '); ?>

	<?php $new_post["category_slug"] = "$category_slug_value" ?>

</div>
<hr class="" style="height: 1px; width: 100%; background:gray; margin: 2rem 0;"></hr>

<div style="background-color: hsla(189, 100%, 50%, 0.2)">
	<h2>$postmet & slug</h2>
	<!-- Post meta (informazioni varie) -->
	<?php $metas = $postmeta->filterBy('post_id',$post->ID()) ?>
	<?php foreach ($metas as $meta): ?>
		<?php $new_post["$meta->meta_key()"] = "$meta->meta_value()"; ?>
	<?php endforeach ?>

	<p><strong>Post Meta added to $new_post</strong></p>

	<?php echo '<pre>'; print_r($new_post); echo '</pre>'; ?>

</div>


<hr class="" style="height: 1px; width: 100%; background:red; margin: 2rem 0;"></hr>

<div style="background-color: hsla(106, 100%, 50%, 0.2)">

	<h2>Filtering $post_attachment</h2>
	<!-- Post Attachment -->
	<?php $post_attachment = $posts->filterBy('ID',"9358") ?>
	<?php $attachment = (array) $post_attachment->first(); ?>
	<?php echo '<pre>'; print_r($attachment); echo '</pre>'; ?>
	<?php $new_post["attachment_post_title"] = $attachment['post_title']; ?>
	<?php $new_post["attachment_post_name"] = $attachment['post_name']; ?>
	<?php $new_post["attachment_guid"] = $attachment['guid']; ?>

</div>



<div style="background-color: hsla(46, 100%, 50%, 0.2)">

	<h2 class="">Search and Replace Images / Sanitization</h2>

	<!-- Search and replace incartalarte.it// into incartalarte.it/ -->

	<?php 
	$new_post['guid'] = str_replace("incartalarte.it//","incartalarte.it/",$new_post['guid']);
	$new_post['attachment_guid'] = str_replace("incartalarte.it//","incartalarte.it/",$new_post['attachment_guid']);
	$new_post['post_content'] = str_replace("incartalarte.it//","incartalarte.it/",$new_post['post_content']); ?>


	<!-- Finds any string starting with http, ending with jpg and not including white spaces, and puts it in $images -->

	<?php 
	$what = '/http.[^\s]*jpg/';
	preg_match_all($what, $new_post['post_content'], $images); ?>
	<?php $images =  $images[0]; ?>


	
	<!-- Find JPEGbay code, moves it to $new_post['jpegbay'], then removes it from $new_post['post_content'] -->
	<!-- Find any string starting with JPEG and ending with stop, including whitespace and multiline -->
	<?php 
	$what = '/<!-- JPEG.[\S\s]*stop -->/';
	preg_match_all($what, $new_post['post_content'], $jpegbay); ?>
	<?php $new_post['jpegbay'] = $jpegbay[0][0] ?>
	<?php $new_post['post_content'] = str_replace($new_post['jpegbay'],"",$new_post['post_content']); ?>

	
	<!-- Remove any <img> tag from post content -->
	<?php
	$img_tag = '<img([\w\W]+?)>';
	preg_match_all($img_tag, $new_post['post_content'], $img_tag_matches);
	$new_post['post_content'] = str_replace($img_tag_matches[0], "", $new_post['post_content']); ?>


	<!-- Puts the image $new_post['attachment_guid'] into $images -->
	<?php 
	$images[] = $new_post['attachment_guid'];
	echo '<pre>'; print_r($images); echo '</pre>'; ?>



	<!-- If an image link is broken, gets moved to $images_broken. If it's working, get's moved to $image_working -->
	<?php 
	$images_working = [];
	$images_broken = [];
	foreach ($images as $image) {
		if (@getimagesize($image)) {
			$images_working[] = $image;
			echo $image . " is working<br>";

		}
		else {
			$images_broken[] = $image;
			echo $image . " is broken<br>";
		}
	};
	?>

	<!-- Implodes $images_working and $images_broken and adds them to $new_post -->
	<?php $new_post['images_working'] =  implode(', ', $images_working); ?>
	<?php $new_post['images_broken'] =  implode(', ', $images_broken); ?>

</div>

<hr class="" style="height: 1px; width: 100%; background:red; margin: 2rem 0;"></hr>

<div style="background-color: hsla(55, 100%, 50%, 0.2)">

	<h2 class="">Outputting final $new_post</h2>
	<?php echo '<pre>'; print_r($new_post); echo '</pre>'; ?>

</div>


<div style="background-color: hsla(16, 100%, 50%, 0.2)">

	<h2 class="">Try write page on hard drive</h2>


	<?php 

	try {


		// Creates new page under incartalarte-export with template 'project'
		$newPage = page('incartalarte-export')->children()->create($new_post['post_name'], 'project', $new_post);
		echo "The page " . $new_post['post_name'] . " has been created <br>";
		echo $newPage->root() . "<br>";


		// Save and rename all images listed in $images		
		$n = 0;
		foreach ($images_working as $image) {
						
			$n++;
			file_put_contents($newPage->root() . DS . $new_post['post_name'] . "-" . $n . ".jpg", fopen($image, 'r'));
			
		}


	}
	catch(Exception $e) {

		echo $e->getMessage();

		echo $e;

		echo "The page " . $new_post['post_name'] . " has not been created <br><br>";
  				// optional error message: $e->getMessage();
	}; ?>

</div>	

<?php snippet('footer') ?>