<?php
class CustomercontactController extends Zend_Controller_Action {
	
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
		    	
		    	$data = new LLLT_Model_Customercontact();
		    	$data->SetCustomer_id($params['customer_id']);
		    	$data->setActive(1);
		    	$data->setFirst_name($params['first_name']);
		    	$data->setLast_name($params['last_name']);
		    	$data->setPhone($params['phone']);
		    	$data->setPhone_ext($params['phone_ext']);
		    	$data->setCell_phone($params['cell_phone']);
		    	$data->setFax_phone($params['fax_phone']);
		    	$data->setEmail($params['email']);
		    	$data->setNotes(trim($params['notes']));
		    	$data->setCreated($date);
	    		$data->setCreated_by($this->auth['Employee']->getEmp_id());
	    		$data->setLast_updated($date);
	    		$data->setlast_updated_by($this->auth['Employee']->getEmp_id());
		    			    	
		    	$dataMapper = new LLLT_Model_CustomercontactMapper();
		    	$dataMapper->add($data);
		    	
		    	$this->_redirect('customercontact/view/customerid/'.$params['customer_id']);
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
		}
		$params['customerid']=$params['customerid'];
		$this->view->params = $params;
		$this->view->type = 'add';
		$this->renderScript('customercontact/form.phtml');
    }
    
 public function activeAction() {
    	
        $request = $this->getRequest();
    	$params = $request->getParams();
    	$this->_helper->layout->disableLayout();	
    	if (isset($params['active'])) {

		    	
		    	$data = new LLLT_Model_Customercontact();
		    	$data->setContact_id($params['contactid']);
		    	$data->setActive($params['active']);
		    	$data->setLast_updated($date);
	    		$data->setlast_updated_by($this->auth['Employee']->getEmp_id());		    	
		    	
		    	$dataMapper = new LLLT_Model_CustomercontactMapper();
		    	$dataMapper->active($data);
		    	$this->_redirect('customercontact/view/customerid/'.$params['customerid']);
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
		    	
		    	$data = new LLLT_Model_Customercontact();
		    	$data->setContact_id($params['contact_id']);
		    	$data->setFirst_Name($params['first_name']);
		    	$data->setLast_Name($params['last_name']);
		    	$data->setPhone($params['phone']);
		    	$data->setPhone_ext($params['phone_ext']);
		    	$data->setCell_Phone($params['cell_phone']);
		    	$data->setFax_Phone($params['fax_phone']);
		    	$data->setEmail($params['email']);
		    	$data->setNotes(trim($params['notes']));
	    		$data->setLast_updated($date);
	    		$data->setlast_updated_by($this->auth['Employee']->getEmp_id());		    	
		    	
		    	$dataMapper = new LLLT_Model_CustomercontactMapper();
		    	$dataMapper->edit($data);
		    	
		    	$this->_redirect('customercontact/view/customerid/'.$params['customer_id']);
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;	
		    	$this->view->type = 'edit';	    	
		    }
		}		
    	else {
    		
	    	$dataMapper = new LLLT_Model_CustomercontactMapper();
			$fs = (array) $dataMapper->find($params['contactid']);
	    	

	    	$fields = array();

	    	foreach ($fs as $k => $v) {

	    		$fields[substr($k, 4)] = $fs[$k];
	    	}

	    	$this->view->id = $params['contactid'];
	    	$this->view->customerid = $params['customerid'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('customercontact/form.phtml');
    }
    
    public function viewAction() {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	$where = null;
    	$this->view->header = 'All';
    	if(isset($params['customerid']))
    	{
    		$where['customer_id']= $params['customerid'];
    		if(isset($params['active']))
    		{
    			$where['active']= $params['active'];
    			$this->view->active = $params['active'];
    			
    		}
    		else
    		{
    			$where['active']= 1;
    			$this->view->active = 1;
    		}
    		
    	}


    	$dataMapper = new LLLT_Model_CustomercontactMapper();
    	$data = $dataMapper->fetchall($where , 'contact_id asc');
    	
    	if(!is_array($data))
    	{
    		$customerMapper = new LLLT_Model_CustomerMapper();
    		$customer = $customerMapper->find($params['customerid']);
    		$this->view->customername=$customer->getName();
    	}
    	else
    	{
    		$this->view->customername =$data[0]->getCustomer_name();
    	}
    	
    	$this->view->customerid = $params['customerid'];

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

}