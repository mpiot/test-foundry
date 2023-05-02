<?php

namespace App\Entity;

use App\Entity\Traits\BlameableEntity;
use App\Entity\Traits\TimestampableEntity;
use App\Enum\Severity;
use App\Repository\ChangeRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(['capaCase', 'caseNumber'])]
#[ORM\Entity(repositoryClass: ChangeRequestRepository::class)]
class ChangeRequest
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[Assert\DisableAutoMapping]
    #[ORM\Column(length: 255)]
    private ?string $caseNumber = null;

    #[ORM\OneToMany(mappedBy: 'changeRequest', targetEntity: ChangeRequestDocument::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['id' => 'asc'])]
    private Collection $documents;

    #[ORM\Column]
    private array $productionOrderItems = [];

    public function __construct()
    {
        $this->documents = new ArrayCollection();

        $this->initDefaultInitialDocuments();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaseNumber(): ?string
    {
        return $this->caseNumber;
    }

    public function setCaseNumber(string $caseNumber): self
    {
        $this->caseNumber = $caseNumber;

        return $this;
    }

    /**
     * @return ReadableCollection<int, ChangeRequestDocument>
     */
    #[Assert\Valid]
    public function getInitialDocuments(): ReadableCollection
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('initial', true))
        ;

        $documents = $this->documents->matching($criteria);

        return new ArrayCollection(array_values($documents->toArray()));
    }

    public function addInitialDocument(ChangeRequestDocument $initialDocument): self
    {
        if (false === $initialDocument->isInitial()) {
            throw new \Exception('The addInitialDocument must receive a CapaChangeRequestDocument with initial as true.');
        }

        if (!$this->documents->contains($initialDocument)) {
            $this->documents->add($initialDocument);
            $initialDocument->setChangeRequest($this);
        }

        return $this;
    }

    public function removeInitialDocument(ChangeRequestDocument $initialDocument): self
    {
        if (false === $initialDocument->isInitial()) {
            throw new \Exception('The removeInitialDocument must receive a CapaChangeRequestDocument with initial as true.');
        }

        // set the owning side to null (unless already changed)
        if ($this->documents->removeElement($initialDocument) && $initialDocument->getChangeRequest() === $this) {
            $initialDocument->setChangeRequest(null);
        }

        return $this;
    }

    /**
     * @return ReadableCollection<int, ChangeRequestDocument>
     */
    #[Assert\Valid]
    public function getAdditionalDocuments(): ReadableCollection
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('initial', false))
        ;

        $documents = $this->documents->matching($criteria);

        return new ArrayCollection(array_values($documents->toArray()));
    }

    public function addAdditionalDocument(ChangeRequestDocument $additionalDocument): self
    {
        if (true === $additionalDocument->isInitial()) {
            throw new \Exception('The addAdditionalDocument must receive a CapaChangeRequestDocument with initial as false.');
        }

        if (!$this->documents->contains($additionalDocument)) {
            $this->documents->add($additionalDocument);
            $additionalDocument->setChangeRequest($this);
        }

        return $this;
    }

    public function removeAdditionalDocument(ChangeRequestDocument $additionalDocument): self
    {
        if (true === $additionalDocument->isInitial()) {
            throw new \Exception('The removeInitialDocument must receive a CapaChangeRequestDocument with initial as false.');
        }

        // set the owning side to null (unless already changed)
        if ($this->documents->removeElement($additionalDocument) && $additionalDocument->getChangeRequest() === $this) {
            $additionalDocument->setChangeRequest(null);
        }

        return $this;
    }

    private function initDefaultInitialDocuments(): void
    {
        foreach (self::getDefaultDocumentInfos() as $documentInfo) {
            $document = new ChangeRequestDocument();
            $document
                ->setInitial(true)
                ->setCategory($documentInfo[0])
                ->setRequireImplementation($documentInfo[1])
            ;

            $this->addInitialDocument($document);
        }
    }

    public static function getDefaultDocumentInfos(): \Generator
    {
        yield ['MOP', false];
        yield ['Plan mécanique', false];
        yield ['TPS/Plan de spec', false];
        yield ['PAP/PCE', false];
        yield ['Spec de contrôle', false];
        yield ['Documents Qualités', false];
        yield ['Analyse de risques', false];
        yield ['Gamme/Nomenclature', true];
    }
}
