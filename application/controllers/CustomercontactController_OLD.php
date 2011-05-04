<?php
class CustomercontactController extends Zend_Controller_Action {
	
	public function init()
	{
	}
	
	public function indexAction(){
		
		$contact_id= 123;
		
		$post_params = $this->_request->getPost();
		
    	$page_params = $this->_request->getParams();
    	//_method options form,contact,customer,add,update or delete
    	if(!isset($page_params['_method']))
    	{
    		echo 'Invalid Method Chosen';
    	}

    	elseif($page_params['_method']=='contact')
    	{
    		$this->contactAction();
    		$this->render($page_params['_method']);
    	}
		elseif($page_params['_method']=='customer')
    	{
    		$this->_helper->layout->disableLayout();
    		$this->customerAction();
    		$this->render($page_params['_method']);
    	}
		elseif($page_params['_method']=='add'||$page_params['_method']=='update'||$page_params['_method']=='delete')
    	{
    		
    		$form = true;
    		if(isset($post_params)&&isset($post_params['formtype']))
    		{
    			$post_params['last_updated']=new Zend_Db_Expr('CURDATE()');
    			$post_params['last_updated_by']=$contact_id;
    			$form = false;
    			//Remove formtype from the array
    			 unset($post_params['formtype']);
    		}
    		
    		
    		if($page_params['_method']=='add' && !$form)
    		{
    			$this->_helper->layout->disableLayout();
    			$post_params['created']=new Zend_Db_Expr('CURDATE()');
    			$post_params['created_by']=$contact_id;
    			$this->add($post_params);
    		}
    		else if($page_params['_method']=='add' && $form)
    		{
    			$this->_helper->layout->disableLayout();
    			$this->addAction();
    			$this->render($page_params['_method']);
    		}
    		else if($page_params['_method']=='update' && $form)
    		{
    			$this->_helper->layout->disableLayout();
    			$this->updateAction();
    			$this->render($page_params['_method']);
    		}
    	    else if($page_params['_method']=='update' && !$form)
    		{
    			$this->_helper->layout->disableLayout();
    			$this->update($post_params);
   				$this->customerAction();
   				$this->render('customer');
    		}
    	    else if($page_params['_method']=='delete' && !$form)
    		{
    			$this->_helper->layout->disableLayout();
    			$this->update($post_params);

    		}
    		
    	}

	}
	
	public function formAction(){
		$data = new LLLT_Model_Customercontact();
		$post_params = $this->_request->getPost();
    	$page_params = $this->_request->getParams();
    	
    	$this->view->contact_data = $data->sel_customer_by_contact($page_params['_contact_id']);
	}
	
	public function contactAction(){
		$data = new LLLT_Model_Customercontact();
		$post_params = $this->_request->getPost();
    	$page_params = $this->_request->getParams();
    	
    	$this->view->contact_data = $data->sel_customer_by_contact($page_params['_contact_id']);
	}

	
	public function customerAction(){
		
		$data = new LLLT_Model_Customercontact();
		$post_params = $this->_request->getPost();
    	$page_params = $this->_request->getParams();
    	if(isset($page_params['_customer_id']))
    	{$customer_id = $page_params['_customer_id'];}
    	else
    	{$customer_id =$page_params['customer_id'];}
    	
    	$this->view->contact_data = $data->sel_customer_by_customer($customer_id);
	}
	
	public function update($post_params){
		$data = new LLLT_Model_Customercontact();
		$retval = $data->upd_customer_contact($post_params['contact_id'],$post_params);
		return $retval;
	}
	
	public function updateAction(){
		$page_params = $this->_request->getParams();
		$data = new LLLT_Model_Customercontact();
		$page_params['contact_data']=$data->sel_customer_by_contact($page_params['_contact_id']);
		$this->view->page_params = $page_params;

	}
	
	public function addAction(){
	
		$this->view->page_params = $this->_request->getParams();
  
	}
	
	public function add($post_params)
	{
		if (isset($post_parms['contact_id']))
		{unset($post_params['contact_id']);}
		$data = new LLLT_Model_Customercontact();
		$retval = $data->ins_customer_contact($post_params);
		return $retval;
	}
	
	public function deleteAction(){
		$data = new LLLT_Model_Customercontact();
		$post_params = $this->_request->getPost();
    	$page_params = $this->_request->getParams();
    	
    	//$this->view->contact_data = $data->sel_customer_by_contact($page_params['_contact_id']);
	}
}