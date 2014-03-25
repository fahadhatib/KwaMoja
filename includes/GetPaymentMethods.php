<?php

$PaytTypes = array();
$ReceiptTypes = array();

$sql = 'SELECT  paymentid,
				paymentname,
				paymenttype,
				receipttype
			FROM paymentmethods
			ORDER by paymentname';

$PMResult = DB_query($sql);
while ($PMrow = DB_fetch_array($PMResult)) {
	if ($PMrow['paymenttype'] == 1) {
		$PaytTypes[$PMrow['paymentid']] = $PMrow['paymentname'];
	}
	if ($PMrow['receipttype'] == 1) {
		$ReceiptTypes[$PMrow['paymentid']] = $PMrow['paymentname'];
	}
}
DB_free_result($PMResult); // no longer needed
?>