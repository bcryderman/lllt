<?php
class CustomerController extends Zend_Controller_Action {
	
	public function init() {
    	
        
    }
    
    public function menuAction(){
    	
    }
    

    public function indexAction() {
    	
    	$Post_params = $this->_request->getPost();
    	$page_params = $this->_request->getParams();
    	//Set the customer type
    	//if no customer type is set then default the type to 1
    	if(isset($page_params['_cust_type']))
    	{$cust_type = $page_params['_cust_type'];}
    	else
    	{$cust_type = 1;}
    	$this->view->page_data = $this->_helper->getHelper('PageData')->build_page_data($cust_type);
    	
    	if(count($Post_params)==0){
    		$this->view->cust_data = $this->_helper->getHelper('Jsonbuilder')->getJson($cust_type);  	
    	}
    	else
    	{

    		if($Post_params['_mode'] == 'update')
    		{
    			$this->_helper->layout->disableLayout();
    			//$this->view->post_params = $Post_params;
    			$cust_data = $this->updateform($Post_params);
    			$page_params['cust_data'] = $cust_data;
    			$this->view->page_params = $page_params;
    			$this->render($Post_params['_page']);
    			
    		}
    		elseif($Post_params['_mode'] == 'add')
    		{
    			$this->_helper->layout->disableLayout();
    			$this->view->page_params = $page_params;

    			$this->render('form');	
    		}
    	}

    }
    
    public function updateform($Post_params){
    	
    	$data = new LLLT_Model_Customer();
    	$cust_data = $data->sel_customer_by_id($Post_params['customer_id']);
    	return $cust_data;
    }
    
    public function addform(){}
    public function formAction(){
    	
    }
    public function submitAction(){
    	$this->_helper->layout->disableLayout();
    	$contact_id = 123;
    	$params = $this->_request->getPost();

    	if(count($params)>0)
    	{
    		$sub_type = $params['formtype'];
    		$params = array_splice($params,1);
    		$data = new LLLT_Model_Customer();
    		
    		$params['last_updated']=new Zend_Db_Expr('CURDATE()');
    		$params['last_updated_by']=$contact_id;
    		if($sub_type == 'add')
    		{
    			$params['created_by']=$contact_id;
    			$params['created']=new Zend_Db_Expr('CURDATE()');

    			$x = $data->ins_customer($params);
    			$x = $this->_helper->getHelper('Jsonbuilder')->updatejson($params['customer_type_id']);
    		}
    		else if($sub_type =='update')
    		{	var_dump($params);
    			$x = $data->upd_customer($params['customer_id'],$params);
    			$x = $this->_helper->getHelper('Jsonbuilder')->updatejson($params['customer_type_id']);
    			if($x >= 0)
    			{
    				echo json_encode($params);
    			}
    			else
    			{
    				echo json_encode(array('error'=>$x));
    			}
    		}

    	}
    	
    	
    }
    
  
}