<?php

/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 10/2/18
 * Time: 11:06 AM
 */
interface OverviewableModel {
    public function getOverviewOptions();
    public function getOverviewDisplayColumns();
    //public function buildObjects(array $queryResults);
}