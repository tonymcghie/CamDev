<header class="graph"><h1>Draw Graph</h1>
<?php
echo $this->Html->script('HelperScripts_'.getenv('CSS_VERSION'), array('inline' => false));
echo $this->Html->script('https://www.gstatic.com/charts/loader.js');

$title = "Graph Pfr data: This is under constuction";
$model = "Compoundpfr_data";
$searchOptions = array( //this has the options that go in the search criteria select box
    'empty' => 'Select Criteria',
    'all' => 'All',
    'assigned_name' => 'Compound Name',
    'assigned_confid' => 'Id Confidence (1-5)',
    'exact_mass' => 'Exact Mass',
    'intensity_description' => 'Units',
    'reference' => 'Experiment Ref.',
    'sample_ref' => 'Sample Ref.',
    'sample_description' => 'Sample Description',
    'crop' => 'Crop',
    'species' => 'Species',
    'tissue' => 'Tissue',
    'genotype' => 'Genotype',
    'analyst' => 'Analyst',
    'file' => 'File',
);
$axisOptions = [ //this has the options that go in each of the axis select
    'assigned_name' => 'Compound Name',
    'intensity_value' => 'Intensity Value',
    'intensity_description' => 'Intensity Units',
    'reference' => 'Experiment Ref.',
    'sample_ref' => 'Sample Ref.',    
    'exact_mass' => 'Exact Mass',
    'rt_value' => 'Retention Value',
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue'
];
$pivotOptions = [ //this has the options that go into what the data can be pivoted on
    'none' => 'No Pivot',
    'assigned_name' => 'Compound Name',
    'exact_mass' => 'Exact Mass',
    'reference' => 'Experiment Ref.',
    'sample_ref' => 'Sample Ref.',
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue'];

echo '<table class="noFormat search">'; //formatting needs to be looked at and add ing search boxes
echo $this->Html->tableCells([$this->Form->input('x_axis:', ['label' => 'X-axis', 'id' => 'x_axis', 'options' => $axisOptions]),
        $this->Form->input('y_axis', ['label' => 'Y-axis:', 'id' => 'y_axis', 'options' => $axisOptions]),
        $this->Form->input('chartType', ['label' => 'Chart Type:', 'id' => 'chartType', 'options' => ['pie' => '2D Pie', 'pie3d' => '3D Pie', 'bar' => 'Bar', 'line' => 'Line', 'scatter' => 'Scatter', 'table' => 'Table']]),    
    $this->Form->input('Pivot_by(average):', ['id' => 'Pivot_By', 'options' => $pivotOptions])]);
echo $this->Html->tableCells([
    '<span id="addSet" class="large-button anySizeButton" style="padding: 5px;height: 30px;margin-top:10px">Add Set</span>']);
echo '</table>';
?>
</header>
<div id="sets">

  
</div>
<div id="graph-view"><span id="view" class="large-button anySizeButton"  style="padding-top: 10px;height: 30px;margin-top: 10px">View Graph</span></div>
<div id="overlay" class="noFormat overlay">
    <img class="closeButton" id="closeButton" src="../img/close.png">
    <div id="chart_div"></div>
</div>  

<div id="boxes">
</div>
<?php if (!isset($box_nums)){$box_nums=1;}?>
    <script type="text/javascript">
    
    var boxnum=[<?php echo $box_nums; ?>];    
    var cols =<?php echo json_encode(array_keys($searchOptions)); ?>;
    var names = <?php echo json_encode(array_values($searchOptions)); ?>;
    var setNum = 0;
    var graphData = ['null'];
    cols.splice(cols.length-1,1);  //removes the date option
    names.splice(names.length-1,1); //removes the date option
    
    /**
     * adds another input pair  
     * Uses setNum  
     */    
    $('#addSet').on('click', function(){
        if (setNum >= 2){return;} //only allows 2 sets
       $('#sets').append(newSet(++setNum)); //adds the new set to the HTML code
       $('#boxesButton'+setNum).on('click',function(event){
           newSearchSet(event.target.id.match(/\d+/));
       }); //adds the onClick listener to the button
        if (setNum>1){
            $('#chartType').val('scatter');
            $('#title1').append(' (X-axis)');
            $('#title2').append(' (Y-axis)');
        } //fixes up the input values in chart type for multiple sets
    });
        
    /**
     * This updates the inputs for the x and y axis to match what will be out putted
     */
    $('#Pivot_By').on('input', function(){
        if ($('#Pivot_By').val() === 'none'){
            $('#x_axis').prop('disabled', false);
            $('#y_axis').prop('disabled', false);
            return;
        }
        $('#x_axis').val($('#Pivot_By').val()).prop('disabled', true);
        $('#y_axis').val('intensity_value').prop('disabled', true);
    });
    
    /**
     * returns the HTML code for a new set. 
     * @param {int} count Which number the set is
     * @returns {String} HTML code of the new set
     */
    function newSet(count){
        boxnum.push(0);
        var newSetStr = '<h2 id="title'+count+'">Set '+count+'</h2>';
        newSetStr += '<span id="boxesButton'+count+'" class="large-button anySizeButton" style="paddingchlorogenic acidview: 10px;height: 40px;margin-bottom: 10px">Add Search Criteria</span>';
        newSetStr += '<div id="boxes'+count+'"></div>';
        return newSetStr;
    }
    
    /**
     * This adds a new Set of boxes onto the boxes element for the set which it was pressed for
     * @param {int} count which number the new search set is
     * @returns {null} appends the HTML code
     */
    function newSearchSet(count){
        $('#boxes'+count).append(getNewBox(count+'_'+ ++boxnum[count], cols,names,'<?php echo $model; ?>')); //adds the new boxes the the section     
    }  
    
    /**
     * This addes the new data on the end of the graphData array as well as appending each row of the current data with null
     * @param {type} data
     * @returns {null} Edits the graphData function
     */
    function makeData(data){
        data = JSON.parse(data);
        if (graphData[0] === 'null'){
            graphData = data;
            return;
        }
        for (var i = 0;i<graphData.length;i++){  
            try{
                graphData[i][1] = data[i][1];
            } catch (Error){
               // break;
            }            
        }    
        if (graphData[graphData.length-1][1] !== data[data.length-1][1]){
            alert('The two sets did not match and some values have being cut');
        }
    }        
    
    /**
     * Loads the chart dependancies
     * @returns {null}
     */
    $(document).ready(function(){
        google.charts.load('current', {packages: ['corechart', 'table', 'scatter']});
        google.charts.setOnLoadCallback(drawChart);
    });
    
    /**
     * Hides the overlay then either the close button or the background is clicked
     * @returns {null}
     */
    $("#overlay").on('click',function(event){
        if (event.target.id==='overlay'||event.target.id==='closeButton'){
            $("#overlay").fadeOut('fast');
        }
    });
    
    /**
     * Gets the data using Ajax, starts the data transformation for 2 sets and start the drawing the graph
     * @returns {null}
     */
    $("#view").on('click',function(){ 
        graphData = ['null']; //clears the data used to graph        
        for (var l = 1;$("#Compoundpfr_dataCri"+l+"_1").length > 0; l++){ //loops through all the sets
            var data = [];
            var last=$("#Compoundpfr_dataCri"+ (l+1) +"_1").length > 0; //passed to the success function 
            for (var i = 1;$("#Compoundpfr_dataCri"+l+"_"+i).length > 0;i++){
                //data.push({cri: ($('#Compoundpfr_dataCri'+l+'_'+i).val()), val: ($('#Compoundpfr_dataVal'+l+'_'+i).val()), log: ($('#Compoundpfr_dataLog'+l+'_'+i).val())});
                data.push({cri: ($('#Compoundpfr_dataCri'+l+'_'+i).val()), val: ($('#Compoundpfr_dataVal'+l+'_'+i).val()), log: ($('#Compoundpfr_dataLog'+l+'_'+i).val()), match: ($('#Compoundpfr_dataMatch'+l+'_'+i).val())});
            } //sets the array of criteria values and logic that will be passed to the controller for the current set
            
            var options = {pivot: $("#Pivot_By").val(), xAxis: $("#x_axis").val(), yAxis: $("#y_axis").val()}; //passed to the controller so that it knows how to pivot the data
            <?php
            echo $this->Js->request(['controller' => 'Compoundpfr_data', 'action' => 'getData'], [
                'async' => false,
                'method' => 'post',
                'data' => '{info: data, options: options}',
                'dataExpression' => true,
                'success'=> ' 
                            try{
                                if ($("#chartType").val() === "scatter" || l === 1){
                                    makeData(data);
                                } else {
                                    makeChart();
                                }
                                if (!last){makeChart();}
                            } catch (eer){
                                alert("There was an error. This is often because the search was too broad and the allocated memory ran out");
                            }
                        ',
                'error' => '
                        alert(errorThrown);
                    '
                ]);
           ?>
        }
        return false;
    });
    
    /**
     * sets the data for the chart from the graphData variable and makes the overlay visible
     * @returns {null}
     */
    function makeChart(){        
        var data = new google.visualization.DataTable(); //sets up the google data object
        
        if (!checkTypes( $("#chartType").val(), $("#x_axis").val(), $("#y_axis").val() )){ 
            return;
        } //checks that the colums chosen are suitable
        
        for (var i = 0; i<graphData.length; i++){   
            if (Type($("#x_axis").val())==='number'){
                graphData[i][0] = parseFloat(graphData[i][0]);
            } else if (Type($("#x_axis").val())==='string'){
                graphData[i][0] = ''+(graphData[i][0]);
            }
            for( var l = 1;l<graphData[0].length; l++) {                               
                if (Type($("#y_axis").val())==='number' && graphData[i][l] !== null){
                    graphData[i][l] = parseFloat(graphData[i][l]);
                } else if (Type($("#y_axis").val())==='string' && graphData[i][l] !== null){
                    graphData[i][l] = ''+(graphData[i][l]);
                }
            }
        } //parses all the colums that are to numbers
        
        data.addColumn(Type($("#x_axis").val()), $( "#x_axis option:selected" ).text()); //addes colum name and type
        for (var i = 1;i<graphData[0].length;i++){
            data.addColumn(Type($("#y_axis").val()), "Set "+i+": "+$( "#y_axis option:selected" ).text());
        } //adds a number of colums for the y axis
        data.addRows(graphData); //adds data
        drawChart(data); //draws the chart       
        $("#overlay").fadeIn('fast'); //makes the overlay containing the chart visible
    }
    /**
     * draws the chart into the overlay
     * @param {type} data
     * @returns {undefined}
     */
    function drawChart(data) {        
        var options = {title: $("#y_axis option:selected" ).text()+' By '+$("#x_axis option:selected" ).text(),
                        width:window.innerWidth*.75,
                        height:window.innerHeight*.75,
                        is3D:false,                        
                        chartArea: {left: 'auto',
                                width: 'auto'},
                        vAxis: {title: $("#y_axis option:selected" ).text(),
                                textPosition: 'out'},
                        hAxis: {title: $("#x_axis option:selected" ).text(),
                                textPosition: 'out',
                                slantedText: true
                                }}; //sets the options of all charts
        //sets the options of specific charts
        if ($("#chartType").val()==='pie'){            
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        } else if ($("#chartType").val()==='pie3d'){
            options['is3D'] = true;
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        } else if ($("#chartType").val()==='bar'){
            options['legend'] = 'none';
            options['enableScrollWheel'] = true;
            options['explorer'] = {actions: ['dragToPan','rightClickToReset']};
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        } else if ($("#chartType").val()==='line'){
            options['legend'] = 'none';
            options['enableScrollWheel'] = true;
            options['explorer'] = {actions: ['dragToPan','rightClickToReset']};
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        } else if ($("#chartType").val()==='scatter'){
            options['trendlines'] = {0:{                        
                type: 'linear',
                showR2: true,
                visibleInLegend: true}};
            options['explorer'] = {};  
            if (setNum > 1){
                options['vAxis']['title'] = 'Set 2';
                options['hAxis']['title'] = 'Set 1';
            }
            var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
        } else if ($("#chartType").val()==='table'){
            options['showRowNumber'] = true;
            options['pageSize'] = 20;
            options['cssClassNames'] = {headerRow: 'n', tableRow: 'n', oddTableRow: 'n', selectedTableRow: 'n', hoverTableRow: 'n', headerCell: 'n', tableCell: 'n', rowNumberCell: 'n',table: 'n'};
            var chart = new google.visualization.Table(document.getElementById('chart_div'));
        } else {
            alert('Chart Type not recognised');
            return;
        }
        
        google.visualization.events.addListener(chart, 'ready', function () {
            if ($("#chartType").val()==='table')return;
            $('#chart_div').append('<a href="'+chart.getImageURI() +'" target="_blank" class="find-button anySizeButton">Export to Image</a>');
        }); //adds listener to export the chart to an image
        
        chart.draw(data, options); //draws the chart
    }

    /**
     * returns the type of variable that the column is
     * @param {String} col The name of the column in the database 
     * @returns {String} what type of data to expect
     */
    function Type(col){
        switch(col){
            case 'assigned_name': 
            case 'intensity_description':
            case 'reference':
            case 'sample_ref':
            case 'crop':
            case 'genotype':
            case 'tissue':
                return 'string';                  
            case 'intensity_value':
            case 'exact_mass':
            case 'rt_value':
                return 'number';            
        }        
    }
    /**
     * checks that the right types of variables are selected for the x and y axis
     * @param {String} chartType
     * @param {String} xAxis
     * @param {String} yAxis
     * @returns {Boolean}
     */
    function checkTypes(chartType, xAxis, yAxis){
        switch(chartType){
            case 'pie':
            case 'bar':
            case 'line':
                if (Type(xAxis)==='string' && Type(yAxis)==='number'){
                    return true;
                } else {
                    alert('please have a non numeric data set on the x-axis and a numeric set on the y-axis');
                    return false;
                }
            case 'scatter':
                if (Type(xAxis)==='number' && Type(yAxis)==='number'){
                    return true;
                } else {
                    alert('please choose a numeric set for both x and y axis');
                    return false;
                }
            case 'table':
            default:
                return true;
        }
    }
 </script>   
