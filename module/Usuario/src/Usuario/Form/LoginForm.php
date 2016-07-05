<?php

namespace Usuario\Form;

use Zend\Form\Form;

class LoginForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('loginForm');


        $this->add(array(
            'name' => 'usuario',
            'type' => 'text',
            'options' => array(
                'label' => 'Usuario',
            ),
            'attributes' => array(
                "placeholder" => "Ingresa tu nombre de usuario",
                 'id'   => 'usuario',
                "class" => "form-control",
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Contraseña',
            ),
            'attributes' => array(
                "id"    => "password",
                "placeholder" => "Ingresa tu contraseña",
                "class" => "form-control",
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'remember',
            'options' => array(
                'label' => 'A checkbox',
                'use_hidden_element' => true,
                'checked_value' => 'good',
                'unchecked_value' => 'bad'
            ),
            'attributes' => array(
                'id' => 'remember'
            )
        ));

        $this->add(array(
            'name' => 'enviar',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Ingresa',
            ),
            'attributes' => array(
                'id' => 'enviar',
                "class" => "btn btn-primary",
            ),
        ));
    }

}
