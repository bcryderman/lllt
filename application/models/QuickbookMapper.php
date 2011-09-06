<?php
class LLLT_Model_QuickbookMapper {
	
protected $_dsn;

public function setDSN($dsn)
	{
		$this->_dsn = $dsn;
	}

public function addInvoice($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale){	
		
		$reqid = $requestID;
		$date = date('Y-m-d');
		/**Get Load DATA for building QbXML**/
		$load = new LLLT_Model_LoadMapper();
		$obj = $load->find($ID);
		
		/****Get Bill address and Ship address*/
		
		//Bill to
		$this->_customer_id = $obj->getBill_to_id();
		$billaddy = $this->getcustomerinfo();
	
		//Ship to
		$this->_customer_id = $obj->getShipper_id();
		$shipaddy = $this->getcustomerinfo();
		
		/**Check if there is a fuel surcharge**/
		$fs='';
		if($obj->getFuel_surcharge()>0)
		{
			$fs='<InvoiceLineAdd>
						<ItemRef>
							<FullName>Fuel Surcharge</FullName>
						</ItemRef>
						<RatePercent>'.$obj->getFuel_surcharge().'</RatePercent>
					</InvoiceLineAdd>';
		}
		
		/**Build data ext**/
		$de1 = '<DataExt>
					<OwnerID>0</OwnerID>
					<DataExtName>Ship Date</DataExtName>
					<DataExtValue>'.$obj->getDelivery_date().'</DataExtValue>
				</DataExt>';
		$de2 = '<DataExt>
					<OwnerID>0</OwnerID>
					<DataExtName>Origin</DataExtName>
					<DataExtValue>'.$obj->getOrigin().'</DataExtValue>
				</DataExt>';
		$de3 = '<DataExt>
					<OwnerID>0</OwnerID>
					<DataExtName>Destination</DataExtName>
					<DataExtValue>'.$obj->getDestination().'</DataExtValue>
				</DataExt>';
		
		/***Name of QuickBooks template to use****/
		$qbtemplate = '<TemplateRef>
					  	<FullName>Dispatch LLL Invoice</FullName>
					  </TemplateRef>';
		
		/*****Check if invoice is to get and email ************/
		$sendemail='';
		if($obj->getEmail_invoice()=1)
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
						<FullName>Brian Cryderman</FullName>
					</CustomerRef>'.$qbtemplate.'
					<TxnDate>'.$date.'</TxnDate>
					<BillAddress>
						<Addr1>'.$billaddy->getAddr().'</Addr1>
						<Addr2>'.$billaddy->getAddr2().'</Addr2>
						<City>'.$billaddy->getCity().'</City>
						<State>'.$billaddy->getState().'</State>
						<PostalCode>'.$billaddy->getZip().'</PostalCode>
					</BillAddress>
					<ShipAddress>
						<Addr1>'.$shipaddy->getAddr().'</Addr1>
						<Addr2>'.$shipaddy->getAddr2().'</Addr2>
						<City>'.$shipaddy->getCity().'</City>
						<State>'.$shipaddy->getState().'</State>
						<PostalCode>'.$shipaddy->getZip().'</PostalCode>
					</ShipAddress>
					<IsToBePrinted>true</IsToBePrinted>'.$sendemail.'
					<InvoiceLineAdd>
						<ItemRef>
							<FullName>Freight Chg</FullName>
						</ItemRef>
						<Desc>'.$obj->getOrder_number().'</Desc>
						<Quantity>'.$obj->getNet_gallons().'</Quantity>
						<Rate>'.$obj->getBill_rate().'</Rate>						
					</InvoiceLineAdd>'.$fs.'
				</InvoiceAdd>
			</InvoiceAddRq>
		</QBXMLMsgsRq>
	</QBXML>';
		
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