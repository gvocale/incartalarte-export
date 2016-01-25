<?php snippet('header') ?>

<?php $comments = db::select('comments', '*'); ?>

<?php $alfa_posts = db::select('alfa_posts', '*'); ?>

<?php print_r($comments) ?>

<h2>Comments</h2>
<ul class="comments">

  <?php foreach($comments as $comment): ?>
  	
  <li>
  	<?php print_r($comment) ?>
  	<br>
  </li>
  
  <?php endforeach ?>

</ul>

<h2>Alfa Posts</h2>
<ul class="alfa_posts">

  <?php foreach($alfa_posts as $alfa_post): ?>
  <li>
  	<?php print_r($alfa_post) ?>
  	<br>
  </li>
  <?php endforeach ?>

</ul>



<?php snippet('footer') ?>