<?php
//echo $this->Form->postLink('newView', $this->Html->url('viewURL'), ['class' => 'btn-xs btn-primary']);
//echo $this->Form->postLink('Edit', $this->Html->url($data['editURL']), ['class' => 'btn-xs btn-primary']);
echo $this->Html->link('View Data', $this->Html->url($data['DataViewURL'], true), ['class' => 'btn-xs btn-primary']);
echo $this->Html->link('View Set', $this->Html->url($data['SetViewURL'], true), ['class' => 'btn-xs btn-primary']);
