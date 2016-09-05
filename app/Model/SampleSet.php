<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('model', 'Chemist');

class SampleSet extends AppModel{
    public $findMethods = array('available' =>  true);
    public $validate = array(
        'submitter' => array(
            'rule' => 'notBlank'
        ),
        'chemist' => array(
            'rule' => ['isChemist', 1],
            'required' => true,
            'message' => 'Could not find Chemist'
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
     * Checks that a chemist exists
     * @param String $check The name of the chemist
     * @param type $limit (unused)
     * @return boolean
     */
    public function isChemist($check, $limit){
        $chemist = new Chemist();
        $num = $chemist->find('count', ['conditions' => ['name' => $check]]);
        return $num === 1;
    }
    /**
     * This ovverides the built in find method so that the query all will exclude old versions
     * allVersions will return what the all type query used to
     * the all type query has beign override so that pagination still works
     * @param String $type
     * @param Array $query
     * @return Array
     */
    public function find($type = 'first', $query = Array()) { //        
        switch ($type){
        case 'all':
            $results = $this->doJoinQuery($query); //gets the results that is the most recent version
            return $results;
        case 'count':
            $results = $this->doJoinQuery($query); //gets the results that are the most recent version
            return count($results); //retruns the number of results
        case 'allVersions':
            return $this->filterConfidential(parent::find('all', $query));
        default:            
            return $this->filterConfidential(parent::find($type, $query));
        }
    }
    /**
     * makes the query and returns results
     * @param Array $query
     * @return Array results from the query
     */
    protected function doJoinQuery($query){
        $queryString = "SELECT * FROM `sample_sets` AS `SampleSet` INNER JOIN ( SELECT sample_sets.set_code, max(version) as maxrev FROM sample_sets WHERE sample_sets.version GROUP BY sample_sets.set_code) AS child ON (SampleSet.set_code = child.set_code) AND (SampleSet.version = maxrev)";
        $db = $this->getDataSource(); //gets the connection to MySQL
        $subQuery = $db->buildStatement(['fields' => ['empty'], 
        'conditions' => $query['conditions']], $this); //creates the condition part of the query
        $queryString .= ' AND (';
        $queryString .= substr($subQuery, 30); //chops off the front of the subquery so that only the conditions are left
        $queryString .= ')';
        if (isset($query['order'])){
            $key = current(array_keys($query['order']));
            $queryString .= " ORDER BY ".$key." ".$query['order'][$key];
        }
        if (isset($query['limit'])){ //gets the right number for pagination
            $limit = $query['limit'];
            $page = $query['page'];
            $queryString .= " LIMIT ".(int)(($page-1)*$limit).", ".(int)($limit);
        }        
        $results = $this->filterConfidential($this->query($queryString));
        return $results;
    }
    /**
     * This will get the username from the Cookie and filter out all the confidential sample sets that dont containe the username
     * @param type $results
     * @return type
     */
    private function filterConfidential($results){
        if (!isset($this->username)){
            $this->username = '';
        }
        if (isset($results[0]['SampleSet'])){ //if there are multiple results
            foreach(array_keys($results) as $key){ //filter if confidential and username != name on SS
                if ($results[$key]['SampleSet']['confidential'] === '1' && $this->username !== $results[$key]['SampleSet']['chemist'] && $this->username !== $results[$key]['SampleSet']['submitter']){
                    unset($results[$key]);
                }
            }
        } else if(isset($results['SampleSet'])){ //if there is only one result
                if ($results['SampleSet']['confidential'] === '1' && $this->username !== $results['SampleSet']['chemist'] && $this->username !== $results['SampleSet']['submitter']){
                    unset($results[$key]);
                }            
        }
        return $results;
    }
}
