<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 19/11/17
 * Time: 4:44 PM
 */
class SearchFormHelper extends AppHelper{

    /**
     * @param array $options
     * @param string $initalValue
     * @return array
     */
    public function setSelectedValue($options, $initalValue) {
        assert(array_filter($options, function ($row) use ($initalValue) {return $row['value'] == $initalValue;}),
            'The inital value was not found in the options or there were duplaicated');
        foreach ($options as &$option) {
            if ($initalValue == $option['value']) {
                $option['selected'] = true;
            }
        }
        return $options;
    }
}