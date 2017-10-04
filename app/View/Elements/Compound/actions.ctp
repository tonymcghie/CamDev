<?php
echo $this->Html->link('PubChem', $data['pubchemLink'][0], array('style'=>'width: 70px','class' => 'btn-xs btn-primary', 'target' => '_blank'));
echo $this->Form->postLink('newView', $this->Html->url($data['viewURL']),true, ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('Edit', $this->Html->url($data['editURL']), true, ['class' => 'btn-xs btn-primary']);
