<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Data Record Viewer</h1>
</header>
<table class="noFormat viewSampleSet">
    <tr>
        <td><h2>Compound:</h2> <?php echo $info['SampleSet']['set_code']; ?></td>
        <td><h2>Exact Mass:</h2> <?php echo $info['SampleSet']['submitter']; ?></td>
        <td><h2>CAS #:</h2> <?php echo $info['SampleSet']['date']; ?></td>
    </tr>
    <tr>
        <td><h2>Intensity:</h2> <?php echo $info['SampleSet']['p_name']; ?></td>
        <td><h2>Intensity Units:</h2> <?php echo $info['SampleSet']['p_code']; ?></td>
        <td><h2>Experiment Reference:</h2> <?php echo $info['SampleSet']['exp_reference']; ?></td>
    </tr>
    <tr>
        <td><h2>Crop:</h2> <?php echo $info['SampleSet']['chemist']; ?></td>
        <td><h2>Species:</h2> <?php echo $info['SampleSet']['team']; ?></td>
        <td><h2>Crop:</h2> <?php echo $info['SampleSet']['crop']; ?></td>
    </tr>
    <tr>
        <td><h2>Analyst:</h2> <?php echo $info['SampleSet']['type']; ?></td>
        <td><h2>Data Location:</h2> <?php echo $info['SampleSet']['number']; ?></td>
        <td><h2>Analysis Type:</h2> <?php echo $info['SampleSet']['sample_loc']; ?></td>
    </tr>
</table>





