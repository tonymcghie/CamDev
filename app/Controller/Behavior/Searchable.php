<?php

/**
 * This is a trait that should only be applied to AppController classes
 * requires model variable to be set
 * Class Searchable
 */
trait Searchable {

    public function getComponents() {
        return ['Search'];
    }


    /**
     * This will search the model for some data based on
     */
    public function doSearch(AppController $controller,
                             AppModel $model){

        $controller->set('model', 'SampleSet');
        $controller->helpers[] = 'Mustache.Mustache';


        if (!empty($controller->request->query)) {
            $query = $controller->Search->build_query($model, $controller->request->query);
            $results = $controller->paginate($model, $query);

            $resultObjects = $model->buildObjects($results);

            $controller->set('cols', $model->getDisplayFields());
            $controller->set('results', $resultObjects);
            $controller->set('num', $model->find('count', ['conditions' => $query]));
            $controller->set('data', $controller->request->query);
        }
        $controller->autoRender = false;
        $controller->render('/SampleSets/search');
    }
}