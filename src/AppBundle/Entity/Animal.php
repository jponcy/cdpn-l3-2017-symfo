<?php

/**
 *
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * My animal class.
 *
 * @ORM\Table(name="app_animal")
 * @ORM\Entity()
 */
class Animal
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(name="col_id", type="bigint")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="float", name="weight", nullable=true)
     *
     * @var type
     */
    private $weight;

    /**
     * @ORM\Column(type="datetime", name="birthdate")
     *
     * @var \DateTime
     */
    private $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="Species")
     *
     * @var Species
     */
    private $species;

    /**
     * Gets the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return \AppBundle\Entity\Animal
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the weight.
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the weight.
     *
     * @param float $weight
     *
     * @return Animal
     */
    public function setweight(float $weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the birthdate.
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set the birthdate.
     *
     * @param \DateTime $birthdate
     *
     * @return Animal
     */
    public function setbirthdate(\DateTime $birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Set the species.
     *
     * @param Species $species
     *
     * @return Animal
     */
    public function setSpecies(Species $species)
    {
        if ($this->species !== $species) {
            $this->species = $species;
        }

        return $this;
    }

    /**
     * Get the species.
     *
     * @return Species
     */
    public function getSpecies()
    {
        return $this->species;
    }
}
