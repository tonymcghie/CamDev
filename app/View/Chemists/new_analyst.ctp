 
 <?php
$this->assign('title', 'New Analyst');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'Analyst_form'); ?></h1>
<p><?php echo $this->String->get_string('sub_title', 'Analyst_form'); ?></p>
</header>
<?php
echo $this->BootstrapForm->create_horizontal('Chemist', ['action' => 'newAnalyst']);
echo $this->BootstrapForm->input_horizontal('name', ['label' => ['text' => $this->String->get_string('name', 'Analyst_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('team', ['label' => $this->String->get_string('team', 'Analyst_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('name_code', ['label' => $this->String->get_string('name_code', 'Analyst_form'),
    'autocomplete' => 'off', 'required']);
echo $this->BootstrapForm->input_horizontal('type', ['label' => $this->String->get_string('type', 'Analyst_form'),
    'required', 'options' => $this->My->getAnalystTypeOptions()]);
echo $this->BootstrapForm->input_horizontal('location', ['label' => $this->String->get_string('location', 'Analyst_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('ext_number', ['label' => $this->String->get_string('ext_number', 'Analyst_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('email', ['label' => $this->String->get_string('email', 'Analyst_form')]);

echo $this->BootstrapForm->addActionButtons();

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>   

