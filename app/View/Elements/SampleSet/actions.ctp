<?php
echo $this->Form->postLink('Edit', $this->Html->url($data['editURL']), ['class' => 'btn btn-primary']);
echo $this->Form->postLink('Analysis', $this->Html->url($data['analysisURL']), ['class' => 'btn btn-primary']);