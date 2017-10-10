<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 13/01/17
 * Time: 11:41 PM
 */
class StringHelper extends AppHelper{
    private $strings = [
        'SampleSet_form' => [
            'title' => 'PFR Chemistry: Sample Set Collaboration Workspace',
            'sub_title' => 'Enter/Edit the relevant metadata information about the Sample Set (* required) and then click Save Set',
            'from_setcode' => 'From Previous Set Code',
            'previous_setcode' => 'Previouse Sample Set',
            'previous_setcode_ph' => 'Create Sample Set Similar to previouse Sample Set',
            'confidential' => 'Confidential',
            'collaborator' => 'PFR Collaborator',
            'p_name' => 'Project Name',
            'p_name_ph' => 'Start typing - registered projects will autocomplete',
            'p_code' => 'Project Code',
            'exp_reference' => 'Eperiment Reference',
            'exp_reference_ph' => 'Describe the experiment that produced the sample set',
            'chemist_name' => 'Chemist Name',
            'crop' => 'Crop',
            'sample_type' => 'Sample Type',
            'sample_type_ph' => 'Fruit, leaf, skin etc...',
            'sample_number' => 'Number of Samples',
            'transport' => 'Location/Transport of Samples',
            'reason' => 'Reason for Analysis',
            'reason_ph' => 'Why is the analysis required. Specifically, what results are required?',
            'compounds' => 'Compounds for Analysis',
            'compounds_ph' => 'Enter specific compound names, or analysis type',
            'containment' => 'Requires Containment',
            'containment_detils' => 'Details',
            'version' => 'Version #',
            'comments' => 'Additional Comments',
            'comments_ph' => 'Insert any additional information. For example, copy/past a table of sample identities (labels) from a spreadsheet',
            'metafile' => 'Upload Metadata File'],
        'Compound_form' => [
            'title' => 'Add New Compound to CAM',
            'sub_title' => '* Data will be retrieved from Pubchem when you enter a CID and press tab',
            'cas' => 'CAS Number',
            'pub_chem' => 'PubChem CID',
            'compound_name' => 'Compound Name',
            'pseudonyms' => 'Synonyms',
            'pseudonyms_ph' => 'separate each name with a semicolon',
            'sys_name' => 'Systematic Name',
            'formula' => 'Formula (CHNO...)',
            'formula_ph' => 'CHNO...',
            'exact_mass' => 'Exact (monoisotopic) mass',
            'chemspider_id' => 'ChemSpider ID',
            'metlin_id' => 'Metlin ID',
            'compound_type' => 'Chemical Class',
            'chemfinder_ref' => 'ChemFinder Ref.',
            'comment' => 'Additional Info.',
            'comment_ph' => 'eg additional chemical sub-class'],
        'Project_form' => [
            'title' => 'Register New Project',
            'sub_title' => 'Enter New Project Details',
            'short_name' => 'Short Project Name',
            'long_name' => 'Long Project Name',
            'code' => 'Code',
            'type' => 'Type',
            'owner' => 'Owner'],
        'Metabolite_form' => [
            'title' => 'Add New Unknown Compound',
            'sub_title' => 'not required at present',
            'exact_mass' => 'Exact Mass',
            'ion_type' => 'Ion Type',
            'rt_value' => 'Retention Value',
            'rt_description' => 'Chromatography Description',
            'sources' => 'Crop Source',
            'tissue' => 'Tissue',
            'chemist' => 'Chemist',
            'experiment_ref' => 'Experiment Reference',
            'spectra_uv' => 'UV/vis spectrum',
            'spectra_nmr' => 'NMR Spectrum',
            'date' => 'Date'],
        'Proposed_Metabolite_form' => [
            'title' => 'Enter Possible Chemical Identity of an Uknown',
            'sub_title' => 'Enter the CAM Unknown ID',
            'metabolite_id' => 'Unknown ID',
            'name' => 'Suggested Chemical Name',
            'formula' => 'Formula',
            'mass_diff' => 'Mass Difference',
            'mass_diff_ph' => 'mDa',
            'msigma' => 'Isotope Ratio',
            'msigma_ph' => 'Isotope Ratio',
            'data_file' => 'Source Data File',
            'comment' => 'Comment'],
        'Msms_Metabolite_form' => [
            'title' => 'Enter MSMS spectrum of an Uknown',
            'sub_title' => 'Enter the CAM Unknown ID',
            'metabolite_id' => 'Unknown ID',
            'parent_mz' => 'Parent m/z',
            'energy_ev' => 'Energy (eV)',
            'charge' => 'Charge',
            'charge_ph' => 'pos or neg',
            'msms_level' => 'MSMS Level',
            'spectra_msms' => 'MSMS Spectrum',
            'comment' => 'Comment'],
        'SampleSet' => [
            'id' => 'ID',
            'set_code' => 'Set Code',
            'submitter' => 'PFR Collabotator',
            'chemist' => 'Analyst',
            'crop' => 'Crop',
            'type' => 'Type',
            'number' => 'Number',
            'compounds' => 'Compounds',
            'comments' => 'Comments',
            'team' => 'Team',
            'p_name' => 'Project Name',
            'p_code' => 'Project Code',
            'actions' => 'Actions'],
        'Compoundpfr_data' => [
            'assigned_name' => 'Compound',
            'exact_mass' => 'Exact Mass',
            'intensity_value' => 'Intensity',
            'intensity_description' => 'Units',
            'reference' => 'Experiment Ref.',
            'sample_ref' => 'Sample Ref.',
            'sample_description' => 'Sample Description',
            'genotype' => 'Genotype',
            'tissue' => 'Tissue',
            'crop' => 'Crop',
            'species' => 'Species',
            'analyst' => 'Analyst',
            'actions' => 'Actions'],
        'Molecular_feature' => [
            'feature_tag' => 'Metabolite Tag',
            'feature_id' => 'Metabolite ID',
            'id_confidence' => 'ID confidence (1-4)',
            'mz' => 'm/z',
            'ion_polarity' => 'Ion Polarity',
            'intensity' => 'Intensity',
            'retention_time' => 'RT(min)',
            'chromatography_description' => 'Chrmoatography',
            'ms_instrument_loc' => 'MS Instrument',
            'experiment_reference' => 'Experiment Ref.',
            'sample_reference' => 'Sample Ref.',
            'sample_description' => 'Sample Description',
            'genotype' => 'Genotype',
            'tissue' => 'Tissue',
            'crop' => 'Crop',
            'species' => 'Species',
            'analyst' => 'Analyst',
            'actions' => 'Actions'],
        'Compound' => [
            'compound_name' => 'Name',
            'formula' => 'Formula',
            'exact_mass' => 'Exact Mass',
            'cas' => 'CAS',
            '[M-H]-' => '[M-H]-',
            '[M+COOH-H]-' => '[M+COOH-H]-',
            '[M+H]+' => '[M+H]+',
            '[M+Na]+' => '[M+Na]+',
            'compound_type' => 'Class',
            'pseudonyms' => 'Symonyms',
            'comment' => 'Comment',
            'actions' => 'Actions'],
        'IonAdducts' => [
            'compound_name' => 'Name',
            'exact_mass' => 'Exact Mass',
            'cas' => 'CAS'],
        'Metabolite' => [
            'id' => 'ID',
            'exact_mass' => 'Exact Mass',
            'ion_type' => 'Ion Type',
            'rt_value' => 'Retention Time',
            'rt_description' => 'Chromatography',
            'sources' => 'Source',
            'tissue' => 'Tissue',
            'chemist' => 'Chemist',
            'experiment_ref' => 'Experiment Reference',
            'date' => 'Start Date',
            'actions' => 'Actions']
    ];

    public function get_string($identifier, $set){
        if ($string = $this->get_string_bool($identifier, $set)){
            return $string;
        }
        return "[[ The String: '$identifier' in the set: '$set' was not found. ]]";
    }

    public function get_string_bool($identifier, $set){
        if (!isset($this->strings[$set][$identifier])){
            return false;
        }
        return $this->strings[$set][$identifier];
    }

}