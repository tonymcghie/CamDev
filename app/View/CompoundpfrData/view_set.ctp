<header>
<h1>Sample Set Viewer</h1>
</header>
<table class="table table-striped table-sm table-bordered">
    <tr>
        <td><h3>Set Code:</h3> <?php echo $info['SampleSet']['set_code']; ?></td>
        <td><h3>PFR Collaborator:</h3> <?php echo $info['SampleSet']['submitter']; ?></td>
        <td><h2>Start Date:</h2> <?php echo $info['SampleSet']['date']; ?></td>
    </tr>
    <tr>
        <td><h3>Program Name:</h3> <?php echo $info['SampleSet']['p_name']; ?></td>
        <td><h3>Program Code:</h3> <?php echo $info['SampleSet']['p_code']; ?></td>
        <td><h3>Experiment Reference:</h3> <?php echo $info['SampleSet']['exp_reference']; ?></td>
    </tr>
    <tr>
        <td><h3>Chemist Name:</h3> <?php echo $info['SampleSet']['chemist']; ?></td>
        <td><h3>Team:</h3> <?php echo $info['SampleSet']['team']; ?></td>
        <td><h3>Crop:</h3> <?php echo $info['SampleSet']['crop']; ?></td>
    </tr>
    <tr>
        <td><h3>Type:</h3> <?php echo $info['SampleSet']['type']; ?></td>
        <td><h3>Number of Samples:</h3> <?php echo $info['SampleSet']['number']; ?></td>
        <td><h3>Is Confidential:&nbsp;</h3><span  style="display: inline-block;"><?php echo (($info['SampleSet']['confidential'] == '1') ? 'yes' : 'no');?></span></td>
    </tr>
    <tr>
        <td colspan="3"><span class="text-nowrap"><h3>Location/Transport of Samples:</h3> <?php echo $info['SampleSet']['sample_loc']; ?></span></td>
    </tr>
    <tr>
        <td colspan="3"><h3>Reason for Analysis:</h3> <?php echo $info['SampleSet']['set_reason']; ?></td>
    </tr>
    <tr>
        <td colspan="3"><h3>Compounds for Analysis:</h3> <?php echo $info['SampleSet']['compounds']; ?></td>
    </tr>
    <?php if($info['SampleSet']['containment']==='1'): ?>
    <tr>
        <td colspan="3"><h3>Containment Details:</h3> <?php echo $info['SampleSet']['containment_details']; ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td colspan="3"><h3>Additional Comments:</h3> <?php echo $info['SampleSet']['comments']; ?></td>
    </tr>
    <tr>
        <td colspan="3"><h3>Metadata File:</h3><?php echo $info['SampleSet']['metaFile']; echo $this->Html->link('open',$this->My->makeSSmetaURL($info['SampleSet']['metaFile']),['target'=>'_blank', 'class' => 'find-button anySizeButton']); ?></td>
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
