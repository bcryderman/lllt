<?php

class AccountsController extends Zend_Controller_SecureAction {

    public function init() { }

    public function indexAction() { 
    	
    	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
    	$dbAdapter->setFetchMode(Zend_Db::FETCH_OBJ);
    	$select = $dbAdapter->select()->from('users')->where('active = 1')->order(array('lname ASC', 'fname'));
		$stmt = $dbAdapter->query($select);
		$result = $stmt->fetchAll();
				
		$this->view->users = $result;
    }
    
    public function editAction() {
    	
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender();
	    
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {
	    		    	   	
    		$params = $request->getParams();   
    		 		        		
        	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
        	$usersTable = new Zend_Db_Table('users');					
			$data = array('fname' => $params['fname'], 'lname' => $params['lname']);					
			$where = $usersTable->getAdapter()->quoteInto('userid = ?', $params['userid']); 
			$usersTable->update($data, $where);  
		}
    }

    public function deleteAction() {
    	
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender();
	    
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {
	    		    	   	
    		$params = $request->getParams();   
    		 		        		
        	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
        	$usersTable = new Zend_Db_Table('users');					
			$data = array('active' => 0);					
			$where = $usersTable->getAdapter()->quoteInto('userid = ?', $params['userid']); 
			$usersTable->update($data, $where);  
		}
    }
    
}