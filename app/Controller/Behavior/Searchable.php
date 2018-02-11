<?php

/**
 * This is a trait that should only be applied to AppController classes
 * requires model variable to be set
 * Class Searchable
 */
trait Searchable {

    protected abstract function getModel();

    private function getSearchableComponents() {
        return ['Search', 'Paginator'];
    }


    /**
     * This will search the model for some data based on
     */
    public function search(){
        assert(is_subclass_of($this, 'AppController'),
            'This method must be attacked to a controller');
        assert(in_array('SearchableModel', class_implements($this->getModel())),
            'The model needs to implement SearchableModel');

        $this->set('model', get_class($this->getModel()));
        $this->set('options', $this->getModel()->getSearchOptions());
        $this->helpers[] = 'Mustache.Mustache';

        if (!empty($this->request->query)) {
            $this->Paginator->settings = $this->paginate;
            list($resultObjects, $numResults) = $this->doSearch();

            $this->set('results', $resultObjects);
            $this->set('num', $numResults);
            $this->set('data', $this->request->query);
            $this->set('cols', $this->getModel()->getDisplayColumns());
        }

        $this->autoRender = false;
        $this->render('/Elements/search_page');
    }

    private function doSearch() {
        $query = $this->Search->build_query($this->getModel(), $this->request->query);
        var_dump('Searchable ',$query);
        $results = $this->paginate($this->getModel(), $query);

        $resultObjects = $this->getModel()->buildObjects($results);
        $numResults = $this->getModel()->find('count', ['conditions' => $query]);

        return [$resultObjects, $numResults];
    }
}