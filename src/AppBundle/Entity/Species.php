<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JSON;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity()
 *
 * @UniqueEntity("name")
 *
 * @JSON\ExclusionPolicy("ALL")
 */
class Species
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint", name="id")
     *
     * @JSON\Expose()
     * @JSON\SerializedName("dbId")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="name")
     *
     * @JSON\Expose()
     * @JSON\SerializedName("name")
     *
     * @var string
     */
    protected $name;

    /**
     * ToString.
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name.
     *
     * @param string $name
     *
     * @return Species
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
