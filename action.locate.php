<?php general('Give me something to search!'); ?>
<div style="padding-left: 20px; padding-top: 10px;">
<form name="form1" enctype="multipart/form-data" method="post" action="?action=locate&sub_action=search">
	<input type="text" name="search" value="<?php echo $_POST['row']; ?>" size="40">
	<input type="submit" value="Search"></td>
		</tr>
	</table>
</form>
</div>

<?php if($sub_action == 'search') { ?>
	<center><?php general('Here is what I got for you!'); ?></center>
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

			<td width="50%">
				<b>description</b>
			</td>
		</tr>

	<?php $db_items = $db->Raw("SELECT * FROM `items` WHERE `name` LIKE '%$_POST[search]%' ORDER BY `row`,`column`"); // Selects anything in the database that is similar to the search term, sorts it by row, then by column. ?>

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
		</tr>
	<?php } ?>
	</table>
<?php } ?>