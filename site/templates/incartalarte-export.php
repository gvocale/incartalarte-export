<?php snippet('header') ?>


<?php $posts = db::select('alfa_posts', '*'); ?>
<?php $postmeta = db::select('alfa_postmeta', '*'); ?>
<?php $term_relationships = db::select('alfa_term_relationships', '*'); ?>
<?php $terms = db::select('alfa_terms', '*'); ?>

<style>
	.successful {
		color: green;
	}
	.error {
		color: red;
	}
</style>

<?php 
ini_set('max_execution_time', 15); //300 seconds = 5 minutes
//OR
set_time_limit(15); //If set to zero, no time limit is imposed. ?>

<!-- Number of post I'm testing this page with -->


<?php 

$product = [];

$post = $posts->filterBy("ID", "1144");
foreach ($post as $post) {

	if ($post->post_type() == "product") {
		// Print detailed content of post
		// echo '<pre>'; print_r($post); echo '</pre>';
		// Values I need are following
		// echo $post->ID() . '</br>';
		// echo $post->post_content() . '</br>';
		// echo $post->post_title() . '</br>';
		// echo $post->post_date() . '</br>';
		// echo $post->post_status() . '</br>';
		// echo $post->post_name() . '</br>';
		// echo $post->guid() . '</br>';
		// Let's add these values into the new $product;
		$product["id"] = $post->ID();
		$product["content"] = $post->post_content();
		$product["title_caps"] = $post->post_title();
		$product["date"] = $post->post_date();
		$product["status"] = $post->post_status();
		$product["title"] = $post->post_name();
		$product["old_guid"] = $post->guid();
	}
};


$metas = $postmeta->filterBy("post_id", "1144");
foreach ($metas as $meta) {
	// Print detailed content of meta, related to product id
	// foreach ($meta as $key => $value) {
	// 	echo '<pre>'; echo($key); echo '</pre>';	
	// 	echo '<pre>'; echo($value); echo '</pre>';
	// }
	// Values I need are following
	if ($meta->meta_key() == "_ebay_item_id") {
	// 	echo $meta->meta_key() . '</br>';
	// 	echo $meta->meta_value() . '</br>';
		$product["ebay_item_id"] = $meta->meta_value();
	}
	if ($meta->meta_key() == "_ebay_category_1_id") {
	// 	echo $meta->meta_key() . '</br>';
	// 	echo $meta->meta_value() . '</br>';
		$product["ebay_category"] = $meta->meta_value();
	}
	if ($meta->meta_key() == "_ebay_category_2_id") {
	// 	echo $meta->meta_key() . '</br>';
	// 	echo $meta->meta_value() . '</br>';
	//		Appending string	
		$product["ebay_category"] .= ", " . $meta->meta_value();
	}
	if ($meta->meta_key() == "_regular_price") {
	// 	echo $meta->meta_key() . '</br>';
	// 	echo $meta->meta_value() . '</br>';
		$product["regular_price"] = $meta->meta_value();
	}
	if ($meta->meta_key() == "_price") {
	// 	echo $meta->meta_key() . '</br>';
	// 	echo $meta->meta_value() . '</br>';
		$product["price"] = $meta->meta_value();
	}
	if ($meta->meta_key() == "_sale_price") {
	// 	echo $meta->meta_key() . '</br>';
	// 	echo $meta->meta_value() . '</br>';
		$product["sale_price"] = $meta->meta_value();
	}
	if ($meta->meta_key() == "_sku") {
	// 	echo $meta->meta_key() . '</br>';
	// 	echo $meta->meta_value() . '</br>';
		$product["ebay_sky"] = $meta->meta_value();
	}
	if ($meta->meta_key() == "_thumbnail_id") {
	// 	echo $meta->meta_key() . '</br>';
	// 	echo $meta->meta_value() . '</br>';
		$product["thumbnail_id"] = $meta->meta_value();
	}
	
}


$post = $posts->filterBy("ID", "1145");
foreach ($post as $post) {
		// This is fetching the attachment
		// Print detailed content of post
		// echo '<pre>'; print_r($post); echo '</pre>';
		// Values I need are following
		// echo $post->post_title() . '</br>';
		// echo $post->post_name() . '</br>';
		// echo $post->guid() . '</br>';
		// Let's add these values into the new $product;
	$product["title_caps_with_ebay_number"] = $post->post_title();
	$product["title_with_ebay_number"] = $post->post_name();
	$product["remote_image_url"] = $post->guid();
};

$metas = $postmeta->filterBy("post_id", "1145");
foreach ($metas as $meta) {
	// Search again postmeta, this time using the _thumbnail_id
	// Print detailed content of $meta
	// foreach ($meta as $key => $value) {
	// 	echo '<pre>'; echo($key); echo '</pre>';	
	// 	echo '<pre>'; echo($value); echo '</pre>';	
	// }
	// Values I need are following
	if ($meta->meta_key() == "_wp_attached_file") {
		// echo $meta->meta_key() . '</br>';
		// echo $meta->meta_value() . '</br>';
		// Let's add these values into the new $product;
		$product["local_image_url"] = $meta->meta_value();
	}
}


$product["category"] = [];

$categories = $term_relationships->filterBy("object_id", "1144");
// Let's create a counter and set it to 0
$i = 0;
foreach ($categories as $category) {

		// This is fetching the categories number
		// Print detailed content of post
		// echo '<pre>'; print_r($term); echo '</pre>';
		// Values I need are following
		// echo $category->term_taxonomy_id() . '</br>';
		// Let's get the name fo the slug for each category
	$tag = $terms->filterBy("term_id", $category->term_taxonomy_id())->first();
		// Values I need are following
		// echo $tag->name() . '</br>';
		// echo $tag->slug() . '</br>';
		// Let's add these values into the new $product;
		// Add 1 to the counter, if counter = 1 just add the category, if counter > 1 append comma and category. Let's also not add the category "simple"
	if ($tag->name() !== "simple") {
		$i++;
		if ($i == 1) {
			$product["category"] = $tag->name();
		}
		elseif ($i > 1) {
			$product["category"] .= ", " . $tag->name();
		}
	}

};



// $tags = $terms->filterBy("term_id", "685");
// foreach ($tags as $tag) {

// 		// This is fetching the name of each category
//			// I have incorporated this function above in $categories
// 		// Print detailed content of post
// 		// echo '<pre>'; print_r($tag); echo '</pre>';
// 		// Values I need are following
// 		// echo $tag->name() . '</br>';
// 		// echo $tag->slug() . '</br>';
// };


// Search and replace incartalarte.it// into incartalarte.it/
$product['old_guid'] = str_replace("incartalarte.it//","incartalarte.it/",$product['old_guid']);
$product['remote_image_url'] = str_replace("incartalarte.it//","incartalarte.it/",$product['remote_image_url']);


// Finds any string starting with http, ending with jpg and not including white spaces, and puts it in $images
$what = '/http.[^\s]*jpg/';
preg_match_all($what, $product['content'], $images);
$images = $images[0];

// // Finds images that contain jpegbay into their url, strips the last character before .jpg, and adds f.jpg (for full width).
foreach ($images as $key => $value) {
	$pattern = "jpegbay";
	$check = strpos($value, $pattern);
	if ($check !== false) {
		// Trim the $value of the last 7 digits, while saving it back into $images at $key it belongs
		$images[$key] = substr($value, 0, -6);
		// Appents _f.jpg
		$images[$key] .= "_f.jpg";
	}
}

// Find JPEGbay code, moves it to $product['jpegbay'], then removes it from $product['post_content']
// Find any string starting with JPEG and ending with stop, including whitespace and multiline
$what = '/<!-- JPEG.[\S\s]*stop -->/';
preg_match_all($what, $product['content'], $jpegbay);
$product['jpegbay'] = $jpegbay[0][0];
$product['content'] = str_replace($product['jpegbay'],"",$product['content']);


// Remove any <img> tag from post content
$img_tag = '<img([\w\W]+?)>';
preg_match_all($img_tag, $product['content'], $img_tag_matches);
$product['content'] = str_replace($img_tag_matches[0], "", $product['content']);


// Prepends http://www.incartalarte.it to $product['local_image_url'] and puts it into $images
$images[] = "http://www.incartalarte.it/wp-content/uploads/" . $product['local_image_url'];	



// If an image link is broken, gets moved to $images_broken. If it's working, get's moved to $image_working

$images_working = [];
$images_broken = [];
foreach ($images as $image) {
	if (@getimagesize($image)) {
		$images_working[] = $image;
		// echo "<span class=\"successful\">" . $image . " is working<br></span>";
	}
	else {
		$images_broken[] = $image;
		// echo "<span class=\"error\">" . $image . " is broken<br>";
	}
};

// Implodes $images_working and $images_broken and adds them to $product -->
if (!empty($images_working)) {
	$product['images_links_working'] =  implode(', ', $images_working);
	// echo "<span class=\"successful\">" . count($images_working) . " image links working.<br>";
}
if (!empty($images_broken)) {
	$product['images_links_broken'] =  implode(', ', $images_broken);	
	echo "<span class=\"error\">" . count($images_broken) . " broken image links.<br>";
}


// Sanity check to see if the values have been added to $product;
// foreach ($product as $key => $value) {
// 	echo '<pre>'; echo($key); echo '</pre>';	
// 	echo '<pre>'; echo($value); echo '</pre>';
// }


// Try to save the page onto the hard drive
try {

	// Creates new page under incartalarte-export with template 'project'
	$newPage = page('incartalarte-export')->children()->create($product['title'], 'project', $product);
	echo "<span class=\"successful\">" . $product['title'] . " has been created.<br>";
	// echo "<span class=\"error">" . $image . " is broken<br>";
	// echo $newPage->root() . "<br>";

	// Save and rename all images listed in $images
	$n = 0;
	foreach ($images_working as $image) {
		$n++;
		file_put_contents($newPage->root() . DS . $product['title'] . "-" . $n . ".jpg", fopen($image, 'r'));
	}
	echo "<span class=\"successful\">" . $n . " images saved.<br>";

}
catch(Exception $e) {

	// Throws error messages if something is wrong.
	echo "<span class=\"error\">" . $product['title'] . " has not been created.<br>";
	echo $e->getMessage();

};	
echo "<hr>";

?>


<?php snippet('footer') ?>