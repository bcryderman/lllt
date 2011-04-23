<?php
class LLLT_Model_Customer{
	
	public function sel_customer($customer_type){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->setFetchMode(Zend_Db::FETCH_OBJ);
		$select = $dbAdapter->select()
				->from('tbl_customer')
				->where('active = 1')
				->where('customer_type_id = ?',$customer_type);
		$stmt = $dbAdapter->query($select);
		$result = $stmt->fetchAll();
		return $result;	
	}
	
	public function sel_customer_by_id($customer_id){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->setFetchMode(Zend_Db::FETCH_OBJ);
		$select = $dbAdapter->select()
				->from('tbl_customer')
				->where('active = 1')
				->where('customer_id = ?',$customer_id);
		$stmt = $dbAdapter->query($select);
		$result = $stmt->fetchAll();
		return $result;	
	}
	
	public function ins_customer($data){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$x = $this->modify_data($data);
		$dbAdapter->insert('tbl_customer',$x);
	}
	
	public function upd_customer($cust_id,$data){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$x = $this->modify_data($data);
		$dbAdapter->update('tbl_customer',$x,'customer_id ='.$cust_id);
	}
	
	private function modify_data($data)
	{
		if(isset($data['color_code']))
		{$data['color_code']=str_replace('#','',$data['color_code']);}
		return $data;
	}
}