<?php

function general($message) {
	echo
	('
		<div style="
			font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif;
			margin: 10px;
			width: 500px;
			background-color: #f7f7f7;
			border: 1px solid #cccccc; 
			color: #333333;
			padding: 10px;
			font-size: 13px;
			font-weight: bold;
		">  
			' . $message . ' 
		</div>
	');
}

function success($message) {
	echo
	('
		<div style="
			font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif;
			margin: 10px;
			width: 500px;
			background-color: #fff9d7;
			border: 1px solid #e2c822;
			color: #333333;
			padding: 10px;
			font-size: 13px;
			font-weight: bold;
		">  
			' . $message . ' 
		</div>
	');
}

function error($message) {
	echo
	('
		<div style="
			font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif;
			margin: 10px;
			width: 500px;
			background-color: #ffebe8;
			border: 1px solid #dd3c10;
			color: #333333;
			padding: 10px;
			font-size: 13px;
			font-weight: bold;
		">  
			' . $message . ' 
		</div>
	');
}

?>
