<?php
$this->assign('title', 'New Feedback');
//echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' , array('inline' => false));      
//echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js' , array('inline' => false)); 
$this->Html->css('jquery-ui', null, array('inline' => false));
?>
<header>
<h1>Submit New CAM Feedback</h1>

<p>This space is submitting feedback.</p>
<p> Your feed back can be suggestions for improvement, or reporting problems that need to be fixed.</p>
</header>
<?php
echo $this->Form->create('Feedback', ['type' => 'file']);
//This creates all the inputs in an inline table nested with divs and the text to the left in a span
echo $this->My->makeInputRow('submitter', ['value' => (isset($user['name']) ? $user['name'] : '')], 'Submitter *');
echo $this->My->makeInputRow('issue', ['rows' => '5','placeholder' => 'Describe your feedback or issue'], 'CAM Feedback *');
echo $this->My->makeInputRow('priority', ['options' => $this->My->getFeedbackOptions()], 'Type *');
echo $this->Form->end(['label' => 'Save Feedback', 'class' => 'large-button anySizeButton']);
?>


