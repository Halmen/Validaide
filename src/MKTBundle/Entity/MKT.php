<?php

namespace MKTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MKT
 *
 * @ORM\Table(name="mkt")
 * @ORM\Entity(repositoryClass="MKTBundle\Repository\MKTRepository")
 */
class MKT
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="activationEnergy", type="decimal", precision=19, scale=4)
     */
    private $activationEnergy;

    /**
     * @var string
     *
     * @ORM\Column(name="gasConstant", type="decimal", precision=19, scale=4)
     */
    private $gasConstant;

    /**
     * @var string
     *
     * @ORM\Column(name="temperatures", type="array")
     */
    private $temperatures = array();

    /**
     * @var string
     *
     * @ORM\Column(name="MKT", type="decimal", precision=19, scale=4)
     */
    private $mKT;

    /**
     * @var string
     *
     * @ORM\Column(name="Datetime", type="string", length=35)
     */
    private $datetime;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set activationEnergy
     *
     * @param string $activationEnergy
     *
     * @return MKT
     */
    public function setActivationEnergy($activationEnergy)
    {
        $this->activationEnergy = $activationEnergy;

    }

    /**
     * Get activationEnergy
     *
     * @return string
     */
    public function getActivationEnergy()
    {
        return $this->activationEnergy;
    }

    /**
     * Set gasConstant
     *
     * @param string $gasConstant
     *
     * @return MKT
     */
    public function setGasConstant($gasConstant)
    {
        $this->gasConstant = $gasConstant;
    }

    /**
     * Get gasConstant
     *
     * @return string
     */
    public function getGasConstant()
    {
        return $this->gasConstant;
    }

    /**
     * Set temperatures
     *
     * @param string $temperatures
     *
     * @return MKT
     */
    public function setTemperatures(array $temperatures)
    {
        $this->temperatures = $temperatures;

    }

    /**
     * Get temperatures
     *
     * @return string
     */
    public function getTemperatures()
    {
        return $this->temperatures;
    }

    /**
     * Set mKT
     *
     * @param string $mKT
     *
     * @return MKT
     */
    public function setMKT($mKT)
    {
        $this->mKT = $mKT;

    }

    /**
     * Get mKT
     *
     * @return string
     */
    public function getMKT()
    {
        return $this->mKT;
    }

    /**
     * Set datetime
     *
     * @param string $datetime
     *
     * @return MKT
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

    }

    /**
     * Get datetime
     *
     * @return string
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    public function calculateMKT()
    {

        $e = 2.71828;

        $nr = sizeof($this->temperatures);

        $step1 = $this->activationEnergy / $this->gasConstant;

        $step2 = 0;

        foreach ($this->temperatures as $t) {
            $step2 += pow($e, (-$this->activationEnergy / (($t + 273.15) * $this->gasConstant)));
        }

        $this->mKT = ($step1 / -log($step2 / $nr)) - 273.15;


    }

    public function getTempnr()
    {
        return sizeof($this->temperatures);
    }

}

