<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppHelper', 'View/Helper');

class MyHelper extends AppHelper{
    public $helpers = array('Html' , 'Form' , 'Js', 'Pagination', 'Session');

    /**
     * Draws a CSV file so it can be doqnloaded
     * @param type $data
     * @param type $model
     */
    public function drawCSV($data, $model){
        array_unshift($data,[$model => array_keys($data[0][$model])]);
        foreach ($data as $row):
            foreach ($row[$model] as &$cell):
                // Escape double quotation marks
                $cell = '"' . preg_replace('/"/','""',$cell) . '"';
            endforeach;
            echo implode(',', $row[$model]) . "\n";
        endforeach;
    }
    /**
     * echos a select and text feild for searching
     * @param type $count
     */
    public function searchPair($count, $options){
        $temp = '<table class="noFormat search">';
        $temp .= $this->Html->tableCells([$this->Form->input('cri_'.$count, ['options' => $options, 'label' => '']),
            $this->Form->input('val_'.$count, array('label' => '')),
            $this->Form->input('log_'.$count, ['label' => '' ,'options' => ['AND' => 'AND', 'OR' => 'OR', 'XOR' => 'XOR', 'NOT' => 'NOT']])]);
        $temp .= '</table>';
        return $temp;
    }
    /**
     * will create a div containg a span with the text in it
     * and another div inside the first with the input in it
     * @param type $name
     * name of database colum
     * @param array $options
     * normal options for an input<br>
     * label will be set to an empty string
     * @param type $text
     * the text to go before the input
     * @return string
     */
    public function makeInputRow($name, $options, $text){
        $options['label'] = '';
        $row = '<div class="Trow"';
        if (isset($options['rowId'])){
            $row .= ' id="'.$options['rowId'].'"';
            unset($options['rowId']);
        }
        if (isset($options['rowStyle'])){
            $row .= ' style="'.$options['rowStyle'].'"';
            unset($options['rowStyle']);
        }
        $row .= '><span>'.$text.'</span>';
        $row .= $this->Form->input($name, $options);
        $row .= '</div>';
        return $row;
    }
    /**
     * returns a table of the results.
     * @param type $results
     * @param type $options
     * possible options <br>
     * <b>names</b> (of colums) <br>
     * <b>cols</b> (in the database Action will create a link) <br>
     * <b>model</b> (model that for the database)<br>
     * <b>link</b> ('' => [text , [options]]) always green
     * @return string
     */
    public function makeResultsTable($results, $options, $type = null, $isTablet = 'false'){
        $table = '<table class="table-striped">';
        $table .= $this->Html->tableHeaders($options['names']);
        foreach($results as $row){
            $tableCells = array();
            foreach($options['cols'] as $col){
                if ($col=='Actions'){
                    $links = '';
                    if ($type=='SampleSet'){
                        $links .= $this->sampleSetActions($row['SampleSet']['id'], $row['SampleSet']['set_code'], $isTablet);
                    } else if ($type=='Compound'){
                        $links .= $this->compoundActions($row[$options['model']]['id'], $row[$options['model']]['chemspider_id'], $row[$options['model']]['metlin_id'],$row[$options['model']]['pub_chem'],$row[$options['model']]['cas'],$this->checkFlavVol($row[$options['model']]['comment']));
                    } else if ($type=='Metabolite'){
                        $links .= $this->metaboliteActions($row[$options['model']]['id']);
                    } else if ($type=='Proposed_Metabolite'){
                        $links .= $this->proposedMetaboliteActions($row[$options['model']]['id']);
                    } else if ($type=='Msms_Metabolite'){
                        $links .= $this->msmsMetaboliteActions($row[$options['model']]['id']);
                    }
                    array_push($tableCells, $links);
                } else {
                    if (isset($row[$options['model']][$col])){
                        array_push($tableCells,$row[$options['model']][$col]);
                    } else {
                        array_push($tableCells, '');
                    }
                }
            }
            $table .= $this->Html->tableCells($tableCells);
        }
        $table .= '</table>';
        return $table;
    }
    /**
     * helper method for making the links for makeResultsTable if its a sample set table
     */
    protected function sampleSetActions($id, $set_code, $isTablet = 'false'){
        $temp = $this->Form->postLink('Edit', array('controller' => 'SampleSets', 'action' => 'editSet', $id), array('class' => 'find-button abbr-button', 'title'=>'Edit'));
        $temp .= $this->Form->postLink('View', array('controller' => 'SampleSets', 'action' => 'viewSet', $id), array('class' => 'find-button abbr-button', 'title'=>'View'));
        //check if user is in bio chemistry before showing the analysis button //comment out if statment to show the analysis button
        //if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
            $temp .= $this->Form->postLink('Analyse', array('controller' => 'Analyses', 'action' => 'editAnalysis','?' => ['isTablet' => $isTablet, 'set_code' =>  $set_code]), array('style'=>'width: 60px','class' => 'find-button abbr-button', 'title'=>'Analyse'));
			$temp .= $this->Form->postLink('Samples', array('controller' => 'Samples', 'action' => 'viewSamples', $id), array('style'=>'width: 55px','class' => 'find-button abbr-button', 'title'=>'Samples'));
			$temp .= $this->Form->postLink('UploadSamples', array('controller' => 'Samples', 'action' => 'uploadSamples', $id), array('style'=>'width: 90px','class' => 'find-button abbr-button', 'title'=>'UploadSamples'));
        //}
        return $temp;
    }
    protected function checkFlavVol($comment){
        return (strpos($comment, 'flavour volatile') !== FALSE);
    }
    /**
     * helper method for making the links for makeResultsTable if its a compund table
     */
    protected function compoundActions($id, $chemLink = null, $metlinLink = null, $pubChemLink = null, $cas = null, $isFlav = false){
        $temp = $this->Form->postLink('Edit', array('controller' => 'Compounds', 'action' => 'editCompound', $id), array('class' => 'find-button abbr-button'));
        if ($pubChemLink!=null){
            $temp .= '<span onclick="popUp('.$pubChemLink.')" class="find-button abbr-button">View</span>';
            $temp .= $this->Html->link('Pub Chem', 'https://pubchem.ncbi.nlm.nih.gov/compound/'.$pubChemLink,  array('style'=>'width: 70px','class' => 'find-button abbr-button', 'target' => '_blank'));
        }
        if ($chemLink!=null && $chemLink != '0' && $chemLink != ''){
            $temp .= $this->Html->link('Chem Spider',  'http://www.chemspider.com/Chemical-Structure.'.$chemLink.'.html',  array('style'=>'width: 80px','class' => 'find-button abbr-button', 'target' => '_blank'));
        }
        if ($metlinLink!=null && $metlinLink != '0' && $metlinLink != ''){
            $temp .= $this->Html->link('MetLin', 'https://metlin.scripps.edu/metabo_info.php?molid='.$metlinLink,  array('style'=>'width: 50px','class' => 'find-button abbr-button', 'target' => '_blank'));
        }
        if ($isFlav){
            $temp .= $this->Html->link('Flavornet', 'http://www.flavornet.org/info/'.$cas.'.html',  array('style'=>'width: 70px','class' => 'find-button abbr-button', 'target' => '_blank'));
        }

        /*$file = 'http://www.flavornet.org/info/'.$cas.'.html';
        $file_headers = get_headers($file);
        if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == '') {

        }
        else {

        }*/
        return $temp;
    }
    /**
     * helper method for making the links for makeResultsTable if its a metabolite table
     */
    protected function metaboliteActions($id){
        $temp = $this->Form->postLink('Edit', array('controller' => 'Metabolites', 'action' => 'editMetabolite', $id), array('class' => 'find-button abbr-button'));
        $temp .= $this->Form->postLink('View', array('controller' => 'Metabolites', 'action' => 'viewMetabolite', $id), array('class' => 'find-button abbr-button'));
        return $temp;
    }
    /**
     * helper method for making edit link for resulttable
     */
    protected function proposedMetaboliteActions($id){
        return $this->Form->postLink('Edit', array('controller' => 'Metabolites', 'action' => 'editProposedMetabolite', $id), array('class' => 'find-button anySizeButton'));
    }
    /**
     * helper method for making edit link for resulttable
     */
    protected function msmsMetaboliteActions($id){
        return $this->Form->postLink('Edit', array('controller' => 'Metabolites', 'action' => 'editMsmsMetabolite', $id), array('class' => 'find-button green-button'));
    }
    /**
     * makes a Url that points to an iplant file that can be open in browser
     * @param type $url
     * @return type
     * @todo change to powerplant url
     */
    public function makeDataURL($name){
        return '/data/files/analysis/'.$name;
    }
    public function makeImgURL($name){
        return '/data/images/analysis/'.$name.'?stopCahce='.rand();
    }
    public function makeSSmetaURL($name){
        return '/data/files/samplesets/'.$name;
    }
    /**
     * returns the option value pairs for the crop select input
     * @return type
     */
    public function getCropOptions(){
        return ['apple' => 'apple' , 'arabidopsis' => 'arabidopsis',
            'avocado' => 'avocado' , 'blackcurrant' => 'blackcurrant' , 'boysenberry' => 'boysenberry',
            'broccoli' => 'broccoli' , 'carrot' => 'carrot' , 'feijoa' => 'feijoa' , 'grape' => 'grape' , 'honey' => 'honey', 'hops' => 'hops',
            'human plasma' => 'human plasma' , 'human urine' => 'human urine' , 'kiwifruit' => 'kiwifruit' , 'marine' => 'marine' , 'NZ Natives' => 'NZ Natives' ,'onion' => 'onion' , 'pear' => 'pear',
            'potato' => 'potato' , 'pumpkin' => 'pumpkin' , 'raspberry' => 'raspberry' , 'rat plasma' => 'rat plasma' , 'rat urine' => 'rat urine' , 'seafood' => 'seafood' ,
            'strawberry' => 'strawberry' , 'tobacco' => 'tobacco' , 'tomato' => 'tomato', 'wine' => 'wine' , 'other' => 'other'];
    }
	/**
     * returns the option value pairs for the Chemical Class select input
     * @return type
     */
	public function getChemicalClassOptions(){
        return ['' => '' , 'alcohol' => 'alcohol' , 'aldehyde' => 'aldehyde' , 'alkaloid' => 'alkaloid' , 'amino acid' => 'amino acid' , 'carbohydrate' => 'carbohydrate' , 'carotenoid' => 'carotenoid' , 'epoxide' => 'epoxide' , 'ester' => 'ester' , 'flavonoid' => 'flavonoid',
            'glucosinolate' => 'glucosinolate' , 'hydrocarbon' => 'hydrocarbon' , 'ketone' => 'ketone' , 'lipid' => 'lipid' , 'organic acid' => 'organic acid' , 'peptide' => 'peptide' , 'phenolic acid' => 'phenolic acid' , 'sulphur compound' => 'sulphur compound' , 'terpene' => 'terpene' , 'other' => 'other'];
    }
}
