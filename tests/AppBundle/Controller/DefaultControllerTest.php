<?php

namespace Tests\AppBundle\Controller;

use SebUndefined\ShopBundle\Services\CheckDate;
use SebUndefined\ShopBundle\Services\DefinePrice;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends KernelTestCase
{
    /*public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }*/
    private $em;
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testDate() {
        $date = "22/10/2017";
        echo "Testing date as String. String given : " . $date;
        $serviceDate = new CheckDate($this->em);
        $result = $serviceDate->isValidFormat($date);
        $this->assertEquals(true, $result);

    }
    public function testIsNotBefore() {
        $dateBefore = "22/10/2016";
        echo "Testing date is not before. Date given : " . $dateBefore;
        $serviceDate = new CheckDate($this->em);
        $dateAsDateType = \DateTime::createFromFormat('d/m/Y', $dateBefore);
        $result = $serviceDate->isNotBefore($dateAsDateType);
        $this->assertEquals(false, $result);
    }
    public function testIsNotClosed() {
        $date = "25/12/2017";
        echo "Testing date is not closed : " . $date;
        $serviceDate = new CheckDate($this->em);
        $dateAsDateType = \DateTime::createFromFormat('d/m/Y', $date);
        $result = $serviceDate->isNotAtClosedDay($dateAsDateType);
        $this->assertEquals(true, $result);
    }
    public function testPrice() {

        $service = new DefinePrice();
        $birthDate = "22/10/1988";
        $birthDateAsDate = \DateTime::createFromFormat('d/m/Y', $birthDate);
        $result = $service->definePriceTicket($birthDateAsDate, "full", false);
        $this->assertEquals(16, $result);
    }
}
