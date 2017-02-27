<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 27/02/17
 * Time: 9:22 PM
 */
App::uses('Component', 'Controller');

class SearchComponent extends Component{

    /**
     * @param $model string the name of the modle to search in
     * @param $criteria array the array of the criteria from the search form
     * @param $value array the array of the values from the search form
     * @param $logic array the array of the logic values from the search form
     * @param $match array the array of the match options from the search form
     * @return array the array that can be used by the query builder to search the database
     * @throws Exception
     */
    public function build_query($model, $criteria, $value, $logic, $match) {
        $query = [];
        foreach ($criteria as $index => $criteria_value) {
            $value_value = $value[$index];
            $logic_value = $logic[$index];
            $match_value = $match[$index];

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
                    throw new Exception('There was a match value that was not found if you are modifying the code please add it to this statment');
                    break;
            }
            $query[$logic_value][] = [$model . '.' . $criteria_value . ' LIKE' => $value_value];
        }
        return $query;
    }

}