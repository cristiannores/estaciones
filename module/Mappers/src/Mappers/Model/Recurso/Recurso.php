<?php

namespace Mappers\Model\Recurso;

use Mappers\Model\Recurso\Recurso;

class Recurso
{

    protected $id = null;

    protected $nombre = '';

    protected $controller = '';

    protected $action = '';

    protected $es_menu = null;

    protected $recurso_id = null;

    protected $titulo_menu = '';

    protected $imagen = '';

    protected $clase = '';

    /**
     * Setea el parametro id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Retorna el parametro id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setea el parametro nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Retorna el parametro nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Setea el parametro controller
     *
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Retorna el parametro controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Setea el parametro action
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Retorna el parametro action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Setea el parametro es_menu
     *
     * @param string $es_menu
     */
    public function setEs_menu($es_menu)
    {
        $this->es_menu = $es_menu;
    }

    /**
     * Retorna el parametro es_menu
     *
     * @return string
     */
    public function getEs_menu()
    {
        return $this->es_menu;
    }

    /**
     * Setea el parametro recurso_id
     *
     * @param int $recurso_id
     */
    public function setRecurso_id($recurso_id)
    {
        $this->recurso_id = $recurso_id;
    }

    /**
     * Retorna el parametro recurso_id
     *
     * @return string
     */
    public function getRecurso_id()
    {
        return $this->recurso_id;
    }

    /**
     * Setea el parametro titulo_menu
     *
     * @param string $titulo_menu
     */
    public function setTitulo_menu($titulo_menu)
    {
        $this->titulo_menu = $titulo_menu;
    }

    /**
     * Retorna el parametro titulo_menu
     *
     * @return string
     */
    public function getTitulo_menu()
    {
        return $this->titulo_menu;
    }

    /**
     * Setea el parametro imagen
     *
     * @param string $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    /**
     * Retorna el parametro imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Setea el parametro clase
     *
     * @param string $clase
     */
    public function setClase($clase)
    {
        $this->clase = $clase;
    }

    /**
     * Retorna el parametro clase
     *
     * @return string
     */
    public function getClase()
    {
        return $this->clase;
    }


}

