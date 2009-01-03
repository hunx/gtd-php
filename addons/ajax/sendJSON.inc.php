<?php
if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
require_once 'headerDB.inc.php';
require_once 'JSONlib.inc.php';

$json = new Services_JSON();    // create a new instance of Services_JSON
$values = array();
$action=$_REQUEST['action'];
$output=array('result'=>false); // default result

ob_start();

switch ($action) {

    
    case 'get1': // Request was for a single item, so do query, get data
        $values['itemId']= (int) $_REQUEST['itemId'];
        $values['filterquery']=' WHERE '.sqlparts('singleitem',$values);
        $result = query("selectitem",$values);
        if ($result) $output=$result[0];
        break;

        
    case 'getrecur': // we want to know the next recurrence based on a pattern
        require_once 'gtdfuncs.inc.php';
        $values=array();
        foreach (array('deadline','tickledate','dateCompleted') as $field)
          $values[$field] = (empty($_POST[$field])) ? '' : $_POST[$field];
        list($values['recur'],$dummy) = processRecurrence($values);
        $output=array('next'=>getNextRecurrence($values));
        break;


    case 'list': // getting all items of a particular type
        $values['filterquery']='WHERE '.sqlparts("pendingitems",$values);
        $values['type']=empty($_REQUEST['type'])?'*':$_REQUEST['type'];
        if ($values['type']!=='*')
            $values['filterquery'] .= " AND ".sqlparts("typefilter",$values);
        $result= query('getitems',$values);
        
        if ($result) {
            $output=array();
            foreach ($result as $line)
                $output[$line['itemId']]=$line['title'];
        }
        break;

/*
    case 'findstring': //  searching for a particular string
      $values['type']=$_REQUEST['type'];
      $values['needle']=$_REQUEST['needle'];
      $q=($_REQUEST['haystack']==='title')?'matchtitle':'matchall';

      //do query
      $values['filterquery']=sqlparts('typefilter',$values);
      $values['filterquery'].=' AND '.sqlparts($q,$values);
      $result= query('selectfind',$values);
      if ($result) $output=$result[0];
      break;
*/
}
$output['log']=ob_get_contents();
ob_end_clean();
echo $json->encode($output);
exit;
?>
