<?php
namespace Beer\Form;

use Laminas\Form\Form;

class BeerForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('beers');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'brewery_id',
            'type' => 'number',
            'options' => [
                'label' => 'brewery_id',
            ],
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => 'cat_id',
            'type' => 'number',
            'options' => [
                'label' => 'cat_id',
            ],
        ]);
        $this->add([
            'name' => 'style_id',
            'type' => 'number',
            'options' => [
                'label' => 'Style Id',
            ],
        ]);
        $this->add([
            'name' => 'abv',
            'type' => 'number',
            'options' => [
                'label' => 'ABV'
            ],
            'attributes' => [
                'step' => 'any',
            ]
        ]);
        $this->add([
            'name' => 'ibu',
            'type' => 'number',
            'options' => [
                'label' => 'IBU',
            ],
        ]);
        $this->add([
            'name' => 'srm',
            'type' => 'number',
            'options' => [
                'label' => 'SRM',
            ],
        ]);
        $this->add([
            'name' => 'upc',
            'type' => 'number',
            'options' => [
                'label' => 'UPC',
            ],
        ]);
        $this->add([
            'name' => 'filepath',
            'type' => 'text',
            'options' => [
                'label' => 'Filepath',
            ],
        ]);
        $this->add([
            'name' => 'descript',
            'type' => 'textarea',
            'options' => [
                'label' => 'Descript',
            ],
        ]);
        $this->add([
            'name' => 'add_user',
            'type' => 'number',
            'options' => [
                'label' => 'add_user',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Submit',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}