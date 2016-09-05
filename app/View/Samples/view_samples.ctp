<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Sample View and Upload Workspace</h1>
<h2>Set Code: <?php echo $info['SampleSet']['set_code'] ?></h2>
<?php if (count($results)<=0): ?>
<h2>No Data Found</h2>
<ol>
    <li id="add"><a href="">+</a></li>
</ol>
<?php endif; ?>
</header>
