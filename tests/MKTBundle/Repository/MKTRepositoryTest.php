<?php


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MKTRepositoryTest extends KernelTestCase
{


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByDatetime()
    {
        $date='2016-11-21 06:17:36';
        $mkt = $this->em
            ->getRepository('MKTBundle:MKT')
            ->findOneByDatetime($date);
        ;

        $this->assertCount(1, $mkt);
    }


    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }

}