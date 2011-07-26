<?php

class DispatchController extends Zend_Controller_SecureAction {

    public function init() {
    	    	  	  $auth = Zend_Auth::getInstance()->getIdentity();
    	$this->view->emp_id = $auth['Employee']->getEmp_id();
    		   }

    public function indexAction() {
        $vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;
    	$employees = $vemploadsMapper->fetchAll($where,'last_name asc');

    	//$this->view->employees = $employees;
    var_dump($employees);
    }
    
    public function getdriversAction(){
    	
    	$employeeMapper = new LLLT_Model_VemploadsMapper();
    	$employees = $employeeMapper->fetchAll(null, array('e.last_name asc', 'e.first_name asc'));

    	$this->view->employees = $employees;
    }
    
    public function dispatchAction(){
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();
    	$params = $this->_request->getParams();
    	var_dump($params);
    	$fuelsurcharge = new LLLT_Model_FuelSurchargeMapper();
    	var_dump($fuelsurcharge->getlatest(875));

    	if(isset($params['emp_id'])){
    		
    		if($params['delayed_dispatch']==0 && $params['multi_dispatch']==0)
    		{
    			$this->view->load_data = $params;
    		}
    	
    	}
    	//echo json_encode($params);
    }
    

    
	public function emptabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();


    	$vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;

		if ($params['column'] === 'last_name') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'last_name ' . $params['sort']);
		}
		else if ($params['column'] === 'dispatched_loads') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'dispatched_loads ' . $params['sort']);
		}
		else if ($params['column'] === 'pending_loads') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'pending_loads ' . $params['sort']);
		}
		else {
			
			$employees = $vemploadsMapper->fetchAll(null, 'last_name ' . $params['sort']);
		}

    	$this->view->data = $employees;
	}
	
	public function loadtabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		


		$request = $this->getRequest();
    	$params = $request->getParams();


    	$loadMapper = new LLLT_Model_LoadMapper();
        $where= NULL;

		if ($params['column'] === 'origin') {
			
			$loads = $loadMapper->fetchAll(null, 'c4.city ' . $params['sort'] . ', c4.state ' . $params['sort'] . ', c4.name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else if ($params['column'] === 'destination') {
			
			$loads = $loadMapper->fetchAll(null, 'c6.city ' . $params['sort'] . ', c6.state ' . $params['sort'] . ', c6.name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else if ($params['column'] === 'driver') {
			
			$loads = $loadMapper->fetchAll(null, 'e.last_name ' . $params['sort'] . ', e.first_name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else {
			
			$loads = $loadMapper->fetchAll(null, $params['column'] . ' ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}

    	$this->view->loads = $loads;
    	
	}
	
	public function lockloadAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$auth = Zend_Auth::getInstance()->getIdentity(); 
	    $date = date('Y-m-d H:i:s');
		$request = $this->getRequest();
    	$params = $request->getParams();
    	$load = new LLLT_Model_Load();
    	$load->setLoad_id($params['load_id'])
    	->setLoad_locked($params['load_locked'])
		->setLast_updated($date)
		->setLast_updated_by($auth['Employee']->getEmp_id())
		->setLocked_by($auth['Employee']->getEmp_id());
    	$loadMapper = new LLLT_Model_LoadMapper();

   		$locked = $loadMapper->find($params['load_id']);
   		
   		if($locked->getLoad_locked()==1&& $locked->getLocked_by()!=$auth['Employee']->getEmp_id())
   		{
   			//load is already locked by another employee
   			echo json_encode(array('lock_status'=>'3','locked_by'=>$locked->getLocked_by()));
   		}
   		else
   		{
   			$loadMapper->lockload($load);
   			echo json_encode(array('lock_status'=>$params['load_locked']));
   		}

    	
    	
    	
    	
    	//$loadMapper->edit($load);
	}
    
    public function viewAction() {
    	
    	$vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;
    	$employees = $vemploadsMapper->fetchAll($where,'last_name asc');
    	

    	$loadMapper = new LLLT_Model_LoadMapper();
    	$loads = $loadMapper->fetchAll(null, 'l.delivery_date asc');

		
    	$this->view->loads = $loads;
    	$this->view->loadsarray = $this->buildloadarray($loads);	
    	$this->view->data = $employees;
    }
    
    private function buildloadarray($loads){
        $loadsarray = array();
    	foreach ($loads as $item){
    		$loadsarray[$item->getLoad_id()]= array('bill_to_id'	=>$item->getBill_to_id(),
    												'shipper_id'	=>$item->getShipper_id(),
    												'destination_id'=>$item->getDestination_id());
    	}
    	return $loadsarray;
    }
}