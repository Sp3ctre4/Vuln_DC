<?php

set_include_path( __DIR__ . "/includes/");
include_once "web_functions.inc.php";

render_header();
render_footer();

?>

<div class="container">
 <div class="col-sm-8">
  <div class="panel panel-default">
   <div class="panel-heading text-center"><?php print "Welcome to the Roshar printer management system"; ?></div>
   <div class="panel-body text-center">
    <img src="images/printer.jpg" alt="printer">
   </div>
   </div>
  </div>
 </div>
</div>