<?php
namespace tests\integration\Foodtrack;

class PublicAccessTest extends \PHPUnit_Framework_TestCase
{
    /** @test **/
    public function foodList___returns200()
    {
        $this->assertSame(200, $this->getStatusCode('http://api.dev.foodtrack.com/food'));
    }

    /** @test **/
    public function randomPage___returns404()
    {
        $this->assertSame(404, $this->getStatusCode('http://api.dev.foodtrack.com/' . uniqid()));
    }

    protected function getStatusCode($url)
    {
        $ch = curl_init();
        curl_setopt($ch, \CURLOPT_URL, $url);
        curl_setopt($ch, \CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $statusCode = curl_getinfo($ch, \CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $statusCode;
    }
}
