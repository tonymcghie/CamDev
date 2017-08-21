<header>
<h1>View Unknown Compounds data</h1>
</header>
<div class="unknown-compounds">
<?php
if (!isset($meta)){
    echo '<h2>Unknown Compound Not found</h2>';
} else {
    $results['Metabolite'] = $meta;
    echo $this->My->makeResultsTable($results, array(
            'names' => array('Exact Mass', 'ID', 'Ion Type', 'Retention Value', 'Retention Description','Sources','Tissue','Chemist','Experiment Reference','UV/vis Spectra','NMR Spectra','Start Date'),
            'cols' => array('exact_mass', 'id', 'ion_type', 'rt_value', 'rt_description','sources','tissue','chemist','experiment_ref','spectra_uv','spectra_nmr','start_date'),
            'model' => 'Metabolite',),
            'Metabolite');
}
?>
<h2>Proposed Unknown Compound</h2>
<?php
if (!isset($proposed)||count($proposed)===0){
    echo 'No Propsed Metabolites Found';
} else {
        echo $this->My->makeResultsTable($proposed, array(
            'names' => array('Name', 'Actions', 'Formula', 'Mass Difference', 'Msigma','Data File','Comments'),
            'cols' => array('name', 'Actions', 'formula', 'mass_diff', 'msigma','data_file','comment'),
            'model' => 'Proposed_Metabolite',),
            'Proposed_Metabolite');
}
?>
<h2>Msms Unknown Compound</h2>
<?php
if (!isset($msms)||count($msms)===0){
    echo 'No Msms Metabolites Found';
} else {
        echo $this->My->makeResultsTable($msms, array(
            'names' => array('Name', 'Actions', 'MZ Parent', 'Energy (eV)', 'charge','Msms Level','Spectra Msms','Comments'),
            'cols' => array('name', 'Actions', 'parent_mz', 'energy_ev', 'charge','msms_level','spectra_msms','comment'),
            'model' => 'Msms_Metabolite',),
            'Msms_Metabolite');
}
?>
<h2>Document:</h2>
<?php
//var_dump($meta);
echo $meta['Metabolite']['document']; echo $this->Html->link('open',$this->My->makeUnknownURL($meta['Metabolite']['document']),['target'=>'_blank', 'class' => 'find-button anySizeButton']);
?>

</div>
