<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 14/01/17
 * Time: 6:18 PM
 */
class BootstrapFormHelper extends FormHelper{
    private $model;

    /**
     * Starts a new standard form
     * use normal inputs
     * @param string $model
     * @param array $options
     * @return string
     */
    public function create($model = null, $options = []){
        $this->model = $model;
        return parent::create($model, $options).'<script>validators = [];</script>';
    }

    /**
     * Starts a new form where all the elements will be inline
     * use normal inputs
     * @param null $model
     * @param array $options
     * @return string
     */
    public function create_inline($model = null, $options = []) {
        if (!isset($options['class'])){
            $options['class'] = '';
        }
        $options['class'] .= ' form-inline';
        return $this->create($model, $options);
    }

    /**
     * Starts a new form where the elements will be next to their labels rather than below them
     * use horizontal inputs
     * @param string $model
     * @param array $options
     * @return string
     */
    public function create_horizontal($model = null, $options = []) {
        if (!isset($options['class'])){
            $options['class'] = '';
        }
        $options['class'] .= ' form-horizontal';
//        $options['enctype'] = "m"
        return $this->create($model, $options);
    }

    /**
     * Uses the bs_form_options to decide which form element to create
     * @param string $fieldName
     * @param array $options
     * @param array $bs_form_options
     * @return string
     */
    public function input_maker($fieldName, $options = [], $bs_form_options = []){
        if (isset($bs_form_options['horizontal']) && $bs_form_options['horizontal']){
            if (isset($bs_form_options['type']) && $bs_form_options['type'] == 'button'){
                return $this->single_button($fieldName, $options, ['horizontal' => true, 'class' => 'btn-primary']);
            } else {
                return $this->input_horizontal($fieldName, $options);
            }
        }
        if (isset($bs_form_options['type']) && $bs_form_options['type'] == 'button'){
            return $this->single_button($fieldName, $options,  ['horizontal' => false, 'class' => 'btn-primary']);
        } else {
            return $this->input($fieldName, $options);
        }
    }

    /**
     * Creates a standard element and adds the bootstrap classes to style it
     * TO be used in normal forms and inline forms
     * @param string $fieldName
     * @param array $options
     * @return string
     */
    public function input($fieldName, $options = []) {
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

    /**
     * Creats a form element where the label is beside the input
     * This should be used in a horizontal form
     * @param $fieldName
     * @param array $options
     * @return string
     */
    public function input_horizontal($fieldName, $options = []) {
        if (!isset($options['label'])) {
            $options['label'] = '';
        }
        if (gettype($options['label']) == 'array' && !isset($options['label']['class'])) {
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

    /**
     * this creates a button for an inline or normal form
     * @param string $fieldName
     * @param array $options
     * @return string HTML code for the button
     */
    public function single_button($fieldName, $options = [], $button_options = []){
        $options['type'] = 'button';
        $options['class'] = 'btn '.$button_options['class'];
        if (isset($button_options['horizontal']) && $button_options['horizontal']) {
            return $this->input_horizontal($fieldName, $options);
        } else {
            return $this->input($fieldName, $options);
        }
    }

    /**
     * Returns the javascript for adding a validator
     * @param string $validator name of the validation class
     * @param string $name name of the form element
     * @param array $args options to pass to the validator
     * @return string
     */
    public function add_validator($validator, $name, $args = []){
        $name = "data[$this->model][$name]";
        $args = json_encode($args);
        return "<script>validators.push(new $validator('$name', '$args'));</script>";
    }

    public function display_if_checked($base_name, $rule_element_name){
        $base_name = "data[$this->model][$base_name]";
        $rule_element_name = "data[$this->model][$rule_element_name]";
        return "<script>new display_if_checked('$base_name', '$rule_element_name')</script>";
    }
    public function display_if_equals($base_name, $rule_element_name, $value){

    }
    public function display_if_not_equals($base_name, $rule_element_name, $value){

    }
}