<?php
class LLLT_Model_QuickbookMapper {
	
protected $_dsn;

public function setDSN($dsn)
	{
		$this->_dsn = $dsn;
	}

public function addInvoice($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale){	
//public function addInvoice($requestID, $user, $action, $ID, $extra,  $last_action_time, $last_actionident_time, $version, $locale){	
		
		$reqid = $requestID;
		$date = date('Y-m-d');
		/**Get data from qb_queue table**/
		$qb_queue = new LLLT_Model_QbQueueMapper();
		$queuedata = $qb_queue->fetchall('queue_id = \''.$ID.'\'',null);
		$loadWhere = '';

		foreach($queuedata as $row){
			$loadWhere =$loadWhere .' load_id = '.$row->getLoad_id(). ' or ';
		}
		
		
		
		
		/**Get Load DATA for building QbXML**/ 
		$load = new LLLT_Model_LoadMapper();
		$where = rtrim($loadWhere,'or ');

		$obj = $load->fetchall($where, null);
		
		/****Get Bill address and Ship address*/
		
		//Bill to
		$this->_customer_id = $obj[0]->getBill_to_id();
		$billaddy = $this->getcustomerinfo();
	
		//Ship to
		$this->_customer_id = $obj[0]->getShipper_id();
		$shipaddy = $this->getcustomerinfo();
		
		
		//Customer info
		$this->_customer_id = $obj[0]->getCustomer_id();
		$customerdata = $this->getcustomerinfo();

		
		$ivline = '';
		foreach($obj as $row){
			$ivline = $ivline.'
				<InvoiceLineAdd>
						<ItemRef>
							<FullName>Freight Chg</FullName>
						</ItemRef>
						<Desc>'.$row->getOrder_number().'</Desc>
						<Quantity>'.$row->getNet_gallons().'</Quantity>
						<Rate>'.$row->getBill_rate().'</Rate>
						<DataExt>
							<OwnerID>0</OwnerID>
							<DataExtName>Ship Date</DataExtName>
							<DataExtValue>'.$row->getDelivery_date().'</DataExtValue>
						</DataExt>
						<DataExt>
							<OwnerID>0</OwnerID>
							<DataExtName>Origin</DataExtName>
							<DataExtValue>'.$row->getOrigin_invoice().'</DataExtValue>
						</DataExt>
						<DataExt>
							<OwnerID>0</OwnerID>
							<DataExtName>Destination</DataExtName>
							<DataExtValue>'.$row->getDestination_invoice().'</DataExtValue>
						</DataExt>
					</InvoiceLineAdd>';
				if($row->getFuel_surcharge()>0)
				{
					$ivline = $ivline.='<InvoiceLineAdd>
								<ItemRef>
									<FullName>Fuel Surcharge</FullName>
								</ItemRef>
								<RatePercent>'.$row->getFuel_surcharge().'</RatePercent>
							</InvoiceLineAdd>';
				}
			
			
		}

		
		/***Name of QuickBooks template to use****/
		$qbtemplate = '<TemplateRef>
					  	<FullName>Dispatch LLL Invoice</FullName>
					  </TemplateRef>';
		
		/*****Check if invoice is to get and email ************/
		$sendemail='';
		if($obj[0]->getEmail_invoice()==1)
		{
			$sendemail='<IsToBeEmailed>true</IsToBeEmailed>';
		}
		
		$xml= '<?xml version="1.0"?>
	<?qbxml version="'.$version.'"?>
	<QBXML>
		<QBXMLMsgsRq onError="stopOnError">
			<InvoiceAddRq requestID="'.$reqid.'">
				<InvoiceAdd>
					<CustomerRef>
						<FullName>'.$customerdata->getName().'</FullName>
					</CustomerRef>'.$qbtemplate.'
					<TxnDate>'.$date.'</TxnDate>
					<BillAddress>
						<Addr1>'.$billaddy->getName().'</Addr1>
						<Addr2>'.$billaddy->getAddr().'</Addr2>
						<Addr3>'.$billaddy->getAddr2().'</Addr3>
						<City>'.$billaddy->getCity().'</City>
						<State>'.$billaddy->getState().'</State>
						<PostalCode>'.$billaddy->getZip().'</PostalCode>
					</BillAddress>
					<ShipAddress>
						<Addr1>'.$shipaddy->getName().'</Addr1>
						<Addr2>'.$shipaddy->getAddr().'</Addr2>
						<Addr3>'.$shipaddy->getAddr2().'</Addr3>
						<City>'.$shipaddy->getCity().'</City>
						<State>'.$shipaddy->getState().'</State>
						<PostalCode>'.$shipaddy->getZip().'</PostalCode>
					</ShipAddress>
					<IsToBePrinted>true</IsToBePrinted>'
					.$sendemail
					.$ivline.
					'
				</InvoiceAdd>
			</InvoiceAddRq>
		</QBXMLMsgsRq>
	</QBXML>';
		$xml;
		return $xml;
	}
	
	public function addInvoiceResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale){
		
		$load = array();
    	$load_dispatch = new LLLT_Model_LoadMapper();
    	$date = date('Y-m-d');
		$load['load_id']= $ID;
		$load['invoice_date']=$date;
		$load_dispatch->updatedriverload($load, $ID);
		$log_obj = new LLLT_Model_LoadLog();
		$log = new LLLT_Model_LoadLogMapper();
		$log_obj->setLoad_id($ID);
		$log_obj->setLoad_activity_type_id(5);
		$log_obj->setActivity_time($date);
		$log_obj->setActivity_by(123);
		//$log->add($log_obj);

	}
	
	private function getcustomerinfo(){
			$data = new LLLT_Model_CustomerMapper();
			return $data->find($this->_customer_id);
	}

}