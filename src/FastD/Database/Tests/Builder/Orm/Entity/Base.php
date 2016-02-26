<?php

namespace FastD\Database\Tests\Builder\Orm\Entity;

class Base extends \FastD\Database\Orm\Entity
{
    /*
     * @var mixed
     */
    protected $id;
    /*
     * @var mixed
     */
    protected $name;
    /*
     * @var mixed
     */
    protected $content;
    /*
     * @var mixed
     */
    protected $create_at;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getCreate_at()
    {
        return $this->create_at;
    }

    /**
     * @param mixed $create_at
     * @return $this
     */
    public function setCreate_at($create_at)
    {
        $this->create_at = $create_at;

        return $this;
    }

}