<?php

class User
{

    protected $firstname;

    protected $lastname;

    protected $username;

    protected $email;

    protected $password;

    protected $errors;

    public function __construct($firstname = null, $lastname = null, $username = null, $email = null, $password = null)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @param string $username
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     *
     * @param string $username
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     *
     * @param string $username
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = hash("sha512", $password);
    }
}