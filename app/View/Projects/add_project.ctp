 
 <?php
$this->assign('title', 'New Project');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'Project_form'); ?></h1>
<p><?php echo $this->String->get_string('sub_title', 'Project_form'); ?></p>
</header>
<?php
echo $this->BootstrapForm->create_horizontal('Project', ['action' => 'addProject']);
echo $this->BootstrapForm->input_horizontal('short_name', ['label' => ['text' => $this->String->get_string('short_name', 'Project_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('long_name', ['label' => $this->String->get_string('long_name', 'Project_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('code', ['label' => $this->String->get_string('code', 'Project_form'),
    'autocomplete' => 'off', 'required']);
echo $this->BootstrapForm->input_horizontal('type', ['label' => $this->String->get_string('type', 'Project_form'),
    'required', 'options' => $this->My->getProjectTypeOptions()]);
echo $this->BootstrapForm->input_horizontal('owner', ['label' => $this->String->get_string('owner', 'Project_form')]);

echo $this->BootstrapForm->input_maker('save', [
        'onclick' => 'submit_first_form(\'main_content\'); return false;'
    ], [
        'horizontal' => true,
        'type' => 'button'
]);

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>   
    
    
<?php
/**$projectType_options = ['Blueskies' => 'Blueskies','BPA' => 'BPA','Commercial' => 'Commercial','Core' => 'Core','Discovery Science' => 'Discovery Science','MBIE' => 'MBIE',
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

echo $this->fetch('Project');*/
?>
</div>
