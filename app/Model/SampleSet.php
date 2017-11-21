<?php

App::import('model', 'Chemist');
App::uses('AppModel', 'Model');

require_once 'DataObject/SampleSet.php';

class SampleSet extends AppModel{
    public $findMethods = array('available' =>  true);
    public $validate = array(
        'submitter' => array(
            'rule' => 'notBlank'
        ),
        'chemist' => array(
            'rule' => 'notBlank'
        ),
        'set_code' => array(
            'rule' => 'notBlank'
        ),
        'crop' => array(
            'rule' => 'notBlank'
        ),
        'number' => array(
            'rule' => 'notBlank'
        ),
        'compounds' => array(
            'rule' => 'notBlank'
        ),
        'submit_date' => array(
            'rule' => 'notBlank'
        )
    );
    public $username = '';

    /**
     * This overrides the built in find method so that the query all will exclude old versions
     * allVersions will return what the all type query used to
     * the all type query has beign override so that pagination still works
     * @param String $type
     * @param array $query
     * @return array|int
     */
    public function find($type = 'first', $query = Array()) { //        
        switch ($type){
            case 'all':
                $results = $this->getSampleSet($query); //gets the results that is the most recent version
                return $results;
            case 'count':
                $results = $this->getSampleSet($query); //gets the results that are the most recent version
                return count($results); //returns the number of results
            case 'allVersions':
                // TODO filter confidential
                return parent::find('all', $query);
            case 'withID':
                return parent::find('first', $query);
            default:
                // TODO filter confidential
                return parent::find($type, $query);
        }
    }

    /**
     * makes the query and returns results
     * Filters the confidential as well
     *
     * @param $query
     * @return array results from the query
     * @internal param array $conditions
     */
    private function getSampleSet($query){
        $conditions = $query['conditions'];
        $db = $this->getDataSource();

        $temp = explode('WHERE', $db->buildStatement(['fields' => ['empty'], 'conditions' => $conditions], $this));
        $parsedConditions = end($temp);

        $sql = "SELECT *
                  FROM sample_sets AS SampleSet 
                 INNER JOIN (SELECT sample_sets.set_code sc, max(version) as maxrev
                  FROM sample_sets 
                 WHERE sample_sets.version 
              GROUP BY sample_sets.set_code) AS child 
                       ON (SampleSet.set_code = child.sc)
                  AND (SampleSet.version = maxrev)
                  AND (({$parsedConditions})
                  AND ((SampleSet.confidential = 1 
                      AND (SampleSet.chemist = '{$this->username}' OR SampleSet.submitter = '{$this->username}')) 
                   OR SampleSet.confidential = 0))";
        if (isset($query['order'])){
            $key = current(array_keys($query['order']));
            $sql .= " ORDER BY ".$key." ".$query['order'][$key];
        }
        if (isset($query['limit'])){ //gets the right number for pagination
            $limit = $query['limit'];
            $page = $query['page'];
            $sql .= " LIMIT ".(int)(($page-1)*$limit).", ".(int)($limit);
        }
        return $this->query($sql);
    }

    /**
     * Turns query results into an array of objects of type {@link \Model\DataObject\SampleSet}
     * @param array $queryResults
     * @return array
     */
    public function buildObjects($queryResults){
        $sampleSetObjects = [];
        foreach ($queryResults as $data) {
            $sampleSetObjects[] = new Model\DataObject\SampleSet($this, $data['SampleSet']);
        }
        return $sampleSetObjects;
    }

    public function getSearchableFields() {
        return ['id',
            'set_code',
            'chemist',
            'submitter',
            'p_name',
            'p_code',
            'crop',
            'compounds',
            'comments',
            'team'];
    }

    public function getDisplayFields() {
        return ['actions',
            'id',
            'set_code',
            'chemist',
            'submitter',
            'p_name',
            'p_code',
            'crop',
            'compounds',
            'comments',
            'team'];
    }
}
