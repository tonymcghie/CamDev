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
     * @param $model AppModel the name of the modle to search in
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
            if (empty($value_value))continue;
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
            if ($criteria_value == 'all') {
                foreach (array_keys($model->schema()) as $column_name) {
                    if (in_array($column_name, $this->excluded_fields)){
                        continue;
                    }
                    $query[$logic_value][] = [$model->name . '.' . $column_name . ' LIKE' => $value_value];
                }
            } else {
                $query[$logic_value][] = [$model->name . '.' . $criteria_value . ' LIKE' => $value_value];
            }
        }
        return $query;
    }

}