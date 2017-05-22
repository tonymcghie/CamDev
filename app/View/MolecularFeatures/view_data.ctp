<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Molecular Feature Data Viewer</h1>
</header>
<table class="noFormat viewSampleSet">
    <tr>
        <td><h2>Molecular Feature:</h2> <?php echo $info['Molecular_feature']['feature_tag']; ?></td>
        <td colspan="2"><h2>Molecular Feature ID:</h2> <?php echo $info['Molecular_feature']['feature_id']; ?></td>
        <td><h2> ID Confidence (1-5):</h2> <?php echo $info['Molecular_feature']['id_confidence']; ?></td>
    </tr>
    <tr>
        <td><h2>m/z:</h2> <?php echo $info['Molecular_feature']['mz']; ?></td>
        <td><h2>Polarity:</h2> <?php echo $info['Molecular_feature']['ion_polarity']; ?></td>
        <td><h2>Retention time:</h2> <?php echo $info['Molecular_feature']['retention_time']; ?></td>
        <td><h2>Chromatography:</h2> <?php echo $info['Molecular_feature']['chromatography_description']; ?></td>
    </tr>
    <tr>
        <td><h2>Intensity:</h2> <?php echo $info['Molecular_feature']['intensity']; ?></td>
        <td colspan="2"><h2>Instrument:</h2> <?php echo $info['Molecular_feature']['ms_instrument_loc']; ?></td>
        <td><h2>Analyst:</h2> <?php echo $info['Molecular_feature']['analyst']; ?></td>
    </tr>
    <tr>
        <td><h2>Experiment Reference:</h2> <?php echo $info['Molecular_feature']['experiment_reference']; ?></td>
        <td><h2>Sample Name:</h2> <?php echo $info['Molecular_feature']['sample_reference']; ?></td>
        <td colspan="2"><h2>Sample Description:</h2> <?php echo $info['Molecular_feature']['sample_description']; ?></td>
    </tr>
    <tr>
        <td><h2>Tissue:</h2> <?php echo $info['Molecular_feature']['tissue']; ?></td>
        <td><h2>Crop:</h2> <?php echo $info['Molecular_feature']['crop']; ?></td>
        <td><h2>Species:</h2> <?php echo $info['Molecular_feature']['genus_species']; ?></td>
        <td><h2>Genotype:</h2> <?php echo $info['Molecular_feature']['genotype']; ?></td>
    </tr>
    <tr>
        <td colspan="4"><h2>Data Location:</h2> <?php echo $info['Molecular_feature']['data_location']; ?></td>
    </tr>
</table>





