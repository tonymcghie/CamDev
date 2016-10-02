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
<div id="reagent_calc" align="center" style="border:2px solid blue"">
    Target Conc (mmol/L):<input type="number" min="0" max="1000" step="1" value="100" style="width: 10em;" id="Concentration"><br>
    Target Volume (mL):<input type="number" min="0" max="1000" step="1" value="100" style="width: 10em;" id="Volume"><br><br>
    <button type="button" class="large-button anySizeButton green-button" onclick="myFunction()">Calculate</button><br><br>
</div
<br>
<p>Quantity Required (g):</p>
<p id="Quan_Required"</p>
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
      




