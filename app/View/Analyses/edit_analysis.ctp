<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Sample Set Analysis Workspace</h1>
<h2>Set Code: <?php echo $set_code ?></h2>
<?php if (count($results)<=0): ?>
<h2>No Data Found</h2>
<ol>
    <li id="add"><a href="">+</a></li>
</ol>
<?php endif; ?>
</header>
<div id="overlay" class="noFormat overlay">
    <img class="closeButton" id="closeButton" src="../img/close.png">
    <div class="overlayContent">
<?php
    echo $this->Form->create('Analysis');
    echo $this->Form->input('set_code', array('type' => 'hidden', 'value' => $set_code));
    echo $this->Form->input('key', array('type' => 'hidden', 'value' => 'new'));
    echo $this->My->makeInputRow('title', ['label' => '' , 'oninput' => 'fix("newTitle")', 'id' => 'newTitle', 'placeholder' => 'New Analysis title'], 'Title');
    echo $this->My->makeInputRow('workflow', ['label' => '','options' => ['chem_everything' => 'Chem: all sections', 'chem_details' => 'Chem: analysis details only', 'chem_files' => 'Chem: files only', 'chem_pictures' => 'Chem: pictures only', 'bio_everything' => 'Bio: all sections', 'bio_details' => 'Bio: analysis details only', 'bio_files' => 'Bio: files only', 'bio_pictures' => 'Bio: pictures only', 'reagents' => 'reagents', 'plates' => 'plates' ]], 'Workflow');
    echo $this->Form->end(['label' => 'Create', 'class' => 'large-button anySizeButton green-button']);
?>
    </div>
</div>
<!-- TABS GO HERE -->
<?php
if (count($results) > 0):
$titles = array();
foreach ($results as $res){
    array_push($titles, $res['Analysis']['title']);
}
?>
<ol>
<?php foreach($titles as $title):?>
    <li>
        <a id='<?php echo $title; ?>'><?php echo $title; ?></a>
    </li>
<?php endforeach; ?>
    <li id="add"><a href="">+</a></li>
</ol>
<?php $this->start('tabContent'); ?>
<div class='tab-content'>
<?php
    echo $this->Form->create('Analysis', ['type' => 'file']);
    echo $this->Form->input('set_code', array('type' => 'hidden', 'value' => $set_code));
    if ($tabletView !== 'true'){echo $this->Form->submit('Save', ['class' => 'large-button anySizeButton green-button']);}
    $i=0;
    foreach ($results as $row){
        $form_model = 'Analysis.'.$i.'.';
        $i++;
        echo $this->element('analysis_tab', ['row' => $row, 'form_model' => $form_model, 'tabletView' => $tabletView]);
    }
    echo $this->Form->end(['label' => 'Save', 'class' => 'large-button anySizeButton green-button']);
?>
</div>
<div id="overlay2" class="noFormat overlay">
    <img class="closeButton" id="closeButton2" src="../img/close.png">
    <img id="overlay_img" style="position: fixed;left: 10%; top: 10%;width: 80%;height: 80%;background-color: #FFFFFF;" src="">
</div>
<?php
$this->end();
if ($tabletView !== 'true'){ //desktop view
    echo $this->fetch('tabContent');
}
endif;
$this->start('extras')?>



<script>
    var images = {};
    var currentImg = 0;

    /**
     * Switches the image to the image before the current one
     * @param {String} id The ID of the analysis that the image viewer is in
     */
    function preImg(id){
        currentImg--;
        if (currentImg<0){
            currentImg = 0;
            return;
        }
        $('#show-picture'+id).hide('slide', {direction: 'right'}, 500, function(){
            $('#show-picture'+id).attr('src', imgURL(id, currentImg));
            $('#show-picture'+id).show('slide', {direction: 'left'}, 500, function(){
                centerImg(id);
            });
        });
    }

    /**
     * Switches the image to the image after the current one
     * @param {String} id The ID of the analysis that the image viewer is in
     */
    function nextImg(id){
        currentImg++;
        if (currentImg===images[id].length){
            currentImg = images[id].length-1;
            return;
        }
        $('#show-picture'+id).hide('slide', {direction: 'left'}, 500, function(){
            $('#show-picture'+id).attr('src', imgURL(id, currentImg));
            $('#show-picture'+id).show('slide', {direction: 'right'}, 500, function(){
                centerImg(id);
            });
        });
    }

    /**
     * Returns a string that links to an image on powerplant if live or on the local file system if testing
     * @param {String} id The ID to the analysis that the image is in
     * @param {int} img The position of the image a number 0 upwards but smaller than the migURL
     * @returns {String} url to an Image
     */
    function imgURL(id, img){
        return '<?php echo $this->webroot; ?>data/images/analysis/'+id+'_'+img+'?stopCahce='+Math.random();
    }

    /**
     * centers the img in an analysis tab
     * @param {String} id The ID of the Analysis tab that the img element is in
     * @returns {null}
     */
    function centerImg(id){
        var offset = ($('#imgDiv'+id).width()/2) - ($('#show-picture'+id).width()/2);
        $('#show-picture'+id).attr('style','margin-left: '+offset +'px;background-color:#FFFFFF;');
    }

    /**
     * This is used to sanitize the input that goes into the title inputs in the analysis tabs as well as the create analysis form
     * changes all spaces to underscors
     * @param {String} id The ID of the title element in the create Analysis input
     * @returns {null}
     */
    function fix(id){
        val = document.getElementById(id).value;
        val = val.replace(/\ /g,"_");
        val = val.replace(/\'/g,"_");
        val = val.replace(/\"/g,"_");
        document.getElementById(id).value = val;
    }

    /**
     * this will hide the overlay when the user clicks on either the close button or the dark background
     * @returns {null}
     */
    $("#overlay").on('click',function(event){
        if (event.target.id==='overlay'||event.target.id==='closeButton'){
            $("#overlay").fadeOut('fast');
        }
    });

    /**
     * This will show the overlay when the user clicks on the button to add a new analysis
     * @returns {undefined}
     */
    $('#add').on('click', function(){
        $('#overlay').fadeIn('fast');
        return false;
    });

    /**
     * This sets up the listeners to the tabs as well as the view image for the overlay
     * should be a function
     * @returns {null}
     */
    $(document).ready( function() {
        //setUp(); //sets up the image loading
        <?php if(isset($titles)): ?>
        <?php foreach($titles as $title): ?>            // hides all the panes
             $('#<?php echo $title.'pane' ?>').hide();  //
        <?php endforeach; ?>                            //

        $('#<?php echo $titles[0].'pane' ?>').show();   //shows the first one
        $('#<?php echo $titles[0] ?>').toggleClass("active"); //sets the first one to active

        <?php foreach($titles as $title): ?>
            $('#<?php echo $title ?>').on('click',function(){       //loops through all tabs and adds a onclick event
                <?php foreach($titles as $hidetitle): ?>
                    if($('#<?php echo $hidetitle.'pane' ?>').is(':visible')) {   //checks is pane is visible

                        $('#<?php echo $hidetitle ?>').toggleClass("active");   //makes active tab not active
                        $('#<?php echo $title ?>').toggleClass("active");       //makes clicked tab active

                        $('#<?php echo $hidetitle.'pane' ?>').fadeOut('fast',function(){   //fades out old pane
                            $('#<?php echo $title.'pane' ?>').fadeIn('fast',function(){
                                currentImg = 0;
                                var id = findID('<?php echo $title;?>');
                                $('#show-picture'+id).attr('src', imgURL(id, currentImg));
                                centerImg(id);
                                <?php if ($tabletView === 'true'): ?> //when changing tabs return to the first pane
                                    $('#'+panes[current]).hide();
                                    panes = getPanes();
                                    current = 0;
                                    $('#next').show();
                                    $('#previous').hide();
                                    $('#'+panes[current]).show();
                                <?php endif; ?>
                            });             //fades on new pane after alod pane has faded out
                        });
                    }
                <?php endforeach; ?>
            });
        <?php endforeach; ?>

        //sets the image variable
        <?php foreach($results as $row): ?>
            $('#<?php echo $row['Analysis']['id'];?>').on('load', function(){
                var id = <?php echo $row['Analysis']['id'];?>;
                images[id] = [];
                if ($('#'+id).contents().find('#imgURL').val() !== '0'){
                    for (var i = 0;i<$('#'+id).contents().find('#imgURL').val();i++){
                        images[id].push(id+'_'+i);
                    }
                }
                currentImg = 0;
                $('#show-picture'+id).attr('src', imgURL(id, currentImg));
                centerImg(id);
            });
            images['<?php echo $row['Analysis']['id']; ?>'] = [<?php for ($i=0;$i<$row['Analysis']['imgURL'];$i++){echo ' "'.$row['Analysis']['id'].'_'.$i.'",';} ?>];
            $('#imgDiv'+<?php echo $row['Analysis']['id'];?>).on('click',function(event){
                if (event.target.id === 'show-picture'+<?php echo $row['Analysis']['id'];?>){
                    $('#overlay_img').attr('src', imgURL(<?php echo $row['Analysis']['id'];?>, currentImg));
                    $("#overlay2").fadeIn('fast');
                    return;
                }
                if (images['<?php echo $row['Analysis']['id'];?>'].length === 0)return;
                if(event.pageX - $(this).offset().left < $(this).width()/2){
                    preImg('<?php echo $row['Analysis']['id']; ?>');
                } else {
                    nextImg('<?php echo $row['Analysis']['id']; ?>');
                }
            });
        <?php endforeach; ?>
        <?php endif; ?>

    });

    /**
     * returns the ID of an analysis given its title This is only for the current set code
     * @param {String} title This is the title for the analysis that you want to find the id of
     * @returns {String} Returns the Id of the analysis that has the title
     */
    function findID(title){
        <?php foreach ($results as $row): ?>
            if (title === '<?php echo $row['Analysis']['title'];?>'){
                return '<?php echo $row['Analysis']['id'];?>';
            }
        <?php endforeach;?>
    }

    /**
     * hides the overlay2 when the user clicks on the darkbackround or the close button
     */
    $("#overlay2").on('click',function(event){ //hides overlay
        if (event.target.id==='overlay2'||event.target.id==='closeButton2'){
            $("#overlay2").fadeOut('fast');
        }
    });
</script>
<?php $this->end();
if ($tabletView !== 'true'){ //desktop view
    echo $this->fetch('extras');
}
