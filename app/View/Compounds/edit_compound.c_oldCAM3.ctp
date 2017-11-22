<header><h1>Edit Compound Information</h1></header>
<?php
echo $this->Form->create('Compound');
echo $this->My->makeInputRow('cas', [], 'CAS Number:');
echo $this->My->makeInputRow('pub_chem', [], 'PubChem CID:');
echo $this->My->makeInputRow('compound_name', [], 'Compound Name:');
echo $this->My->makeInputRow('pseudonyms', [], 'Synonyms:');
echo $this->My->makeInputRow('sys_name', [], 'Systematic Name:');
echo $this->My->makeInputRow('formula', [], 'Formula (CHNO...):');
echo $this->My->makeInputRow('exact_mass', [], 'Exact (monoisotopic) mass:');
echo $this->My->makeInputRow('chemspider_id', ['type' => 'text'], 'ChemSpider ID:');
echo $this->My->makeInputRow('metlin_id', ['type' => 'text'], 'Metlin ID:');
echo $this->My->makeInputRow('compound_type', [], 'Compound Type:');
echo $this->My->makeInputRow('chemfinder_ref', [], 'ChemFinder Ref:');
echo $this->My->makeInputRow('comment', [], 'Comment:');
echo $this->Form->end(['label' => 'Save', 'class' => 'large-button anySizeButton']);
