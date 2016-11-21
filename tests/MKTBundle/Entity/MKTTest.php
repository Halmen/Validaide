<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use MKTBundle\Entity\MKT;


class MKTTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @covers MKT::calculateMKT
     * @todo   Implement testCalculateMKT()
     */
    public function testCalculateMKT()

    {

        $mkt = new MKT();
        $temperatures = array(5, 12, 0);
        $mkt->setActivationEnergy(83.1447);
        $mkt->setGasConstant(8.3145);
        $mkt->setTemperatures($temperatures);
        $result = $mkt->calculateMKT();

        $this->assertEquals(5.818, $result);


    }

    /**
     * @covers MKT::getTempnr
     * @todo   Implement testgetTempnr()
     */
    public function testgetTempnr()

    {

        $mkt = new MKT();
        $temperatures = array(5, 12, 0, 12, 15);
        $mkt->setTemperatures($temperatures);
        $result = $mkt->getTempnr();

        $this->assertEquals(5, $result);


    }


}