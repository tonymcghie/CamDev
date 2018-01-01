<?php

/**
 * Description of Editable
 *
 * @author Andrew McGhie
 */
trait Editable {

    protected abstract function setEditFormRequirements();

    /**
     * @param $item
     * @return int the id of the row that the data was saved to
     */
    protected abstract function doSave($item);

    protected abstract function getModel();
    
    public function edit() {
        if (!empty($this->request->data)) {
//            $this->getModel()->
        }
    }
}
