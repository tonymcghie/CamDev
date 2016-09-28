<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Calculate the amount required to prepare a reagent solution</h1>
<p></p>
<p style="display:inline">Compound: <?php echo $info['Compound']['compound_name'] ?></p>
<p style="display:inline">Exact Mass: <?php echo $info['Compound']['exact_mass'] ?></p>
<p style="display:inline">Formula: <?php echo $info['Compound']['formula'] ?></p>
</header>
<?php //echo $this->html->script('Analyses/reagents.js', ['inline' => false]); 
      //echo $this->fetch('script');?>
            
                <!--<td><input type="text" placeholder="Compound" id="Compounds"></td>-->
                <!--<td><input type="text" placeholder="Molecular Weight (mol/g)" id="Mole_Weight"></td>-->
                <p>Concentration Required (mmol/L):</p>
                <input type="number" min="0" max="1000" step="1" value="100" id="Concentration">
                <p>Volume Required (mL):</p>
                <input type="number" min="0" max="1000" step="1" placeholder="Volume (mL) Required" id="Volume">
                <p>Quantity Required (g):</p>
                <p id="Quan_Required"></p>
        <!--<button type="button" class="large-button anySizeButton green-button" onclick="calculate(2,3,4));">Calculate</button>-->
        <!--<button type="button" class="large-button anySizeButton green-button" onclick="calculate($('reagentsTable'));">Calculate</button>-->      
        <!--<button type="button" class="large-button anySizeButton green-button" onclick="$('#reagentsTable > ').append(newRow());">Add Row</button>-->
<?php //echo $this->Html->tableCells([$this->Form->input('derived_results', array('label' => 'Compound:', 'value' => $info['Compound']['compound_name'], 'disabled' => 'disabled'))]);
      //echo $this->Html->tableCells([$this->Form->input('derived_results', array('label' => 'Exact Mass:', 'value' => $info['Compound']['exact_mass'], 'disabled' => 'disabled'))])  ?>
<button type="button" class="large-button anySizeButton green-button" onclick="myFunction()">Calculate</button>

<p id="demo"></p>

<script>
function myFunction() {
    document.getElementById("Quan_Required").innerHTML = calculate(<?php echo $info['Compound']['exact_mass'] ?>,document.getElementById('Concentration').value,document.getElementById('Volume').value);
}

function calculate(mw, conc_mmol, vol_ml){
    return mw * conc_mmol * vol_ml
}
</script>
      




