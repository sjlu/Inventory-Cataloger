<?php 
include 'config.php';
include './include/functions.php';
?>

<?php // Facebook style buttons and font. ?>
<link type="text/css" rel="stylesheet" href="include/style.css" />

<body>

<?php if($action == NULL) { ?>


<?php general('What would you like to do?'); ?>


<div style="padding-left: 20px; padding-top: 10px;">
	<a href="?action=add_item" class="tab">Add an Item</a>
	<a href="?action=locate" class="tab">Locate an Item</a>
	<a href="?action=browse" class="tab">Browse the Database</a>
	<a href="?action=request"  class="tab">Request an Item</a>
	<a href="?action=order" class="tab">View Items Ordered</a>
</div>

<?php // this is only a template file which calls all the other actions in. ?>

<?php } elseif($action == 'add_item') { ?>
	
	<?php include 'action.add_item.php'; ?>
	
<?php } elseif($action == 'locate') { ?>

	<?php include 'action.locate.php'; ?>
	
<?php } elseif($action == 'browse') { ?>
	
	<?php include 'action.browse.php'; ?>
	
<?php } elseif($action == 'request') { ?>

	<?php include 'action.request.php'; ?>

<?php } elseif($action == 'order') { ?>
	
	<?php include 'action.order.php'; ?>

<?php } ?>

</body>