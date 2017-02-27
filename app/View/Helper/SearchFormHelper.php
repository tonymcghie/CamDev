<?php


/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 21/02/17
 * Time: 6:58 PM
 */
class SearchFormHelper extends AppHelper {
    public $helpers = ['BootstrapForm'];

    /** @var array The list of categories and values to make a select out of */
    private $category_options = [];
    /** @var array The list of logic options that the select will display */
    private $logic_options = ['AND' => 'and', 'OR' => 'or', 'XOR' => 'xor', 'NOT' => 'not'];
    /** @var array The array of options that the match select will display */
    private $match_options = ['contains' => 'Contains', 'exact' => 'exactly', 'starts' => 'Start with'];
    /** @var int The number of groups to show when rendering */
    private $groups = 1;
    /** @var string The title that will be displayed at the top of the page */
    private $title = '';
    /** @var string The model that the search form uses */
    private $model = '';

    /**
     * Sets the options to display in the search form.
     * @param $options
     */
    public function set_options($options){
        $this->category_options = $options;
    }

    /**
     * This sets the number of groups to initially display
     * @param int $num_groups
     */
    public function set_groups($num_groups){
        $this->groups = $num_groups;
    }

    /**
     * Sets the model that the search form uses
     * @param $model
     */
    public function set_model($model){
        $this->model = $model;
    }

    /**
     * Sets the title to show at the top of the page
     * @param $title
     */
    public function set_title($title){
        $this->title = $title;
    }

    /**
     * Returns the HTML for the search form
     * @return String html code
     */
    public function render($model = ''){
        if (!empty($model))$this->model = $model;
        if ($this->model == '')throw new Exception('You need to set the model before rendering');
        $html = empty($this->title) ? '' : "<h1>$this->title</h1>";
        $html .= $this->BootstrapForm->create($this->model, ['action' => 'search', 'class' => 'search-form']);

        $html .= $this->BootstrapForm->start_group(['id' => 'search-set', 'class' => 'search-set']);
        $html .= $this->BootstrapForm->input_maker('criteria', ['type' => 'select', 'options' => $this->category_options, 'div' => ['class' => 'col-lg-3']]);
        $html .= $this->BootstrapForm->input_maker('value', ['type' => 'text', 'div' => ['class' => 'col-lg-3']]);
        $html .= $this->BootstrapForm->input_maker('logic', ['type' => 'select', 'options' => $this->logic_options, 'div' => ['class' => 'col-lg-3']]);
        $html .= $this->BootstrapForm->input_maker('match', ['type' => 'select', 'options' => $this->match_options, 'div' => ['class' => 'col-lg-3']]);
        $html .= $this->BootstrapForm->end_group();

        $html .= $this->BootstrapForm->start_group(['id' => 'action-buttons', 'class' => 'search-action-buttons']);
        $html .= $this->BootstrapForm->single_button('Add Set', ['onclick' => 'add_search_set();return false;'], ['class' => 'btn-success col-lg-1']);
        $html .= $this->BootstrapForm->single_button('Search', ['onclick' => 'submit_first_form(\'search-results\'); return false;'], ['class' => 'btn-primary col-lg-1']);
        $html .= $this->BootstrapForm->end_group();
        $html .= $this->BootstrapForm->end();

        $html .= '<script>set_listeners();</script>';

        return $html;
    }

}