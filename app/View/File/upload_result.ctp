<?php if(empty($error)) : ?>
    <div>
        You have uploaded: <?php echo $name; ?>
    </div>
<?php else : ?>
    <div>
        There was an error uploading the file:
        <?php echo $error; ?>
    </div>
<?php endif; ?>
