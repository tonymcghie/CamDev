<?php
echo $this->Form->postLink('oldView', array('controller' => 'SampleSets', 'action' => 'viewSet', 100), ['class' => 'btn btn-primary']);
echo $this->Html->link('PubChem', 'https://pubchem.ncbi.nlm.nih.gov/',  ['class' => 'btn btn-primary']);
echo $this->Form->postLink('newView', $this->Html->url($data['viewURL'], true), ['class' => 'btn btn-primary']);
echo $this->Form->postLink('Edit', $this->Html->url($data['editURL'], true), ['class' => 'btn btn-primary']);
echo $this->Form->postLink('Analysis', $this->Html->url($data['analysisURL'], true), ['class' => 'btn btn-primary']);
