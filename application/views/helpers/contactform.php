<script type="text/javascript" src="/js/plugins/mColorPicker.min.js"></script>

<style>
#customer_form{font-size:14px}
#color{width:25px;height:25px}
</style>
<?php
class Zend_View_Helper_ContactForm extends
 Zend_View_Helper_Abstract{
	
	public function contactform($formdata){
	$x = false;
	if(isset($formdata['contact_data']))
	{
		$x = true;
		$custdata = $formdata['contact_data'][0];
	};

		?>
<div id="contact-form-container">
	<form method='post' action='<?php //echo $formdata['controller'].'/submit';?>' id="contact_form">
    <input type="hidden" name="formtype" id="formtype" value="<?php $formdata['_method']?>"></input>
    <input type="hidden" name="customer_id" id="customer_id" value="<?php if($x){echo $custdata['customer_id'];}else{echo $formdata['_customer_id'];}?>"></input>
    <input type="hidden" name="contact_id" id="contact_id" value="<?php if($x){echo $custdata['contact_id'];}?>"></input>

	
<table>
	<tr>
		<td><label for="first_name">First Name:</label></td>
		<td><input type="text" name="first_name" id="first_name" value="<?php if($x){echo $custdata['first_name'];}?>"></input></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="last_name">Last Name:</label></td>
		<td><input type="text" name="last_name" id="last_name" value="<?php if($x){echo $custdata['last_name'];}?>"></input></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="phone">Phone:</label></td>
		<td><input type="text" name="phone" id="phone" value="<?php if($x){echo $custdata['phone'];}?>"></input></td>
		<td><input type="text" name="phone_ext" id="phone_ext" value="<?php if($x){echo $custdata['phone_ext'];}?>"></input></td>
	</tr>
	<tr>
		<td><label for="cell_phone">Cell Phone:</label></td>
		<td><input type="text" name="cell_phone" id="cell_phone" value="<?php if($x){echo $custdata['cell_phone'];}?>"></input></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="fax_phone">Fax:</label></td>
		<td><input type="text" name="fax_phone" id="fax_phone" value="<?php if($x){echo $custdata['fax_phone'];}?>"></input></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="email">Email:</label></td>
		<td><input type="text" name="email" id="email" value="<?php if($x){echo $custdata['email'];}?>"></input></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="notes">Notes:</label></td>
		<td>
			<textarea name="notes" id="notes" COLS="20" ROW="15">
				<?php if($x){echo $custdata['notes'];}?>
			</textarea>			
		</td>
	</tr>
 
</table>

<button type="submit"><?php echo $formdata['_method'];?></button>
</form>

</div>
<script>

</script>
		
<?php 	}
}?>