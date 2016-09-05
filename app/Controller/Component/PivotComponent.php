<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP PivotComponent
 * @author cfpajm
 */
class PivotComponent extends Component {

    public function pivot($data, $by_key, $mean_key, $model){
        $temp = array();
        foreach($data as $row){
            if (!isset($temp[$row[$model][$by_key]])){
                $temp[$row[$model][$by_key]]=array();
            }
            array_push($temp[$row[$model][$by_key]], floatval($row[$model][$mean_key]));
        }
        foreach($temp as &$row){
            $row = array_sum($row)/count($row);
        }        
        return $temp;
    }
    
    public function FormatGraphData($data, $by_key, $mean_key, $model){
        $temp = $this->pivot($data, $by_key, $mean_key, $model);
        $results = array();
        foreach(array_keys($temp) as $key){
            array_push($results, [$key, $temp[$key]]);
        }
        return $results;
    }

}
