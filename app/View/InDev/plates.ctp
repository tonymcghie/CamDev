<?php 
echo $this->html->script('plates/plates.js');
echo $this->fetch('script');
?>
<canvas id="myCanvas" width="300" height="300" style="border:1px solid #d3d3d3;">
Your browser does not support the HTML5 canvas tag.</canvas>
<table id="coords">
    <tr id="row">
        <!--<td><select placeholder="Name">
  				<option value="Sample">Sample</option>
  				<option value="Standard">Standard</option>
  				<option value="QC">QC</option>
  				</td>-->
		<td><input type="text" placeholder="Name"></td>
        <td><input type="text" placeholder="start"></td>
        <td><input type="text" placeholder="end"></td>
    </tr>
</table>
<button type="button" onclick="addRow()">Add</button>
<button type="button" onclick="draw()">Draw</button>
<script>            
    drawPlate(document.getElementById("myCanvas"), null);
    
    function draw(){
        var coords = []
        $('#coords tr').each(function() {
            coords[coords.length] = startStrToCoor($(this).find("td").eq(1).find("input").val(), $(this).find("td").eq(0).find("input").val())
            coords[coords.length] = strToCoor($(this).find("td").eq(2).find("input").val(), true)       
        });
        
        drawPlate(document.getElementById("myCanvas"), coords);
    }       
    
    function addRow(){
        $('#coords').append($('#row').clone());
    }
</script> 
