<h1>Sample Upload Workspace</h1>
<?php

?>
<table class="noFormat">
    <tr>
        <td style="width: 92%;">
            <iframe id="csvFileFrame" class="iframeNoformat" src="<?php echo $this->Html->url(['controller' => 'Samples', 'action' => 'getCsv']);?>"></iframe>
        </td>
        <td style="width: 20%;">
            <span id="importData" class="find-button anySizeButton green-button">Import</span>
        </td>
    </tr>
</table>

<div id="csvTableDiv">    
    <?php
    if (isset($message)){
        echo '<h2>'.$message.'</h2>';
    }
    echo $this->Form->create('Samples', ['id' => 'csvForm']);
    echo $this->Form->hidden('fileName', ['id' => 'fileName']);
    echo $this->Form->hidden('fileUrl', ['id' => 'fileUrl']);
    ?>
<table id="csvTable">
    <thead>
        <tr id="csvTableSelects">            
        </tr>
        <tr id="csvTableTitles">            
        </tr>
    </thead>
    <tbody id="csvTableBody">
        
    </tbody>    
</table>
    <?php
    echo $this->Form->end();
    ?>
</div>
<script>
$('#importData').on('click', function(){
    $('#csvForm').submit();
});

$('#csvFileFrame').on('load', function(){
        var csvFile = $('#csvFileFrame').contents().find('#fileUrl').val();
        $('#fileUrl').val(csvFile);
        $('#fileName').val($('#csvFileFrame').contents().find('#fileName').val());
        if (!csvFile || csvFile === '')return;
        <?php //THis also sets the data into the input boxes through the setValues function
            echo $this->Js->request(['controller' => 'Samples', 'action' => 'getCsvPreview'], [
                'async' => true,
                'method' => 'post',
                'data' => '{url: csvFile}',
                'dataExpression' => true,
                'success'=> '                        
                            makeTable(data);                            
                        ',
                'error' => '
                    /*alert(JSON.stringify(XMLHttpRequest));
                    alert(textStatus);
                    alert(errorThrown);*/
                    '
                ]);
        ?>
    });

/**
 * makes a table from the csv file
 * @param {type} data
 * @returns {undefined}
 */
var columns = {names: ['none', 'set_code', 'sample_name', 'treatment_1', 'description_1', 'treatment_2', 'treatment_3', 'description_3', 'tissue',
            'sample_weight', 'weight_unit' , 'kea_num', 'comment'],
                displayNames: ["Don't Import", 'Sample Set', 'Sample Name', 'Treatment 1', 'Description 1', 'Treatment 2', 'Description 2', 'Treatment 3', 'Description 3',
            'Tissue', 'Sample Weight' , 'Unit', 'Kea Number', 'Comment']};

function makeTable(data){     
    $('#csvTableSelects').html(''); //clears the current table
    $('#csvTableTitles').html('');
    $('#csvTableBody').html('');
    //$('body').html(data);
    //alert(data);
    var dataArray = JSON.parse(data);
    var headers = dataArray[0];
    for(var i = 0;i<headers.length;i++){
        $('#csvTableSelects').append('<th>' + makeSelect(i, headers[i]) + '</th>');
        $('#csvTableTitles').append('<th>' + headers[i] + '</th>');
    }
    for(var i = 1;i<dataArray.length;i++){
        var row = '<tr>';
        for(var l = 0;l<dataArray[i].length;l++){
            row += '<td>' + dataArray[i][l]+'</td>';
        }
        row += '</tr>';
        $('#csvTableBody').append(row);
    }
    $('#csvTableDiv').width($('#csvTable').width()+10);
}

function makeSelect(name, title){
    var select = '<select name="data[Samples]['+name+']">';
    for (var i = 0;i<columns['names'].length;i++){
        if (title === columns['names'][i] || title === columns['displayNames'][i]){
            select += '<option selected value="'+columns['names'][i]+'">'+columns['displayNames'][i]+'</option>';
        } else {
            select += '<option value="'+columns['names'][i]+'">'+columns['displayNames'][i]+'</option>';
        }
    }
    select += '</select>';
    return select;
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
} else {
    // IE 6/7/8
    window.attachEvent("onmousewheel", scrollHorizontally);
}
})();
</script>
