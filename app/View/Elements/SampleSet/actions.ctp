<?php
//var_dump($data);
echo $this->Html->link('View', $data['viewURL'], ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('Edit',
    $this->Html->url($data['editURL'], true),
    ['class' => 'btn-xs btn-primary', 'target' => '_blank']);
echo $this->Html->link('Analysis',
    $this->Html->url($data['analysisURL'], true),
    ['class' => 'btn-xs btn-primary', 'target' => '_blank']);
?>
