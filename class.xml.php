<?php
/**
 * efast 的字段转 ECSTORE 的字段
 * --
 * 做接口对接的时候，最经常的就是需要将外部的接口的字段
 * 名转为本地的字段名，一般都是从API文档中复制对方的格
 * 式，然后手动转为本地字段，劳力劳神，所以就半自动处理
 * 一下。
**/
function xml()
{
	$filename = PUBLIC_DIR.'/efast.xml';
	//
	$xml = simplexml_load_file( $filename );
	foreach( $xml->Worksheet->Table->Row as $key=>$val ){
		$fieldName = (string) $val->Cell[0]->Data;
		$fieldName = str_ireplace( ' ', '', $fieldName );
		$count1 = 0;
		$outputTmp[ $count1 ] = array();
		foreach( $val->Cell as $key1=>$val1 ){
			$outputTmp[ $count1 ] = str_ireplace( ' ', '', (string) $val1->Data );
			$count1++;
		}
		//
		$output[ $fieldName ] = array(
			$outputTmp[ 0 ],
			$outputTmp[ 1 ],
			true,
			$outputTmp[ 2 ],
			$outputTmp[ 3 ],
		);
	}
	
	$result = var_export( $output );
	$result = str_ireplace( "=>\n", '=>', $result );
	print_r( $result );	
}