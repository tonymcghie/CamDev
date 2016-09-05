<header>
<h1>Edit Unknown Compound</h1>
</header>
<?php
echo $this->Form->create('Metabolite');
echo $this->Form->input('id',['type' => 'hidden']);
echo $this->My->makeInputRow('exact_mass', [], 'Exact Mass');
echo $this->My->makeInputRow('ion_type', [], 'Ion Type');
echo $this->My->makeInputRow('rt_value', [], 'Retention Value');
echo $this->My->makeInputRow('rt_description', [], 'Retention Description');
echo $this->My->makeInputRow('sources', [], 'Sources');
echo $this->My->makeInputRow('tissue', [], 'Tissue');
echo $this->My->makeInputRow('chemist', [], 'Chemist');
echo $this->My->makeInputRow('experiment_ref', [], 'Experiment Reference');
echo $this->My->makeInputRow('spectra_uv', ['rows' => '3'], 'UV/vis Spectra');
echo $this->My->makeInputRow('spectra_nmr', ['rows' => '3'], 'NMR Spectra');
echo $this->My->makeInputRow('start_date', [], 'Start Date');
echo $this->Form->end(['label' => 'Save Metabolite', 'class' => 'large-button anySizeButton']);
