<?php
echo $this->Form->postLink('View', $this->Html->url($data['viewURL'], true), ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('Edit', $this->Html->url($data['editURL'], true), ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('Load Doc', $this->Html->url($data['loaddocURL'], true), ['class' => 'btn-xs btn-primary']);
