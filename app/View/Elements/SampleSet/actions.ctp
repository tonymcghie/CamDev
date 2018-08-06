<?php
//var_dump($data);
echo $this->Html->link('View', $data['viewURL'], ['class' => 'btn-xs btn-primary']);
echo $this->Html->link('Edit',
   $data['editURL'],
    ['class' => 'btn-xs btn-primary', 'target' => '_blank']);
if ($this->Session->read('Auth.User.CAMuserType')!==null) {  //show action if a CAM user
    echo $this->Html->link('Analysis',
    $this->Html->url($data['analysisURL'], true),
    ['class' => 'btn-xs btn-primary', 'target' => '_blank']);    
}
?>
