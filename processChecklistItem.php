<?php
//INCLUDES
	include_once('header.php');

//RETRIEVE URL AND FORM VARIABLES
	$values['checklistId']=(int) $_POST['checklistId'];
	$values['item']=mysql_real_escape_string($_POST['item']);
	$values['notes']=mysql_real_escape_string($_POST['notes']);

    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; url=checklistReport.php?checklistId='.$values['checklistId'].'"';
//	echo '<p>New checklist item added at ';
//	echo date('H:i, jS F');
//	echo '</p>';

	# don't forge null
query ("newchecklistitem",$config,$values);

	//echo "New record inserted with ID ".mysql_insert_id();

	mysql_close($connection);
	include_once('footer.php');

?>
