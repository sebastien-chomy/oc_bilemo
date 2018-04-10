<?php
/**
 * This file is part of oc_bilemo project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/04
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BrandRepository
 *
 * @package App\Entity
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 *
 * @UniqueEntity("name", message="brand.name.unique_entity")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route("app_api_brand_get",
 *            parameters={ "idBrand" = "expr(object.getIdBrand())" },
 *            absolute=true,
 *           )
 * )
 *
 * @Hateoas\Relation(
 *     "modify",
 *     href = @Hateoas\Route("app_api_brand_put",
 *            parameters={ "idBrand" = "expr(object.getIdBrand())" },
 *            absolute=true,
 *           )
 * )
 *
 * @Hateoas\Relation(
 *     "delete",
 *     href = @Hateoas\Route("app_api_brand_delete",
 *            parameters={ "idBrand" = "expr(object.getIdBrand())" },
 *            absolute=true
 *          )
 * )
 */
class Brand
{
    /**
     * Contains the ID of the brand
     *
     * @var int|null
     *
     * @ORM\Column(
     *     name="id_brand",
     *     type="integer",
     *     length=11,
     *     nullable=false,
     *     unique=true,
     *     options={"unsigned"=true,
     *              "comment"="Contains the ID of the brand"
     *     }
     * )
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"Default"})
     */
    private $idBrand;

    /**
     * Contains the name of the brand
     *
     * @var null|string
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255,
     *     nullable=false,
     *     unique=true,
     *     options={"comment"="Contains the name of the brand"}
     * )
     *
     * @Assert\NotBlank(
     *      message="brand.name.not_blank"
     * )
     * @Assert\Length(
     *          max="255",
     *          maxMessage="brand.name.max_length"
     * )
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"Default"})
     */
    private $name;

    /** *******************************
     *  SETTER / GETTER
     */

    /**
     * @return int|null
     */
    public function getIdBrand(): ?int
    {
        return $this->idBrand;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return Brand
     */
    public function setName(?string $name): Brand
    {
        $this->name = $name;
        return $this;
    }
}
