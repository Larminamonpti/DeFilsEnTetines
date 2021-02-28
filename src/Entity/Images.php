<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 * @Vich\Uploadable
 */
class Images
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Vich\UploadableField(mapping="products", fileNameProperty="name")
     * @Assert\Image(
     *     maxSize = "2048k",
     *     maxSizeMessage="Votre photo est trop volumineuse ({{ size }} {{ suffix }}). La taille maximum authorisée est {{ limit }} {{ suffix }}."
     * )
     */
    private $file;

    /**
     * @ORM\Column(type="datetime", nullable= true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="images", cascade={"remove"})
     */
    private $products;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->getName();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }


    public function setFile(?File $file): self
    {
        $this->file = $file;
        if ($file != null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getProducts(): ?Products
    {
        return $this->products;
    }

    public function setProducts(?Products $products): self
    {
        $this->products = $products;

        return $this;
    }
}
