<?php // this page displays all requested items and a form to request an item. when submitted, it will properly insert it into the database. ?>

<?php 
if ($sub_action == 'insert') {
	if($_POST['name'] AND $_POST['description'] !== NULL AND $_POST['quantity'] !== NULL AND $_POST['vendor'] !== NULL AND $_POST['requestor'] !== NULL AND $_POST['price'] !== NULL) {
		$db->Raw("INSERT INTO `request` (`name`,`description`,`quantity`,`vendor`, `requestor`, `price`) VALUES ('$_POST[name]', '$_POST[description]', '$_POST[quantity]', '$_POST[vendor]', '$_POST[requestor]', '$_POST[price]')");
		success('Your request has been successfuly submitted!');
	} else {
		$error = 1;
	}
} elseif ($sub_action == 'edit') {
	$db->Raw("UPDATE `request` SET `name`='$_POST[name]',`description`='$_POST[description]',`quantity`='$_POST[quantity]',`vendor`='$_POST[vendor]',`requestor`='$_POST[requestor]',`price`='$_POST[price]' WHERE `id`='$item';");
	success('Item has been successfully edited');
}
?>	

<?php
if(isset($delete)) {
	$db->Raw("DELETE FROM `request` WHERE `id`='$delete'");
	success('Item has been successfully deleted!');
}
?>

<?php
if(isset($edit)) {
	$edit_data = $db->Raw("SELECT * FROM `request` WHERE `id`='$edit'");
	$edit_data = stripslashes_deep($edit_data);
}
?>

<?php if ($edit == 1) general ('You can edit the following entry that you have selected.'); elseif($sub_action == NULL) general('Please insert the following information in order to request for an item to be ordered.'); elseif ($error == 1) error('You forgot to fill in some information, all fields are required.');?>
<div style="padding-left: 20px; padding-top: 10px;">
<form name="form1" enctype="multipart/form-data" method="post" action="?action=request&sub_action=<?php if(isset($edit)) echo 'edit&item=' . $edit . ''; else echo 'insert'; ?>">
	<table border="0">
		<tr>
			<td>Product Number:</td> 		<td><input type="text" name="name" value="<?php if(isset($edit)) echo $edit_data[0]['name']; else echo $_POST['name']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Item Description:</td> 	<td><input type="text" name="description" value="<?php if(isset($edit)) echo $edit_data[0]['description']; echo $_POST['description']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Quantity:</td> 	<td><input type="text" name="quantity" value="<?php if(isset($edit)) echo $edit_data[0]['quantity']; else echo $_POST['quantity']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Price Each:</td> 	<td><input type="text" name="price" value="<?php if(isset($edit)) echo $edit_data[0]['price']; else echo $_POST['price']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Vendor:</td> 	<td><input type="text" name="vendor" value="<?php if(isset($edit)) echo $edit_data[0]['vendor']; else echo $_POST['vendor']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Requestor:</td> 	<td><input type="text" name="requestor" value="<?php if(isset($edit)) echo $edit_data[0]['requestor']; else echo $_POST['requestor']; ?>" size="25"></td>
		</tr>
		<tr>
			<td></td>					<td><input type="submit" value="<?php if(isset($edit)) echo 'Update'; else echo 'Add Item'; ?>"></td>
		</tr>
	</table>
</form>
</div>

<?php general('Here is the current list of requested items'); ?>

<?php $requested_items = $db->Raw("SELECT * FROM `request` ORDER BY `vendor`,`time`,`name`"); ?>

<table border="0" width="100%">
	<tr>
		<td width="15%">
		<b>Product Number</b>
		</td>
		
		<td width="10%">
		<b>Vendor</b>
		</td>
		
		<td width="40%">
		<b>Item Description</b>
		</td>
		
		<td width="5%">
		<b>Quantity</b>
		</td>
		
		<td width="10%">
		<b>Ext. Price</b>
		</td>
		
		<td width="10%">
		<b>Requestor</b>
		</td>
		
		<td width="10%">
		<b>Action Set</b>
		</td>
	</tr>

<?php foreach ($requested_items as $item_request) { ?>
	<?php $total_price += $item_request['price']*$item_request['quantity']; ?>
	<?php $bg_color++; ?>
	<tr>
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item_request['name']; ?>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item_request['vendor']; ?>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item_request['description']; ?>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item_request['quantity']; ?>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo money_format('%i',$item_request['price']*$item_request['quantity']); ?>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item_request['requestor']; ?>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
			<a href="?action=request&edit=<?php echo $item_request['id']; ?>">edit</a> <a href="?action=request&delete=<?php echo $item_request['id']; ?>">del</a> <a href="?action=order&item=<?php echo $item_request['id']; ?>">ord</a>
		</td>
	</tr>
<?php } ?>

	<tr>
		<td>
		</td>
		
		<td>
		</td>

		<td>
		</td>
		
		<td style="border-top: 1px solid #000000;">
		<b>Total Price</b>
		</td>
		
		<td style="border-top: 1px solid #000000;">
		<b><?php echo money_format('%i',$total_price); ?></b>
		</td>
		
		<td>
		</td>
	</tr>
</table>

<?php general('Here is the list of vendors and their contact information.'); ?>
<?php $vendor_info = $db->Raw("SELECT * FROM `vendors`"); ?>
<table border="0" width="50%">
	<tr>
		<td>
		<b>name</b>
		</td>
		
		<td>
		<b>website</b>
		</td>
		
		<td>
		<b>phone</b>
		</td>
		
		<td>
		<b>email</b>
		</td>
	</tr>
	
<?php foreach ($vendor_info as $vendor) { ?>
	<tr>
		<td>
		<?php echo $vendor['name']; ?>
		</td>
		
		<td>
		<?php echo $vendor['website']; ?>
		</td>
		
		<td>
		<?php echo $vendor['phone']; ?>
		</td>
		
		<td>
		<?php echo $vendor['email']; ?>
		</td>
	</tr>
<?php } ?>
		
