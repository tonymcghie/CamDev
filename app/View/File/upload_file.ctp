<?php
/**
 * @var $this View
 * @var $this BootstrapFormHelper
 */
    echo $this->BootstrapForm->create('File', ['type' => 'file', 'id' => 'file-form']);
    echo $this->BootstrapForm->input('location', ['type' => 'hidden']);
    echo $this->BootstrapForm->input('file', ['type' => 'file', 'label' => 'Metadata File', 'id' => 'file-input']);
    echo '</form>';
    ?>
<script>
    $('#file-input').on('change', function(){
       $('#file-form').submit();
    });
</script>
