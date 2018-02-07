<?php if (!$error): ?>
<h1><?php echo $this->String->get_string('title', 'SampleSet_form'); ?></h1>
    <p>The Sample Set was created successfully!</p>
    <p>The set code assigned is <?php echo $set_code;?></p>
<?php else: ?>
    <?php var_dump($error); ?>
    There was a problem please contact Tony McGhie
<?php endif; ?>
