<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Calculate the Quantity for a Solution</h1>
<p style="display:inline">Compound: <?php echo $info['Compound']['compound_name'] ?></p>
<p style="display:inline">Exact Mass: <?php echo $info['Compound']['exact_mass'] ?></p>
<p style="display:inline">Formula: <?php echo $info['Compound']['formula'] ?></p>
</header>
<?php echo $this->html->script('Analyses/reagents.js', ['inline' => false]); 
      echo $this->fetch('script');?>
        <table id="reagentsTable">
            <tr>
                <td><input type="text" placeholder="Compound" id="Compounds"></td>
                <td><input type="text" placeholder="Molecular Weight (mol/g)" id="Mole_Weight"></td>
                <td><input type="text" placeholder="Concentration (mmol/L)" id="Concentration"></td>
                <td><input type="text" placeholder="Volume (mL)" id="Volume"></td>
                <td><input type="text" placeholder="Quantity Required (g)" id="Quan_Required"></td>
            </tr>
        </table>
        <button type="button" class="large-button anySizeButton green-button" onclick="calculate($('reagentsTable'));">Calculate</button>       
        <button type="button" class="large-button anySizeButton green-button" onclick="$('#reagentsTable > ').append(newRow());">Add Row</button>
      




