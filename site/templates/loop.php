<?php snippet('header') ?>

<?php $comments = db::select('comments', '*'); ?>

<?php $alfa_posts = db::select('alfa_posts', '*'); ?>

<?php $incartalarte = db::select('incartalarte', '*'); ?>
<?php $wp_postmeta = db::select('wp_postmeta', '*'); ?>
<?php $wp_posts = db::select('wp_posts', '*'); ?>

<?php $wp_terms = db::select('wp_terms', '*'); ?>

<h2>Liquorvitae WP TERMS</h2>
<ul class="alfa_posts">
  <?php print_r($wp_terms) ?>
  
  <?php foreach($key as $each): ?>

    <?php if ($each->meta_key() == "_wp_attached_file"): ?>
      <li style="margin-top: 1rem">
        <?php print_r($each) ?>
        <p><strong>post_id</strong> <?php echo $each->post_id() ?></p>
        <p><strong>meta_key</strong> <?php echo $each->meta_key() ?></p>
        <p><strong>meta_value</strong> <?php echo $each->meta_value() ?></p>
      </li>
    <?php endif ?>
  
  <?php endforeach ?>
</ul>

<h2>Liquorvitae Photos</h2>
<ul class="alfa_posts">
  <?php foreach($wp_postmeta as $each): ?>
  	<?php if ($each->meta_key() == "_wp_attached_file"): ?>
      <li style="margin-top: 1rem">
        <p><strong>post_id</strong> <?php echo $each->post_id() ?></p>
        <p><strong>meta_key</strong> <?php echo $each->meta_key() ?></p>
        <p><strong>meta_value</strong> <?php echo $each->meta_value() ?></p>
      </li>
    <?php endif ?>
  <?php endforeach ?>
</ul>

<h2>Liquorvitae Posts</h2>
<ul class="alfa_posts">
  <?php foreach($wp_posts as $each): ?>
    <?php if (!empty($each->post_content())): ?>
    <li style="margin-top: 1rem">
    <?php print_r($each) ?>
    <p><strong>ID</strong> <?php echo $each->ID() ?></p>
    <p><strong>post_name</strong> <?php echo $each->post_name() ?></p>
    <p><strong>guid</strong> <?php echo $each->guid() ?></p>
    <p><strong>post_title</strong> <?php echo $each->post_title() ?></p>
    <p><strong>post_content</strong> <?php echo $each->post_content() ?></p>
      <p><strong>post_comment</strong> <?php echo $each->post_comment() ?></p>
      <p><strong>post_type</strong> <?php echo $each->post_mime_type() ?></p>
      
    </li>
    <?php endif ?>
  <?php endforeach ?>
</ul>

<?php try {
$newPage = $page->children()->create(get('ID'), 'project', array(
  'ID'     => get('ID'),
  'post_name' => get('post_name'),
  'guid'      => get('guid')
));
  echo 'The page has been created';
} 

catch(Exception $e) {

  echo 'The user could not be created';
  // optional error message: $e->getMessage();

} ?>
<?php snippet('footer') ?>