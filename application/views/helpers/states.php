<?php
class Zend_View_Helper_States extends
 Zend_View_Helper_Abstract{
	
	public function states($selected){
		$retval='<option value=""></option>';
	foreach($this->state_array()as $row)
	{
		$x='';
		if($selected == $row['value'])
		{$x = 'SELECTED';}
		
		$retval=$retval.'<option value="'.$row['value'].'" '.$x.'>'.$row['display'].'</option>';
		}
		return $retval;
	}

	
	private function state_array(){
		return array(	array('value'=>'AL','display'=>'Alabama'),
		array('value'=>'AK','display'=>'Alaska'),
		array('value'=>'AZ','display'=>'Arizona'),
		array('value'=>'AR','display'=>'Arkansas'),
		array('value'=>'CA','display'=>'California'),
		array('value'=>'CO','display'=>'Colorado'),
		array('value'=>'CT','display'=>'Connecticut'),
		array('value'=>'DE','display'=>'Delaware'),
		array('value'=>'DC','display'=>'Dist of Columbia'),
		array('value'=>'FL','display'=>'Florida'),
		array('value'=>'GA','display'=>'Georgia'),
		array('value'=>'HI','display'=>'Hawaii'),
		array('value'=>'ID','display'=>'Idaho'),
		array('value'=>'IL','display'=>'Illinois'),
		array('value'=>'IN','display'=>'Indiana'),
		array('value'=>'IA','display'=>'Iowa'),
		array('value'=>'KS','display'=>'Kansas'),
		array('value'=>'KY','display'=>'Kentucky'),
		array('value'=>'LA','display'=>'Louisiana'),
		array('value'=>'ME','display'=>'Maine'),
		array('value'=>'MD','display'=>'Maryland'),
		array('value'=>'MA','display'=>'Massachusetts'),
		array('value'=>'MI','display'=>'Michigan'),
		array('value'=>'MN','display'=>'Minnesota'),
		array('value'=>'MS','display'=>'Mississippi'),
		array('value'=>'MO','display'=>'Missouri'),
		array('value'=>'MT','display'=>'Montana'),
		array('value'=>'NE','display'=>'Nebraska'),
		array('value'=>'NV','display'=>'Nevada'),
		array('value'=>'NH','display'=>'New Hampshire'),
		array('value'=>'NJ','display'=>'New Jersey'),
		array('value'=>'NM','display'=>'New Mexico'),
		array('value'=>'NY','display'=>'New York'),
		array('value'=>'NC','display'=>'North Carolina'),
		array('value'=>'ND','display'=>'North Dakota'),
		array('value'=>'OH','display'=>'Ohio'),
		array('value'=>'OK','display'=>'Oklahoma'),
		array('value'=>'OR','display'=>'Oregon'),
		array('value'=>'PA','display'=>'Pennsylvania'),
		array('value'=>'RI','display'=>'Rhode Island'),
		array('value'=>'SC','display'=>'South Carolina'),
		array('value'=>'SD','display'=>'South Dakota'),
		array('value'=>'TN','display'=>'Tennessee'),
		array('value'=>'TX','display'=>'Texas'),
		array('value'=>'UT','display'=>'Utah'),
		array('value'=>'VT','display'=>'Vermont'),
		array('value'=>'VA','display'=>'Virginia'),
		array('value'=>'WA','display'=>'Washington'),
		array('value'=>'WV','display'=>'West Virginia'),
		array('value'=>'WI','display'=>'Wisconsin'),
		array('value'=>'WY','display'=>'Wyoming')
	);
	
	
	}
}