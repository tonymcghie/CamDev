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
            'comments' => 'Comments']
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