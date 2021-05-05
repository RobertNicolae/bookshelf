<?php


namespace App\Entity;


class Author
{
    protected int $id;
    protected string $name;

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Author
     */
    public function setId(int $id): Author
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Author
     */
    public function setName(string $name): Author
    {
        $this->name = $name;
        return $this;
    }


}