<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Country
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table("app_country")
 */
class Country
{
    use ORMBehaviors\Translatable\Translatable;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string country iso code in ISO 3166-1
     * @ORM\Column(type="string", length=2)
     */
    private $isoCode;

    /**
     * @var ArrayCollection|Index[]
     * @ORM\OneToMany(targetEntity="App\Entity\Index", mappedBy="country", cascade={"all"})
     */
    private $indexes;

    public function __construct()
    {
        $this->indexes = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $isoCode
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;
    }

    /**
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * Proxy method
     * @return string
     */
    public function getName()
    {
        return $this->translate()->getName();
    }

    /**
     * @return \App\Entity\Index[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /**
     * @param Index $index
     */
    public function addIndex(Index $index)
    {
        if (!$this->indexes->contains($index)) {
            $this->indexes->add($index);
        }
    }

    /**
     * @param Index $index
     */
    public function removeIndex(Index $index)
    {
        if (!$this->indexes->contains($index)) {
            $this->indexes->remove($index);
        }
    }
}
