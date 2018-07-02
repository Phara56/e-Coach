<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroupControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/"admin/groups"/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(0, $crawler->filter('table.records_list tbody tr'));
    }
}
