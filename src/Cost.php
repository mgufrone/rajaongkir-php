<?php namespace Gufy\Rajaongkir;

class Cost{
  public static function get($origin, $destination, $metrics, $courier){
    $params[ 'courier' ] = strtolower( $courier );
		$params[ 'originType' ] = strtolower( key( $origin ) );
		$params[ 'destinationType' ] = strtolower( key( $destination ) );
		if ( $params[ 'originType' ] !== 'city' )
		{
			$params[ 'originType' ] = 'subdistrict';
		}
		if ( ! in_array( $params[ 'destinationType' ], [ 'city', 'country' ] ) )
		{
			$params[ 'destinationType' ] = 'subdistrict';
		}
		if ( is_array( $metrics ) )
		{
			if ( ! isset( $metrics[ 'weight' ] ) &&
				isset( $metrics[ 'length' ] ) &&
				isset( $metrics[ 'width' ] ) &&
				isset( $metrics[ 'height' ] )
			)
			{
				$metrics[ 'weight' ] = ( ( $metrics[ 'length' ] * $metrics[ 'width' ] * $metrics[ 'height' ] ) / 6000 ) * 1000;
			}
			elseif ( isset( $metrics[ 'weight' ] ) &&
				isset( $metrics[ 'length' ] ) &&
				isset( $metrics[ 'width' ] ) &&
				isset( $metrics[ 'height' ] )
			)
			{
				$weight = ( ( $metrics[ 'length' ] * $metrics[ 'width' ] * $metrics[ 'height' ] ) / 6000 ) * 1000;
				if ( $weight > $metrics[ 'weight' ] )
				{
					$metrics[ 'weight' ] = $weight;
				}
			}
			foreach ( $metrics as $key => $value )
			{
				$params[ $key ] = $value;
			}
		}
		elseif ( is_numeric( $metrics ) )
		{
			$params[ 'weight' ] = $metrics;
		}
		switch ( Rajaongkir::getInstance()->getPackage() )
		{
			case 'starter':
				if ( $params[ 'destinationType' ] === 'country' )
				{
					throw new \Exception('Unsupported International Destination. Tipe akun starter tidak mendukung pengecekan destinasi international.',301);

				}
				elseif ( $params[ 'originType' ] === 'subdistrict' OR $params[ 'destinationType' ] === 'subdistrict' )
				{
					throw new \Exception('Unsupported Subdistrict Origin-Destination. Tipe akun starter tidak mendukung pengecekan ongkos kirim sampai kecamatan.',302);

				}
				if ( ! isset( $params[ 'weight' ] ) &&
					isset( $params[ 'length' ] ) &&
					isset( $params[ 'width' ] ) &&
					isset( $params[ 'height' ] )
				)
				{
					throw new \Exception('Unsupported Dimension. Tipe akun starter tidak mendukung pengecekan biaya kirim berdasarkan dimensi.',304);

				}
				elseif ( isset( $params[ 'weight' ] ) && $params[ 'weight' ] > 30000 )
				{
					throw new \Exception('Unsupported Weight. Tipe akun starter tidak mendukung pengecekan biaya kirim dengan berat lebih dari 30000 gram (30kg).',305);

				}
				if ( ! in_array( $params[ 'courier' ], Rajaongkir::getInstance()->supportedCouriers()[ Rajaongkir::getInstance()->getPackage() ] ) )
				{
					throw new \Exception('Unsupported Courier. Tipe akun starter tidak mendukung pengecekan biaya kirim dengan kurir ' . $_couriers_list[ $courier ] . '.',303);

				}
				break;
			case 'basic':
				if ( $params[ 'originType' ] === 'subdistrict' OR $params[ 'destinationType' ] === 'subdistrict' )
				{
					throw new \Exception('Unsupported Subdistrict Origin-Destination. Tipe akun basic tidak mendukung pengecekan ongkos kirim sampai kecamatan.',302);

				}
				if ( ! isset( $params[ 'weight' ] ) &&
					isset( $params[ 'length' ] ) &&
					isset( $params[ 'width' ] ) &&
					isset( $params[ 'height' ] )
				)
				{
					throw new \Exception('Unsupported Dimension. Tipe akun basic tidak mendukung pengecekan biaya kirim berdasarkan dimensi.',304);

				}
				elseif ( isset( $params[ 'weight' ] ) && $params[ 'weight' ] > 30000 )
				{
					throw new \Exception('Unsupported Weight. Tipe akun basic tidak mendukung pengecekan biaya kirim dengan berat lebih dari 30000 gram (30kg).',305);

				}
				elseif ( isset( $params[ 'weight' ] ) && $params[ 'weight' ] < 30000 )
				{
					unset( $params[ 'length' ], $params[ 'width' ], $params[ 'height' ] );
				}
				if ( ! in_array( $params[ 'courier' ], Rajaongkir::getInstance()->supportedCouriers()[ Rajaongkir::getInstance()->getPackage() ] ) )
				{
					throw new \Exception('Unsupported Courier. Tipe akun basic tidak mendukung pengecekan biaya kirim dengan kurir ' . $_couriers_list[ $courier ] . '.',303);

				}
				break;
		}
		$params[ 'origin' ] = $origin[ key( $origin ) ];
		$params[ 'destination' ] = $destination[ key( $destination ) ];
		$path = key( $destination ) === 'country' ? 'internationalCost' : 'cost';
    // print_r($params);
    return Rajaongkir::getInstance()->post($path, $params);
  }
}
