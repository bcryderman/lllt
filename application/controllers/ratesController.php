<?php

class RatesController extends Zend_Controller_Action {
	
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
		    	
		    	$rate = new LLLT_Model_Rates();
		    	$rate->setBill_to_id($params['bill_to_id']);
		    	$rate->setOrigin_id($params['origin_id']);
		    	$rate->setDestination_id($params['destination_id']);
		    	$rate->setRoute_type_id($params['route_type_id']);
		    	$rate->setRate($params['rate']);
		    	$rate->setStart_date(date('Y-m-d', strtotime($params['start_date'])));
		    	$rate->setEnd_date('');
		    	$rate->setCreated($date);
	    		$rate->setCreated_by($this->auth['Employee']->getEmp_id());
	    		$rate->setLast_updated($date);
	    		$rate->setlast_updated_by($this->auth['Employee']->getEmp_id());
		    			    	
		    	$ratesMapper = new LLLT_Model_RatesMapper();
		    	$ratesMapper->add($rate);
		    	
		    	$this->_redirect('rates/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
		}

		$this->view->type = 'add';
		$this->renderScript('rates/form.phtml');
    }
    
    public function deleteAction() { 
	    
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$ratesMapper = new LLLT_Model_RatesMapper();
	    $rates = $ratesMapper->find($params['rate']);
	    	
    	if ($request->isPost()) {
    		$rate = new LLLT_Model_Rates();
    		$rate->setRate_id($params['rate']);
    		$ratesMapper->delete($rate);
	    	
	    	$this->_redirect('rates/view');
    	}    	

    	$this->view->rate = $rates;	
    	$this->view->params = $params;
    }
    
    public function editAction() {
    	
        $request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$date = date('Y-m-d H:i:s');
		    	
		    	$rate = new LLLT_Model_Rates();
		    	$rate->setRate_id($params['rate_id']);
		    	$rate->setBill_to_id($params['bill_to_id']);
		    	$rate->setOrigin_id($params['origin_id']);
		    	$rate->setDestination_id($params['destination_id']);
		    	$rate->setRoute_type_id($params['route_type_id']);
		    	$rate->setRate($params['rate']);
		    	$rate->setStart_date(date('Y-m-d', strtotime($params['start_date'])));
		    	$rate->setEnd_date('');
		    	$rate->setCreated($date);
	    		$rate->setCreated_by($this->auth['Employee']->getEmp_id());
	    		$rate->setLast_updated($date);
	    		$rate->setlast_updated_by($this->auth['Employee']->getEmp_id());		    	
		    	
		    	$ratesMapper = new LLLT_Model_RatesMapper();
		    	$ratesMapper->edit($rate);
		    	
		    	$this->_redirect('rates/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->reminderTypeId = $params['reminder_type_id'];
		    	$this->view->params = $params;	
		    	$this->view->type = 'edit';	    	
		    }
		}		
    	else {
    		
	    	$ratesMapper = new LLLT_Model_RatesMapper();
			$rate = (array) $ratesMapper->find($params['rate']);
	    	

	    	$fields = array();

	    	foreach ($rate as $k => $v) {

	    		$fields[substr($k, 4)] = $rate[$k];
	    	}

	    	$this->view->rate_id = $params['rate'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('rates/form.phtml');
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
    	
    	$ratesMapper = new LLLT_Model_RatesMapper();
    	$rates = $ratesMapper->fetchAll($where, 'start_date asc');
    	
    	$this->view->rates = $rates;
    }
    
    public function searchAction(){
    	//$ratesMapper = new LLLT_Model_RatesMapper();
    	//$rates = $ratesMapper->fetchAll(null, 'start_date asc');
    }
    
    public function validation($params) {
    	
    	$errors = array();
	    	
    	if (empty($params['bill_to_id'])) {
    		
    		$errors['bill_to_id'] = 'You must enter a Bill To.';
    	}
    	
        if (empty($params['origin_id'])) {
    		
    		$errors['origin_id'] = 'You must enter a Origin.';
    	}
    	
        if (empty($params['destination_id'])) {
    		
    		$errors['destination_id'] = 'You must enter a Destination.';
    	}
    	
        if (empty($params['route_type_id'])) {
    		
    		$errors['route_type_id'] = 'You must enter a Route Type.';
    	}
    	
        if (empty($params['start_date'])) {
    		
    		$errors['start_date'] = 'You must enter a Effective Date.';
    	}
       
    	if (empty($params['rate'])) {
    		
    		$errors['rate'] = 'You must enter a rate.';
    	}

    	
    	return $errors;
    }
    
    public function buildwhere($params){
    	$retval=array();
    	if (!empty($params['bill_to_id'])) {
    		
    		$retval['bill_to_id = ?']= $params['bill_to_id'];
    	}
        if (!empty($params['origin_id'])) {
    		
    		$retval['origin_id = ?'] = $params['origin_id'];
    	}
        if (!empty($params['destination_id'])) {
    		
    		$retval['destination_id = ?']= $params['destination_id'];
    	}
        if (!empty($params['route_type_id'])) {
    		
    		$retval['route_type_id = ?']= $params['route_type_id'];
    	}
    	if (!empty($params['start_date'])&&!empty($params['end_date'])) {
    		
    		$retval['start_date >= ?']= date('Y-m-d', strtotime($params['start_date']));
    		$retval['start_date <= ?']= date('Y-m-d', strtotime($params['end_date']));
    	}
       if (!empty($params['start_date'])&& empty($params['end_date'])) {
    		
    		$retval['start_date = ?']= date('Y-m-d', strtotime($params['start_date']));
    	}
    	if (!empty($params['rate'])) {
    		
    		$retval['rate = ?']= $params['rate'];
    	}
    	

    	if(count($retval)==0){
    		$retval = null;
    	}
    	return $retval;
    	
    }
}