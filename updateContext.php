<?php
include_once('header.php');

//GET URL AND FORM DATA
$values['contextId']        = (int) $_GET['contextId'];
$values['name']             = mysql_real_escape_string($_POST['name']);
$values['description']      = mysql_real_escape_string($_POST['description']);
$values['delete']           = $_POST['delete']{0};
$values['newContextId']     = (int) $_POST['newContextId'];

if ($values['delete']=="y") {
        query("reassignspacecontext",$config,$values);
        query("deletespacecontext",$config,$values);
	}

else query("updatespacecontext",$config,$values);

echo '<META HTTP-EQUIV="Refresh" CONTENT="0; url=reportContext.php" />';

include_once('footer.php');
?>
