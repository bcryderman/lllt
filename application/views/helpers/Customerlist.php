<?php
class Zend_View_Helper_Customerlist extends
 Zend_View_Helper_Abstract{
	
	public function customerlist($customerlist){?>
	<table>
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Zip</th>
				<th>FEIN</th>
				<th>Color</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach($customerlist as $row)
			{?>
			<tr id="cust_id<?php echo $row['customer_id'];?>" cust_id="<?php echo $row['customer_id'];?>">
				<td><span><a class="cust_edit_link" href="/customer?customer_id=<?php echo $row['customer_id'];?>" cust_id="<?php echo $row['customer_id'];?>">Edit</span></td>
				<td class='cust_name'><?php echo $row['name'];?></td>
				<td class="cust_address"><?php echo $row['addr'];?><div class="hidden cust_address2"><?php echo $row['addr2'];?></div></td>
				<td class="city"><?php echo $row['city'];?></td>
				<td class="state"><?php echo $row['state'];?></td>
				<td class="zip"><?php echo $row['zip'].'-'.$row['zip4'];?></td>
				<td class="fein"><?php echo $row['fein'];?></td>
				<td class="color"><div class="color_code"  style="width:100px;height:20px;background-color:#<?php echo $row['color_code'];?>;">&nbsp;</div></td>
				<td><span><a class="contact_edit_link" href="/customercontact?_method=customer&_customer_id=<?php echo $row['customer_id'];?>">Show Contacts</a></span></td>
			</tr>			

	  <?php }
		?>
		
		</tbody>
	
	

	</table>	
<?php 	}
 }?>