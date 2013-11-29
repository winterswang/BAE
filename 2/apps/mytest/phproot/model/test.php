<?php
class test extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function buildWhere($where = array())
    {
    	$whereArr = array();
 		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
		if(isset($where['user_id']) && $where['user_id']){
			$whereArr[] = " user_id = '".$where['user_id']."'";
		}
		if(isset($where['file_path']) && $where['file_path']){
			$whereArr[] = " file_path = '".$where['file_path']."'";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';			
    }
    public function addUser($arr){
        
		$this->getDb()->beginTransaction();

		if(!$this->insert('test',$arr)){
			$this->getDb()->rollBack();
		}        
        $this->getDb()->commit();
    }
	public function updateUser($arr,$where)
	{
        return $this->update('test',$arr, $where);
	}   	
}