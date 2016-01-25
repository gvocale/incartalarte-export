<?php snippet('header') ?>

<?php db::insert('comments', array(
  'name'    => 'Bastian',
  'email'   => 'bastian@getkirby.com',
  'comment' => 'This is my first comment',
  'date'    => 'NOW()',
)); ?>

<?php snippet('footer') ?>