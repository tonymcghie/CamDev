<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 25/11/17
 * Time: 11:06 AM
 */
interface SearchableModel {
    public function getSearchOptions();
    public function getDisplayColumns();
    public function buildObjects(array $queryResults);
}