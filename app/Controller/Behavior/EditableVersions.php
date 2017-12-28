<?php

/**
 * Class EditVersions
 * @author Andrew McGhie
 */
trait EditableVersions {

    protected abstract function getModel();

    protected abstract function setEditFormRequirements();

    protected abstract function doSave($item);

    public function edit() {
        if (empty($this->request->query['id'])) {
            throw new Exception("The id parameter was not set");
        }
        assert($this->getModel() instanceof VersionableModel, 'The Model has to implement VersionableModel');
        $id = $this->request->query['id'];
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