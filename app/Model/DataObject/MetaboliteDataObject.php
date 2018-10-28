<?php

App::uses('DataObject', 'Model/DataObject');
App::uses('ViewableModel', 'Model/Behavior');

class MetaboliteDataObject extends DataObject implements ViewableModel {

    /** @var string $actions HTML string of the actions to display in table */
    public $actions;

    protected $immutableFields = ['id'];

    // FRONT END DATA APP . 'View' . DS . 'Helper' . DS

    /**
     * {@inheritdoc}
     *
     * This function returns an array of arrays that contain data to make urls
     * They will be turned into buttons in the view.
     * @return array
     */
    public function getActionData() {
        return [
            'viewURL' => ['controller' => 'Metabolites', 'action' => 'view', '?' => ['id' => $this->id]],
            'editURL' => ['controller' => 'Metabolites', 'action' => 'editMetabolite', '?' => ['id' => $this->id]],
            'loaddocURL' => ['controller' => 'Metabolites', 'action' => 'docsMetabolite', '?' => ['id' => $this->id]],
            'document' => ['path' => $this->document],
            'msmsURL' => ['controller' => 'Metabolites', 'action' => 'addMsms', '?' => ['id' => $this->id]],
            'proposed_idURL' => ['controller' => 'Metabolites', 'action' => 'addProposedid', '?' => ['id' => $this->id]]
        ];
    }
    
    public function getViewData() {
        return [
            'id' => [
                'text' => $this->id],
            'exact_mass' => [
                'text' => $this->exact_mass],
            'ion_type' => [
                'text' => $this->ion_type],
            'rt_value' => [
                'text' => $this->rt_value],
            'rt_description' => [
                'text' => $this->rt_description],
            'sources' => [
                'text' => $this->sources],
            'tissue' => [
                'text' => $this->tissue],
            'chemist' => [
                'text' => $this->chemist],
            'experiment_ref' => [
                'text' => $this->experiment_ref],
            'document' => [
                'text' => $this->document],
            'date' => [
                'text' => $this->date]];
    }
    // BACKEND

}