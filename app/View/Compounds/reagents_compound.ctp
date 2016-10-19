<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<style>
body {
	padding:2em;
	font-family:Georgia;
	font-size:1em;
}

form{
	background:#fff7db;
	padding:1em;
	width:800px;
}

label {
	display:inline-block;
	width:250px;
	text-align:right;
}

input {
	display:inline-block;
	width:40px;
	margin:0 1em;
	padding:2px 3px;
	border-radius:3px;
	border:1px solid #ccc;
	font-size:1em;
}

legend {
	font-weight:bold;
}

p:last-of-type {
	margin-left:67px;
	font-weight:bold;
}

strong {
	margin-left:0.9em;
}
</style>
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
<!--<form>
<!--<div id="reagent_calc" align="center" style="border:2px solid blue"">-->
    <!--Target Conc (mmol/L):<input type="number" min="0" max="1000" step="1" style="width: 10em;" id="Concentration" name="Concentration"><br>
    Target Volume (mL):<input type="number" min="0" max="1000" step="1" style="width: 10em;" id="Volume" name="Volume"><br><br>
    <!--<button type="button" class="large-button anySizeButton green-button" onclick="myFunction()">Calculate</button><br><br>-->
<!--</div-->
<!--<br>
Quantity Required (g):<output oninput="value=Concentration.value * Volume.value"></output>
<!--<p id="Quan_Required"</p>
</form>-->
<div id="reagent_calc" align="center" style="border:2px solid blue"">
<form onsubmit="return false" oninput="o.value = <?php echo $info['Compound']['exact_mass'] ?> * (parseInt(conc_mmol.value)/1000) * (parseInt(vol_mL.value)/1000)">
    <p><label for="conc_mmol">Target Conc (mmol/L):</label>
        <input name="conc_mmol" type="number" step="any" style="width: 10em;"></p>
    <p><label for="vol_mL">Target Volume (mL):</label>
    <input name="vol_mL" type="number" step="any" style="width: 10em;"></p>
    <p style="display:inline"><label for="o">Weight Required (g):</label><output name="o"></output></p>
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
      




