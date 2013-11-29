<?php
require_once (dirname(__FILE__)."/../ext/IKuaiZuApi.php");
class AppController extends BaseController{

	public $uuid;
	public $meta = array('title' => '');
	public $api;
	//public $_cache;
	
	public function init(){
		$req = WinBase::app()->getRequest();
		$uuid = $req->getParam("uuid",'oMJ6NjnnUSjsLBOJDIbzgV1rnrgk');
		if(!$uuid){
			die('Invalid Visit');
		}		
		$this -> uuid = $uuid;
		$this -> api = new IKuaiZuApi(array('uuid'=>$uuid));
	}	
	
	public function redirect($url){
		header('Location: '.$url);
		exit();
	}
	
    function getReferer($referer = ''){

        if (empty($referer)) {
            $referer = WinBase::app()->getRequest()->getParam('referer');
            $referer = !empty($referer) ? $referer : WinBase::app()->getUri()->getUri();
		}

        $referer = htmlspecialchars($referer);
        $referer = str_replace('&amp;', '&', $referer);
        $reurl = parse_url($referer);

        if (!isset($reurl['host'])) {
            $referer = '/'.ltrim($referer, '/');
        }
        return strip_tags($referer);
    }	
	
	public function setMeta($key,$value){
		$this->meta[$key]=$value;
	}
	
    public function showMessage($message, $msg_type = 0, $links = array()){
		$this->render('/common/message', array(
			'message'       => $message,
			'links'         => $links,
			'msg_type'      => $msg_type
		));
		exit();
    }
}