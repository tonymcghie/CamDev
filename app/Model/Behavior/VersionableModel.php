<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 28/12/17
 * Time: 5:37 PM
 */
interface VersionableModel {
    function getVersionKeyColumn();
    function getVersionIds($key);
}