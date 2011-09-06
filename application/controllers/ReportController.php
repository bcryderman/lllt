<?php
class ReportController extends Zend_Controller_SecureAction {
	
	private $emp_id;
	private $_params;
	private $_delivery_type= array (array('value'=>'1','description'=>'Taken out of State'),
									array('value'=>'2','description'=>'Brought in State'),
									array('value'=>'3','description'=>'Intra State')
				);
	
	public function init(){
		$this->view->title = 'Reports';
		$auth = Zend_Auth::getInstance()->getIdentity(); 
		$this->emp_id =$auth['Employee']->getEmp_id();
		

	}
	
	public function indexAction(){
		
	}
	
	public function statereportAction(){
		$this->view->deliverytype=$this->_delivery_type;
	}
	

}