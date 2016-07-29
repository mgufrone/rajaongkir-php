<?php namespace Gufy\Rajaongkir;
class Province{
  public static function all(){
    return Rajaongkir::getInstance()->get("province");
  }
  public static function find($id){
    return Rajaongkir::getInstance()->get("province",['id'=>$id]);
  }
}
