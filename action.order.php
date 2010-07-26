<?php if ($sub_action == 'insert') { ?> 
	<?php if($_POST['name'] AND $_POST['description'] !== NULL AND $_POST['quantity'] !== NULL AND $_POST['vendor'] !== NULL AND $_POST['requestor'] !== NULL) { ?> 
		<?php $_POST = htmlspecialchars($_POST, ENT_QUOTES); ?> 
		<?php $db->Raw("INSERT INTO `order` (`name`,`description`,`quantity`,`vendor`, `requestor`,`buyer`,`order`,`price`) VALUES ('$_POST[name]', '$_POST[description]', '$_POST[quantity]', '$_POST[vendor]', '$_POST[requestor]', '$_POST[buyer]', '$_POST[order]', '$_POST[price]')"); ?>
		<?php success('Item added to order database!'); ?> 
		<?php $db->Raw("DELETE FROM `request` WHERE `id`='$id' LIMIT 1;"); ?>
	<?php } else { ?>
		<?php $error = 1; ?>
	<?php } ?>
<?php } ?>

<?php if($sub_action == NULL AND isset($item)) general('Some fields have been filled in for you, please confirm and fill in the rest of the fields!'); elseif ($error == 1) error('You are missing some information!');?>

<?php if (isset($item)) { ?>
	<?php $item = $db->Raw("SELECT * FROM `request` WHERE `id`='$item'"); ?>
	<?php $item = stripslashes_deep($item); ?>
	
	<div style="padding-left: 20px; padding-top: 10px;">
	<form name="form1" enctype="multipart/form-data" method="post" action="?action=order&sub_action=insert&id=<?php echo $item[0]['id']; ?>">
	<table border="0">
		<tr>
			<td>Product Number:</td> 		<td><input type="text" name="name" value="<?php echo $item[0]['name']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Item Description:</td> 	<td><input type="text" name="description" value="<?php echo $item[0]['description']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Requestor:</td> 	<td><input type="text" name="requestor" value="<?php echo $item[0]['requestor']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Buyer:</td> 	<td><input type="text" name="buyer" value="<?php echo $item[0]['buyer']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Quantity:</td> 	<td><input type="text" name="quantity" value="<?php echo $item[0]['quantity']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Vendor:</td> 	<td><input type="text" name="vendor" value="<?php echo $item[0]['vendor']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Price Each:</td> 	<td><input type="text" name="price" value="<?php echo $item[0]['price'] ?>" size="25"></td>
		</tr>
		<tr>
			<td>Order Number:</td> 	<td><input type="text" name="order" value="<?php echo $item[0]['order']; ?>" size="25"></td>
		</tr>
		<tr>
			<td></td>					<td><input type="submit" value="Add Item"></td>
		</tr>
	</table>
	</form>
	</div>
<?php } ?>

<?php general('Here is the order list!'); ?>

<?php $orders = $db->Raw("SELECT * FROM `order` ORDER BY `vendor`,`order`"); ?>

<?php 
$current_vendor = '';
$current_order = '';
?>

<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<b>Vendor</b>
		</td>
		
		<td>
			<b>Order</b>
		</td>
		
		<td>
			<b>Time</b>
		</td>
		
		<td>
			<b>Item</b>
		</td>
		
		<td>
			<b>Description</b>
		</td>
		
		<td>
		</td>
		
		<td>
			<b>Ext. Price</b>
		</td>
		
		<td>
			<b>Requestor</b>
		</td>
		
		<td>
			<b>Buyer</b>
		</td>
		
	</tr>

<?php $first = 1; ?>
	
<?php
foreach($orders as $item) {
	// If the current vendor is the same, it will not display the vendor number again.
	if ($item['vendor'] == $current_vendor) 
	{ 
		$vendor = '';
	} 
	else
	{
		// if vendor number is not the same, display the vendor, set the current vendor and delete the child (which is orders).
		$vendor = $item['vendor'];
		$current_vendor = $item['vendor'];
		$current_order = '';
	}
	
	// Child (which is orders) which does the same as above.
	if ($item['order'] == $current_order) 
	{ 
		$order = '';
		$time = '';
	//	$total_price = $total_price+($item['price']*$item['quantity']);
	} 
	else
	{
		$order = $item['order'];
		$current_order = $item['order'];
		$time = $item['time'];
		$print_total_price = $total_price;
		$total_price = 0;
		$bg_color++;
	}
?>

<?php if ($total_price == 0 AND $first !== 1) { ?>
	<?php $total_price = $total_price+($item['price']*$item['quantity']); ?>
	<tr>
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?> style="border-top: 1px solid #000000;">
		<div align="right"><b>Total:</b></div>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?> style="border-top: 1px solid #000000;">
		<div align="right" style="padding-right: 10px;"><b><?php echo money_format('%i',$print_total_price); ?></b></div>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 1) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
	</tr>
	
	<tr>
		<td>
		<div style="padding-top: 16px;"></div>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
		
	</tr>
<?php } else { ?>
	<?php $total_price += $item['price']*$item['quantity']; ?>
	<?php $first = 0; ?>
<?php } ?>
	
	<tr>
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<b><?php echo $vendor; ?></b>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<b><?php echo $order; ?></b>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<b><?php echo $time; ?></b>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item['name']; ?>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item['description']; ?>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item['quantity']; ?>x
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<div align="right" style="padding-right: 10px;"><?php echo money_format('%i',$item['price']*$item['quantity']); ?></div>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item['requestor']; ?>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
			<?php echo $item['buyer']; ?>
		</td>
		
	</tr>
<?php } ?>

	<tr>
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?> style="border-top: 1px solid #000000;">
		<div align="right"><b>Total Price:</b></div>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?> style="border-top: 1px solid #000000;">
		<div align="right" style="padding-right: 10px;"><b><?php echo money_format('%i',$total_price); ?></b></div>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
		</td>
		
		<td <?php if($bg_color%2 == 0) echo 'bgcolor="CCCC99"'; ?>>
		</td>
	</tr>

</table>
