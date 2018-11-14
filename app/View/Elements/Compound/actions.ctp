<?php
//var_dump($data['pubchemLink'][0]);
//var_dump($data);
if ($data['pubchemLink'][0] == 'https://pubchem.ncbi.nlm.nih.gov/compound/0') {
    echo $this->Html->link('PubChem', $data['pubchemLink'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-warning', 'target' => '_blank'));
} else {
    echo $this->Html->link('PubChem', $data['pubchemLink'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-success', 'target' => '_blank'));
}
//echo $this->Html->link('PubChem', $data['pubchemLink'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-primary', 'target' => '_blank'));
echo $this->Html->link('ChemSpider', $data['chemspiderLink'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-success', 'target' => '_blank'));
if ($data['viewURL'][0] == 'https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/cid/0/PNG') {
   echo $this->Html->link('Structure', $data['viewURL'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-warning', 'target' => '_blank')); 
} else {
   echo $this->Html->link('Structure', $data['viewURL'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-success', 'target' => '_blank')); 
}
//echo $this->Html->link('Structure', $data['viewURL'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-primary', 'target' => '_blank'));
if ($this->Session->read('Auth.User.CAMuserType')=='BCB Analyst') {
    echo $this->Form->postLink('Edit', $this->Html->url($data['editURL'], true), array('class' => 'btn-xs btn-primary', 'target' => '_blank'));
    echo $this->Form->postLink('msms', $this->Html->url($data['msmsURL'], true), array('class' => 'btn-xs btn-success', 'target' => '_blank'));  
}
