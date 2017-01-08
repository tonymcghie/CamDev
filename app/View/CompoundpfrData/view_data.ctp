<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Data Record Viewer</h1>
</header>
<table class="noFormat viewSampleSet">
    <tr>
        <td><h2>Compound:</h2> <?php echo $info['Compoundpfr_data']['assigned_name']; ?></td>
        <td><h2>Exact Mass:</h2> <?php echo $info['Compoundpfr_data']['exact_mass']; ?></td>
        <td><h2>CAS #:</h2> <?php echo $info['Compoundpfr_data']['cas']; ?></td>
    </tr>
    <tr>
        <td><h2>Id Confidence:</h2> <?php echo $info['Compoundpfr_data']['assigned_confid']; ?></td>
        <td><h2>Intensity:</h2> <?php echo $info['Compoundpfr_data']['intensity_value']; ?></td>
        <td><h2>Intensity Units:</h2> <?php echo $info['Compoundpfr_data']['intensity_description']; ?></td>
    </tr>
    <tr>
        <td><h2>Experiment Reference:</h2> <?php echo $info['Compoundpfr_data']['reference']; ?></td>
        <td><h2>Sample Name:</h2> <?php echo $info['Compoundpfr_data']['sample_ref']; ?></td>
        <td><h2>Sample Description:</h2> <?php echo $info['Compoundpfr_data']['sample_description']; ?></td>
    </tr>
    <tr>
        <td><h2>Crop:</h2> <?php echo $info['Compoundpfr_data']['crop']; ?></td>
        <td><h2>Species:</h2> <?php echo $info['Compoundpfr_data']['species']; ?></td>
        <td><h2>Genotype:</h2> <?php echo $info['Compoundpfr_data']['genotype']; ?></td>
    </tr>
    <tr>
        <td><h2>Tissue:</h2> <?php echo $info['Compoundpfr_data']['tissue']; ?></td>
        <td><h2>Analyst:</h2> <?php echo $info['Compoundpfr_data']['analyst']; ?></td>
        <td><h2>Analysis Type:</h2> <?php echo $info['Compoundpfr_data']['target_untarget']; ?></td>
    </tr>
    <tr>
        <td colspan="3"><h2>Data Location:</h2> <?php echo $info['Compoundpfr_data']['data_location']; ?></td>
    </tr>
</table>





