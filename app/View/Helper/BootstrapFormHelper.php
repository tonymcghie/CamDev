<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 14/01/17
 * Time: 6:18 PM
 */
class BootstrapFormHelper extends FormHelper{

    public function create($model = null, $options = array()){
        return parent::create($model, $options);
    }
    public function create_inline($model = null, $options = array()){
        if (!isset($options['class'])){
            $options['class'] = '';
        }
        $options['class'] .= ' form-inline';
        return parent::create($model, $options);
    }
    public function create_horizontal($model = null, $options = array()){
        if (!isset($options['class'])){
            $options['class'] = '';
        }
        $options['class'] .= ' form-horizontal';
        return parent::create($model, $options);
    }

    public function input($fieldName, $options = []){
        if (!isset($options['div'])){
            $options['div'] = [];
        }
        if (!isset($options['div']['class'])){
            $options['div']['class'] = '';
        }
        if (!isset($options['class'])){
            $options['class'] = '';
        }

        $options['div']['class'] .= ' form-group row';
        if (!isset($options['type']) || $options['type'] != 'checkbox') {
            $options['class'] .= ' form-control';
        }
        return parent::input($fieldName, $options);
    }
    public function input_horizontal($fieldName, $options = []){
        if (gettype($options['label']) == 'array' && !isset($options['label']['class'])){
            $options['label']['class'] = '';
        } else if(gettype($options['label']) == 'string') {
            $label_text = $options['label'];
            $options['label'] = [];
            $options['label']['class'] = '';
            $options['label']['text'] = $label_text;
        } else {

        }
        if (isset($options['label'])){
            $options['label']['class'] .= ' control-label col-lg-4';
        }
        if (!isset($options['between'])){
            $options['between'] = '';
        }
        $options['between'] .= '<div class="col-lg-6">';
        if (!isset($options['after'])){
            $options['after'] = '';
        }
        $options['after'] = '</div>'.$options['after'];
        return $this->input($fieldName, $options);
    }
}