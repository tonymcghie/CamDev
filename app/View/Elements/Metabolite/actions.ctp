<?php
echo $this->Form->postLink('View', $this->Html->url($data['viewURL'], true), ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('Edit', $this->Html->url($data['editURL'], true), ['class' => 'btn-xs btn-primary']);
//If a document has been uploaded then show a different colour for the action button
if (!empty($data['document']['path'])) {
    echo $this->Form->postLink('Document', $this->Html->url($data['loaddocURL'], true), ['class' => 'btn-xs btn-success']);;
} else {
    echo $this->Form->postLink('+Document', $this->Html->url($data['loaddocURL'], true), ['class' => 'btn-xs btn-primary']);
}
echo $this->Form->postLink('+ms/ms', $this->Html->url($data['msmsURL'], true), ['class' => 'btn-xs btn-primary']);
echo $this->Form->postLink('Proposed ID', $this->Html->url($data['proposed_idURL'], true), ['class' => 'btn-xs btn-primary']);
