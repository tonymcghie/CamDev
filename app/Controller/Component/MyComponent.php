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
        $criteria = array();$value = array();$logic = array();$match = array();
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
                } else { //only one table column is to be searchered when 'all' is not selected
                    if (!isset($search[$logic[$count]])){$search[$logic[$count]]=[];} //if not set make it an array
                    // special search criteria added as requested
                    if ($model == 'Compound' && $criteria[$count] == 'compound_name'){//
                        array_push($search[$logic[$count]], ['OR' => [[$model.'.'.$criteria[$count].' LIKE' => '%'.$value[$count].'%'],[$model.'.pseudonyms LIKE' => '%'.$value[$count].'%'],[$model.'.sys_name LIKE' => '%'.$value[$count].'%']]]);                        
                        continue;
                    }
                    if ($model == 'Compoundpfr_data' && $criteria[$count] == 'exact_mass_10mDa'){
                        $criteria[$count]="exact_mass"; //set variable to exact_mass so that the correct column is used for dB searching
                        $lower_limit=$value[$count]-0.010;
                        $upper_limit=$value[$count]+0.010;
                        array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' BETWEEN ? AND ?' => array($lower_limit, $upper_limit)]);
                        continue;
                    }
                    if ($model == 'Compoundpfr_data' && $criteria[$count] == 'exact_mass_50mDa'){
                        $criteria[$count]="exact_mass";  //set variable to exact_mass so that the correct column is used for dB searching
                        $lower_limit=$value[$count]-0.050;
                        $upper_limit=$value[$count]+0.050;
                        array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' BETWEEN ? AND ?' => array($lower_limit, $upper_limit)]);
                        continue;
                    }
                    if ($match[$count] == 'contain'){
                        array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' LIKE' => '%'.$value[$count].'%']);
                    }
                    if ($match[$count] == 'exact'){
                        array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' LIKE' => ''.$value[$count].'']);
                    }
                    if ($match[$count] == 'starts_with'){
                        array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' LIKE' => ''.$value[$count].'%']);
                    }
                    array_push($search[$logic[$count]], [$model.'.'.$criteria[$count].' LIKE' => '%'.$value[$count].'%']);   //default search string constructured                  
                }
            }
        }
        return $search;
    }
    
    /**
     * Opens a .csv file and reads the first line into an array of column headings
     * Adds two new column headings
     * Returns the array of headings
     */  
     public function IdentifyHeadings($DataFile){
        $file = fopen($DataFile,"r"); //sets up the file for reading
        $heading = fgetcsv($file); //read the column headers from the datafile
        array_push($heading, "Compound (found)", "Total # of hits"); //add another column for search hits to the column headers
        return $heading;
    }
    
    public function IdentifyMass($DataFile, $mass_tolerance, $ion_type){
        //print $DataFile."\n";
        //print $mass_tolerance."\n";
        //print $ion_type."\n";
        $foundcmpd=array(); $data=array();
        $model = ClassRegistry::init('Compound');
        //$DataFile="/home/tony/temp/".$DataFile;
        $file = fopen($DataFile,"r"); //sets up the file for reading
        $head = fgetcsv($file); //read the first line (column headers) from the datafile and ignore in this function
        $n = 0;
        while (1==1){
            $line = fgetcsv($file);
            if ($line=== false){
                break;
            } //when there are no more lines exit the loop               
            //var_dump($line);
            if ($ion_type==='[M-H]-'){
                $mass = $line[3] + 1.00794; //for [M-H] data add the mass of hydrogen to get monoisotopic MW
            }
            if ($ion_type==='[M+H]+'){
                $mass = $line[3] - 1.00794; //for [M+H] data subtract the mass of hydrogen to get monoisotopic MW
            }
            $low_mass = $mass - $mass_tolerance; //calculate lower and upper limits of the acurate mass window
            $high_mass = $mass + $mass_tolerance;
            $search =  array("Compound.exact_mass BETWEEN ? AND ?" => array($low_mass, $high_mass));
            //var_dump($search);
            $foundallcmpd = $model->find('all', ['conditions' =>$search]);
            foreach ($foundallcmpd as $cmpd) {
                //echo var_dump($cmpd['Compound']['exact_mass']), $mass, $mass-$cmpd['Compound']['exact_mass'], "<br>";
            }
            $foundcmpd = $model->find('first', ['conditions' =>$search]);  //search compounds table for match and add to the $linae array if found
            if (isset($foundcmpd["Compound"])){ 
                array_push($line, $foundcmpd["Compound"]["compound_name"]);
            } else {
                array_push($line, ' '); //insert a blank
            }
            $numberofcmpd = $model->find('count', ['conditions' =>$search]);
            //if (isset($numberofcmpd["Compound"])){ 
                array_push($line, $numberofcmpd);
            //}
            //var_dump($foundcmpd);
            array_push($data, $line); //adds the array contining the values to an array containing all values to save
            //array_push($found, $foundcmpd); //adds the array containing the found compounds  to an array containing all values to save
            $n = $n + 1;
            } //loops through the CSV file an adds the appropriate values to an array
        return $data;             
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
