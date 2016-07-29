<?php
use Gufy\Rajaongkir\Rajaongkir;
use Gufy\Rajaongkir\Province;
use Gufy\Rajaongkir\City;
use Gufy\Rajaongkir\Cost;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
class RajaongkirTest extends \PHPUnit_Framework_TestCase{
  public $api;
  public function setUp(){
    parent::setUp();
    Rajaongkir::init('9613a54cd1a6e83cadaba3932f8ec1d6', 'starter');

    // $content = [
    //   json_encode(['result'=>'success','clients'=>['client'=>[]]]),
    //   json_encode(['result'=>'success','clients'=>['client'=>[]]]),
    //   json_encode(['result'=>'success','clients'=>['client'=>[]]]),
    //   json_encode(['result'=>'success','clients'=>['client'=>[]]]),
    //   json_encode(['result'=>'success','clients'=>['client'=>[]]]),
    //   json_encode(['result'=>'success','clients'=>['client'=>[]]]),
    // ];
    // $mock = new MockHandler([
    //   new Response(200, ["Content-Type"=>"text/json"], $content[0]),
    //   new Response(200, ["Content-Type"=>"text/json"], $content[1]),
    //   new Response(200, ["Content-Type"=>"text/json"], $content[2]),
    //   new Response(200, ["Content-Type"=>"text/json"], $content[3]),
    //   new Response(200, ["Content-Type"=>"text/json"], $content[4]),
    //   new Response(200, ["Content-Type"=>"text/json"], $content[5]),
    // ]);
    // $handler = HandlerStack::create($mock);
    // Rajaongkir::getInstance()->client(["handler"=>$handler]);
  }
  public function testGetProvinces(){
    $provinces = Province::all();
    $request = Rajaongkir::getInstance()->getRequest();
    $this->assertEquals("/starter/province", $request->getUri()->getPath());
    $this->assertEquals('9613a54cd1a6e83cadaba3932f8ec1d6', $request->getHeader("key")[0]);
  }
  public function testGetProvinceById(){
    $provinces = Province::find(10);
    $request = Rajaongkir::getInstance()->getRequest();
    $this->assertEquals("/starter/province", $request->getUri()->getPath());
    $this->assertEquals("id=10",$request->getUri()->getQuery());
    $this->assertEquals('9613a54cd1a6e83cadaba3932f8ec1d6', $request->getHeader("key")[0]);
  }
  public function testGetCities(){
    $provinces = City::all();
    $request = Rajaongkir::getInstance()->getRequest();
    $this->assertEquals("/starter/city", $request->getUri()->getPath());
    $this->assertEquals('9613a54cd1a6e83cadaba3932f8ec1d6', $request->getHeader("key")[0]);
  }
  public function testGetCityByProvince(){
    $provinces = City::all(10);
    $request = Rajaongkir::getInstance()->getRequest();
    $this->assertEquals("/starter/city", $request->getUri()->getPath());
    $this->assertEquals("province=10",$request->getUri()->getQuery());
    $this->assertEquals('9613a54cd1a6e83cadaba3932f8ec1d6', $request->getHeader("key")[0]);
  }
  public function testGetCityById(){
  $provinces = City::find(10);
    $request = Rajaongkir::getInstance()->getRequest();
    $this->assertEquals("/starter/city", $request->getUri()->getPath());
    $this->assertEquals("id=10",$request->getUri()->getQuery());
    $this->assertEquals('9613a54cd1a6e83cadaba3932f8ec1d6', $request->getHeader("key")[0]);
  }
  public function testGetCost(){
    $provinces = Cost::get(['city'=>'10'],['city'=>'100'],1000,'pos');
    $request = Rajaongkir::getInstance()->getRequest();
    $this->assertEquals("/starter/cost", $request->getUri()->getPath());
    // print_r($request->getBody()->getContents());
    // $this->assertEquals("id=10",$request->getBody()->getQuery());
    $this->assertEquals('9613a54cd1a6e83cadaba3932f8ec1d6', $request->getHeader("key")[0]);
  }
}
