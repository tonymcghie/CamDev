
<header>
<h1>New Project</h1>
</header>
<div class="add-metabolite">
<?php
$projectType_options = ['Blueskies' => 'Blueskies','BPA' => 'BPA','Commercial' => 'Commercial','Core' => 'Core','Discovery Science' => 'Discovery Science','MBIE' => 'MBIE',
    'Other' => 'Other'];
$this->start('Project');  
echo $this->Form->create('Project');
echo "<h2>Enter New Project Details</h2>";
//echo $this->My->makeInputRow('exact_mass', [], 'Exact Mass');
echo $this->My->makeInputRow('short_name', ['placeholder' => 'Less than 45 characters'], 'Short Name *');
echo $this->My->makeInputRow('long_name', [], 'Long Name');
echo $this->My->makeInputRow('code', ['placeholder' => 'Enter charge code e.g. P/...., or NC if no code available.'], 'Code *');
echo $this->My->makeInputRow('type', ['options' => $projectType_options], 'Type');
echo $this->My->makeInputRow('owner', ['placeholder' => 'PFR staff member'], 'Owner');
echo $this->Form->end(['label' => 'Save New Project', 'class' => 'large-button anySizeButton green-button']);
$this->end();

echo $this->fetch('Project');
?>
</div>
