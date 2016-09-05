<header>
<h1>Review/Edit Sample Set MetaData</h1>
<?php
echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' , array('inline' => false));

$versionOptions = array();
foreach($versions as $version){
    $versionOptions[$version['SampleSet']['version']] = 'Version '.$version['SampleSet']['version'];
    $latestVersion = $version['SampleSet']['version'];
}

echo '<table class="noFormat editSampleVersion">';
echo $this->Html->tableCells([$this->Form->input('versions',['options' => $versionOptions, 'selected' => $latestVersion, 'id' => 'switcher']), //displayes the version select
    (($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])) ? $this->Html->link('Analysis', array('controller' => 'Analyses', 'action' => 'editAnalysis', '?' => 'set_code='.$set_code), array('class' => 'find-button anySizeButton')) : '')]); //displays the analyses button if uer is chemist
echo '</table>';
echo '</header>';
foreach($versions as $version){
    echo $this->Form->create('SampleSet', ['id' => $version['SampleSet']['version'].'form' ]);
    echo $this->Form->input('id', array('type' => 'hidden', 'value' => (isset($newId) ? $newId : $version['SampleSet']['id'])));
    echo $this->Form->input('set_code', array('type' => 'hidden', 'value' => $set_code));
    echo $this->Form->input('chemist', array('type' => 'hidden', 'value' => $version['SampleSet']['chemist']));
    echo $this->Form->input('team', array('type' => 'hidden', 'value' => $version['SampleSet']['team']));
    echo $this->Form->input('submitter_email', array('type' => 'hidden', 'value' => $version['SampleSet']['submitter_email']));
    echo $this->My->makeInputRow('set_code', ['disabled' => 'disabled', 'value' => $version['SampleSet']['set_code']], 'Set Code');
    if ($version['SampleSet']['confidential'] === '1'){
        echo $this->My->makeInputRow('confidential', ['type' => 'checkbox', 'checked' => 'checked'], 'Confidential');
    } else {
        echo $this->My->makeInputRow('confidential', ['type' => 'checkbox'], 'Confidential');
    }
    echo $this->My->makeInputRow('submitter', ['value' => $version['SampleSet']['submitter']], 'PFR Collaborator');
    echo $this->My->makeInputRow('p_name', ['value' => $version['SampleSet']['p_name']], 'Program Name');
    echo $this->My->makeInputRow('p_code', ['value' => $version['SampleSet']['p_code']], 'Program Code');
    echo $this->My->makeInputRow('exp_reference', ['value' => $version['SampleSet']['exp_reference']], 'Experiment Reference');
    echo $this->My->makeInputRow('chemist', ['id' => 'chemist', 'disabled' => 'disabled', 'value' => $version['SampleSet']['chemist']], 'Chemist Name');
    echo $this->My->makeInputRow('team', ['disabled' => 'disabled', 'value' => $version['SampleSet']['team']], 'Team');
    echo $this->My->makeInputRow('crop', ['options' => $this->My->getCropOptions(), 'value' => $version['SampleSet']['crop']], 'Crop');
    echo $this->My->makeInputRow('type', ['value' => $version['SampleSet']['type']], 'Sample Type');
    echo $this->My->makeInputRow('number', ['value' => $version['SampleSet']['number']], 'Number of Samples');
    echo $this->My->makeInputRow('sample_loc', ['value' => $version['SampleSet']['sample_loc']], 'Location/Transport Of Samples');
    echo $this->My->makeInputRow('set_reason', ['rows' => '3', 'value' => $version['SampleSet']['set_reason']], 'Reason for Analysis');
    echo $this->My->makeInputRow('compounds', ['rows' => '3', 'value' => $version['SampleSet']['compounds']], 'Compounds for Analysis');
    echo $this->My->makeInputRow('containment', ['type' => 'checkbox', 'id' => 'containment'.$version['SampleSet']['version'], 'checked' => $version['SampleSet']['containment'] ], 'Reqires Containment');
    echo $this->My->makeInputRow('containment_details', ['rows' => '3', 'rowId' => 'containment_details'.$version['SampleSet']['version'], 'value' => $version['SampleSet']['containment_details']], 'Details');
    echo $this->My->makeInputRow('comments', ['rows' => '3', 'value' => $version['SampleSet']['comments']], 'Additional Comments');
    echo '<div class="Trow"><span>Upload new Metadata File</span><div class="input text">'.$this->Form->file('metadataFile', []).'</div></div>';
    echo $this->Form->end(['label' => 'Save As New Version', 'class' => 'large-button anySizeButton']);
}

?>
<script>
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

    function toggleDetails(bool, from){
        $("#containment_details"+from).toggle(bool);
    }
    $("#switcher").change(function(event){
        $("#"+currentForm).fadeOut('fast',function(){
            $("#"+$("#switcher  :selected").val()+"form").fadeIn('fast');
            currentForm = $("#switcher :selected").val()+"form";
        });
    });
</script>
