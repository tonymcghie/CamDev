<?php
$this->assign('title', 'New Feedback');
echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' , array('inline' => false));      
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js' , array('inline' => false)); 
$this->Html->css('jquery-ui_'.getenv('CSS_VERSION'), null, array('inline' => false));
?>
<header>
<h1>Submit New CAM Feedback</h1>

<?php
if (isset($set_code)){
    echo '<h2>The Set code for this sample set is: '.$set_code.'</h2>';
}
if (isset($error)){
    echo '<h2>Some Thing went wrong and the Sample Set was unable to be added</h2>';
}
?>

<p>This space is submitting feedback.  This can be suggestions for improvement, or reporting issues.
    Enter the relevant information (* required) and click Save Set</p>
	</header>
<?php
echo $this->Form->create('Feedback', ['type' => 'file']);
//This creates all the inputs in an inline table nested with divs and the text to the left in a span
$this->start('slide1');
echo $this->My->makeInputRow('submitter', ['value' => (isset($user['name']) ? $user['name'] : '')], 'Submitter *');
echo $this->My->makeInputRow('issue', ['rows' => '5','placeholder' => 'Describe your feedback or issue'], 'CAM Feedback');
echo $this->My->makeInputRow('type', ['options' => $this->My->getFeedbackOptions()], 'Type *');
$this->end();
$this->start('slide2');
echo $this->Form->end(['label' => 'Save Set', 'class' => 'large-button anySizeButton']);
$this->end();
$this->start('extras');
echo $this->Html->scriptStart();
echo $this->Js->get('#chemist')->event('keyup', 'ajaxCallChemist()', false); //ajax call that will update the ul with the possible names
echo $this->Html->scriptEnd();
// Add a scriptStart specifically for project names
echo $this->Html->scriptStart();
echo $this->Js->get('#p_name')->event('keyup', 'ajaxCallProject()', false); //ajax call that will update the ul with the possible project names
echo $this->Html->scriptEnd();
?>
<ul id='autoOptions' class='ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all' style='position: absolute;'>
    
</ul>
<ul id='ProAutoOptions' class='ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all' style='position: absolute;'>
    
</ul>
<script>
    
    /**
     * Shows the options when the chemists textbox is selected
     */
    $("#chemist").on('focus', function(){ //shows the ul when chemist input is selected
        $("#autoOptions").show(); 
    });
    
    /**
     * Shows the options when the project name textbox is selected
     */
    $("#p_name").on('focus', function(){ //shows the ul when project name input is selected
        $("#ProAutoOptions").show(); 
    });
    
    /**
     * hides the auto complete options when anything other than the chemist text box and the options ul is clicked
     */
    $("html").on('click', function(event){ //hides the ul when clicking off the chemist input
        if (event.target.id!=='chemist'&&event.targetid!=='autoOptions'){
            $('#autoOptions').hide(); 
        }
        if (event.target.id!=='p_name'&&event.targetid!=='ProAutoOptions'){
            $('#ProAutoOptions').hide(); 
        }
    });
    
    $("document").ready(function (){
        $('#autoOptions').hide();  //hides the auto fill options when the page loads
        $('#ProAutoOptions').hide();  //hides the auto fill options when the page loads
        $('#setCodeRow').hide();  //hides the previous set code option when the page loads
    });
    
    $("#containment").click(function(){                 //shows and hides the containment_details row as needed
        $("#containment_details").toggle(this.checked);
    });
    $("#isPreSetCode").click(function(){ //this will show the setcode row and hide the check bax when clicked
        $("#setCodeRow").toggle(this.checked);
        $("#isPreSetCodeRow").hide();
    });
    
    /**
     * This starts an Ajax call that will update the chemists auto fill as well as position it and hide it if there are no results to show
     * @returns {undefined}
     */
    function ajaxCallChemist(){
        <?php
        echo $this->Js->request(['action' => 'nameAutoComplete'] , [
            'async' => true,
            'method' => 'post',
            'data' => '{name: $("#chemist").val()}',
            'dataExpression' => true,
            'update' => '#autoOptions']);
        ?>
        var offset = $("#chemist").offset();  //gets the offset of the input box           
        var height = $("#chemist").outerHeight();  //gets the height of the input bx
        $("#autoOptions").css('left' , offset.left); //sets the left offset for the ul
        $("#autoOptions").css('top' , offset.top+height); //sets the top offset
        if($("#autoOptions").is(':empty')){
            $("#autoOptions").hide(); //hides the options if there are none to display
        } else {
            $("#autoOptions").show();
        }
    }
    
    function ajaxCallProject(){
        <?php
        echo $this->Js->request(['controller' => 'Projects', 'action' => 'projectAutoComplete'] , [
            'async' => true,
            'method' => 'post',
            'data' => '{name: $("#p_name").val()}',
            'dataExpression' => true,
            'update' => '#ProAutoOptions']);
        ?>
        var offset = $("#p_name").offset();  //gets the offset of the input box           
        var height = $("#p_name").outerHeight();  //gets the height of the input bx
        $("#ProAutoOptions").css('left' , offset.left); //sets the left offset for the ul
        $("#ProAutoOptions").css('top' , offset.top+height); //sets the top offset
        if($("#ProAutoOptions").is(':empty')){
            $("#ProAutoOptions").hide(); //hides the options if there are none to display
        } else {
            $("#ProAutoOptions").show();
        }
    }
    
    function getProjectData(name){
		var shortname = name.split(" - ")[0];
        <?php
		    echo $this->Js->request(['controller' => 'Projects', 'action' => 'getData'] , [
		        'async' => true,
		        'method' => 'post',
		        'data' => '{name: shortname}',
		        'dataExpression' => true,
				'success' => '{updateProjectData(data);}']);
        ?>
	}
        function updateProjectData(data){
		var dataArray = JSON.parse(data);
		$('#p_code').val(dataArray['Project']['code']);
	}
    
    /**
     * This adds the new name to the chemist input
     * then hides the options
     * @param {String} newName the value to set in the Chemists input
     * @returns {null}
     */
    function change(newName){ //adds the new name to the chemist input then hides the ul
        $("#chemist").val(newName);
        ajaxCall();
        $("#autoOptions").hide();
    }
    
    function changeProject(newName){
		$("#p_name").val(newName);
		ajaxCallProject();
		$("#ProAutoOptions").hide();
		getProjectData(newName);
	}
        
    /**
     * This is Called then the user inputs into the from previo0us sample set box
     * It starts an ajax call to get the info of the entered sample set
     * then calls a method to set the values into the inputs
     */
    $("#setCode").on('input', function(){ //This calls the ajax method in the controller which returns a json array with 1 sample set in it
       <?php //This also sets the data into the input boxes through the setValues function
        echo $this->Js->request(['controller' => 'SampleSets', 'action' => 'getSetCode'], [
            'async' => true,
            'method' => 'post',
            'data' => '{setCode: $("#setCode").val()}',
            'dataExpression' => true,
            'type' => 'json',
            'success'=> ' 
                        setValues(data);
                    ',
            'error' => '
                        //alert(errorThrown);
                '
            ]);
       ?>
    });
    
    /**
     * takes an array and sets all the values in the form from that array
     * @param {array} data in the form data[0]["SampleSet"][values]
     * @returns {null}
     */
    function setValues(data){
        if (typeof data[0] !== 'undefined') {
            $("[name='data[SampleSet][submitter]']").val(data[0]["SampleSet"]["submitter"]);
            $("[name='data[SampleSet][p_name]']").val(data[0]["SampleSet"]["p_name"]);
            $("[name='data[SampleSet][p_code]']").val(data[0]["SampleSet"]["p_code"]);
            $("[name='data[SampleSet][exp_reference]']").val(data[0]["SampleSet"]["exp_reference"]);
            $("[name='data[SampleSet][chemist]']").val(data[0]["SampleSet"]["chemist"]);
            $("[name='data[SampleSet][crop]']").val(data[0]["SampleSet"]["crop"]);
            $("[name='data[SampleSet][type]']").val(data[0]["SampleSet"]["type"]);
            $("[name='data[SampleSet][number]']").val(data[0]["SampleSet"]["number"]);
            $("[name='data[SampleSet][sample_loc]']").val(data[0]["SampleSet"]["sample_loc"]);
            $("[name='data[SampleSet][set_reason]']").val(data[0]["SampleSet"]["set_reason"]);
            $("[name='data[SampleSet][compounds]']").val(data[0]["SampleSet"]["compounds"]);
            $("[name='data[SampleSet][containment]']").prop('checked', data[0]["SampleSet"]["containment"]);            
            $("[name='data[SampleSet][containment_details]']").val(data[0]["SampleSet"]["containment_details"]);
            if ($("[name='data[SampleSet][containment_details]']").val() !== ''){
                $("#containment_details").show();
            } else {
                $("[#containment_details").hide();
            }
            $("[name='data[SampleSet][comments]']").val(data[0]["SampleSet"]["comments"]);  
        }        
    }
</script>
<?php $this->end();
if ($tabletView !== 'true'){ //desktop view
    echo $this->fetch('slide1');
    echo $this->fetch('slide2');    
    echo $this->fetch('extras');
}
?>

