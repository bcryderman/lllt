<?php
class CustomerController extends Zend_Controller_Action {
	
	public $auth;
    
	public function init() {
    $this->auth = Zend_Auth::getInstance()->getIdentity();
    }
    

    public function addAction() {
    	
    	$request = $this->getRequest();
    	$params = $request->getParams();
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	$date = date('Y-m-d H:i:s');
		    	
		    	$data = new LLLT_Model_Customer();
		    	$data->setActive(1);
		    	$data->setName($params['name']);
		    	$data->setAddr($params['addr']);
		    	$data->setAddr2($params['addr2']);
		    	$data->setCity($params['city']);
		    	$data->setState($params['state']);
		    	$data->setZip($params['zip']);
		    	$data->setZip4($params['zip4']);
		    	$data->setFein($params['fein']);
		    	$data->setColor_code(str_replace('#','',$params['color_code']));
		    	$data->setCustomer_type_id($params['customer_type_id']);
		    	$data->setNotes(trim($params['notes']));
		    	$data->setCreated($date);
	    		$data->setCreated_by($this->auth['Employee']->getEmp_id());
	    		$data->setLast_updated($date);
	    		$data->setlast_updated_by($this->auth['Employee']->getEmp_id());
		    			    	
		    	$dataMapper = new LLLT_Model_CustomerMapper();
		    	$dataMapper->add($data);
		    	
		    	$this->_redirect('customer/view/customertype/'.$params['customer_type_id']);
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
		}
		$params['customer_type_id']=$params['customertype'];
		$this->view->params = $params;
		$this->view->type = 'add';
		$this->renderScript('customer/form.phtml');
    }
    
 public function activeAction() {
    	
        $request = $this->getRequest();
    	$params = $request->getParams();
    	$this->_helper->layout->disableLayout();	
    	if (isset($params['active'])) {

		    	
		    	$data = new LLLT_Model_Customer();
		    	$data->setCustomer_id($params['customerid']);
		    	$data->setActive($params['active']);
		    	$data->setLast_updated($date);
	    		$data->setlast_updated_by($this->auth['Employee']->getEmp_id());		    	
		    	
		    	$dataMapper = new LLLT_Model_CustomerMapper();
		    	$dataMapper->active($data);
		    	$this->_redirect('customer/view/customertype/'.$params['customertype']);
		}		

    }
    
    public function deleteAction() { 
//	    
//    	$request = $this->getRequest();
//    	$params = $request->getParams();
//    	
//    	$dataMapper = new LLLT_Model_FuelsurchargeMapper();
//	    $data = $dataMapper->find($params['fuelsurcharge']);
//	    	
//    	if ($request->isPost()) {
//    		$fs = new LLLT_Model_Fuelsurcharge();
//    		$fs->setId($params['fuelsurcharge']);
//    		$dataMapper->delete($fs);
//	    	
//	    	$this->_redirect('fuelsurcharge/view');
//    	}    	
//
//    	$this->view->data = $data;	
//    	$this->view->params = $params;
    }
    
    public function editAction() {
    	
        $request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$date = date('Y-m-d H:i:s');
		    	
		    	$data = new LLLT_Model_Customer();
		    	$data->setCustomer_id($params['customer_id']);
		    	$data->setName($params['name']);
		    	$data->setAddr($params['addr']);
		    	$data->setAddr2($params['addr2']);
		    	$data->setCity($params['city']);
		    	$data->setState($params['state']);
		    	$data->setZip($params['zip']);
		    	$data->setZip4($params['zip4']);
		    	$data->setFein($params['state']);
		    	$data->setColor_code(str_replace('#','',$params['color_code']));
		    	$data->setNotes(trim($params['notes']));
	    		$data->setLast_updated($date);
	    		$data->setlast_updated_by($this->auth['Employee']->getEmp_id());		    	
		    	
		    	$dataMapper = new LLLT_Model_CustomerMapper();
		    	$dataMapper->edit($data);
		    	
		    	$this->_redirect('customer/view/customertype/'.$params['customer_type_id']);
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;	
		    	$this->view->type = 'edit';	    	
		    }
		}		
    	else {
    		
	    	$dataMapper = new LLLT_Model_CustomerMapper();
			$fs = (array) $dataMapper->find($params['customerid']);
	    	

	    	$fields = array();

	    	foreach ($fs as $k => $v) {

	    		$fields[substr($k, 4)] = $fs[$k];
	    	}

	    	$this->view->id = $params['customerid'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('customer/form.phtml');
    }
    
    public function viewAction() {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	$where = null;
    	$this->view->header = 'All';
    	if(isset($params['customertype']))
    	{
    		$where['customer_type_id = ?']= $params['customertype'];
    		if(isset($params['active']))
    		{
    			$where['active = ?']= $params['active'];
    			$this->view->active = $params['active'];
    			
    		}
    		else
    		{
    			$where['active = ?']= 1;
    			$this->view->active = 1;
    		}
    		
    	}

    	$dataMapper = new LLLT_Model_CustomerMapper();
    	$data = $dataMapper->fetchAll($where , 'last_updated asc');
    	$this->view->customertype = $params['customertype'];

    	$this->view->data = $data;
    }
    
    public function searchAction(){
    	//$ratesMapper = new LLLT_Model_RatesMapper();
    	//$rates = $ratesMapper->fetchAll(null, 'start_date asc');
    }
    
    public function validation($params) {
    	
    	$errors = array();
	    	
//    	if (empty($params['customer_id'])) {
//    		
//    		$errors['customer_id'] = 'You must enter a Customer.';
//    	}
//    	    	
//        if (empty($params['start_date'])) {
//    		
//    		$errors['start_date'] = 'You must enter a Effective Date.';
//    	}
//       
//    	if (empty($params['fuel_surcharge'])) {
//    		
//    		$errors['fuel_surcharge'] = 'You must enter a fuel surcharge.';
//    	}

    	
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
    
	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

		$auth = Zend_Auth::getInstance()->getIdentity();

    	$dataMapper = new LLLT_Model_CustomerMapper();
    	$where=array('active = ?'=>1,'customer_type_id = ?'=>$params['customertype']);

		if ($params['column'] === 'c1.name') {
			
			$data = $dataMapper->fetchAll($where , 'name '.$params['sort']);
			
		}
		else if ($params['column'] === 'c1.address') {
			
			$data = $dataMapper->fetchAll($where , 'addr '.$params['sort']);
			
		}
		else if ($params['column'] === 'c1.city') {
			
			$data = $dataMapper->fetchAll($where , 'city '.$params['sort']);
			
		}
		else if ($params['column'] === 'c1.state') {
			
			$data = $dataMapper->fetchAll($where , 'state '.$params['sort']);
			
		}
		else if ($params['column'] === 'c1.zip') {
			
			$data = $dataMapper->fetchAll($where , 'zip '.$params['sort']);
			
		}
		else if ($params['column'] === 'c1.fein') {
			
			$data = $dataMapper->fetchAll($where , 'fein '.$params['sort']);
			
		}
		else if ($params['column'] === 'c1.color') {
			
			$data = $dataMapper->fetchAll($where , 'color_code '.$params['sort']);	
		}
		else {
			
				$data = $dataMapper->fetchAll($where , 'name '.$params['sort']);
		}

    	$this->view->data = $data;
	}
}