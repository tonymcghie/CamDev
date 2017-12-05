<?php
//var_dump($data);
echo $this->Form->postLink('View',
    $this->Html->url($data['viewURL'], true),
    ['class' => 'btn-xs btn-primary', 'target' => '_blank']);
echo $this->Form->postLink('Edit',
    $this->Html->url($data['editURL'], true),
    ['class' => 'btn-xs btn-primary', 'target' => '_blank']);
echo $this->Html->link('Analysis',
    $this->Html->url($data['analysisURL'], true),
    ['class' => 'btn-xs btn-primary', 'target' => '_blank']);
?>
