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
        ];
    }
    
    public function getViewData() {
        return [
            'id' => [
                'text' => $this->id],
            'name' => [
                'text' => $this->name],
            'type' => [
                'text' => $this->type],
            'team' => [
                'text' => $this->team],
            'name_code' => [
                'text' => $this->name_code],
            'location' => [
                'text' => $this->location],
            'ext_number' => [
                'text' => $this->ext_number],
            'email' => [
                'text' => $this->email],
            'status' => [
                'text' => $this->status]];
    }
    // BACKEND

}