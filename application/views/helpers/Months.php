<?php
class Zend_View_Helper_Months extends
 Zend_View_Helper_Abstract{
	
	public function months(){

	foreach($this->date_array()as $row)
	{

		$retval=$retval.'<option value="'.$row['value'].'" >'.$row['display'].'</option>';
	}

		return $retval;
	}

	
	private function date_array(){
		return array(	array('value'=>'1','display'=>'Jan'),
		array('value'=>'2','display'=>'Feb'),
		array('value'=>'3','display'=>'Mar'),
		array('value'=>'4','display'=>'Apr'),
		array('value'=>'5','display'=>'May'),
		array('value'=>'6','display'=>'Jun'),
		array('value'=>'7','display'=>'Jul'),
		array('value'=>'8','display'=>'Aug'),
		array('value'=>'9','display'=>'Sep'),
		array('value'=>'10','display'=>'Oct'),
		array('value'=>'11','display'=>'Nov'),
		array('value'=>'12','display'=>'Dec')
	);
	
	
	}
}