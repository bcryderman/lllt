<?php
class BillToController extends Zend_Controller_Action {
	
	public function init() {
    	
        
    }
    

    public function indexAction() {
		$data = new LLLT_Model_Customer();
//		$d = array( 'name'=>'Preston',
//					'customer_type_id'=>1,
//					'quickbook_print'=>0,
//					'active'=>1,
//					'created'=>new Zend_Db_Expr('CURDATE()'),
//					'created_by'=>123,
//					'last_updated'=>new Zend_Db_Expr('CURDATE()'),
//					'last_updated_by'=>123);

		$d = array( 'name'=>'Prestonwdd',
					'last_updated'=>new Zend_Db_Expr('CURDATE()'),
					'last_updated_by'=>123);
		$x = $data->upd_customer(10,$d);
		//var_dump($this->_helper->getHelper('Xmlbuilder')->getxml(2));

    }
    
  
}