<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait HasTimestampsTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private \DateTime $updatedAt;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $dateTimeNow = new \DateTime('now');
        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return static
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     * @return static
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}