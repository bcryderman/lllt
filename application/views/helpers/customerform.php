<script type="text/javascript" src="/js/plugins/mColorPicker.min.js"></script>

<style>
#customer_form{font-size:14px}
#color{width:25px;height:25px}
</style>
<?php
class Zend_View_Helper_CustomerForm extends
 Zend_View_Helper_Abstract{
	
	public function customerform($formdata,$states,$page_data){
	$x = false;
	if(isset($formdata['cust_data']))
	{
		$x = true;
		$custdata = $formdata['cust_data'][0];
	};

		?>
	<form method='post' action='<?php echo $formdata['controller'].'/submit';?>' id="customer_form">
    <input type="hidden" name="formtype" id="formtype" value="<?php echo $formdata['_mode'];?>"></input>
<input type="hidden" name="customer_type_id" id="customer_type_id" value="<?php echo $page_data['customer_type_id'];?>"></input>
<?php 
	if($formdata['_mode']=='update')
	{?>
		<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $formdata['customer_id'];?>"></input>
<?php ;}
?>
<table>
	<tr>
		<td><label for="customer_type_id">Name:</label></td>
		<td><input type="text" name="name" id="name" value="<?php if($x){echo $custdata->name;}?>"></input></td>
	</tr>
	<tr>
		<td><label for="customer_type_id">Active?:</label></td>
		<td><input type="checkbox" name="active" id="active" checked></input></td>
	</tr>
	<tr>
		<td><label for="addr">Address:</label></td>
		<td><input type="text" name="addr" id="addr"  value="<?php if($x){echo $custdata->addr;}?>"></input></td>
	</tr>
	<tr>
		<td<label for="addr2">Address 2:</label></td>
		<td><input type="text" name="addr2" id="addr2"  value="<?php if($x){echo $custdata->addr2;}?>"></input></td>
	</tr>
	<tr>
		<td<label for="city">City:</label></td>
		<td><input type="text" name="city" id="city"  value="<?php if($x){echo $custdata->city;}?>"></input></td>
	</tr>
	<tr>
		<td><label for="state">State:</label></td>
		<td>
			<select name="state" id="state">
				<?php echo $states;?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="zip">Zip:</label></td>
		<td>
			<input type="text" name="zip" id="zip"  value="<?php if($x){echo $custdata->zip;}?>"></input>
			<input type="text" name="zip4" id="zip4"  value="<?php if($x){echo $custdata->zip4;}?>"></input>
		</td>
	</tr>
		<tr>
		<td><label for="fein">FEIN:</label></td>
		<td>
			<input type="text" name="fein" id="fein"  value="<?php if($x){echo $custdata->fein;}?>"></input>
		</td>
	</tr>
		</tr>
		<tr>
		<td><label for="color_code">Color:</label></td>
		<td>
			<input id="color" type="color" data-hex="true" data-text="hidden" name="color_code" id="color_code" value="<?php if($x){echo '#'. $custdata->color_code;}?>"></input>
		</td>
	</tr>
		</tr>
		<tr>
		<td><label for="notes">Notes:</label></td>
		<td>
			<textarea name="notes" id="notes" COLS="20" ROW="15"> <?php if($x){echo $custdata->notes;}?></textarea>			
		</td>
	</tr>
 
</table>

<button type="submit"><?php echo $formdata['_mode'];?></button>
</form>

		
<?php 	}
}?>