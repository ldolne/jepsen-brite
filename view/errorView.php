<div>
    <h1>Error</h1>
    <?php if(isset($previousURL)) {?><p><a href="<?= $previousURL?>">Back to the previous page</a></p><?php }?>
    <p><a href="index.php">Back to homepage</a></p>
    <?php if(isset($errorMsg)){echo $errorMsg;}; ?>
</div>
