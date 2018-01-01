<?php

App::uses('Editable', 'Controller/Behavior');

/**
 * Class EditVersions
 * @author Andrew McGhie
 */
trait EditableVersions {

    use Editable {
        Editable::edit as parentEdit;
    }

    public function edit() {
        assert($this->getModel() instanceof VersionableModel,
            'The Model has to implement VersionableModel');
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
        $versions = $model->getVersionIds($item['SampleSet']['set_code']);

        $this->set('item', $item);
        $this->set('versions', $versions);
        $this->set('model', get_class($model));
        $this->setEditFormRequirements();

        $this->render('/Elements/edit_versions');
    }
}