<?php

App::uses('DataObject', 'Model/DataObject');
App::uses('ViewableModel', 'Model/Behavior');

class ChemistDataObject extends DataObject implements ViewableModel {

    /** @var string $actions HTML string of the actions to display in table */
    public $actions;

    protected $immutableFields = ['id'];

    // FRONT END DATA HELPERS

    /**
     * {@inheritdoc}
     *
     * This function returns an array of arrays that contain data to make urls
     * They will be turned into buttons in the view.
     * @return array
     */
    public function getActionData() {
        return [
            'viewURL' => ['controller' => 'Chemists', 'action' => 'view', '?' => ['id' => $this->id]],
            'editURL' => ['controller' => 'Chemists', 'action' => 'editAnalyst', '?' => ['id' => $this->id]],
            'deleteURL' => ['controller' => 'Chemists', 'action' => 'deleteAnalyst', '?' => ['id' => $this->id]],
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