<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Species
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint", name="id")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="name")
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
