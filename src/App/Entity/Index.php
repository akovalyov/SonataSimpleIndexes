<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Index
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table("app_index")
 */
class Index
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $enabled = false;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="indexes", cascade={"all"})
     */
    private $country;

    /**
     * @var ArrayCollection|Value[]
     * @ORM\OneToMany(targetEntity="App\Entity\Value", mappedBy="index")
     * @ORM\OrderBy({"createdAt" = "ASC"})
     */
    private $values;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param \App\Entity\Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return \App\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param \App\Entity\Value[]|\Doctrine\Common\Collections\ArrayCollection $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return \App\Entity\Value[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getValues()
    {
        return $this->values;
    }

}
