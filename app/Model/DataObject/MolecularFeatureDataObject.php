<?php

App::uses('DataObject', 'Model/DataObject');
App::uses('ViewableModel', 'Model/Behavior');

class MolecularFeatureDataObject extends DataObject implements ViewableModel {

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
            'DataViewURL' => ['controller' => 'MolecularFeatures', 'action' => 'view', '?' => ['id' => $this->id]],
            'SetViewURL' => ['controller' => 'MolecularFeatures', 'action' => 'viewSet', '?' => ['experiment_reference' => $this->experiment_reference]]
        ];
    }

    public function getViewData() {
        return [
            'feature_tag' => [
                'text' => $this->feature_tag],
            'feature_id' => [
                'text' => $this->feature_id],
            'id_confidence' => [
                'text' => $this->id_confidence],
            'mz' => [
                'text' => $this->mz],
            'ion_polarity' => [
                'text' => $this->ion_polarity],
            'intensity' => [
                'text' => $this->intensity],
            'ms_instrument_loc' => [
                'text' => $this->ms_instrument_loc],
            'retention_time' => [
                'text' => $this->retention_time],
            'chromatography_description' => [
                'text' => $this->chromatography_description],
            'experiment_reference' => [
                'text' => $this->experiment_reference],
            'sample_reference' => [
                'text' => $this->sample_reference],
            'sample_description' => [
                'text' => $this->sample_description],
            'crop' => [
                'text' => $this->crop],
            'genus_species' => [
                'text' => $this->genus_species],
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