<?php

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