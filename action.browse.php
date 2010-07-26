<?php 
if(isset($delete)) {
	$db->Raw("DELETE FROM `items` WHERE `id`='$delete';");
	success('Item has been successfully deleted!');
}
?>
	
<center><?php general('Here is everything that I know of...'); ?></center>
<table border="0" width="100%">
	<tr>
		<td width="10%">
			<b>row id</b>
		</td>
		
		<td width="10%">
			<b>column id</b>
		</td>
		
		<td width="30%">
			<b>name</b>
		</td>
		
		<td width="45%">
			<b>description</b>
		</td>
		
		<td width="5%">
			<b>action</b>
		</td>
	</tr>

<?php $db_items = $db->Raw("SELECT * FROM `items` ORDER BY `row`,`column`"); // grabs everything from database, then sorts it by row, then by column. ?>
<?php
$current_row = '';
$current_column = '';
?>

<?php foreach ($db_items as $item) { ?>
	<?php 
	// If the current row is the same, it will not display the row number again.
	if ($item['row'] == $current_row) 
	{ 
		$row = '';
	} 
	else
	{
		// if row number is not the same, display the row, set the current row and delete the child (which is columns).
		$row = $item['row'];
		$current_row = $item['row'];
		$current_column = '';
	}
	
	// Child (which is columns) which does the same as above.
	if ($item['column'] == $current_column) 
	{ 
		$column = '';
	} 
	else
	{
		$column = $item['column'];
		$current_column = $item['column'];
	}
	?>
		
	<tr>
		<td>
			<?php echo $row; ?>
		</td>
		
		<td>
			<?php echo $column; ?>
		</td>
		
		<td>
			<?php echo htmlspecialchars_decode($item['name'], ENT_QUOTES); ?>
		</td>
		
		<td>
			<?php echo htmlspecialchars_decode($item['description'], ENT_QUOTES); ?>
		</td>
		
		<td>
			<a href="?action=browse&delete=<?php echo $item['id']; ?>">delete</a>
		</td>
	</tr>
<?php } ?>
</table>