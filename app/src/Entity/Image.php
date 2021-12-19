<?php

namespace App\Entity;

use App\Traits\HasTimestampsTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    use HasTimestampsTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private string $title;

    /**
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private string $filename;

    /**
     * @var UploadedFile|null
     */
    private ?UploadedFile $file;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return null|UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param null|UploadedFile $file
     */
    public function setFile(?UploadedFile $file): void
    {
        $this->file = $file;
    }

    /**
     * @param string $path
     * @return string
     */
    public function getPathname(string $path): string
    {
        return "{$path}/{$this->getFilename()}";
    }

    /**
     * @return string
     */
    public function getWebPath(): string
    {
        return $this->getFilename();
    }
}
