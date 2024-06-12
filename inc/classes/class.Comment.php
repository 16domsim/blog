<?php

class Comment
{

    protected $content;
    
    protected $userName;


    public function __construct($content = null, $username=null)
    {
        $this->content = $content;
    }

    /**
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     *
     * @param string $username
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     *
     * @param string $username
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
}