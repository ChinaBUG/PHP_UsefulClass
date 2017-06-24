<?php
/**
 * 之前第三方的class.RestorePrint.php类在实际使用中发现有点不懂得用，
 * 造成二维数据的数据是无法恢复的，所以只好还是自己写一个吧，简单点。
 * -
 * 作用：写接口的时候，目前都是直接输出的，要重试的话，数据已经格式化
 * 了，只能想办法将格式化的重新转为数组。
 * 思路：直接通过观察发现规律直接采用替换的方法处理了，目前是符合实际
 * 需求的，如果有什么问题提供数据反馈给我吧。
 *
**/
class RePrintR
{
	static public function parse( $tostring )
	{
		//1. 将每行的空格都移除
		$tostring = preg_replace( '/^(\s*)/im', '', $tostring );
		//2. 将每行的[]及=>符号替换成正确的
		$tostring = preg_replace( '/^\[([^\]]*)\] => ([^\n]*)$/im', "'$1'=>'$2',", $tostring );
		//3. 将特殊的字符替换一下
		$pF = array(
			'/\'Array\',/',
			'/Array/',
			'/\)/',
		);
		$pR = array(
			'array',
			'array',
			'),',
		);
		$tostring = preg_replace( $pF, $pR, $tostring );
		//4.将最后的分号替换
		$strLen = strlen($tostring);
		if( $tostring{$strLen-1} == ',' ){
			$tostring = substr($tostring,0,strLen-1) . ';';
		}
		eval( "\$output=$tostring" );
		return $output;		
	}
}