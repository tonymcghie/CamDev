<?php
echo $this->Form->postLink('oldView', array('controller' => 'SampleSets', 'action' => 'viewSet', 100), ['class' => 'btn-xs btn-primary']);
echo $this->Html->link('PubChem', 'https://pubchem.ncbi.nlm.nih.gov/',  ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('newView', $this->Html->url('viewURL'), ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('Edit', $this->Html->url($data['editURL']), ['class' => 'btn-xs btn-primary']);
