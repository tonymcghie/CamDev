<?php

App::uses('DataObject', 'Model/DataObject');
App::uses('ViewableModel', 'Model/Behavior');

class SampleSetDataObject extends DataObject implements ViewableModel {

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
            'viewURL' => ['controller' => 'SampleSets', 'action' => 'view', '?' => ['id' => $this->id]],
            'editURL' => ['controller' => 'SampleSets', 'action' => 'edit', '?' => ['id' => $this->id]],
            'analysisURL' => ['controller' => 'Analyses', 'action' => 'newAnalysis','?' => ['set_code' =>  $this->set_code]]
        ];
    }

    public function getViewData() {
        // Hack cause the model associations wont work canse the sampleSets table is not setup right
        $analyses = $this->model->Analysis->find('all', ['conditions' => ['set_code' => $this->set_code]]);
        $analysisItems = [];
        foreach ($analyses as $index => $analysis) {
            $analysisItems[$analysis['Analysis']['title']] = [
                'links' => [
                    [
                        'text' => [
                            'id' => 'processedDataFile',
                            'set' => 'Analysis'
                        ],
                        'url' => $analysis['Analysis']['derived_results']
                        //'url' => 'data/files/analysis/' . $analysis['Analysis']['derived_results'] //removed to get correct urls for processedDataFile
                    ],
                    [
                        'text' => [
                            'id' => 'resultsDataFile',
                            'set' => 'Analysis'
                        ],
                        'url' => $analysis['Analysis']['processed']
                        //'url' => 'data/files/analysis/' . $analysis['Analysis']['processed'] //removed to get correct urls for resultsDataFile (Additional)
                    ]
                ]
            ];
        }
        
        $DataFileLink =[];
        $DataFileLink['metaData'] = [
            'links' => [
                    'text' => 'metaData File',
                    'url' =>$this->metaFile
            ]
        ];
        //var_dump($analysisItems['Analysis_One']);
        //var_dump($metaDataFileLink);
        
        $data = [
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
            'set_reason' => [
                'text' => $this->set_reason],
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
            //'metaFile' => [
            //    'text' => $this->metaFile],
            'status' => [
                'text' => $this->status]
        ];
        return array_merge($data, $analysisItems, $DataFileLink);
    }

    // BACKEND

}
