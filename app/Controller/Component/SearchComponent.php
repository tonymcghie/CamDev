<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 27/02/17
 * Time: 9:22 PM
 */
App::uses('Component', 'Controller');

class SearchComponent extends Component{
    public $excluded_fields = ['id'];

    /**
     * @param $model AppModel the name of the model to search in
     * @param $criteria array the array of the criteria from the search form
     * @param $value array the array of the values from the search form
     * @param $logic array the array of the logic values from the search form
     * @param $match array the array of the match options from the search form
     * @return array the array that can be used by the query builder to search the database
     * @throws Exception
     */
    public function build_query($model, $searchParams) {
        $criteria = $searchParams['criteria'];
        $value = $searchParams['value'];
        $logic = $searchParams['logic'];
        $match = $searchParams['match'];
        //var_dump($searchParams);

        $query = [];
        foreach ($criteria as $index => $criteria_value) { //TODO there is a problem here: sometime the value is not passed to this function ????
            $value_value = $value[$index];
            $logic_value = $logic[$index];
            $match_value = $match[$index];
            
            if (empty($value_value))continue;
            //if searching for an adduct then adjust the enter mass value for the adduct type            
            if (($criteria_value=='[M-H]-') || ($criteria_value=='[M+H]+') || ($criteria_value=='[M+HCOOH-H]-') || ($criteria_value=='[M+Na]+'))  {
                
                $precision = count(explode('.', $value_value))==2 ? strlen(explode('.', $value_value)[1]) : 0;
            
                switch ($criteria_value) {            
                    case '[M-H]-':
                        $value_value = round(floatval($value_value) + 1.007276, $precision);
                        $criteria_value = 'exact_mass';
                        break;
                    case '[M+HCOOH-H]-':
                        $value_value = round(floatval($value_value) - 44.998201, $precision);
                        $criteria_value = 'exact_mass';
                        break;
                    case '[M+H]+':
                        $value_value = round(floatval($value_value) - 1.007276, $precision);
                        $criteria_value = 'exact_mass';
                        break;
                    case '[M+Na]+':
                        $value_value = round(floatval($value_value) -  22.989218, $precision);
                        $criteria_value = 'exact_mass';
                        break;
                    default:
                        throw new Exception('Specified adduct not found');
                        break;
                }
            }
            // adjust the value according to the match required
            switch ($match_value) {
                case 'contains':
                    $value_value = '%'.$value_value.'%';
                    break;
                case 'exact':
                    // Do not change the value
                    break;
                case 'starts':
                    $value_value .= '%';
                    break;
                default:
                    throw new Exception('There was a match value that was not found if you are modifying the code please add it to this statement');
                    break;
            }
            // construct the query array using the default or a specifc search type as specified
            switch ($criteria_value) {
                case 'all': //search all field a given model (database table)
                    $query[$logic_value]['OR'] = [];
                    foreach ($model->getSearchableFields() as $column_name) {
                        $query[$logic_value]['OR'][] = [$model->name . '.' . $column_name . ' LIKE' => $value_value];  
                    }
                    break;
                case 'compound_name':  //search both compound.compound_name and compound.pseudonyms 
                    $query[$logic_value]['OR'] = [];
                    $query[$logic_value]['OR'][] = [$model->name . '.' . $criteria_value . ' LIKE' => $value_value];
                    $query[$logic_value]['OR'][] = [$model->name . '.' . 'pseudonyms' . ' LIKE' => $value_value];                  
                    break;
                default:
                    $query[$logic_value][] = [$model->name . '.' . $criteria_value . ' LIKE' => $value_value];
                    break;
            } 
        }
        return $query;
    }
    
    /**
     * build a query specifically for the Overview action using a SELECT DISTINCT SQL query
     * @param $model AppModel the name of the model to search in
     * @param $criteria array the array of the criteria from the search form
     * @param $value array the array of the values from the search form
     * @param $logic array the array of the logic values from the search form
     * @param $match array the array of the match options from the search form
     * @return array the array that can be used by the query builder to search the database
     * @throws Exception
     */
    public function build_overview_query($model, $overviewParams) {
        $by = $overviewParams['by'][0];
        $value = $overviewParams['value'][0];
        $match = $overviewParams['match'][0];
        $for = $overviewParams['for'][0];
        $query = [];
        
        switch ($match) {
            case 'contains':
                $value = '%'.$value.'%';
                break;
            case 'exact':
                // Do not change the value
                break;
            case 'starts':
                $value = '%'.$value;
                break;
            default:
                throw new Exception('The match value was not found, if you are modifying the code please add it to this statement');
                break;
        }
        
        $query = array('fields' => 'DISTINCT ' . $for,
       'conditions' => array($by . ' LIKE' => $value));
        return $query;
    }
}