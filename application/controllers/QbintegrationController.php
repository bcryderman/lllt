<?php
class QbintegrationController extends Zend_Controller_Action {
	
	private $emp_id;
	private $_params;
	private $_load_obj;
	private $_load_id;
	
	
	public function init(){
	}
	
	public function indexAction(){
		$this->_helper->layout()->disableLayout();
		//$this->view->_dsn = 'mysql://lllt:21dive@localhost/qb_lllt';
	}
	
	
	public function addinvoiceAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$invoice = $this->_helper->getHelper('QbInvoice');
		$request = $this->getRequest();
    	$params = $request->getParams();
    	$this->_load_id = $params['load_id'];
    	$this->getloaddata();

		$invoice->buildInvoice($this->_load_obj);
	}
	
	public function serverAction(){
		
	}

	private function getloaddata(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$auth = Zend_Auth::getInstance()->getIdentity(); 
	   
		$request = $this->getRequest();
    	$params = $request->getParams();
   
    	$load = array();
    	$data = new LLLT_Model_LoadMapper();
		$this->_load_obj = $data->find($this->_load_id);
	}
	
	
	
}