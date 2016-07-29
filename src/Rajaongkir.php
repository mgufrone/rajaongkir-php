<?php namespace Gufy\Rajaongkir;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use Psr\Http\Message\RequestInterface;

class Rajaongkir{
  private $api_key;
  private $package;
  private $request;
  private $client;
  private static $instance;
  public static function init($api_key, $package='starter'){
    static::$instance = new Rajaongkir($api_key, $package);
    return static::$instance;
  }
  public function __construct($api_key, $package='starter'){
    $this->api_key = $api_key;
    $this->package = $package;
    $this->client = $this->client();
  }
  public static function getInstance(){
    return static::$instance;
  }
  public function post($url, $data){
    $response = $this->client->post($url,['form_params'=>$data]);
    return $this->parse($response);
  }
  public function get($url, $data=array()){
    $response = $this->client->get($url,['query'=>$data]);
    return $this->parse($response);
  }
  public function parse(Response $response){
    return json_decode($response->getBody()->getContents(), 1)["rajaongkir"];
  }
  public function client($config=array()){
    $config["base_uri"] = "http://api.rajaongkir.com/".$this->package."/";
    $config["headers"] = ["key"=>$this->api_key];
    $config['timeout'] = 30;
    if(empty($config["handler"])){
      $stack = new HandlerStack();
      $stack->setHandler(new CurlHandler());
      $config["handler"] = $stack;
    }
    $config["handler"]->push($this->appendRequest());
    $client = new Client($config);
    return $client;
  }
  private function appendRequest(){
    $class = $this;
    return function (callable $handler) use($class){
      return function (RequestInterface $request, array $options) use($handler, $class){
        $class->setRequest($request);
        return $handler($request,$options);
      };
    };
  }
  public function setRequest(RequestInterface $request){
    $this->request = $request;
  }
  public function getApiKey(){
    return $this->api_key;
  }
  public function getClient(){
    return $this->client;
  }
  public function getRequest(){
    return $this->request;
  }
  public function getPackage(){
    return $this->package;
  }
  public function supportedCouriers(){
    return [
      'starter' => array(
  			'jne',
  			'pos',
  			'tiki',
  		),
  		'basic'   => array(
  			'jne',
  			'pos',
  			'tiki',
  			'pcp',
  			'esl',
  			'rpx',
  		),
  		'pro'     => array(
  			'jne',
  			'pos',
  			'tiki',
  			'rpx',
  			'esl',
  			'pcp',
  			'pandu',
  			'wahana',
  		),
    ];
  }
}
