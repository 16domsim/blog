<?php

class Blog
{

    public const MAX_IMAGE_SIZE = 1048576;

    protected $title;

    protected $content;

    protected $userName;

    protected $imageTypes = array();

    protected $imageSizes = array();

    protected $images = array();

    protected $imageId = 0;

    protected $commentId = 0;

    protected $errors;

    protected $comment = array();

    public function __construct($title = null, $content = null, $userName = null, $imageTypes = null, $imageSizes = null, $images = null, $comment=null)
    {
        $this->firstname = $title;
        $this->content = $content;
        $this->userName = $userName;
        $this->comments = CommentList();
    }

    /**
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * @return string
     */
    public function getImageTypes()
    {
        return $this->imageTypes;
    }

    /**
     *
     * @return string
     */
    public function getImageSizes()
    {
        return $this->imageSizes;
    }

    /**
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     *
     * @return int
     */
    public function getImageId()
    {
        return $this->imageId;
    }
    
    /**
     *
     * @return int
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     *
     * @param string $username
     */
    public function setTitle($title)
    {
        $this->title = $title;
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

    /**
     *
     * @param string $image
     */
    public function addImage($image, $imageType, $imageSize)
    {
        $this->images[$this->imageId] = $image;
        $this->imageTypes[$this->imageId] = $imageType;
        $this->imageSizes[$this->imageId] = $imageSize;
        $this->imageId ++;
    }

    /**
     *
     * @param int $id
     */
    public function deleteImage($id)
    {
        if (array_key_exists($id, $this->images))
            unset($this->images[$id]);
        unset($this->imageSize[$id]);
        unset($this->imageType[$id]);
    }

    public function addComment($comment)
    {
        $ret = false;
        if (isset($comment)) {
            $this->comment[$this->commentId] = $comment;
            $this->commentId ++;
            $ret = true;
        }
        return $ret;
    }

    public function getComments()
    {
        return count($this->comment) == 0 ? false : $this->comment;
    }

    public function getComment($commentId)
    {
        $ret = false;
        if (isset($commentId) && isset($this->comment[$commentId]))
            $ret = clone $this->comment[$commentId];
        return $ret;
    }

    public function deleteComment($commentId)
    {
        $ret = false;
        if (isset($commentId) && isset($this->comment[$commentId])) {
            unset($this->comment[$commentId]);
            $ret = true;
        }
        return $ret;
    }
}