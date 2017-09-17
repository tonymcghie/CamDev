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
            'title' => 'PFR Chemistry: Collaboration Workspace',
            'sub_title' => 'This workspace is for communicating information about the work unit (set of samples) that will be analysed. Enter the relevant information (* required) and click Save Set',
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
            'comments' => 'Additional Comments',
            'comments_ph' => 'Insert any additional information. For example, copy/past a table of sample identities (labels) from a spreadsheet',
            'metafile' => 'Upload Metadata File'],
        'SampleSet' => [
            'set_code' => 'Set Code',
            'submitter' => 'PFR Collabotator',
            'chemist' => 'Chemist',
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
            'analyst' => 'Analyst'],
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
            'analyst' => 'Analyst'],
        'Compound' => [
            'compound_name' => 'Name',
            'formula' => 'Formula',
            'exact_mass' => 'Exact Mass',
            'cas' => 'CAS',
            'compound_type' => 'Class',
            'pseudonyms' => 'Symonyms',
            'comment' => 'Comment'],
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
            'date' => 'Start Date']
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