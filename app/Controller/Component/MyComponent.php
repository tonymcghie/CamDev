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
     public function NamechangeHeadings($DataFile){
        $file = fopen($DataFile,"r"); //sets up the file for reading
        $heading = fgetcsv($file); //read the column headers from the datafile
        array_push($heading, 'CAM Cmpound Name', 'CAS #'); //add another column for search hits to the column headers
        return $heading;
    }
    
    public function Namechange($DataFile, $criteria, $column){
        $foundcmpd=array(); $data=array();
        $model = ClassRegistry::init('Compound');
        $file = fopen($DataFile,"r"); //sets up the file for reading
        $head = fgetcsv($file); //read the first line (column headers) from the datafile and ignore in this function
        $n = 0;
        while (1==1){
            $line = fgetcsv($file);
            if ($line=== false){
                break;
            } //when there are no more lines exit the loop               
            
            //replace < and > if present in the string with the entities &lt and &gt
            $line[$column] = str_replace("<","&lt;",str_replace(">","&gt;",$line[$column]));
            
            //remove non-printable characters from the inputed name string
            $name_string = preg_replace('/[[:^print:]]/', "", $line[$column]);
            //try to match the compound name or the CAS # depending on the value of $criteria
            if ($criteria === 'name') {
                //construct the query strings if matching by name
                $search_name = array('OR' => array(
                    'Compound.compound_name LIKE' => "%" . $name_string . "%"));
            
                $search_pseudonyms = array('OR' => array(
                    'Compound.pseudonyms LIKE' => "% " . $name_string . ";%"));

                $foundcmpd = $model->find('first', ['conditions' =>$search_name]);  //search compounds table for match and add to the $line array if found
                $foundpseudonym = $model->find('first', ['conditions' =>$search_pseudonyms]); //search compounds table for match and add to the $line array if found
            
                if (isset($foundcmpd['Compound'])){ //if compounds name found push compound name and CAS to line
                    array_push($line, $foundcmpd['Compound']['compound_name'], $foundcmpd['Compound']['cas']);
                } else if (isset($foundpseudonym['Compound'])) { //if pseudonym found push compound name and CAS to line
                    array_push($line, $foundpseudonym['Compound']['compound_name'], $foundpseudonym['Compound']['cas']); 
                } else if ($name_string <> $line[$column]) { //if a non prinatable cahracter has been removed
                    array_push($line, 'Your compound name contains an unrecognised character - please remove!');
                } else {
                    array_push($line, ' ', ' '); // if neither compound name or pseudonoym found insert a blank
                }
            } else if ($criteria === 'CAS') {
                $search_cas = array('OR' => array(
                    'Compound.cas LIKE' => "" . $name_string . ""));
                $foundcmpd = $model->find('first', ['conditions' =>$search_cas]);  //search compounds table for match and add to the $line array if found
                if (isset($foundcmpd['Compound']['cas'])){ //if compounds CAS found push compound name and CAS to line
                    array_push($line, $foundcmpd['Compound']['compound_name'], $foundcmpd['Compound']['cas']);
                } else {
                    array_push($line, ' ', ' '); // if cas not found insert a blank
                }
            }

            array_push($data, $line); //adds the array contining the values to an array containing all values to save
            //array_push($found, $foundcmpd); //adds the array containing the found compounds  to an array containing all values to save
            $n = $n + 1;
            } //loops through the CSV file an adds the appropriate values to an array
            fclose($file);
        return $data;             
    }
    
    /**
     * Opens a .csv file and reads the first line into an array of column headings
     * Adds two new column headings
     * Returns the array of headings
     */  
     public function IdentifyHeadings($DataFile){
        $file = fopen($DataFile,"r"); //sets up the file for reading
        $heading = fgetcsv($file); //read the column headers from the datafile
        array_push($heading, "CAM Compound (found)", "delta mDa", "Total # of hits"); //add another column for search hits to the column headers
        return $heading;
    }
    
    public function IdentifyMass($DataFile, $mass_tolerance, $ion_type, $column){
        $foundcmpd=array(); $data=array();
        $model = ClassRegistry::init('Compound');
        $file = fopen($DataFile,"r"); //sets up the file for reading
        $head = fgetcsv($file); //read the first line (column headers) from the datafile and ignore in this function
        $n = 0;
        while (1==1){
            $line = fgetcsv($file);
            if ($line=== false){
                break;
            } //when there are no more lines exit the loop               

            if ($ion_type==='[M-H]-'){
                $mass = $line[$column] + 1.00794; //for [M-H] data add the mass of hydrogen to get monoisotopic MW
            }
            if ($ion_type==='[M+H]+'){
                $mass = $line[$column] - 1.00794; //for [M+H] data subtract the mass of hydrogen to get monoisotopic MW
            }
            $low_mass = $mass - $mass_tolerance; //calculate lower and upper limits of the acurate mass window
            $high_mass = $mass + $mass_tolerance;
            $search =  array("Compound.exact_mass BETWEEN ? AND ?" => array($low_mass, $high_mass));

            $numberofcmpd = $model->find('count', ['conditions' =>$search]);
            $foundallcmpd = $model->find('all', ['conditions' =>$search]);
            //var_dump($foundallcmpd);
            
                //$cmpd_line = $line;
            if ($numberofcmpd > 0) {
                foreach($foundallcmpd as $item) {
                    $cmpd_line = $line;
                    //$foundcmpd = $model->find('first', ['conditions' =>$search]);  //search compounds table for match and add to the $line array if found
                    if (isset($item['Compound'])){ 
                        array_push($cmpd_line, $item['Compound']['compound_name']);
                    } else {
                        array_push($cmpd_line, ' '); //insert a blank
                    }
             
                    if (isset($item['Compound'])){
                        //calculate mass difference
                        $delta_mDa = number_format(($mass - $item['Compound']['exact_mass'])*1000,2);
                        array_push($cmpd_line, $delta_mDa);
                    } else {
                        array_push($cmpd_line, ' '); //insert a blank
                    }
                    array_push($cmpd_line, $numberofcmpd);
                    array_push($data, $cmpd_line); //adds the array contining the values to an array containing all values to save
                }              
            } else { //push a couple of blanks and finish the line
                array_push($line, ' '); //insert a blank
                array_push($line, ' '); //insert a blank
                array_push($line, '0'); //insert a zero
                array_push($data, $line); //adds the array contining the values to an array containing all values to save
            } 
            
            //$numberofcmpd = $model->find('count', ['conditions' =>$search]);
            //if (isset($numberofcmpd["Compound"])){ 
                //array_push($line, $numberofcmpd);
            //}

            //array_push($data, $line); //adds the array contining the values to an array containing all values to save
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
    
    public function isLoggedIn($logIn){
        if (!$logIn) {
            //echo "loggedOut";
            $this->Session->setFlash('Please Login to use Sample Set actions','popup_message');
            $this->redirect(['controller' => 'General', 'action' => 'welcome']);
        }
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
