<?php

App::uses('DataObject', 'Model/DataObject');
App::uses('ViewableModel', 'Model/Behavior');

class SampleSetDataObject extends DataObject implements ViewableModel {

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
            'viewURL' => ['controller' => 'SampleSets', 'action' => 'details', '?' => ['id' => $this->id]],
            'editURL' => ['controller' => 'SampleSets', 'action' => 'editSet', '?' => ['id' => $this->id]],
            'analysisURL' => ['controller' => 'Analyses', 'action' => 'editAnalysis','?' => ['set_code' =>  $this->set_code]]
        ];
    }

    public function getViewData() {


        return [
            'submitter' => [
                'text' => $this->submitter],
            'submitter_email' => [
                'text' => $this->submitter_email],
            'team' => [
                'text' => $this->team],
            'chemist' => [
                'text' => $this->chemist],
            'set_code' => [
                'text' => $this->set_code],
            'type' => [
                'text' => $this->type],
            'crop' => [
                'text' => $this->crop],
            'sample_number' => [
                'text' => $this->number],
            'p_name' => [
                'text' => $this->p_name],
            'p_code' => [
                'text' => $this->p_code],
            'exp_reference' => [
                'text' => $this->exp_reference],
            'compounds' => [
                'text' => $this->compounds],
            'comments' => [
                'text' => $this->comments],
            'date' => [
                'text' => $this->date],
            'sample_loc' => [
                'text' => $this->sample_loc],
            'containment' => [
                'text' => $this->containment],
            'containment_details' => [
                'text' => $this->containment_details],
            'metaFile' => [
                'text' => $this->metaFile],
            'status' => [
                'text' => $this->status]];
    }

    // BACKEND

}