<?php if (!$error): ?>
<h1><?php echo $this->String->get_string('confirm_new_sampleset', 'SampleSet_form'); ?></h1>
    <p>The set code assigned is <?php echo $sampleSet['set_code'];?></p>
<?php else: ?>
    <?php var_dump($error); ?>
    There was a problem please contact Tony McGhie
<?php endif; ?>
