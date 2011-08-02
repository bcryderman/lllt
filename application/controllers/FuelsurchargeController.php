<?php

class FuelsurchargeController extends Zend_Controller_Action {
	
	public $auth;
    public function init() {
    $this->auth = Zend_Auth::getInstance()->getIdentity();
    }
    

    public function addAction() {
    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {

	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	$date = date('Y-m-d H:i:s');
		    	
		    	$data = new LLLT_Model_Fuelsurcharge();
		    	$data->setCustomer_id($params['customer_id']);
		    	$data->setFuel_surcharge($params['fuel_surcharge']);
		    	$data->setStart_date(date('Y-m-d', strtotime($params['start_date'])));
		    	$data->setEnd_date(null);
		    	$data->setCreated($date);
	    		$data->setCreated_by($this->auth['Employee']->getEmp_id());
	    		$data->setLast_updated($date);
	    		$data->setlast_updated_by($this->auth['Employee']->getEmp_id());
		    			    	
		    	$dataMapper = new LLLT_Model_FuelsurchargeMapper();
		    	$dataMapper->add($data);
		    	
		    	$this->_redirect('fuelsurcharge/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
		}

		$this->view->type = 'add';
		$this->renderScript('fuelsurcharge/form.phtml');
    }
    
    public function deleteAction() { 
	    
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$dataMapper = new LLLT_Model_FuelsurchargeMapper();
	    $data = $dataMapper->find($params['fuelsurcharge']);
	    	
    	if ($request->isPost()) {
    		$fs = new LLLT_Model_Fuelsurcharge();
    		$fs->setId($params['fuelsurcharge']);
    		$dataMapper->delete($fs);
	    	
	    	$this->_redirect('fuelsurcharge/view');
    	}    	

    	$this->view->data = $data;	
    	$this->view->params = $params;
    }
    
    public function editAction() {
    	
        $request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$date = date('Y-m-d H:i:s');
		    	
		    	$data = new LLLT_Model_Fuelsurcharge();
		    	$data->setId($params['id']);
		    	$data->setCustomer_id($params['customer_id']);
		    	$data->setFuel_surcharge($params['fuel_surcharge']);
		    	$data->setStart_date(date('Y-m-d', strtotime($params['start_date'])));
		    	$data->setEnd_date(null);
		    	$data->setCreated($date);
	    		$data->setCreated_by($this->auth['Employee']->getEmp_id());
	    		$data->setLast_updated($date);
	    		$data->setlast_updated_by($this->auth['Employee']->getEmp_id());		    	
		    	
		    	$dataMapper = new LLLT_Model_FuelsurchargeMapper();
		    	$dataMapper->edit($data);
		    	
		    	$this->_redirect('fuelsurcharge/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->reminderTypeId = $params['reminder_type_id'];
		    	$this->view->params = $params;	
		    	$this->view->type = 'edit';	    	
		    }
		}		
    	else {
    		
	    	$dataMapper = new LLLT_Model_FuelsurchargeMapper();
			$fs = (array) $dataMapper->find($params['fuelsurcharge']);
	    	

	    	$fields = array();

	    	foreach ($fs as $k => $v) {

	    		$fields[substr($k, 4)] = $fs[$k];
	    	}

	    	$this->view->id = $params['fuelsurcharge'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('fuelsurcharge/form.phtml');
    }
    
    public function viewAction() {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	$where = null;
    	$this->view->header = 'All';
    	if(isset($params['today']))
    	{
    		$date = date('Y-m-d');
    		$where = array('last_updated >= ?' => $date);
    		$this->view->header = 'Today\'s ';
    		
    	}
    	elseif(isset($params['search']))
    	{
    		$this->view->header = 'Search';
    		$where = $this->buildwhere($params);

    	}
    	
    	$dataMapper = new LLLT_Model_FuelsurchargeMapper();
    	$data = $dataMapper->fetchAll($where, 'start_date asc');
    	
    	$this->view->rates = $data;
    }
    
    public function searchAction(){
    	//$ratesMapper = new LLLT_Model_RatesMapper();
    	//$rates = $ratesMapper->fetchAll(null, 'start_date asc');
    }
    
    public function validation($params) {
    	
    	$errors = array();
	    	
    	if (empty($params['customer_id'])) {
    		
    		$errors['customer_id'] = 'You must enter a Customer.';
    	}
    	    	
        if (empty($params['start_date'])) {
    		
    		$errors['start_date'] = 'You must enter a Effective Date.';
    	}
       
    	if (empty($params['fuel_surcharge'])) {
    		
    		$errors['fuel_surcharge'] = 'You must enter a fuel surcharge.';
    	}

    	
    	return $errors;
    }
    
    public function buildwhere($params){
    	$retval=array();
    	if (!empty($params['customer_id'])) {
    		
    		$retval['customer_id = ?']= $params['customer_id'];
    	}
        if (!empty($params['fuel_surcharge'])) {
    		
    		$retval['fuel_surcharge = ?']= $params['fuel_surcharge'];
    	}
    	if (!empty($params['start_date'])&&!empty($params['end_date'])) {
    		
    		$retval['start_date >= ?']= date('Y-m-d', strtotime($params['start_date']));
    		$retval['start_date <= ?']= date('Y-m-d', strtotime($params['end_date']));
    	}
       if (!empty($params['start_date'])&& empty($params['end_date'])) {
    		
    		$retval['start_date = ?']= date('Y-m-d', strtotime($params['start_date']));
    	}
   
    	if(count($retval)==0){
    		$retval = null;
    	}
    	return $retval;
    	
    }
}