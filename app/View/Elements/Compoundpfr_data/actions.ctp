<?php
echo $this->Html->link('PubChem', 'https://pubchem.ncbi.nlm.nih.gov/',  ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('View Data', $this->Html->url($data['DataViewURL'], true), ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('View Set', $this->Html->url($data['SetViewURL'], true), ['class' => 'btn-xs btn-primary']);
