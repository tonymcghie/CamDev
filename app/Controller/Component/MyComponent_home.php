<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyComponent
 *
 * @author CFPAJM
 */
App::uses('Component', 'Controller');

class MyComponent extends Component{
    
    /**
     * This returns an Array that CakePHP can use as the conditions array in a database query.
     * If the Model is set to Compunds then the array will be deaper as psudonims and sys name are added as OR at the same point that the name is
     * @param array $data The data from a form containing cri_# val_# and log_# keys
     * @param array $allCols An array that has the name of all the colums that should be search when the user selects all
     * @param String $model The Model that the Form was made for. Used as an Identifyer as well
     * @return array An array that CakePHP can search on
     */
    public function extractSearchTerm($data, $allCols, $model){            
        $criteria = array();$value = array();$match = array();$logic = array();
        $count=0;
        while (isset($data[$model]['cri_'.$count])){
            array_push($criteria, $data[$model]['cri_'.$count]);//get the criteria values as an array
            array_push($value, $data[$model]['val_'.$count]);    //get the values as an array  
            array_push($logic, $data[$model]['log_'.$count]);
            array_push($match, $data[$model]['match_'.$count]);    
            $count++;
        }        
        $search = array();
        if (isset($data[$model]['start_date'])&&$data[$model]['start_date']!==$data[$model]['end_date']&&$data[$model]['isDate']==1){            
            $search['date >='] = $data[$model]['start_date'];
            $search['date <='] = $data[$model]['end_date'];
        }        
        unset($data[$model]['isDate']);
        for ($count=0;$count<count($criteria);$count++){ //add the valid search pairs to an array
            if ($criteria[$count]!=''&&$value[$count]!=''&&$criteria[$count]!='empty'){                
                if ($criteria[$count]=='all'){ //all table columns searched if the criteria is all
                    foreach ($allCols as $col){
                        if (!isset($search['OR'])){$search['OR'] = [];}
                        array_push($search['OR'],[$model.'.'.$col.' LIKE' =>  '%'.$value[$count].'%']);                                              
                    }
                } else { //only one table column searched is criteria if it isnt set to all
                    if (!isset($search[$logic[$count]])){$search[$logic[$count]]=[];} //if not set make it an array
                    // special search criteria added as requested
                    if ($model == 'Compound' && $criteria[$count] == 'compound_name'){//
                        array_push($search[$logic[$count]], ['OR' => [[$model.'.'.$criteria[$count].' LIKE' => '%'.$value[$count].'%'],[$model.'.pseudonyms LIKE' => '%'.$value[$count].'%'],[$model.'.sys_name LIKE' => '%'.$value[$count].'%']]]);                        
                        continue;
                    }
                    if ($model == 'Compoundpfr_data' && $criteria[$count] == 'exact_mass_10mDa'){
                        $lower_limit=$value[$count]-0.010;
                        $upper_limit=$value[$count]+0.010;
                        array_push($search[$logic[$count]], [$model.'.'.exact_mass.' BETWEEN ? AND ?' => array($lower_limit, $upper_limit)]);
                        continue;
                    }
                    if ($model == 'Compoundpfr_data' && $criteria[$count] == 'exact_mass_50mDa'){
                        $lower_limit=$value[$count]-0.050;
                        $upper_limit=$value[$count]+0.050;
                        array_push($search[$logic[$count]], [$model.'.'.exact_mass.' BETWEEN ? AND ?' => array($lower_limit, $upper_limit)]);
                        continue;
                    }
                    if ($match[$count] == 'include'){
                        array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' LIKE' => '%'.$value[$count].'%']);
                    }
                    if ($match[$count] == 'exact'){
                        array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' LIKE' => ''.$value[$count].'']);
                    }
                    if ($match[$count] == 'starts_with'){
                        array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' LIKE' => ''.$value[$count].'%']);
                    }
                }
            }
        }
        return $search;
    }
    public function resultsToGraph($results, $model, $x_axis, $y_axis){
        $data = array();
        foreach($results as $row){
            array_push($data, [$row[$model][$x_axis], floatval($row[$model][$y_axis])]);
        }
        return $data;
    }
    
    public function exportCSV($modelstr, $model, $controller, $allColums, $data = null, $allORSearch = FALSE){
        if ($data==null){
            return;
        }
        parse_str($data);
        $data = array();
        $data[$modelstr] = $$modelstr;
        if ($allORSearch){
            $search = $controller->buildConditionsArray($data);
        } else {
            $data[$modelstr]['num_boxes'] = (isset($data[$modelstr]['num_boxes']) ? $data[$modelstr]['num_boxes'] : 1);  
            $search = $controller->My->extractSearchTerm($data, $allColums, $modelstr); 
        }
        $data = $model->find('all', ['conditions' => $search]);
        $controller->set('data', $data);
        $controller->response->download("export.csv");
        $controller->layout = 'ajax';  
    }

    
    /*
     * Functions for authorisation *************************
     */
    
    public function isAuthorizedSampleSet($user, $SampleSet){        
        //return true; //uncomment to allow all access to SampleSet
        if ($SampleSet->action !== 'newSet' && $SampleSet->action !== 'editSet') {
            return true;
        } else if (isset($user)){
            return true;
        } else {
            $SampleSet->redirect(array('controller' => 'users', 'action' => 'noPerm'));
            return false;
        }
    } 
    public function isAuthorizedAnalysis($user, $Analysis){        
        //return true; //uncomment to allow all access to analysis
        if (in_array("PFR-GP-Biological Chemistry and Bioactives Group", $user['groups'])){
            return true;
        } else {
            $Analysis->redirect(array('controller' => 'users', 'action' => 'noPerm'));
            return false;
        }
    }
    public function isAuthorizedCompound($user, $Compound){
        if (($Compound->action == 'editCompound' || $Compound->action == 'addCompound' ) && !in_array("PFR-GP-Biological Chemistry and Bioactives Group", $user['groups'])){
            $Compound->redirect(array('controller' => 'users', 'action' => 'noPerm'));
            return false;
        }
        return true;
    }
    public function isAuthorizedPFRData($user, $PFRData){
        return true;
    }
    public function isAuthorizedMetabolite($user, $Metabolite){
        if (in_array("PFR-GP-Biological Chemistry and Bioactives Group", $user['groups']) == false){
            if ($Metabolite->action == 'addMetabolite' || $Metabolite->action == 'editMetabolite' || $Metabolite->action == 'editMsmsMetabolite' || $Metabolite->action == 'editProposedMetabolite'){
                $Metabolite->redirect(array('controller' => 'users', 'action' => 'noPerm'));
                return false;
            }
        }
        return true;
    }
    /*
     *  End of functions for authorisation **************************
     */
}
