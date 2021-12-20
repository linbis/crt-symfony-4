<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private string $slug;

    /**
     * @var Product[]
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category", fetch="EAGER")
     */
    private $products;

    /**
     * Конструктор категории
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     * Получение товаров категория
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * Получение 5 последних товаров категории
     * @return Collection|Product[]
     */
    public function getLastProducts(): Collection
    {
        return $this->products->matching(
            ProductRepository::createNewestCriteria(3)
        );
    }

    /**
     * Общее количество товаров
     * @return int
     */
    public function getTotalProducts(): int
    {
        return $this->products->count();
    }

    /**
     * Добавление товара
     * @param Product $product
     */
    public function addProduct(Product $product): void
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        };
    }

    /**
     * Удаление товара
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);

            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
