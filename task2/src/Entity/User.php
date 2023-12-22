<?php

declare(strict_types=1);

namespace App\Entity;

class User
{
    private int $id;

    private string $name;

    /**
     * @var Article[]
     * OneToMany relation with Article
     */
    private array $artircls;

    public function __construct()
    {
        $this->artircls = [];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getArtircls(): array
    {
        return $this->artircls;
    }

    public function addArtircl(Article $artircl): self
    {
        $this->artircls[$artircl->getId()] = $artircl;
        $artircl->setAuthor($this);

        return $this;
    }
}