<?php
/**
 * A Behaviour that sets up the View to display record data.
 * The 'id' is passed from the search results, the data for this 'id' is 
 * obtained from the appropriate data table (model) and built into objects.
 * Finally the data are displayed in a view.
 * Note the fields displayed as listed in modelDataObject/getViewData
 */

trait Viewable {
    protected abstract function getModel();

    public function view() {
        $id = $this->params['url']['id'];
        $item = $this->getModel()->findById($id);
        $dataObject = $this->getModel()->buildObjects([$item])[0];
        $this->set('dataObject', $dataObject);
        $this->render('/Elements/view/view');
    }
}