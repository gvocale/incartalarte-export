
<?php snippet('header') ?>

  <main class="main" role="main">

<?php

$csv = array_map('str_getcsv', file('ebay.csv'));
print_r($csv);

?>
  </main>

<?php snippet('footer') ?>