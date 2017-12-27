<?php

/**
 * Description of Editable
 *
 * @author Andrew McGhie
 */
trait Editable {
    
    protected abstract function getModel();
    
    public function edit() {
        if (!empty($this->request->data)) {
            $this->getModel()->
        }
    }
}
