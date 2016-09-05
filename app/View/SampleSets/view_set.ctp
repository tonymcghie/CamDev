<header>
<h1>Sample Set Viewer</h1>
</header>
<table class="noFormat viewSampleSet">
    <tr>
        <td><h2>Set Code:</h2> <?php echo $info['SampleSet']['set_code']; ?></td>
        <td><h2>PFR Collaborator:</h2> <?php echo $info['SampleSet']['submitter']; ?></td>
        <td><h2>Start Date:</h2> <?php echo $info['SampleSet']['date']; ?></td>
    </tr>
    <tr>
        <td><h2>Program Name:</h2> <?php echo $info['SampleSet']['p_name']; ?></td>
        <td><h2>Program Code:</h2> <?php echo $info['SampleSet']['p_code']; ?></td>
        <td><h2>Experiment Reference:</h2> <?php echo $info['SampleSet']['exp_reference']; ?></td>
    </tr>
    <tr>
        <td><h2>Chemist Name:</h2> <?php echo $info['SampleSet']['chemist']; ?></td>
        <td><h2>Team:</h2> <?php echo $info['SampleSet']['team']; ?></td>
        <td><h2>Crop:</h2> <?php echo $info['SampleSet']['crop']; ?></td>
    </tr>
    <tr>
        <td><h2>Type:</h2> <?php echo $info['SampleSet']['type']; ?></td>
        <td><h2>Number of Samples:</h2> <?php echo $info['SampleSet']['number']; ?></td>
        <td><h2>Location/Transport of Samples:</h2> <?php echo $info['SampleSet']['sample_loc']; ?></td>
    </tr>
    <tr>
        <td colspan="3"><h2>Is Confidential:&nbsp;</h2><span  style="display: inline-block;"><?php echo (($info['SampleSet']['confidential'] == '1') ? 'yes' : 'no');?></span></td>
    </tr>
    <tr>
        <td colspan="3"><h2>Reason for Analysis:</h2> <?php echo $info['SampleSet']['set_reason']; ?></td>
    </tr>
    <tr>
        <td colspan="3"><h2>Compounds for Analysis:</h2> <?php echo $info['SampleSet']['compounds']; ?></td>
    </tr>
    <?php if($info['SampleSet']['containment']==='1'): ?>
    <tr>
        <td colspan="3"><h2>Containment Details:</h2> <?php echo $info['SampleSet']['containment_details']; ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td colspan="3"><h2>Additional Comments:</h2> <?php echo $info['SampleSet']['comments']; ?></td>
    </tr>
    <tr>
        <td colspan="3"><h2>Metadata File:</h2><?php echo $info['SampleSet']['metaFile']; echo $this->Html->link('open',$this->My->makeSSmetaURL($info['SampleSet']['metaFile']),['target'=>'_blank', 'class' => 'find-button anySizeButton']); ?></td>
    </tr>
</table>
<?php

echo '<table class="noFormat view" style="width:90%;">';
echo '<tr><td colspan="2"><h2>Processed Data:</h2></td></tr>';
foreach($deRes as $derived_result){
    echo $this->Html->tableCells([$this->Form->input('derived_results', array('label' => $derived_result['Analysis']['title'].' Derived data:', 'value' => $derived_result['Analysis']['derived_results'], 'disabled' => 'disabled')),
    $this->Html->link('open',$this->My->makeDataURL($derived_result['Analysis']['derived_results']),['target'=>'_blank', 'class' => 'find-button anySizeButton'])]);
}
echo '</table>';
