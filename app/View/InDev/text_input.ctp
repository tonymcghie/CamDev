<?php
$this->assign('title', 'New Set');
echo $this->Html->script('jquery-3.1.1/jquery-3.1.1.min' , array('inline' => false));
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js' , array('inline' => false)); 
echo $this->Html->script('/js/ckeditor/ckeditor' ,  array('inline' => false));
//$this->Html->script('HelperScripts.min.js?'.filemtime('js/HelperScripts.min.js'), array('inline' => false));
//echo $this->Html->script('https://cdn.ckeditor.com/4.7.2/standard/ckeditor.js' , array('inline' => false));
//CKEditor is working for the above line eventhough it is installed into the project in webroot/js
//this is okay but for production there are too many dangerous editing options and so the number of editing options with need to be reduced
$this->Html->css('jquery-ui', null, array('inline' => false));
?>
<header>
<h1>Text Input Testing</h1>

<p>This page is for testing how to use CKEditor</p>
<p>CKEditor is a wysiwyg editor and convert inputted text into HTML, which can then be stored in database table</p>

</header>
<body>
<fieldset>
    <legend><?php echo __('Add Some Text'); ?></legend>
    <?php
	//echo $this->Form->input('firstname');
        echo $this->Form->create('Test');
        //if use makeInputTextEd the editor is screwed up but the Form statment below workds and it is Posted
	//echo $this->My->makeInputTextEd('text_input', ['rows' => '3', 'placeholder' => 'Insert any additional information, using makeInputTextEd', 'class' => 'ckeditor', 'required' => false], 'Additional Comments');
        echo $this->Form->textarea('text_input', array(
           'class' => 'ckeditor',
           'required' => false
        ));
        echo $this->Form->end(['label' => 'Save Set', 'class' => 'large-button anySizeButton']);
        $this->end();
    ?>
</fieldset>
<?php echo $this->Js->writeBuffer(); ?>
</body>

