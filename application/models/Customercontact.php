<?php
class LLLT_Model_Customercontact{
	
	public function sel_customer_by_contact($contact_id){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->setFetchMode(Zend_Db::FETCH_ASSOC);
		$select = $dbAdapter->select()
				->from('tbl_customer_contact')
				->where('active = 1')
				->where('contact_id = ?',$contact_id);
		$stmt = $dbAdapter->query($select);
		$result = $stmt->fetchAll();
		return $result;	
	}
	
	public function sel_customer_by_customer($customer_id){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->setFetchMode(Zend_Db::FETCH_ASSOC);
		$select = $dbAdapter->select()
				->from('tbl_customer_contact')
				->where('active = 1')
				->where('customer_id = ?',$customer_id);
		$stmt = $dbAdapter->query($select);
		$result = $stmt->fetchAll();
		return $result;	
	}
	
	public function ins_customer_contact($data){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->insert('tbl_customer_contact',$data);
	}
	
	public function upd_customer_contact($contact_id,$data){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->update('tbl_customer_contact',$data,'contact_id ='.$contact_id);
	}

}