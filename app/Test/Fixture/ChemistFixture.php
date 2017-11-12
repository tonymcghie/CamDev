<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 21/07/17
 * Time: 7:47 PM
 */
class ChemistFixture extends CakeTestFixture {
    public $import = 'Chemist';
    public $useDbConfig = 'test';
    public $records = [
        [
            'id' => 1,
            'name' => 'test_name',
            'team' => 'test_team',
            'name_code' => 'tn',
            'location' => 'test_location',
            'ext_number' => 1234,
            'email' => 'test@test.test'
        ]
    ];
}