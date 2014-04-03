<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class Value
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table("app_value")
 * @ORM\HasLifecycleCallbacks()
 */
class Value
{
    use Timestampable;

    const VOLATILITY_LOW = 'low';
    const VOLATILITY_MEDIUM = 'medium';
    const VOLATILITY_HIGH = 'high';
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $volatility;
    /**
     * Represents fixed value of index.
     *
     * @var float
     * @ORM\Column(type="float")
     */
    private $fixed;
    /**
     * Represents prognosed value of index.
     *
     * @var float
     * @ORM\Column(type="float")
     */
    private $prognosed;
    /**
     * Represents actual value of index.
     *
     * @var float
     * @ORM\Column(type="float")
     */
    private $actual;
    /**
     * @var Index
     * @ORM\ManyToOne(targetEntity="App\Entity\Index", inversedBy="values")
     */
    private $index;

    public function __toString()
    {
        return 'Value';
    }

    public function __construct()
    {
        $this->volatility = 1;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $actual
     */
    public function setActual($actual)
    {
        $this->actual = $actual;
    }

    /**
     * @return float
     */
    public function getActual()
    {
        return $this->actual;
    }

    /**
     * @ORM\PrePersist
     */
    public function setFixed()
    {
        $this->fixed = $this->actual - $this->prognosed;
    }

    /**
     * @return float
     */
    public function getFixed()
    {
        return $this->fixed;
    }

    /**
     * @param Index $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return Index
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param float $prognosed
     */
    public function setPrognosed($prognosed)
    {
        $this->prognosed = $prognosed;
    }

    /**
     * @return float
     */
    public function getPrognosed()
    {
        return $this->prognosed;
    }

    /**
     * @param mixed $volatility
     */
    public function setVolatility($volatility)
    {
        $this->volatility = $volatility;
    }

    /**
     * @return mixed
     */
    public function getVolatility()
    {
        return $this->volatility;
    }

    public static function getVolatilityValues()
    {
        return [
            self::VOLATILITY_LOW,
            self::VOLATILITY_MEDIUM,
            self::VOLATILITY_HIGH,
        ];
    }
}
