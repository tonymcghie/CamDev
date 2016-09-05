<h1>Edit Proposed ID</h1>
<?php
echo $this->Form->create('Proposed_Metabolite');
echo $this->Form->input('id',['type' => 'hidden']);
echo $this->My->makeInputRow('metabolite_id', ['type' => 'number'], 'ID');
echo $this->My->makeInputRow('name', [], 'Name (annotation)');
echo $this->My->makeInputRow('formula', [], 'Formula');
echo $this->My->makeInputRow('mass_diff', [], 'Mass difference (mDa)');
echo $this->My->makeInputRow('msigma', [], 'Isotope abundance (msigma)');
echo $this->My->makeInputRow('data_file', [], 'Data file');
echo $this->My->makeInputRow('comment', ['rows' => '3'], 'Comment');
echo $this->Form->end(['label' => 'Save Proposed ID', 'class' => 'large-button anySizeButton green-button']);
