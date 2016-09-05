<?php 
echo $this->Form->create('Analysis', ['type' => 'file', 'url' => 'uploadNewImg?id='.$id, 'id' => 'Form']);
echo $this->Form->hidden('MAX_FILE_SIZE', ['value' => '48000000']);
echo $this->Form->hidden('id', ['value' => $id]);
echo $this->Form->hidden('imgURL', ['value' => $imgURL, 'id' => 'imgURL']);
echo $this->Form->file('newImg', [
    'accept' => 'image/*;capture=camera', 
    'id' => 'newImg',]);
echo $this->Form->end();
?>
<script>
    $('#newImg').change(function(){
        if ($('#newImg').val() !== ''){
            $('#Form').submit();
        }
    });
</script>
    
