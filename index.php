<?php
//$q='sz000792';
//$q='sh600031';
$q='sh601212';

session_start();
$url='http://qt.gtimg.cn/q='.$q;
for($i=0;$i<600;$i++){
$data=curl_get($url);	
	if(isset($_SESSION['vel'])){
		$ints=round($data-$_SESSION['vel'],2);
		if($ints>0){
			if($ints>0.06){
				echo "\033[0;31m\033[47m";
				$rt=' ↑ 正在抢筹 '.$ints;
			}else{
				echo "\033[0;31m";
				$rt=' ↑ '.$ints;
			}
		}elseif($ints==0){
			echo "\033[1;37m";
			$rt=' -- ';
		}
		else{
			echo "\033[1;32m";
			$rt=' ↓ '.$ints;
		}
	}else{
		$rt=' -- ';
	}
echo date('H:i:s').' '.$data.$rt."\n";
$_SESSION['vel']=$data;
sleep(6);
}


function curl_get($url){
	    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
	//显示获得的数据
    return substr($data,30,4);
}

function subData($data){
	
	/*
	v_sh600519="1~贵州茅台~600519~568.40~573.41~572.00~30388~15022~15366~568.40~0~568.35~0~568.33~2~568.19~1~568.05~1~568.41~0~568.45~55~568.50~31~568.60~1~568.70~4~14:51:39/568.40/2/S/114238/18892|14:51:36/568.35/13/B/699074/18888|14:51:33/568.41/8/S/451342/18884|14:51:30/568.41/11/S/625374/18881|14:51:24/568.60/8/S/454957/18872|14:51:18/568.60/3/M/170576/18866~20171024145139~-5.01~-0.87~573.80~563.61~568.56/30266/1718458489~30388~172535~0.24~37.25~~573.80~563.61~1.78~7140.24~7140.24~9.44~630.75~516.07~1.15";
	*/
	
	//切割成交信息
	$matches=[];
	/*preg_match_all('/(\d{8}\$[^<]+)/', $subject, $result, PREG_PATTERN_ORDER);
	for ($i = 0; $i < count($result[0]); $i++) {
		# Matched text = $result[0][$i];
	}*/
	//strstr('\/',$data);
	$start=strstr( $data, '/');
	$str=strstr($start, '~');
	$matches=explode('|',$str); 
	return $matches;
	
}
?>
