<?php
//var_dump($data);
echo $this->Html->link('View', $data['viewURL'], ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('Edit', $this->Html->url($data['editURL'], true), array('class' => 'btn-xs btn-primary', 'target' => '_blank'));
echo $this->Form->postLink('Analysis', $this->Html->url($data['analysisURL'], true), array('class' => 'btn-xs btn-primary', 'target' => '_blank'));
