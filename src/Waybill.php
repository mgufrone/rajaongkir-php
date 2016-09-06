<?php namespace Gufy\Rajaongkir;
class Waybill{
  public static function find($courier, $waybill){
    return Rajaongkir::getInstance()->post("waybill", ['courier'=>$courier, 'waybill'=>$waybill]);
  }
}
