<h1>Edit Msms</h1>
<?php
echo $this->Form->create('Msms_Metabolite');
echo $this->Form->input('id',['type' => 'hidden']);
echo $this->My->makeInputRow('metabolite_id', ['type' => 'number'], 'ID');
echo $this->My->makeInputRow('name', [], 'Name (annotation');
echo $this->My->makeInputRow('parent_mz', [], 'Parent m/z');
echo $this->My->makeInputRow('energy_ev', [], 'Energy (eV)');
echo $this->My->makeInputRow('charge', [], 'Charge (pos/neg)');
echo $this->My->makeInputRow('msms_level', [], 'MSMS Level');
echo $this->My->makeInputRow('spectra_msms', [], 'MSMS Spectra');
echo $this->My->makeInputRow('comment', ['rows' => '3'], 'Comment');
echo $this->Form->end(['label' => 'Save MSMS', 'class' => 'large-button anySizeButton green-button']);
