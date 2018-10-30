 
 <?php
$this->assign('title', 'New Project');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'Project_form'); ?></h1>
<p><?php echo $this->String->get_string('sub_title', 'Project_form'); ?></p>
</header>
<?php
echo $this->BootstrapForm->create_horizontal('Project', ['url' => array('controller' => 'Projects', 'action' => 'addProject')]);
echo $this->BootstrapForm->input_horizontal('short_name', ['label' => ['text' => $this->String->get_string('short_name', 'Project_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('long_name', ['label' => $this->String->get_string('long_name', 'Project_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('code', ['label' => $this->String->get_string('code', 'Project_form'),
    'autocomplete' => 'off', 'required']);
echo $this->BootstrapForm->input_horizontal('type', ['label' => $this->String->get_string('type', 'Project_form'),
    'required', 'options' => $this->My->getProjectTypeOptions()]);
echo $this->BootstrapForm->input_horizontal('owner', ['label' => $this->String->get_string('owner', 'Project_form')]);

echo $this->BootstrapForm->addActionButtons();

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>   

