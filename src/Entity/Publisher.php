<?php


namespace App\Entity;


class Publisher
{
    protected int $id;
    protected string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Publisher
     */
    public function setId(int $id): Publisher
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
     * @return Publisher
     */
    public function setName(string $name): Publisher
    {
        $this->name = $name;
        return $this;
    }


}