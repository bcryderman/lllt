<?php

class CarrierdiscountsController extends Zend_Controller_Action {

    public function init() {}

	public function addAction() {
    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {

	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');
		    			    	
		    	$carrierDiscount = new LLLT_Model_CarrierDiscount();
		
		    	$carrierDiscount->setCompany_id($params['company_id']);
		    	$carrierDiscount->setStart_date(date('Y-m-d', strtotime($params['start_date'])));
				$carrierDiscount->setEnd_date(date('Y-m-d', strtotime($params['end_date'])));
				$carrierDiscount->setDiscount($params['discount']);
		    	$carrierDiscount->setCreated($date);
	    		$carrierDiscount->setCreated_by($auth['Employee']->getEmp_id());
	    		$carrierDiscount->setLast_updated($date);
	    		$carrierDiscount->setLast_updated_by($auth['Employee']->getEmp_id());
	    			    		
		    	$carrierDiscountMapper = new LLLT_Model_CarrierDiscountMapper();
		    	$carrierDiscountMapper->add($carrierDiscount);
		    	
		    	$this->_redirect('carrierdiscounts/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
		}
    
    	$this->view->type = 'add';
    	$this->renderScript('carrierdiscounts/form.phtml');
    }
        
    public function deleteAction() {
    
        $request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$carrierDiscountMapper = new LLLT_Model_CarrierDiscountMapper();
	    $carrierDiscount = $carrierDiscountMapper->find($params['id']);
	    	    	
    	if ($request->isPost()) {
    		
    		$carrierDiscountMapper->delete($carrierDiscount);
	    	
	    	$this->_redirect('carrierdiscounts/view');
    	}    	

		$customerMapper = new LLLT_Model_CustomerMapper();
		$customer = $customerMapper->find($carrierDiscount->getCompany_id());
     	
    	$this->view->carrierDiscount = $carrierDiscount;
		$this->view->company = $customer;
    	$this->view->params = $params;
    }
        
    public function editAction() {
    
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');  

		    	$carrierDiscount = new LLLT_Model_CarrierDiscount();
		
				$carrierDiscount->setId($params['id']);
		    	$carrierDiscount->setCompany_id($params['company_id']);
		    	$carrierDiscount->setStart_date(date('Y-m-d', strtotime($params['start_date'])));
				$carrierDiscount->setEnd_date(date('Y-m-d', strtotime($params['end_date'])));
				$carrierDiscount->setDiscount($params['discount']);
		    	$carrierDiscount->setCreated($date);
	    		$carrierDiscount->setCreated_by($auth['Employee']->getEmp_id());
	    		$carrierDiscount->setLast_updated($date);
	    		$carrierDiscount->setLast_updated_by($auth['Employee']->getEmp_id());
		    	
		    	$carrierDiscountMapper = new LLLT_Model_CarrierDiscountMapper();
		    	$carrierDiscountMapper->edit($carrierDiscount);
		    	
		    	$this->_redirect('carrierdiscounts/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->id = $params['id'];
		    	$this->view->params = $params;	
		    	$this->view->type = 'edit';	    	
		    }
		}		
    	else {
    		
	    	$carrierDiscountMapper = new LLLT_Model_CarrierDiscountMapper();
	    	$carrierDiscount = (array) $carrierDiscountMapper->find($params['id']);
	    	    	
	    	$fields = array();
	    	
	    	foreach ($carrierDiscount as $k => $v) {
	  
	    		$fields[substr($k, 4)] = $carrierDiscount[$k];
	    	}
	    	
	    	$this->view->id = $params['id'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('carrierdiscounts/form.phtml');
    }
    
    public function viewAction() {
    	
		$carrierDiscountMapper = new LLLT_Model_CarrierDiscountMapper();
		$carrierDiscounts = $carrierDiscountMapper->fetchAll(null, 'start_date asc');
		
		$customerMapper = new LLLT_Model_CustomerMapper();
		$customers = $customerMapper->fetchAll(null, 'name asc');
		
		$customersArr = array();
    	
    	foreach ($customers as $item) {
    		
    		$customersArr[$item->getCustomer_id()] = $item;
    	}
		
    	$this->view->carrierDiscounts = $carrierDiscounts;
		$this->view->customers = $customersArr;
    }
    
	public function validation($params) {
    	
    	$errors = array();
	    	
    	if (empty($params['company_id'])) {
    		
    		$errors['company_id'] = 'You must select a company.';
    	}
    	
		if (empty($params['start_date'])) {
    		
    		$errors['start_date'] = 'You must enter a start date.';
    	}
    	else if (!is_int((int) substr($params['start_date'], 0, 2)) || !is_int((int) substr($params['start_date'], 3, 2)) || !is_int((int) substr($params['start_date'], 6, 4)) ||    			 
    			 !checkdate((int) substr($params['start_date'], 0, 2), (int) substr($params['start_date'], 3, 2), (int) substr($params['start_date'], 6, 4))) {
    		
    		$errors['start_date'] = 'The start date you entered is formatted incorrectly.';    		
    	}
    	
		if (empty($params['end_date'])) {
    		
    		$errors['end_date'] = 'You must enter an end date.';
    	}
    	else if (!is_int((int) substr($params['end_date'], 0, 2)) || !is_int((int) substr($params['end_date'], 3, 2)) || !is_int((int) substr($params['end_date'], 6, 4)) ||    			 
    			 !checkdate((int) substr($params['end_date'], 0, 2), (int) substr($params['end_date'], 3, 2), (int) substr($params['end_date'], 6, 4))) {
    		
    		$errors['end_date'] = 'The end date you entered is formatted incorrectly.';    		
    	}

		if (empty($params['discount'])) {
    		
    		$errors['discount'] = 'You must enter a discount.';
    	}
    	
    	return $errors;
    }
}