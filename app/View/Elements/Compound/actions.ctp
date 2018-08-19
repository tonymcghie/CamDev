<?php
//var_dump($data);
echo $this->Html->link('PubChem', $data['pubchemLink'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-primary', 'target' => '_blank'));
echo $this->Html->link('ChemSpider', $data['chemspiderLink'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-primary', 'target' => '_blank'));
echo $this->Html->link('Structure', $data['viewURL'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-primary', 'target' => '_blank'));
if ($this->Session->read('Auth.User.CAMuserType')=='BCB Analyst') {
    echo $this->Form->postLink('Edit', $this->Html->url($data['editURL'], true), array('class' => 'btn-xs btn-primary', 'target' => '_blank'));
    if (($this->Session->read('Auth.User.name') == 'Tony McGhie') && ($this->Session->read('Auth.User')!==null)) {
        echo $this->Form->postLink('addmsms', $this->Html->url($data['addmsmsURL'], true), array('class' => 'btn-xs btn-primary', 'target' => '_blank'));
    }   
}