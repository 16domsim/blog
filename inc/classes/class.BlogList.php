<?php

class BlogList
{

    protected $blog = array();

    public function addBlog($blog)
    {
        $ret = false;
        if (isset($blog)) {
            $blog->validate();
            if (empty($blog->getAllErrors())) {
                $ret = true;
                if (isset($this->blog[$blog->getTitle()])){
                    $blog->setTitleError("Blogname already used");
                    $ret = false;
                }
            }
            if (count( $blog->getAllErrors() )== 0&&$ret) 
                $this->blog[$blog->getTitle()] = $blog; 
            else 
                $ret=false;
        }
        return $ret;
    }

    public function updateBlog($oldBlogname, $blog)
    {
        $ret = false;
        if (isset($oldBlogname) && isset($this->blog[$oldBlogname]) && isset($blog)) {
            $blog->validate();
            if (count( $blog->getAllErrors() )== 0) {
                if ($oldBlogname != $blog->getTitle()) {
                    if (isset($this->blog[$blog->getTitle()])) {
                        $blog->setTitleError("Blogname already used");
                    } else {
                        unset($this->blog[$oldBlogname]);
                        $this->blog[$blog->getTitle()] = $blog;
                        $ret = true;
                    }
                } else {
                    $this->blog[$blog->getTitle()] = $blog;
                    $ret = true;
                }
            }
        }
        return $ret;
    }

    public function getBlogs()
    {
        return count($this->blog) == 0 ? false : $this->blog;
    }

    public function getBlog($blogname)
    {
        $ret = false;
        if (isset($blogname) && isset($this->blog[$blogname]))
            $ret = clone $this->blog[$blogname];
        return $ret;
    }

    public function deleteBlog($blogname)
    {
        $ret = false;
        if (isset($blogname) && isset($this->blog[$blogname])) {
            unset($this->blog[$blogname]);
            $ret = true;
        }
        return $ret;
    }
    
    public function deleteBlogsByUsername($username){
        $ret = false;
        if (isset($username) ) {
            foreach ($this->blog as $key => $value) {
                if(strcmp($key, $username)){
                    unset($this->blog[$value->getTitle()]);
                }
            }
           
            $ret = true;
        }
        return $ret;
    }
}