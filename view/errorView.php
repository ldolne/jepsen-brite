<?php $title = 'Error'; ?>

<?php ob_start(); ?>
<h1>Error</h1>
<p><a href="./index_laeti.php">Back to the homepage</a></p>
<p>Error:</p>

<?php $content = ob_get_clean(); ?>

<?php require('template_laeti.php'); ?>