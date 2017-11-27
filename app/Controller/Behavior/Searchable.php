<?php

/**
 * This is a trait that should only be applied to AppController classes
 * requires model variable to be set
 * Class Searchable
 */
trait Searchable {

    protected abstract function getModel();

    private function getComponents() {
        return ['Search'];
    }


    /**
     * This will search the model for some data based on
     */
    public function search(){
        assert(is_subclass_of($this, 'AppController'),
            'This method must be attacked to a controller');
        assert(in_array('SearchableModel', class_implements($this->getModel())),
            'The model needs to implement SearchableModel');
        $this->doSearch($this, $this->getModel());
    }

    private function doSearch(AppController $controller,
                              AppModel $model) {
        $controller->set('model', get_class($model));
        $controller->helpers[] = 'Mustache.Mustache';
        $controller->set('options', $model->getSearchOptions());

        if (!empty($controller->request->query)) {
            $query = $controller->Search->build_query($model, $controller->request->query);
            $results = $controller->paginate($model, $query);

            $resultObjects = $model->buildObjects($results);

            $controller->set('results', $resultObjects);
            $controller->set('num', $model->find('count', ['conditions' => $query]));
            $controller->set('data', $controller->request->query);
            $controller->set('cols', $model->getDisplayColumns());
        }

        $controller->autoRender = false;
        $controller->render('/Elements/search_page');
    }
}