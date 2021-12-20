<?php

namespace App\Entity;

use App\Traits\HasTimestampsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    use HasTimestampsTrait;

    /**
     * Кол-во позиций на странице
     */
    public const PER_PAGE = 10;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Category $category;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private string $title;
    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private string $slug;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private string $description;

    /**
     * @ORM\Column(name="price", type="integer")
     */
    private int $price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Image")
     */
    private ArrayCollection $images;

    /**
     * Конструктор товара
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price = 0): void
    {
        $this->price = $price;
    }

    /**
     * Получение первой фото товара
     * @return Image|null
     */
    public function getCover(): ?Image
    {
        if ($image = $this->images->first()) {
            return $image;
        }
        return null;
    }

    /**
     * Все фото товара
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * Добавление фото товара
     * @param Image $image
     */
    public function addImage(Image $image): void
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
        }
    }

    /**
     * Удаление фото товара
     * @param Image $image
     */
    public function removeImage(Image $image): void
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }
    }
}
