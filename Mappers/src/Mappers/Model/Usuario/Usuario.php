<?php

namespace Mappers\Model\Usuario;

use Mappers\Model\Usuario\Usuario;

class Usuario
{

    protected $correo = '';

    protected $nombres = '';

    protected $ap_pat = '';

    protected $ap_mat = '';

    protected $fecha_nacimiento = null;

    protected $run = '';

    protected $habilitado = null;

    protected $fecha_expiracion = null;

    protected $password = '';

    protected $email_confirmado = null;

    protected $fecha_registro = null;

    protected $rol_id = null;

    protected $habilita_correo = null;

    protected $verifica_facebook = null;

    protected $id_facebook = null;

    protected $verifica_gmail = null;

    protected $id_gmail = null;

    /**
     * Setea el parametro correo
     *
     * @param string $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    /**
     * Retorna el parametro correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Setea el parametro nombres
     *
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * Retorna el parametro nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Setea el parametro ap_pat
     *
     * @param string $ap_pat
     */
    public function setAp_pat($ap_pat)
    {
        $this->ap_pat = $ap_pat;
    }

    /**
     * Retorna el parametro ap_pat
     *
     * @return string
     */
    public function getAp_pat()
    {
        return $this->ap_pat;
    }

    /**
     * Setea el parametro ap_mat
     *
     * @param string $ap_mat
     */
    public function setAp_mat($ap_mat)
    {
        $this->ap_mat = $ap_mat;
    }

    /**
     * Retorna el parametro ap_mat
     *
     * @return string
     */
    public function getAp_mat()
    {
        return $this->ap_mat;
    }

    /**
     * Setea el parametro fecha_nacimiento
     *
     * @param Zend/Date $fecha_nacimiento
     */
    public function setFecha_nacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * Retorna el parametro fecha_nacimiento
     *
     * @return string
     */
    public function getFecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Setea el parametro run
     *
     * @param string $run
     */
    public function setRun($run)
    {
        $this->run = $run;
    }

    /**
     * Retorna el parametro run
     *
     * @return string
     */
    public function getRun()
    {
        return $this->run;
    }

    /**
     * Setea el parametro habilitado
     *
     * @param string $habilitado
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;
    }

    /**
     * Retorna el parametro habilitado
     *
     * @return string
     */
    public function getHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * Setea el parametro fecha_expiracion
     *
     * @param Zend/Date $fecha_expiracion
     */
    public function setFecha_expiracion($fecha_expiracion)
    {
        $this->fecha_expiracion = $fecha_expiracion;
    }

    /**
     * Retorna el parametro fecha_expiracion
     *
     * @return string
     */
    public function getFecha_expiracion()
    {
        return $this->fecha_expiracion;
    }

    /**
     * Setea el parametro password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Retorna el parametro password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Setea el parametro email_confirmado
     *
     * @param string $email_confirmado
     */
    public function setEmail_confirmado($email_confirmado)
    {
        $this->email_confirmado = $email_confirmado;
    }

    /**
     * Retorna el parametro email_confirmado
     *
     * @return string
     */
    public function getEmail_confirmado()
    {
        return $this->email_confirmado;
    }

    /**
     * Setea el parametro fecha_registro
     *
     * @param Zend/Date $fecha_registro
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    /**
     * Retorna el parametro fecha_registro
     *
     * @return string
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     * Setea el parametro rol_id
     *
     * @param int $rol_id
     */
    public function setRol_id($rol_id)
    {
        $this->rol_id = $rol_id;
    }

    /**
     * Retorna el parametro rol_id
     *
     * @return string
     */
    public function getRol_id()
    {
        return $this->rol_id;
    }

    /**
     * Setea el parametro habilita_correo
     *
     * @param int $habilita_correo
     */
    public function setHabilita_correo($habilita_correo)
    {
        $this->habilita_correo = $habilita_correo;
    }

    /**
     * Retorna el parametro habilita_correo
     *
     * @return string
     */
    public function getHabilita_correo()
    {
        return $this->habilita_correo;
    }

    /**
     * Setea el parametro verifica_facebook
     *
     * @param int $verifica_facebook
     */
    public function setVerifica_facebook($verifica_facebook)
    {
        $this->verifica_facebook = $verifica_facebook;
    }

    /**
     * Retorna el parametro verifica_facebook
     *
     * @return string
     */
    public function getVerifica_facebook()
    {
        return $this->verifica_facebook;
    }

    /**
     * Setea el parametro id_facebook
     *
     * @param int $id_facebook
     */
    public function setId_facebook($id_facebook)
    {
        $this->id_facebook = $id_facebook;
    }

    /**
     * Retorna el parametro id_facebook
     *
     * @return string
     */
    public function getId_facebook()
    {
        return $this->id_facebook;
    }

    /**
     * Setea el parametro verifica_gmail
     *
     * @param int $verifica_gmail
     */
    public function setVerifica_gmail($verifica_gmail)
    {
        $this->verifica_gmail = $verifica_gmail;
    }

    /**
     * Retorna el parametro verifica_gmail
     *
     * @return string
     */
    public function getVerifica_gmail()
    {
        return $this->verifica_gmail;
    }

    /**
     * Setea el parametro id_gmail
     *
     * @param int $id_gmail
     */
    public function setId_gmail($id_gmail)
    {
        $this->id_gmail = $id_gmail;
    }

    /**
     * Retorna el parametro id_gmail
     *
     * @return string
     */
    public function getId_gmail()
    {
        return $this->id_gmail;
    }


}

