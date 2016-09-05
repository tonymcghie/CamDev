<?php
/**
 *  @LIVE swap location of pythonScripts
*/
$python_location = '/app/app/webroot/files/pythonScripts/';
//$python_location = 'C:/wamp/www/CAMcake/app/webroot/files/pythonScripts/';
?>
<header>
<h1>Scripts</h1>
<table class="noFormat" style="width: 100%;">
    <tr style="width: 100%;">
        <td style="width: 100%;" colspan="2">
            <iframe id="csvFileFrame" class="iframeNoformat" src="<?php echo $this->Html->url(['controller' => 'General', 'action' => 'getCsv']);?>"></iframe>
        </td>
    </tr>
    <tr>
        <td>
            <select id="script" onclick="info()">
                <?php
                foreach(scandir($python_location) as $script){
                    if ($script == '.' || $script == '..'){continue;}
                    if (explode('_',$script)[count(explode('_', $script))-1] == 'template'){continue;} //continue if the file is a template file
                    echo '<option value="'.$script.'">'.$script.'</option>';
                }
                ?>
            </select>
        </td>
        <td>
            <span style="margin-left: 10px;" id="runScript" class="find-button anySizeButton green-button">Run Script</span>
        </td>
    </tr>
</table>
</header>
<div id="help"></div>
<div id="output"></div>
<?php
    echo $this->Form->create('General');
    echo $this->Form->hidden('temp_name', ['id' => 'temp_name']);
    echo $this->Form->hidden('name', ['id' => 'name']);
    echo $this->Form->end(['label' => 'Download', 'class' => 'large-button anySizeButton green-button', 'id' => 'download', 'style' => 'display: none;']);
?>


<script>
    $('#runScript').click(function(){
        <?php
            echo $this->Js->request(['controller' => 'General', 'action' => 'runScript'] , [
            'async' => true,
            'method' => 'post',
            'data' => '{name: $("#script").val(), args: [$("#csvFileFrame").contents().find("#fileUrl").val(), $("#csvFileFrame").contents().find("#fileUrl").val()]}',
            'dataExpression' => true,
            'success' => '
                $("#output").html("Output: ");
                $("#output").append(data);
                $("#download").show();
                ',
            'error' => '
                '
            ]);
        ?>
    });
    $('#csvFileFrame').on('load', function(){
        $("#temp_name").val($("#csvFileFrame").contents().find("#fileUrl").val());
        var name = $("#csvFileFrame").contents().find("#fileName").val();
        ext = name.split('.')[name.split('.').length-1];
        name = name.replace('.'+ext, '')+'_out.'+ext;
        $("#name").val(name);
    });
    $('document').ready(function(){
        info();
    });
    function info(){
        file =  $('#script').find(":selected").text() + '_help';
        $.get('ScriptHelp',{name: file},function(data, textStatus, jqxhr){
            $('#help').html(data);
        });
    }
</script>
