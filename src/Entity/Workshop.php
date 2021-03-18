<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkshopRepository")
 */
class Workshop
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="uuid", unique=true)
     */
    private UuidInterface $identifier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private \DateTimeImmutable $workshopDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Attendee", mappedBy="workshops")
     */
    private Collection $attendees;

    public function __construct(
        string $identifier,
        string $title,
        \DateTimeImmutable $workshopDate
    ) {
        Assert::uuid($identifier, 'Argument $identifier is not a valid UUID: %s');

        $this->identifier = Uuid::fromString($identifier);
        $this->title = $title;
        $this->workshopDate = $workshopDate;

        $this->attendees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier->toString();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getWorkshopDate(): ?\DateTimeImmutable
    {
        return $this->workshopDate;
    }

    /**
     * @return Attendee[]
     */
    public function getAttendees(): array
    {
        return $this->attendees->toArray();
    }

    public function addAttendee(Attendee $attendee): self
    {
        if (!$this->attendees->contains($attendee)) {
            $this->attendees->add($attendee);
            $attendee->addWorkshop($this);
        }

        return $this;
    }

    public function removeAttendee(Attendee $attendee): self
    {
        if ($this->attendees->contains($attendee)) {
            $this->attendees->removeElement($attendee);
            $attendee->removeWorkshop($this);
        }

        return $this;
    }
}
