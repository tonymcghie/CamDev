<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
    <h1>Reagent Calculator</h1><br>
<p style="display:inline">Compound: <?php echo $info['Compound']['compound_name'] ?></p>
<p style="display:inline">Exact Mass: <?php echo $info['Compound']['exact_mass'] ?></p>
<p style="display:inline">Formula: <?php echo $info['Compound']['formula'] ?></p>
<p>To calculate the amount required to prepare a reagent solution, enter a concentration and volume and press Calculate.</p>
<p style="font-size:80%;">Note: calculation is based on the monoisotopic mass, not molecular weight.</p>

<?php //echo $this->html->script('Analyses/reagents.js', ['inline' => false]); 
      //echo $this->fetch('script');?>
<form>
<!--<div id="reagent_calc" align="center" style="border:2px solid blue"">-->
    Target Conc (mmol/L):<input type="number" min="0" max="1000" step="1" style="width: 10em;" id="Concentration" name="Concentration"><br>
    Target Volume (mL):<input type="number" min="0" max="1000" step="1" style="width: 10em;" id="Volume" name="Volume"><br><br>
    <!--<button type="button" class="large-button anySizeButton green-button" onclick="myFunction()">Calculate</button><br><br>-->
<!--</div-->
<br>
Quantity Required (g):<output oninput="value=Concentration.value * Volume.value"></output>
<!--<p id="Quan_Required"</p>-->
</form>
<div id="reagent_calc" align="center" style="border:2px solid blue"">
<form onsubmit="return false" oninput="o.value = <?php echo $info['Compound']['exact_mass'] ?> * (parseInt(conc_mmol.value)/1000) * (parseInt(vol_mL.value)/1000)">
    <p>Target Conc (mmol/L):<input name="conc_mmol" type="number" step="any" style="width: 10em;"></p>
    <p>Target Volume &nbsp;(mL):<input name="vol_mL" type="number" step="any" style="width: 10em;"></p>
    <h2>Quantity Required (g):<output name="o"></output></h2>
</form>
</div>
</header>
        

<script>
function myFunction() {
    var conc = calculate(<?php echo $info['Compound']['exact_mass'] ?>,document.getElementById('Concentration').value,document.getElementById('Volume').value);
    document.getElementById("Quan_Required").innerHTML = conc.toPrecision(5);
}

function calculate(mw, conc_mmol, vol_ml){
    return mw * ((conc_mmol/1000) * (vol_ml/1000))
}
</script>
      




