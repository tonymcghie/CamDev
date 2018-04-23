<?php

class Chemist extends AppModel{

    /**
     * Finds the id of the Analyst and generates a new setcode based on
     * the Analysts name_code and an incrementing number.
     * Ensures that all setcode are unique.
     * If no chemist is found then it will return false
     *
     * @param string $chemistName the name of the chemist to search the database for
     *
     * @return stdClass|False [id, name, team, email, setcode]
     */
    
    public function nextSamplesetInfo($chemistName) {
        $chemist = $this->find('first', ['fields' => ['Chemist.id', 'Chemist.team', 'Chemist.name_code', 'Chemist.email'],
            'conditions' => ['name' => $chemistName]]);
        if ($chemist == null)return false;
        $SampleSet = ClassRegistry::init('SampleSet');
        $numOfNextSetCode = 1 + intval($SampleSet->query(
            "SELECT MAX(CAST(SUBSTRING(`set_code` FROM 3 FOR 5)AS UNSIGNED)) AS `set_code`
              FROM {$this->getDataSource()->config['database']}.sample_sets as SampleSet
              WHERE `set_code` LIKE '{$chemist['Chemist']['name_code']}%';")
            [0][0]['set_code']);

        $chemistData = new stdClass();
        $chemistData->id = $chemist['Chemist']['id'];
        $chemistData->name = $chemistName;
        $chemistData->team = $chemist['Chemist']['team'];
        $chemistData->email = $chemist['Chemist']['email'];
        $chemistData->nextSetCode = $chemist['Chemist']['name_code'].$numOfNextSetCode;
        return $chemistData;
    }
}