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
        if ($this->request->is('post')) {
            $id = $this->doSave($this->request->data);
            assert (filter_var($id, FILTER_VALIDATE_INT) && $id > 0,
                "The value returned from doSave was not the new id");
        }
        if (empty($this->request->query['id']) && !isset($id)) {
            throw new Exception("The id parameter was not set");
        }
        if (!isset($id)) {
            $id = $this->request->query['id'];
        }

        $model = $this->getModel();
        $item = $model->find('first', ['conditions' => ['id' => $id]]);

        $this->set('item', $item);
        $this->set('model', get_class($model));
        $this->setEditFormRequirements();

        $this->render('/Elements/edit');
    }
}
