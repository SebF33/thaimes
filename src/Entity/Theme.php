<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 * @Gedmo\TranslationEntity(class="App\Entity\ThemeTranslation")
 * @UniqueEntity("slug")
 */
class Theme implements Translatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=4)
     */
    private $year;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $catch;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $asideText;

    /**
     * @ORM\Column(type="boolean")
     */
    private $display;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="theme", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureAuthor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureAuthorLink;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    private $textTwo;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titleTwo;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    private $textThree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureTwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureTwoAuthor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureTwoAuthorLink;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    private $textFour;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="themes")
     */
    private $tags;

    /**
     * @ORM\OneToMany(
     *   targetEntity="ThemeTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title . ' (' . $this->year . ')';
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this)->lower();
        }
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCatch(): ?string
    {
        return $this->catch;
    }

    public function setCatch(string $catch): self
    {
        $this->catch = $catch;

        return $this;
    }

    public function getAsideText(): ?string
    {
        return $this->asideText;
    }

    public function setAsideText(string $asideText): self
    {
        $this->asideText = $asideText;

        return $this;
    }

    public function getDisplay(): ?bool
    {
        return $this->display;
    }

    public function setDisplay(bool $display): self
    {
        $this->display = $display;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTheme($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTheme() === $this) {
                $comment->setTheme(null);
            }
        }

        return $this;
    }

    public function getCommentCount(): int
    {
        return $this->comments->count();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPictureAuthor(): ?string
    {
        return $this->pictureAuthor;
    }

    public function setPictureAuthor(string $pictureAuthor): self
    {
        $this->pictureAuthor = $pictureAuthor;

        return $this;
    }

    public function getPictureAuthorLink(): ?string
    {
        return $this->pictureAuthorLink;
    }

    public function setPictureAuthorLink(string $pictureAuthorLink): self
    {
        $this->pictureAuthorLink = $pictureAuthorLink;

        return $this;
    }

    public function getTextTwo(): ?string
    {
        return $this->textTwo;
    }

    public function setTextTwo(string $textTwo): self
    {
        $this->textTwo = $textTwo;

        return $this;
    }

    public function getTitleTwo(): ?string
    {
        return $this->titleTwo;
    }

    public function setTitleTwo(string $titleTwo): self
    {
        $this->titleTwo = $titleTwo;

        return $this;
    }

    public function getTextThree(): ?string
    {
        return $this->textThree;
    }

    public function setTextThree(string $textThree): self
    {
        $this->textThree = $textThree;

        return $this;
    }

    public function getPictureTwo(): ?string
    {
        return $this->pictureTwo;
    }

    public function setPictureTwo(?string $pictureTwo): self
    {
        $this->pictureTwo = $pictureTwo;

        return $this;
    }

    public function getPictureTwoAuthor(): ?string
    {
        return $this->pictureTwoAuthor;
    }

    public function setPictureTwoAuthor(string $pictureTwoAuthor): self
    {
        $this->pictureTwoAuthor = $pictureTwoAuthor;

        return $this;
    }

    public function getPictureTwoAuthorLink(): ?string
    {
        return $this->pictureTwoAuthorLink;
    }

    public function setPictureTwoAuthorLink(string $pictureTwoAuthorLink): self
    {
        $this->pictureTwoAuthorLink = $pictureTwoAuthorLink;

        return $this;
    }

    public function getTextFour(): ?string
    {
        return $this->textFour;
    }

    public function setTextFour(string $textFour): self
    {
        $this->textFour = $textFour;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
