<?php

class Plan {
    private string $_token = "", $_fall, $_winter, $_spring, $_summer;

    public function __construct(){
        $this->_token = "";
        $this->_fall = "";
        $this->_winter = "";
        $this->_summer = "";
        $this->_spring = "";
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->_token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->_token = $token;
    }

    /**
     * @return string
     */
    public function getFall(): string
    {
        return $this->_fall;
    }

    /**
     * @param string $fall
     */
    public function setFall(string $fall): void
    {
        $this->_fall = $fall;
    }

    /**
     * @return string
     */
    public function getWinter(): string
    {
        return $this->_winter;
    }

    /**
     * @param string $winter
     */
    public function setWinter(string $winter): void
    {
        $this->_winter = $winter;
    }

    /**
     * @return string
     */
    public function getSpring(): string
    {
        return $this->_spring;
    }

    /**
     * @param string $spring
     */
    public function setSpring(string $spring): void
    {
        $this->_spring = $spring;
    }

    /**
     * @return string
     */
    public function getSummer(): string
    {
        return $this->_summer;
    }

    /**
     * @param string $summer
     */
    public function setSummer(string $summer): void
    {
        $this->_summer = $summer;
    }
}