<?php
$this->assign('title', 'New Sample Set');

//var_dump($versions);
$versionOptions = array();
foreach($versions as $version){
    $versionOptions[$version['SampleSet']['version']] = 'Version '.$version['SampleSet']['version'];
    $latestVersion = $version['SampleSet']['version'];  //on the last iteration sets the $latestVersion 
}
//setup process for displaying multiple version of the sample set info
?>
<header>
<h1><?php echo $this->String->get_string('edit_title', 'SampleSet_form'); ?></h1>

<?php
if (isset($set_code)){
    echo '<h3>The Set Code for this sample set is: '.$set_code.'</h3>';
}
?>

<p><?php echo $this->String->get_string('sub_title', 'SampleSet_form'); ?></p><br>

<?php
echo '<table class="noFormat editSampleVersion">';
echo $this->Html->tableCells([$this->Form->input('versions',['options' => $versionOptions, 'selected' => $latestVersion, 'id' => 'switcher']), //displayes the version select
    (($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])) ? $this->Html->link('Analysis', array('controller' => 'Analyses', 'action' => 'editAnalysis', '?' => 'set_code='.$set_code), array('class' => 'find-button anySizeButton')) : '')]); //displays the analyses button if uer is chemist
echo '</table>';
var_dump($versions);
?>
</header>

<?php
foreach($versions as $version){
echo $this->BootstrapForm->create_horizontal('SampleSet', ['type' => 'file' ,'action' => 'createSampleSet']);
//to do make a clone button in the table

echo $this->BootstrapForm->input_horizontal('version', ['label' => $this->String->get_string('version', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('confidential', ['type' => 'checkbox',
    'label' => $this->String->get_string('confidential', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('submitter', ['label' => ['text' => $this->String->get_string('submitter', 'SampleSet_form')],
     'readonly',]);

echo $this->BootstrapForm->input_horizontal('p_name', ['label' => $this->String->get_string('p_name', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('p_name_ph', 'SampleSet_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('exp_reference', ['label' => $this->String->get_string('exp_reference', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('exp_reference_ph', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('chemist', ['label' => $this->String->get_string('chemist_name', 'SampleSet_form'),
    'readonly']);

echo $this->BootstrapForm->input_horizontal('crop', ['label' => $this->String->get_string('crop', 'SampleSet_form'),
    'required', 'options' => $this->My->getCropOptions()]);

echo $this->BootstrapForm->input_horizontal('type', ['label' => $this->String->get_string('sample_type', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('sample_type_ph', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('number', ['label' => $this->String->get_string('sample_number', 'SampleSet_form'),
    'required']);

echo $this->BootstrapForm->input_horizontal('sample_loc', ['label' => $this->String->get_string('transport', 'SampleSet_form')]);
echo $this->BootstrapForm->input_horizontal('set_reason', ['label' => $this->String->get_string('reason', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('reason_ph', 'SampleSet_form'),
    'rows' => '3']);

echo $this->BootstrapForm->input_horizontal('compounds', ['label' => $this->String->get_string('compounds', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('compounds_ph', 'SampleSet_form'),
    'rows' => '3',
    'required']);

echo $this->BootstrapForm->input_horizontal('containment', ['type' => 'checkbox',
    'label' => $this->String->get_string('containment', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('containment_details', ['label' => $this->String->get_string('containment_detils', 'SampleSet_form'),
    'rows' => '3']);

echo $this->BootstrapForm->input_horizontal('comments', ['label' => $this->String->get_string('comments', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('comments_ph', 'SampleSet_form'),
    'rows' => '3']);

echo $this->BootstrapForm->input_horizontal('status', ['label' => $this->String->get_string('status', 'SampleSet_form'),
    'options' => $this->My->getSampleSetStatusOptions()]);

echo $this->BootstrapForm->input_horizontal('metadataFile', ['label' => $this->String->get_string('metafile', 'SampleSet_form'),
    'type' => 'file']);

echo $this->BootstrapForm->addActionButtons();

$this->BootstrapForm->add_validator('requires', 'submitter');
$this->BootstrapForm->add_validator('requires', 'chemist');
$this->BootstrapForm->add_validator('requires', 'number');
$this->BootstrapForm->add_validator('requires', 'compounds');
$this->BootstrapForm->add_validator('match_validator', 'chemist', ['data' => $names]);

$this->BootstrapForm->new_rule('display_if_checked', 'containment_details', 'containment' , null, ['transition' => 'slide_down']);

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
}
?>
<script>
    $(function() {
        $('#SampleSetChemist').autocomplete({
            source: Object.values(JSON.parse('<?php echo json_encode($names); ?>')),
            appendTo: $('#SampleSetChemist').closest('div')
        });
        $('#SampleSetPName').autocomplete({
            source: Object.values(JSON.parse('<?php echo json_encode($p_names); ?>')),
            appendTo: $('#SampleSetPName').closest('div')
        });
    });
    
    var currentForm = $("#switcher :selected").val()+"form";

    <?php foreach($versions as $version): ?>
    $("#containment<?php echo $version['SampleSet']['version']; ?>").click(function(){   //hides and shows details
        toggleDetails(this.checked, <?php echo $version['SampleSet']['version']; ?>);
    });
    <?php endforeach; ?>

    $("document").ready(function(){
        <?php foreach($versions as $version): ?>
            toggleDetails($("#containment<?php echo $version['SampleSet']['version']; ?>").is(':checked'), <?php echo $version['SampleSet']['version']; ?>); //hides or shows details when page loads
            $("#<?php echo $version['SampleSet']['version'].'form'; ?>").hide();
        <?php endforeach; ?>
        $("#" + $("#switcher :selected").val()+"form").show();
        currentForm = $("#switcher :selected").val()+"form";
    });


    /**
     * takes an array and sets all the values in the form from that array
     * @param {array} data in the form data[0]["SampleSet"][values]
     * @returns {null}
     */
/*    function setValues(data){
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
    }*/
</script>

