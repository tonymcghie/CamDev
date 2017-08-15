
<header>
<h1>New Unknown Compound</h1>
</header>
<div class="add-metabolite">
<?php
$ionType_options = ['[M-H]-' => '[M-H]-', '[2M-H]-' => '[2M-H]-', '[M+HCOOH-H]-' => '[M+HCOOH-H]-','[M+H]+' => '[M+H]+',
    '[2M+H]+' => '[2M+H]+', '[M+Na]+' => '[M+Na]+','[M+K]+' => '[M+K]+'];
$this->start('Metabolite');
echo $this->Form->create('Metabolite');
echo "<h2>Add Unknown Compound</h2>";
echo $this->My->makeInputRow('exact_mass', [], 'Exact Mass');
echo $this->My->makeInputRow('ion_type', ['options' => $ionType_options], 'Ion Type');
echo $this->My->makeInputRow('rt_value', [], 'Retention Value');
echo $this->My->makeInputRow('rt_description', [], 'Retention Description');
echo $this->My->makeInputRow('sources', [], 'Sources');
echo $this->My->makeInputRow('tissue', [], 'Tissue');
echo $this->My->makeInputRow('chemist', [], 'Chemist');
echo $this->My->makeInputRow('experiment_ref', [], 'Experiment Reference');
echo $this->My->makeInputRow('spectra_uv', ['rows' => '3'], 'UV/vis Spectra');
echo $this->My->makeInputRow('spectra_nmr', ['rows' => '3'], 'NMR Spectra');
echo $this->My->makeInputRow('date', [], 'Date');
echo $this->Form->end(['label' => 'Save Unknown Compound', 'class' => 'large-button anySizeButton']);
$this->end();
$this->start('ProMetabolite');
echo $this->Form->create('Proposed_Metabolite');
echo "<h2>Add Proposed Unknown Compound</h2>";
echo $this->My->makeInputRow('metabolite_id', ['type' => 'number'], 'ID');
echo $this->My->makeInputRow('name', [], 'Name (annotation)');
echo $this->My->makeInputRow('formula', [], 'Formula');
echo $this->My->makeInputRow('mass_diff', [], 'Mass difference (mDa)');
echo $this->My->makeInputRow('msigma', [], 'Isotope abundance (msigma)');
echo $this->My->makeInputRow('data_file', [], 'Data file');
echo $this->My->makeInputRow('comment', ['rows' => '3'], 'Comment');
echo $this->Form->end(['label' => 'Save Proposed ID', 'class' => 'large-button anySizeButton']);
$this->end();
$this->start('MsmsMetabolite');
echo $this->Form->create('Msms_Metabolite');
echo "<h2>Add Msms Unknown Compound</h2>";
echo $this->My->makeInputRow('metabolite_id', ['type' => 'number'], 'ID');
echo $this->My->makeInputRow('name', [], 'Name (annotation');
echo $this->My->makeInputRow('parent_mz', [], 'Parent m/z');
echo $this->My->makeInputRow('energy_ev', [], 'Energy (eV)');
echo $this->My->makeInputRow('charge', [], 'Charge (pos/neg)');
echo $this->My->makeInputRow('msms_level', [], 'MSMS Level');
echo $this->My->makeInputRow('spectra_msms', [], 'MSMS Spectra');
echo $this->My->makeInputRow('comment', ['rows' => '3'], 'Comment');
echo $this->Form->end(['label' => 'Save MSMS', 'class' => 'large-button anySizeButton']);
$this->end();

if ($tabletView !== 'true'){ //draw the blocks if not tablet view
    echo $this->fetch('Metabolite');
    echo $this->fetch('ProMetabolite');
    echo $this->fetch('MsmsMetabolite');
}
?>
</div>
