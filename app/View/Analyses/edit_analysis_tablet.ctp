<?php include('edit_analysis.ctp');
echo $this->fetch('tabContent');?>

<span id="previous"><img src="<?php echo $this->webroot; ?>img/previous_tablet.png"></span>
<span id="next"><img src="<?php echo $this->webroot; ?>img/next_tablet.png"></span>

<script>
    var current = 0;
    var panes = [];
    
    /**
     * Switches to the previous pane
     * Uses the function pre from the tablet layout
     */
    $("#previous").on('click', function(){
        panes = getPanes();
        pre();
    });
    
    /**
     * Switches to the next layout
     * Uses the function next from the tablet layout
     */
    $("#next").on('click', function(){
        panes = getPanes();
        next();
    });
    
    /**
     * Switches to the previous pane
     * Uses the function pre from the tablet layout
     */
    $("html").on("swiperight",function(){
        panes = getPanes();
        pre();
    });
    
    /**
     * Switches to the next layout
     * Uses the function next from the tablet layout
     */
    $("html").on("swipeleft",function(){
       panes = getPanes();
       next(); 
    });   
    
    /**
     * Gets the Panes for the analysis tab that is currently visible
     * @returns {Array} An array of the id of the panes that are part of the currently visible analysis tab
     */
    function getPanes(){
        var tabs = $('[name="panes"]').toArray(); 
        for (var i = 0;i < tabs.length;i++){
            if ($(tabs[i]).is(':visible')){
                var panesArray = [];
                for (var l =1 ; $("#slide_"+l+"_"+$(tabs[i]).attr('id')).length > 0; l++){
                    panesArray.push('slide_'+l+'_'+$(tabs[i]).attr('id'));
                    //return ['slide_1_'+$(tabs[i]).attr('id') , 'slide_2_'+$(tabs[i]).attr('id') , 'slide_3_'+$(tabs[i]).attr('id')];
                }
                return panesArray;
            }
        }
    }
</script>

<?php
echo $this->fetch('extras');
