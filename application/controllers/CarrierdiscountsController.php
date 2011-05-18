<?php

class CarrierdiscountsController extends Zend_Controller_Action {

    public function init() {
	
		$this->view->title = 'Carrier Discounts';
	}

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
	    
    	if ($request->isPost()) {
    		
    		$carrierDiscountMapper->delete($params['id']);
	    	
	    	$this->_redirect('carrierdiscounts/view');
    	}    	
		else {
			
			$carrierDiscount = $carrierDiscountMapper->find($params['id']);
			
			$this->view->carrierDiscount = $carrierDiscount;
		    $this->view->params = $params;
		}
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
		    	$this->view->params = $params;	
		    }
		}		
    	else {
    		
	    	$carrierDiscountMapper = new LLLT_Model_CarrierDiscountMapper();
	    	$carrierDiscount = (array) $carrierDiscountMapper->find($params['id']);
	    	    	
			$object2Array = new LLLT_Model_Object2Array();
			$object2Array->setFields($carrierDiscount);
	    	
	    	$this->view->params = $object2Array->getFields(); 	
    	}  

  		$this->view->type = 'edit';

    	$this->renderScript('carrierdiscounts/form.phtml');
    }

	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

    	$carrierDiscountMapper = new LLLT_Model_CarrierDiscountMapper();
    	$carrierDiscounts = $carrierDiscountMapper->fetchAll(null, $params['column'] . ' ' . $params['sort'] . ', tbl_customer.name ' . $params['sort']);

    	$this->view->carrierDiscounts = $carrierDiscounts;

		$this->renderScript('carrierdiscounts/tabulardata.phtml');
	}
    
    public function viewAction() {
    	
		$carrierDiscountMapper = new LLLT_Model_CarrierDiscountMapper();
		$carrierDiscounts = $carrierDiscountMapper->fetchAll(null, 'tbl_customer.name asc');
		
    	$this->view->carrierDiscounts = $carrierDiscounts;
    }
    
	public function validation($params) {
    	
    	$errors = array();
	    	
    	if (empty($params['company_id'])) {
    		
    		$errors['company_id'] = 'You must select a company.';
    	}

		if (empty($params['start_date'])) {
			
			$errors['start_date'] = 'You must enter a start date.';
		}
   		else {
			
			$date = new LLLT_Model_Date(array('date' => $params['start_date']));
			
			if (!$date->isValid()) {
				
				$errors['start_date'] = 'Start Date is formatted incorrectly or an invalid date.';
			}
		}
    	
		if (!empty($params['end_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['end_date']));
			
			if (!$date->isValid()) {
				
				$errors['end_date'] = 'End Date is formatted incorrectly or an invalid date.';
			}
		}

		if (empty($params['discount'])) {
    		
    		$errors['discount'] = 'You must enter a discount.';
    	}
    	
    	return $errors;
    }
}