<?php $title = 'error'; ?>
<?php ob_start(); ?>
<div>
    <h1>Error</h1>
    <?php if(isset($previousURL)) {?><p><a class="btn btn-info" href="<?= $previousURL?>">Back to the previous page</a></p><?php }?>
    <p><a class="btn btn-info" href="index.php">Back to homepage</a></p>
    <?php if(isset($errorMsg)){echo $errorMsg;}; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>