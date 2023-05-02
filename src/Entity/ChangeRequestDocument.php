<?php

namespace App\Entity;

use App\Repository\ChangeRequestDocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ChangeRequestDocumentRepository::class)]
class ChangeRequestDocument
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[Assert\DisableAutoMapping]
    #[ORM\ManyToOne(inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ChangeRequest $changeRequest = null;

    #[ORM\Column]
    private bool $initial = false;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column]
    private bool $requireImplementation = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChangeRequest(): ?ChangeRequest
    {
        return $this->changeRequest;
    }

    public function setChangeRequest(?ChangeRequest $changeRequest): self
    {
        $this->changeRequest = $changeRequest;

        return $this;
    }

    public function isInitial(): bool
    {
        return $this->initial;
    }

    public function setInitial(bool $initial): self
    {
        $this->initial = $initial;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function isRequireImplementation(): bool
    {
        return $this->requireImplementation;
    }

    public function setRequireImplementation(bool $requireImplementation): self
    {
        $this->requireImplementation = $requireImplementation;

        return $this;
    }
}
