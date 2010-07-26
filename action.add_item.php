<?php // When a post is in queue, it will first check if the values are filled in. If it is, it will go ahead and insert it into the database, display a message with more actions, and then kill the rest of the script. If something is missing, it will fill in the form with the current values the user has supplied and generate an error message. ?>

<?php if ($sub_action == 'insert') { ?> 
	<?php if($_POST['row'] !== NULL AND $_POST['column'] !== NULL AND $_POST['name'] AND $_POST['description'] !== NULL) { ?>
		<?php $_POST = htmlspecialchars($_POST, ENT_QUOTES); ?> 
		<?php $db->Raw("INSERT INTO `items` (`row`,`column`,`name`,`description`) VALUES ('$_POST[row]', '$_POST[column]', '$_POST[name]', '$_POST[description]')"); ?>
		<?php success('Item has been successfully added to the database!'); ?> 
		<div style="padding-left: 20px; padding-top: 10px;"> <a href="?action=add_item" class="tab">Add Another Item</a> <a href="index.php" class="tab">Go Back to Main Page</a> </div> <?php die(); ?>
		<?php } ?> 
<?php } ?>

<?php if($sub_action == NULL) general('Please supply the following information to continue.'); else error('You forgot to fill in some information, all fields are required.'); ?>
<div style="padding-left: 20px; padding-top: 10px;">
<form name="form1" enctype="multipart/form-data" method="post" action="?action=add_item&sub_action=insert">
	<table border="0">
		<tr>
			<td>Row ID:</td> 			<td><input type="text" name="row" value="<?php echo $_POST['row']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Column ID:</td> 		<td><input type="text" name="column" value="<?php echo $_POST['column']; ?>" size="25"></td>
		</tr>
		<tr>
			<td>Item Name:</td> 		<td><input type="text" name="name" value="<?php echo htmlspecialchars_decode($_POST['name'], ENT_QUOTES); ?>" size="25"></td>
		</tr>
		<tr>
			<td>Item Description:</td> 	<td><input type="text" name="description" value="<?php echo htmlspecialchars_decode($_POST['description'], ENT_QUOTES); ?>" size="25"></td>
		</tr>
		<tr>
			<td></td>					<td><input type="submit" value="Add Item"></td>
		</tr>
	</table>
</form>
</div>