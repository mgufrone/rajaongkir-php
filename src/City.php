<?php namespace Gufy\Rajaongkir;
class City{
  public static function all($province=null){
    $data = [];
    if(!empty($province)){
      $data["province"] = $province;
    }
    return Rajaongkir::getInstance()->get("city",$data);
  }
  public static function find($id){
    return Rajaongkir::getInstance()->get("city",['id'=>$id]);
  }
}
