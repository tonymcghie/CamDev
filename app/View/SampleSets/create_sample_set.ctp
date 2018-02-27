<?php if (!$error) {
    $title = $this->String->get_string('confirm_new_sampleset', 'SampleSet_form');
    $message = 'The set code assigned is to: ' . $sampleSet['set_code'];
} else {
    $title = $this->String->get_string('error_new_sampleset', 'SampleSet_form');
    $message = 'Please contact Tony McGhie';
} 
?>

<div id="messageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $title; ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $message;?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'> $(document).ready(function(){ $('#messageModal').modal('show'); }); </script>