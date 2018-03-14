<h1><?= $this->String->get_string('importTitle', $model);?></h1>

<?php echo $model; ?>

<?php if (!empty($message)):?>
    <div class="<?= $class; ?> alert alert-dismissible show" role="alert">
        <?= $message; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php echo $model; ?>
<p>The process is:</p>
<p><?= $this->String->get_string('importMessage1', $model);?></p>
<p> 2) Click on Choose File and select the .csv file. The first 5 rows of the .csv sample table will be displayed.  </p>
<p> 3) Select the database fields (top row) to match the table column headings (second row) of the incoming .csv file.</p>
<p> 4) Click on Import button to upload the sample data into the database.</p>

<div class="file-loading">
    <?php

    echo $this->BootstrapForm->create_horizontal($model, ['action' => 'import']);

    echo $this->BootstrapForm->immediateUpload(
        'importfile',
        [
            'label' => $this->String->get_string('importFile', 'Import'),
            'callback' => 'handleFileUpload',
            'url' => $this->Html->url(['action' => 'uploadcsv'.'/'.$model], true)
            //pass the model name in the url
        ]
    );

    echo $this->BootstrapForm->input(
        'fileUrl',
        [
            'type' => 'hidden',
            'id' => 'file-url',
            'label' => false,
        ]
    );

    echo $this->BootstrapForm->addActionButtons(
        $this->String->get_string('import', 'Import'),
        $this->String->get_string('clear', 'General'),
        "window.location.replace('{$this->Html->url(['action' => 'import'], true)}');return false;"
    );
    ?>

    <div id="preview-continer">

    </div>

    <?php
    echo $this->BootstrapForm->get_js();
    echo $this->BootstrapForm->end();
    ?>
</div>

<script>
    function handleFileUpload(data) {
        $('#file-url').val(JSON.parse(data).filename);
        $.ajax({
            type: "POST",
            url: '<?= $this->Html->url(['action' => 'preview'], true); ?>',
            data: {"filename": data},
            error: function(jqXHR, textStatus, errorMessage) {
                console.log(errorMessage);
            },
            success: function (data) {
                $('#preview-continer').html(data);
            }
        });
    }

    /**
     * makes the page scroll horizontally
     * @returns {undefined}
     */
    (function() {
        function scrollHorizontally(e) {
            e = window.event || e;

            var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
            document.documentElement.scrollLeft -= (delta*80); // Multiplied by 40 change these to cahnge speed
            document.body.scrollLeft -= (delta*80); // Multiplied by 40
            e.preventDefault();
        }

        if (window.addEventListener) {
            // IE9, Chrome, Safari, Opera
            window.addEventListener("mousewheel", scrollHorizontally, false);
            // Firefox
            window.addEventListener("DOMMouseScroll", scrollHorizontally, false);
        }
    })();
</script>


