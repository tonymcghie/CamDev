<?php

App::uses('DataObject', 'Model/DataObject');
App::uses('ViewableModel', 'Model/Behavior');

class CompoundPfrDataObject extends DataObject implements ViewableModel {

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
            'DataViewURL' => ['controller' => 'CompoundpfrData', 'action' => 'view', '?' => ['id' => $this->id]],
            'SetViewURL' => ['controller' => 'CompoundpfrData', 'action' => 'viewSet', '?' => ['reference' => $this->reference]]
        ];
    }
    
    public function getViewData() {


        return [
            'assigned_name' => [
                'text' => $this->assigned_name],
            'cas' => [
                'text' => $this->cas],
            'exact_mass' => [
                'text' => $this->exact_mass],
            'intensity_value' => [
                'text' => $this->intensity_value],
            'intensity_description' => [
                'text' => $this->intensity_description],
            'rt_value' => [
                'text' => $this->rt_value],
            'reference' => [
                'text' => $this->reference],
            'sample_ref' => [
                'text' => $this->sample_ref],
            'sample_description' => [
                'text' => $this->sample_description],
            'crop' => [
                'text' => $this->crop],
            'species' => [
                'text' => $this->species],
            'genotype' => [
                'text' => $this->genotype],
            'tissue' => [
                'text' => $this->tissue],
            'analyst' => [
                'text' => $this->analyst],
            'data_location' => [
                'text' => $this->data_location]];
    }
    // BACKEND

}