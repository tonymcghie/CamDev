<?php
var_dump($data);
echo $this->Form->postLink('View', $this->Html->url($data['viewURL'], true), array('class' => 'btn-xs btn-primary', 'target' => '_blank'));
echo $this->Form->postLink('Edit', $this->Html->url($data['editURL'], true), array('class' => 'btn-xs btn-primary', 'target' => '_blank'));
echo $this->Form->postLink('Analysis', $this->Html->url($data['analysisURL'], true), array('class' => 'btn-xs btn-primary', 'target' => '_blank'));
