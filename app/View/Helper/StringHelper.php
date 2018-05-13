<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 13/01/17
 * Time: 11:41 PM
 */
class StringHelper extends AppHelper{
    private $strings = [
        'Edit_form' => [
            'title' => 'Edit'
        ],
        'Search_form' => [
            'criteria' => 'Criteria',
            'value' => 'Value',
            'match' => 'Match',
            'logic' => 'Logic',
            'noresults' => 'There is nothing in the database that matches your search criteria!'
        ],
        'Overview_form' => [
            'by' => 'By',
            'value' => 'Value',
            'match' => 'Match',
            'for' => 'For',
            'noresults' => 'No results were found in the database!'
        ],
        'SampleSet_form' => [
            'title' => 'PFR Chemistry: Sample Set Collaboration Workspace',
            'edit_title' => 'PFR Chemistry: Sample Set Edit Workspace',
            'sub_title' => 'Enter/Edit the relevant metadata information about the Sample Set (* required) and then click Save',
            'from_setcode' => 'From Previous Set Code',
            'previous_setcode' => 'Previouse Sample Set',
            'previous_setcode_ph' => 'Create Sample Set Similar to previouse Sample Set',
            'confidential' => 'Confidential',
            'submitter' => 'PFR Collaborator',
            'submitter_ph' => 'Enter your name.  Separate multiple Collaborator names with a semicolon (;)',
            'p_name' => 'Project Name',
            'p_name_ph' => 'Start typing - registered projects will autocomplete',
            'p_code' => 'Project Code',
            'exp_reference' => 'Experiment Reference',
            'exp_reference_ph' => 'Describe the experiment that produced the sample set',
            'chemist_name' => 'Analyst Name',
            'associate_analyst_name' => 'Assoc. Analyst Name',
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
            'containment_details' => 'Details',
            'version' => 'Version #',
            'comments' => 'Additional Comments',
            'comments_ph' => 'Insert any additional information. For example, copy/past a table of sample identities (labels) from a spreadsheet',
            'status' => 'Status',
            'metaFile' => 'Upload Metadata File',
            'metaFile_new' => 'Upload & Replace Metadata File',
            'metaFile_current' => 'Current Metadata File',
            'confirm_new_sampleset' => 'The new Sample Set has been successfully saved!',
            'error_new_sampleset' => 'Unfortunately there is a problem - Sample Set has not been saved!'],
        'Compound_form' => [
            'title' => 'PFR Chemistry: Add New Compound',
            'edit_title' => 'PFR Chemistry: Edit Compound Information',
            'sub_title' => '* Data will be retrieved from Pubchem when you enter a CID and press tab',
            'edit_sub_title' => 'Enter/Edit the relevant information about this compound and then click Save',
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
            'canonical_smiles' => 'Canonical SMILES',
            'metlin_id' => 'Metlin ID',
            'compound_type' => 'Chemical Class',
            'chemfinder_ref' => 'ChemFinder Ref.',
            'comment' => 'Additional Info.',
            'comment_ph' => 'eg additional chemical sub-class'],
        'Project_form' => [
            'title' => 'Add Project',
            'sub_title' => 'Enter New Project Details',
            'short_name' => 'Short Project Name',
            'long_name' => 'Long Project Name',
            'code' => 'Code',
            'type' => 'Type',
            'owner' => 'Owner'],
        'Analyst_form' => [
            'title' => 'Add New Analyst',
            'sub_title' => "Enter New Analyst's Details",
            'edit_title' => 'Edit Analyst Details',
            'name' => 'Name',
            'id' => 'Analyst ID',
            'type' => 'Type',
            'team' => 'Team',
            'name_code' => 'Name Code',
            'name_code_ph' => 'Two letter identifier for Analyst',
            'location' => 'Location',
            'ext_number' => 'Extension Number',          
            'email' => 'Email Address',
            'status' => 'Status'],
        'Metabolite_form' => [
            'title' => 'Add New Unknown Compound',
            'edit_title' => 'PFR Chemistry: Edit Unknown Compound',
            'sub_title' => 'Enter/Edit information about the Unknown Compound (* required) and then click Save',
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
            'title' => 'Enter Proposed Chemical Identity for an Unknown Compound',
            'sub_title' => 'Enter the CAM Unknown ID',
            'metabolite_id' => 'CAM Unknown ID',
            'metabolite_id_ph' => 'Enter CAM Unknown ID',
            'name' => 'Suggested Compound Name',
            'formula' => 'Formula',
            'formula_ph' => 'CHNO...',
            'mass_diff' => 'Mass Difference',
            'mass_diff_ph' => '+- mDa',
            'msigma' => 'Isotope Ratio',
            'msigma_ph' => 'eg mSigma',
            'data_file' => 'Source Data File',
            'comment' => 'Comment'],
        'Msms_Metabolite_form' => [
            'title' => 'Enter MSMS spectrum of an Uknown',
            'sub_title' => 'Enter the CAM Unknown ID',
            'metabolite_id' => 'CAM Unknown ID',
            'name' => 'Suggested Compound Name',
            'parent_mz' => 'Parent m/z',
            'energy_ev' => 'Energy (eV)',
            'charge' => 'Charge (pos/neg)',
            'charge_ph' => 'pos or neg',
            'msms_level' => 'MSMS Level',
            'spectra_msms' => 'MSMS Spectrum',
            'comment' => 'Comment'],
        'SampleSet' => [ // TODO need to combined SampleSet and SampleSets
            'SampleSet' => 'Sample Set',
            'importInfo' => 'Samples can only be imported to an existing Sample Set.',
            'all' => 'All',
            'id' => 'CAM ID',
            'set_code' => 'Set Code',
            'submitter' => 'PFR Collabotator',
            'chemist' => 'Analyst',
            'associate_analyst' => 'Associate Analyst',
            'crop' => 'Crop',
            'type' => 'Type',
            'number' => 'Number',
            'compounds' => 'Compounds',
            'comments' => 'Comments',
            'team' => 'Team',
            'p_name' => 'Project Name',
            'p_code' => 'Project Code',
            'set_reason' => 'Reason for Analysis',
            'status' => 'Status',
            'metaFile' => 'metaData File',
            'actions' => 'Actions',
            'searchTitle' => 'Find Sample Set'],
        'SampleSets' => [  //hack to get the SampleSet View working
            'view' => 'Sample Set Data Viewer',
            'all' => 'All',
            'id' => 'ID',
            'set_code' => 'Set Code',
            'submitter' => 'PFR Collabotator',
            'submitter_email' => 'Submitter email',
            'chemist' => 'Analyst',
            'associate_analyst' => 'Associate Analyst',
            'crop' => 'Crop',
            'type' => 'Type',
            'sample_number' => 'Number',
            'compounds' => 'Compounds',
            'comments' => 'Comments',
            'team' => 'Team',
            'status' => 'Status',
            'containment' => 'Containment',
            'containment_details' => 'Containment Details',
            'metaFile' => 'metaData File',
            'exp_reference' => 'Experiment Reference',
            'sample_loc' => 'Sample Location',
            'date' => 'Date',
            'p_name' => 'Project Name',
            'p_code' => 'Project Code',
            'actions' => 'Actions',
            'searchTitle' => 'Find Sample Set'],
        'Sample' => [ 
            'importInfo' => 'Samples can only be imported to an existing Sample Set.',
            'all' => 'All',
            'id' => 'CAM ID',
            'set_code' => 'Set Code',
            'sample_name' => 'Sample Name',
            'attribute_1' => 'Attribute 1',
            'description_1' => 'Attribute 1 Description',
            'attribute_2' => 'Attribute 2',
            'description_2' => 'Attribute 2 Description',
            'attribute_3' => 'Attribute 3',
            'description_3' => 'Attribute 3 Description',
            'replicate' => 'Replicate',
            'tissue' => 'Tissue',
            'sample_weight' => 'Sample Weight',
            'weight_unit' => 'Sample Weight units',
            'kea_num' => 'Kea Sample Number',
            'ebrida_ref' => 'Ebrida Reference',
            'comment' => 'Comment',
            'file' => 'File',
            'actions' => 'Actions',
            'importTitle' => 'Sample Upload Workspace',
            'importMessage1' => '1) Generate a flat .csv file containing sample and treatment or attribute information.',
            'searchTitle' => 'Find Sample'],
        'Compoundpfr_data' => [
            'id' => 'CAM ID',
            'assigned_name' => 'Compound Name',
            'cas' =>'CAS #',
            'exact_mass' => 'Exact Mass',
            'intensity_value' => 'Intensity',
            'intensity_description' => 'Units',
            'rt_value' => 'Retention Time',
            'rt_description' => 'Chromatography Description',
            'reference' => 'Experiment Reference (eg Set Code)',
            'sample_ref' => 'Sample Reference',
            'sample_description' => 'Sample Description',
            'target_untarget' => 'Targeted or Untargeted Analysis',
            'genotype' => 'Genotype',
            'tissue' => 'Tissue',
            'crop' => 'Crop',
            'species' => 'Species',
            'analyst' => 'Analyst',
            'data_location' => 'Data Location',
            'actions' => 'Actions',
            'all' => 'All',
            'assigned_confid' => 'Id Confidence (1-5)',
            'exact_mass_10mDa' => 'Exact Mass +- 10 mDa',
            'exact_mass_50mDa' => 'Exact Mass +- 50 mDa',
            'file' => 'File',
            'model' => 'Compound PFR Data',
            'importTitle' => 'PFR Compound Data Upload Workspace',
            'importMessage1' => '1) Generate a flat .csv file containing PFR Compound Data with specified metadata.',
            'searchTitle' => 'Find PFR Compound Data',
            'overviewTitle' => 'Overview PFR Compound Data'],
        'CompoundpfrData' => [ //hack to get the CompoundpfrData View working
            'id' => 'CAM ID',
            'view' => 'Compound PFR Data Viewer',
            'assigned_name' => 'Compound Name',
            'cas' =>'CAS #',
            'cas' => 'CAS #',
            'exact_mass' => 'Exact Mass',
            'intensity_value' => 'Intensity',
            'intensity_description' => 'Units',
            'rt_value' => 'Retention Time',
            'rt_description' => 'Chromatography Description',
            'reference' => 'Experiment Reference (eg Set Code)',
            'sample_ref' => 'Sample Reference',
            'sample_description' => 'Sample Description',
            'target_untarget' => 'Targeted or Untargeted Analysis',
            'genotype' => 'Genotype',
            'tissue' => 'Tissue',
            'crop' => 'Crop',
            'species' => 'Species',
            'analyst' => 'Analyst',
            'actions' => 'Actions',
            'all' => 'All',
            'assigned_confid' => 'Id Confidence (1-5)',
            'exact_mass_10mDa' => 'Exact Mass +- 10 mDa',
            'exact_mass_50mDa' => 'Exact Mass +- 50 mDa',
            'file' => 'File',
            'data_location' => 'Data Location'],
        'Molecular_feature' => [
            'id' => 'CAM ID',
            'feature_tag' => 'Metabolite Tag',
            'feature_id' => 'Metabolite ID',
            'id_confidence' => 'ID confidence (1-4)',
            'mz' => 'm/z',
            'ion_polarity' => 'Ion Polarity',
            'intensity' => 'Intensity',
            'retention_time' => 'RT(min)',
            'chromatography_description' => 'Chrmoatography',
            'ms_instrument_loc' => 'MS Instrument',
            'experiment_reference' => 'Experiment Reference (eg Set Code)',
            'sample_reference' => 'Sample Reference',
            'sample_description' => 'Sample Description',
            'genotype' => 'Genotype',
            'tissue' => 'Tissue',
            'crop' => 'Crop',
            'genus_species' => 'Species',
            'analyst' => 'Analyst',
            'data_location' => 'Data Location',
            'file' => 'Input File',
            'date' => 'Input Date',
            'actions' => 'Actions',
            'all' => 'All',
            'importTitle' => 'Metabolomic Data Upload Workspace',
            'importMessage1' => '1) Generate a flat .csv file containing Metabolomic Data with specified metadata.',
            'searchTitle' => 'Find Metabolomic Data',
            'overviewTitle' => 'Overview Metabolomic Data'],
        'MolecularFeatures' => [ //hack to get the MetabolomicData View working
            'view' => 'Metabolomic Data Viewer',
            'id' => 'CAM ID',
            'feature_tag' => 'Metabolite Tag',
            'feature_id' => 'Metabolite ID',
            'id_confidence' => 'ID confidence (1-4)',
            'mz' => 'm/z',
            'ion_polarity' => 'Ion Polarity',
            'intensity' => 'Intensity',
            'retention_time' => 'RT(min)',
            'chromatography_description' => 'Chrmoatography',
            'ms_instrument_loc' => 'MS Instrument',
            'experiment_reference' => 'Experiment Reference (eg Set Code)',
            'sample_reference' => 'Sample Reference',
            'sample_description' => 'Sample Description',
            'genotype' => 'Genotype',
            'tissue' => 'Tissue',
            'crop' => 'Crop',
            'genus_species' => 'Species',
            'analyst' => 'Analyst',
            'data_location' => 'Data Location',
            'file' => 'Input File',
            'date' => 'Input Date',
            'actions' => 'Actions',
            'all' => 'All',
            'data_location'=>'Raw Data Location'],
        'Compound' => [
            'all' => 'All',
            'compound_name' => 'Name',
            'formula' => 'Formula',
            'exact_mass' => 'Exact Mass',
            'cas' => 'CAS',
            '[M-H]-' => '[M-H]-',
            '[M+HCOOH-H]-' => '[M+HCOOH-H]-',
            '[M+H]+' => '[M+H]+',
            '[M+Na]+' => '[M+Na]+',
            'compound_type' => 'Class',
            'pseudonyms' => 'Synonym',
            'comment' => 'Comment',
            'actions' => 'Actions',
            'searchTitle' => 'Find Compounds',
            'pub_chem' => 'PubChem ID',
            'chemspider_id' => 'ChemSpider ID'],
        'IonAdducts' => [
            'compound_name' => 'Name',
            'exact_mass' => 'Exact Mass',
            'cas' => 'CAS'],
        'Chemist' => [
            'id' => 'Analyst ID',
            'name' => 'Name',
            'type' => 'Type',
            'name_code' => 'Name Code',
            'team' => 'Team',
            'location' => 'Location',
            'ext_number' => 'Extension Number',
            'email' => 'Email Address',
            'status' => 'Status',
            'searchTitle' => 'Find Analyst',
            'actions' => 'Actions'],
        'Chemists' => [ //hack to get the Chemist/Analyst View working
            'view' => 'Analyst Viewer',
            'id' => 'Analyst ID',
            'name' => 'Name',
            'type' => 'Type',
            'name_code' => 'Name Code',
            'team' => 'Team',
            'location' => 'Location',
            'ext_number' => 'Extension Number',
            'email' => 'Email Address',
            'status' => 'Status',
            'searchTitle' => 'Find Analyst',
            'actions' => 'Actions'],
        'Metabolite' => [
            'id' => 'CAM Unknown ID',
            'exact_mass' => 'Exact Mass',
            'ion_type' => 'Ion Type',
            'rt_value' => 'Retention Time',
            'rt_description' => 'Chromatography',
            'sources' => 'Source',
            'tissue' => 'Tissue',
            'chemist' => 'Chemist',
            'experiment_ref' => 'Experiment Reference (eg Set Code)',
            'date' => 'Date Entered',
            'actions' => 'Actions',
            'all' => 'All',
            'document'=> 'Document',
            'searchTitle' => 'Find Unknown Compounds'],
        'Metabolites' => [ //hack to get the Unknown View working
            'view' => 'Unknown Compound Data Viewer',
            'id' => 'CAM Unknown ID',
            'exact_mass' => 'Exact Mass',
            'ion_type' => 'Ion Type',
            'rt_value' => 'Retention Time',
            'rt_description' => 'Chromatography',
            'sources' => 'Source',
            'tissue' => 'Tissue',
            'chemist' => 'Chemist',
            'experiment_ref' => 'Experiment Reference (eg Set Code)',
            'date' => 'Date Entered',
            'actions' => 'Actions',
            'all' => 'All',
            'document'=> 'Document',
            'searchTitle' => 'Find Unknown Compounds'],
        'Bioactivitypfr_data' => [
            'empty' => 'Select Criteria',
            'all' => 'All',
            'bioactivity_name' => 'Bioactivity Name',
            'value' => 'Value',
            'unit_description' => 'Units',
            'bioassay_description' => 'Bioassay Description',
            'bioassay_ref' => 'Bioassay ref.',
            'sample_ref' => 'Sample ref.',
            'reference' => 'Experiment Reference (eg Set Code)',
            'sample_description' => 'Sample Description',
            'crop' => 'Crop',
            'species' => 'Species',
            'tissue' => 'Tissue',
            'genotype' => 'Genotype',
            'analyst' => 'Analyst',
            'file' => 'File',
            'searchTitle' => 'Search PFR Bioactivity Data'],
        'Analysis' => [
            'title' => 'Analysis Title',
            'workflow' => 'Select Workflow',
            'rawData' => 'Raw Data Location',
            'processedData' => 'Processed Data (xlsx file):',
            'resultsData' => 'Additional Data (any file type):',
            'uploadImage' => 'Upload new image',           
            'processedDataFile' => 'Processed Data File',
            'resultsDataFile' => ' Additional Data File'],
        'Import' => [
            'import' => 'Import',
            'importFile' => 'Upload CSV file',
            'exclude' => 'Exclude'],
        'General' => [
            'save' => 'Save',
            'cancel' => 'Cancel',
            'back' => 'Back',
            'clear' => 'Clear'
        ]
    ];

    public function get_string($identifier, $set, $parameter = null){
        if ($string = $this->get_string_bool($identifier, $set)){
            if (isset($parameter)) {
                return preg_replace('\\$a', $parameter, $string);
            } else {
                return $string;
            }
        }
        return "[[ The String: '$identifier' in the set: '$set' was not found. ]]";
    }

    public function string_exists($identifier, $set) {
        return isset($this->strings[$set][$identifier]);
    }

    private function get_string_bool($identifier, $set){
        if (!isset($this->strings[$set][$identifier])){
            return false;
        }
        return $this->strings[$set][$identifier];
    }

}