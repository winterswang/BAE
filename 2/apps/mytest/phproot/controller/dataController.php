<?php
require_once(dirname(__FILE__)."/../libraries/bcs/bcs.class.php");
class dataController extends AppController 
{
	//////负责存储上传到照片到云存储
	//////负责将照片地址，faceAPI信息存储到云数据库
    public function actionTest(){
    	echo "test\r\n";	
    }
    public function actionUploadPic()
    {
    	$bae = Config::getConfig('system','bae');

		if($_SERVER['REQUEST_URI']) 
		{
			$temp = urldecode($_SERVER['REQUEST_URI']);
			if(strpos($temp, '<') !== false || strpos($temp, '>') !== false || strpos($temp, '(') !== false || strpos($temp, '"') !== false) 
			{
				exit('Request Bad url');
			}
		}
		if($_FILES['Filedata']['size'] != 0)
		{
			$attach = $_FILES['Filedata'];
			$old_attachName = mb_detect_encoding($attach['name'])=='UTF-8'?$attach['name']:iconv('gbk',"utf-8",$attach['name']);
			$attach['ext']  = explode('.', $attach['name']);

			
			$year = date("Y");
			$month = date("m");
			$day = date("d");
			$ext = $attach['ext'][1];

			
			$path =$attach['tmp_name'];
			$opt=array(
				"filename"=>$old_attachName,
				"acl"=>"public-read"
			);

			$fnamehash = md5(uniqid(microtime()));
			$object = '/'.$year.'/'.$month.'/'.$day.'/'.$fnamehash.'.'.$ext;
			$baiduBCS = new BaiduBCS( $bae['ak'], $bae['sk'], $bae['host']);

			if (in_array($ext,array('exe','cmd','sh','torrent'))) 
			{
				@unlink($attach['tmp_name']);
				echo "these filetypes are not support\r\n";
			}

			if ($attach['size'] > $bae['max_upload_size'])
	 		{ 
	 			@unlink($attach['tmp_name']);	 			
	 			echo "size is too big \r\n"; 
	 		}

	 		$response = $baiduBCS->create_object( $bae['bucket'], $object, $path ,$opt);
 			if (! $response->isOK ()){
 				die ( "Create object failed." );	 				
 			}
 			$url=$response->header['_info']['url'];
 			$arr=explode("?",$url);
			$url=urldecode($arr[0]);
			$url=preg_replace('/\/\//','/',$url);
			$url=preg_replace('/http:\//','http://',$url);
			echo "filedata has size: $url \r\n";
		}
		else{
			echo "sth is wrong";
		}
    } 
    public function actionSavePicDb(){

    }
}