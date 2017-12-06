<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 14/01/17
 * Time: 6:18 PM
 */
class BootstrapFormHelper extends FormHelper{
    private $model;
    private $currently_grouping = false;
    private $js = '';
    public $helpers = ['Mustache.Mustache', 'Html'];

    /**
     * Starts a new standard form
     * use normal inputs
     * @param string $model
     * @param array $options
     * @return string
     */
    public function create($model = null, $options = []){
        $this->model = $model;
        $this->js .= 'validators = [];';
        return parent::create($model, $options);
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
        if (!$this->currently_grouping)$options['div']['class'] .= ' form-group row';
        if (!isset($options['type']) || $options['type'] != 'checkbox') {
            $options['class'] .= ' form-control';
        }
        if (isset($options['type']) &&  $options['type'] == 'checkbox')return $this->make_checkbox($fieldName, $options);
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
        if (!isset($options['label']))$options['label'] = '';
        if (gettype($options['label']) == 'array' && !isset($options['label']['class'])) {
            $options['label']['class'] = '';
        } else if(gettype($options['label']) == 'string') {
            $label_text = $options['label'];
            $options['label'] = [];
            $options['label']['class'] = '';
            $options['label']['text'] = $label_text;
        } else if(gettype($options['label']) !== 'boolean') {
            throw new Exception('You are passing somethign that isnt a string or array or false in the $options[\'label\'] index');
        }$options['label']['class'] .= ' control-label col-lg-4';

        if (!isset($options['between']))$options['between'] = '';
        $options['between'] .= '<div class="col-lg-6">';
        if (!isset($options['after'])){
            $options['after'] = '';
        }
        $options['after'] = '</div>'.$options['after'];
        return $this->input($fieldName, $options);
    }

    public function make_checkbox($fieldName, $options = array()) {
        $options['checkbox'] = parent::input($fieldName, ['type' => 'checkbox', 'label' => false, 'div' => false]);
        return $this->_View->Element('form/checkbox', ['options' => $options]);
    }

    public function immediateUpload($fieldName, $options) {
        assert(isset($options['url']), 'The url to send the image to must be set');

        return $this->Mustache->render('form/immediateUpload', [
            'name' => $fieldName,
            'label' => $options['label'],
            'url' => $options['url'],
            'callback' => $options['callback']
            ]);
    }

    /**
     * this creates a button for an inline or normal form
     * @param string $fieldName
     * @param array $options
     * @return string HTML code for the button
     */
    public function single_button($fieldName, $options = [], $button_options = []) {
        $options['type'] = 'button';
        $options['class'] = 'btn '.$button_options['class'];
        $options['label'] = false;
        if (isset($button_options['horizontal']) && $button_options['horizontal']) {
            return $this->input_horizontal($fieldName, $options);
        } else {
            return $this->input($fieldName, $options);
        }
    }

    /**
     * Creates a single link element
     * @param $text
     * @param $url
     * @param array $options
     * @param array $button_options
     * @return string
     */
    public function single_link($text, $url, $options = [], $button_options = []) {
        if (!isset($options['class']))$options['class'] = '';
        $options['class'] .= ' btn btn-default';
        return $this->Html->div($button_options['class'],  $this->Html->link($text, $url, $options), $button_options);
    }

    /**
     * Creates a save and cancel button
     */
    public function addActionButtons() {
        $html = '';
        $html .= $this->start_group();
        $html .= $this->single_button('Cancel', ['onclick' => 'window.history.back();', 'div' => ['class' => 'offset-lg-4 col-lg-1']], ['class' => 'btn-default']);
        $html .= $this->single_button('Save', ['div' => ['class' => 'col-lg-1']], ['class' => 'btn-primary']);
        $html .= $this->end_group();
        return $html;
    }

    /**
     * Adds the javascript for adding a validator
     * @param string $validator name of the validation class
     * @param string $name name of the form element
     * @param array $args options to pass to the validator
     * @return null
     */
    public function add_validator($validator, $name, $args = []){
        $name = "data[$this->model][$name]";
        $args = json_encode($args);
        $this->js .= "validators.push(new $validator('$name', '$args'));";
    }

    /**
     * Adds a new rule to the form such as showing and hiding an element
     * @param $rule
     * @param $base_name
     * @param $rule_element_name
     * @param array $data
     * @param array $options
     * @return string
     */
    public function new_rule($rule, $base_name, $rule_element_name, $data = [], $options = []){ // TODO the parameters passed
        $base_name = "data[$this->model][$base_name]";
        $rule_element_name = "data[$this->model][$rule_element_name]";
        $data = json_encode($data);
        $options = json_encode($options);
        $this->js .= "new $rule('$base_name', '$rule_element_name', '$data', '$options');";
    }

    public function get_js(){
        $html = '';
        $html .= $this->Html->script('typescript/validator/validator.min', ['inline' => false, 'async' => 'async']);
        $html .= $this->Html->script('typescript/form_rules/displayif.min', ['inline' => false, 'async' => 'async']);
        $html .= '<script>'.$this->js.'</script>';
        return $html;
    }

    /**
     * makes the html code for a new inline group
     * @param array $options optional parameters for the div
     * @return string
     * @throws Exception
     */
    public function start_group($options = []){
        if($this->currently_grouping == true)throw new Exception('You are already in a group');
        $this->currently_grouping = true;
        if (!isset($options['class'])) {
            $options['class'] = 'form-group row';
        } else {
            $options['class'] .= ' form-group row';
        }
        $html = '<div';
        foreach ($options as $name => $value){
            $html .= ' ' . $name . '="'.$value.'"';
        }
        $html .= '>';
        return $html;
    }

    /**
     * ends the inline group
     * @return string
     * @throws Exception
     */
    public function end_group(){
        if($this->currently_grouping == false)throw new Exception('You are not in a group');
        $this->currently_grouping = false;
        return '</div>';
    }

    /**
     * Overrides end to make sure that the inline group has being ended before the form gets ended
     * @param null $options
     * @param array $secureAttributes
     * @return string
     * @throws Exception
     */
    public function end($options = null, $secureAttributes = array()) {
        if ($this->currently_grouping){
            throw new Exception('Please exit the current inline group before ending the form');
        }
        return parent::end($options, $secureAttributes);
    }

    /**
     * Takes an array of options for a drop down and sets the one that should be selected.
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