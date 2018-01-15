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

    protected function checkFlavVol($comment){
        return (strpos($comment, 'flavour volatile') !== FALSE);
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
    public function makeSSmetaURL($name){
        return '/data/files/samplesets/'.$name;
    }
    public function makeTemplateURL($name){
        return '/data/files/templates/'.$name;
    }
    public function makeUnknownURL($name){
        return '/files/Unknowns/'.$name;
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
    
    /**
     * returns the option value pairs for the type of Project select input
     * @return type
     */
	public function getProjectTypeOptions(){
        return ['Blueskies' => 'Blueskies','BPA' => 'BPA','Commercial' => 'Commercial','Core' => 'Core','Discovery Science' => 'Discovery Science','MBIE' => 'MBIE',
    'Other' => 'Other'];
    }
    
    /**
     * returns the option value pairs for the type of MS ion to select for input
     * @return type
     */
	public function getIonTypeOptions(){
        return ['[M-H]-' => '[M-H]-', '[2M-H]-' => '[2M-H]-', '[M+HCOOH-H]-' => '[M+HCOOH-H]-','[M+H]+' => '[M+H]+',
    '[2M+H]+' => '[2M+H]+', '[M+Na]+' => '[M+Na]+','[M+K]+' => '[M+K]+'];
    }
    
    /**
     * returns the option value pairs for the type of MS ion to select for input
     * @return type
     */
	public function getSampleSetStatusOptions(){
        return ['submitted' => 'submitted', 'in progress' => 'in progress', 'data available' => 'data available','completed' => 'completed',
    'completed & samples discarded' => 'completed & samples discarded'];
    }
}
