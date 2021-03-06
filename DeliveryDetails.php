<?php

/* This is where the delivery details are confirmed/entered/modified and
 * the order committed to the database once the place order/modify order
 * button is hit.
 */

include('includes/DefineCartClass.php');

/* Session started in header.inc for password checking the session will
 * contain the details of the order from the Cart class object. The details
 * of the order come from SelectOrderItems.php
 */

include('includes/session.inc');
$Title = _('Order Delivery Details');
$ViewTopic = 'SalesOrders';// Filename's id in ManualContents.php's TOC.
$BookMark = 'DeliveryDetails';// Anchor's id in the manual's html document.
include('includes/header.inc');
include('includes/FreightCalculation.inc');
include('includes/SQL_CommonFunctions.inc');
include('includes/CountriesArray.php');

if (isset($_GET['identifier'])) {
	$Identifier = $_GET['identifier'];
} //isset($_GET['identifier'])

unset($_SESSION['WarnOnce']);
if (!isset($_SESSION['Items' . $Identifier]) or !isset($_SESSION['Items' . $Identifier]->DebtorNo)) {
	prnMsg(_('This page can only be read if an order has been entered') . '. ' . _('To enter an order select customer transactions then sales order entry'), 'error');
	include('includes/footer.inc');
	exit;
} //!isset($_SESSION['Items' . $Identifier]) or !isset($_SESSION['Items' . $Identifier]->DebtorNo)

if ($_SESSION['Items' . $Identifier]->ItemsOrdered == 0) {
	prnMsg(_('This page can only be read if an there are items on the order') . '. ' . _('To enter an order select customer transactions then sales order entry'), 'error');
	include('includes/footer.inc');
	exit;
} //$_SESSION['Items' . $Identifier]->ItemsOrdered == 0

/*Calculate the earliest dispacth date in DateFunctions.inc */

$EarliestDispatch = CalcEarliestDispatchDate();

if (isset($_POST['ProcessOrder']) or isset($_POST['MakeRecurringOrder'])) {
	/*need to check for input errors in any case before order processed */
	$_POST['Update'] = 'Yes rerun the validation checks'; //no need for gettext!

	/*store the old freight cost before it is recalculated to ensure that there has been no change - test for change after freight recalculated and get user to re-confirm if changed */

	$OldFreightCost = round($_POST['FreightCost'], 2);

} //isset($_POST['ProcessOrder']) or isset($_POST['MakeRecurringOrder'])

if (isset($_POST['Update']) or isset($_POST['BackToLineDetails']) or isset($_POST['MakeRecurringOrder'])) {
	$InputErrors = 0;
	if (mb_strlen($_POST['DeliverTo']) <= 1) {
		$InputErrors = 1;
		prnMsg(_('You must enter the person or company to whom delivery should be made'), 'error');
	} //mb_strlen($_POST['DeliverTo']) <= 1
	if (mb_strlen($_POST['BrAdd1']) <= 1) {
		$InputErrors = 1;
		prnMsg(_('You should enter the street address in the box provided') . '. ' . _('Orders cannot be accepted without a valid street address'), 'error');
	} //mb_strlen($_POST['BrAdd1']) <= 1
	//	if (mb_strpos($_POST['BrAdd1'],_('Box'))>0){
	//		prnMsg(_('You have entered the word') . ' "' . _('Box') . '" ' . _('in the street address') . '. ' . _('Items cannot be delivered to') . ' ' ._('box') . ' ' . _('addresses'),'warn');
	//	}
	if (!is_numeric($_POST['FreightCost'])) {
		$InputErrors = 1;
		prnMsg(_('The freight cost entered is expected to be numeric'), 'error');
	} //!is_numeric($_POST['FreightCost'])
	if (isset($_POST['MakeRecurringOrder']) and $_POST['Quotation'] == 1) {
		$InputErrors = 1;
		prnMsg(_('A recurring order cannot be made from a quotation'), 'error');
	} //isset($_POST['MakeRecurringOrder']) and $_POST['Quotation'] == 1
	if (($_POST['DeliverBlind']) <= 0) {
		$InputErrors = 1;
		prnMsg(_('You must select the type of packlist to print'), 'error');
	} //($_POST['DeliverBlind']) <= 0

	/*	if (mb_strlen($_POST['BrAdd3'])==0 or !isset($_POST['BrAdd3'])){
	$InputErrors =1;
	echo "<br />A region or city must be entered.<br />";
	}

	Maybe appropriate in some installations but not here
	if (mb_strlen($_POST['BrAdd2'])<=1){
	$InputErrors =1;
	echo "<br />You should enter the suburb in the box provided. Orders cannot be accepted without a valid suburb being entered.<br />";
	}

	*/
	// Check the date is OK
	if (isset($_POST['DeliveryDate']) and !is_date($_POST['DeliveryDate'])) {
		$InputErrors = 1;
		prnMsg(_('An invalid date entry was made') . '. ' . _('The date entry must be in the format') . ' ' . $_SESSION['DefaultDateFormat'], 'warn');
	} //isset($_POST['DeliveryDate']) and !is_date($_POST['DeliveryDate'])
	// Check the date is OK
	if (isset($_POST['QuoteDate']) and !is_date($_POST['QuoteDate'])) {
		$InputErrors = 1;
		prnMsg(_('An invalid date entry was made') . '. ' . _('The date entry must be in the format') . ' ' . $_SESSION['DefaultDateFormat'], 'warn');
	} //isset($_POST['QuoteDate']) and !is_date($_POST['QuoteDate'])
	// Check the date is OK
	if (isset($_POST['ConfirmedDate']) and !is_date($_POST['ConfirmedDate'])) {
		$InputErrors = 1;
		prnMsg(_('An invalid date entry was made') . '. ' . _('The date entry must be in the format') . ' ' . $_SESSION['DefaultDateFormat'], 'warn');
	} //isset($_POST['ConfirmedDate']) and !is_date($_POST['ConfirmedDate'])

	/* This check is not appropriate where orders need to be entered in retrospectively in some cases this check will be appropriate and this should be uncommented

	elseif (Date1GreaterThanDate2(Date($_SESSION['DefaultDateFormat'],$EarliestDispatch), $_POST['DeliveryDate'])){
	$InputErrors =1;
	echo '<br /><b>' . _('The delivery details cannot be updated because you are attempting to set the date the order is to be dispatched earlier than is possible. No dispatches are made on Saturday and Sunday. Also, the dispatch cut off time is') .  $_SESSION['DispatchCutOffTime']  . _(':00 hrs. Orders placed after this time will be dispatched the following working day.');
	}

	*/

	if ($InputErrors == 0) {
		if ($_SESSION['DoFreightCalc'] == True) {
		       list ($_POST['FreightCost'], $BestShipper) = CalcFreightCost($_SESSION['Items'.$Identifier]->total,
																			$_POST['BrAdd2'],
																			$_POST['BrAdd3'],
																			$_POST['BrAdd4'],
																			$_POST['BrAdd5'],
																			$_POST['BrAdd6'],
																			$_SESSION['Items'.$Identifier]->totalVolume,
																			$_SESSION['Items'.$Identifier]->totalWeight,
																			$_SESSION['Items'.$Identifier]->Location,
																			$_SESSION['Items'.$Identifier]->DefaultCurrency,
																			$CountriesArray);
			if (!empty($BestShipper)) {
				$_POST['FreightCost'] = round($_POST['FreightCost'], 2);
				$_POST['ShipVia'] = $BestShipper;
			} else {
				prnMsg(_($_POST['FreightCost']), 'warn');
			}
		} //$_SESSION['DoFreightCalc'] == True
		$SQL = "SELECT custbranch.brname,
						custbranch.braddress1,
						custbranch.braddress2,
						custbranch.braddress3,
						custbranch.braddress4,
						custbranch.braddress5,
						custbranch.braddress6,
						custbranch.phoneno,
						custbranch.email,
						custbranch.defaultlocation,
						custbranch.defaultshipvia,
						custbranch.deliverblind,
						custbranch.specialinstructions,
						custbranch.estdeliverydays,
						custbranch.salesman
					FROM custbranch
					WHERE custbranch.branchcode='" . $_SESSION['Items' . $Identifier]->Branch . "'
						AND custbranch.debtorno = '" . $_SESSION['Items' . $Identifier]->DebtorNo . "'";

		$ErrMsg = _('The customer branch record of the customer selected') . ': ' . $_SESSION['Items' . $Identifier]->CustomerName . ' ' . _('cannot be retrieved because');
		$DbgMsg = _('SQL used to retrieve the branch details was') . ':';
		$Result = DB_query($SQL, $ErrMsg, $DbgMsg);
		if (DB_num_rows($Result) == 0) {
			prnMsg(_('The branch details for branch code') . ': ' . $_SESSION['Items' . $Identifier]->Branch . ' ' . _('against customer code') . ': ' . $_POST['Select'] . ' ' . _('could not be retrieved') . '. ' . _('Check the set up of the customer and branch'), 'error');

			if ($Debug == 1) {
				echo '<br />' . _('The SQL that failed to get the branch details was') . ':<br />' . $SQL;
			} //$Debug == 1
			include('includes/footer.inc');
			exit;
		} //DB_num_rows($Result) == 0
		if (!isset($_POST['SpecialInstructions'])) {
			$_POST['SpecialInstructions'] = '';
		} //!isset($_POST['SpecialInstructions'])
		if (!isset($_POST['DeliveryDays'])) {
			$_POST['DeliveryDays'] = 0;
		} //!isset($_POST['DeliveryDays'])
		if (!isset($_SESSION['Items' . $Identifier])) {
			$MyRow = DB_fetch_row($Result);
			$_SESSION['Items' . $Identifier]->DeliverTo = $MyRow[0];
			$_SESSION['Items' . $Identifier]->DelAdd1 = $MyRow[1];
			$_SESSION['Items' . $Identifier]->DelAdd2 = $MyRow[2];
			$_SESSION['Items' . $Identifier]->DelAdd3 = $MyRow[3];
			$_SESSION['Items' . $Identifier]->DelAdd4 = $MyRow[4];
			$_SESSION['Items' . $Identifier]->DelAdd5 = $MyRow[5];
			$_SESSION['Items' . $Identifier]->DelAdd6 = $MyRow[6];
			$_SESSION['Items' . $Identifier]->PhoneNo = $MyRow[7];
			$_SESSION['Items' . $Identifier]->Email = $MyRow[8];
			$_SESSION['Items' . $Identifier]->Location = $MyRow[9];
			$_SESSION['Items' . $Identifier]->ShipVia = $MyRow[10];
			$_SESSION['Items' . $Identifier]->DeliverBlind = $MyRow[11];
			$_SESSION['Items' . $Identifier]->SpecialInstructions = $MyRow[12];
			$_SESSION['Items' . $Identifier]->DeliveryDays = $MyRow[13];
			$_SESSION['Items' . $Identifier]->SalesPerson = $MyRow[14];
			$_SESSION['Items' . $Identifier]->DeliveryDate = $_POST['DeliveryDate'];
			$_SESSION['Items' . $Identifier]->QuoteDate = $_POST['QuoteDate'];
			$_SESSION['Items' . $Identifier]->ConfirmedDate = $_POST['ConfirmedDate'];
			$_SESSION['Items' . $Identifier]->CustRef = $_POST['CustRef'];
			$_SESSION['Items' . $Identifier]->Comments = $_POST['Comments'];
			$_SESSION['Items' . $Identifier]->FreightCost = round($_POST['FreightCost'], 2);
			$_SESSION['Items' . $Identifier]->Quotation = $_POST['Quotation'];
		} //!isset($_SESSION['Items' . $Identifier])
		else {
			$_SESSION['Items' . $Identifier]->DeliverTo = $_POST['DeliverTo'];
			$_SESSION['Items' . $Identifier]->DelAdd1 = $_POST['BrAdd1'];
			$_SESSION['Items' . $Identifier]->DelAdd2 = $_POST['BrAdd2'];
			$_SESSION['Items' . $Identifier]->DelAdd3 = $_POST['BrAdd3'];
			$_SESSION['Items' . $Identifier]->DelAdd4 = $_POST['BrAdd4'];
			$_SESSION['Items' . $Identifier]->DelAdd5 = $_POST['BrAdd5'];
			$_SESSION['Items' . $Identifier]->DelAdd6 = $_POST['BrAdd6'];
			$_SESSION['Items' . $Identifier]->PhoneNo = $_POST['PhoneNo'];
			$_SESSION['Items' . $Identifier]->Email = $_POST['Email'];
			$_SESSION['Items' . $Identifier]->Location = $_POST['Location'];
			$_SESSION['Items' . $Identifier]->ShipVia = $_POST['ShipVia'];
			$_SESSION['Items' . $Identifier]->DeliverBlind = $_POST['DeliverBlind'];
			$_SESSION['Items' . $Identifier]->SpecialInstructions = $_POST['SpecialInstructions'];
			$_SESSION['Items' . $Identifier]->DeliveryDays = $_POST['DeliveryDays'];
			$_SESSION['Items' . $Identifier]->DeliveryDate = $_POST['DeliveryDate'];
			$_SESSION['Items' . $Identifier]->QuoteDate = $_POST['QuoteDate'];
			$_SESSION['Items' . $Identifier]->ConfirmedDate = $_POST['ConfirmedDate'];
			$_SESSION['Items' . $Identifier]->CustRef = $_POST['CustRef'];
			$_SESSION['Items' . $Identifier]->Comments = $_POST['Comments'];
			$_SESSION['Items' . $Identifier]->SalesPerson = $_POST['SalesPerson'];
			$_SESSION['Items' . $Identifier]->FreightCost = round($_POST['FreightCost'], 2);
			$_SESSION['Items' . $Identifier]->Quotation = $_POST['Quotation'];
		}
		/*$_SESSION['DoFreightCalc'] is a setting in the config.php file that the user can set to false to turn off freight calculations if necessary */


		/* What to do if the shipper is not calculated using the system
		- first check that the default shipper defined in config.php is in the database
		if so use this
		- then check to see if any shippers are defined at all if not report the error
		and show a link to set them up
		- if shippers defined but the default shipper is bogus then use the first shipper defined
		*/
		if ((isset($BestShipper) and $BestShipper == '') and ($_POST['ShipVia'] == '' or !isset($_POST['ShipVia']))) {
			$SQL = "SELECT shipper_id
						FROM shippers
						WHERE shipper_id='" . $_SESSION['Default_Shipper'] . "'";
			$ErrMsg = _('There was a problem testing for the default shipper');
			$DbgMsg = _('SQL used to test for the default shipper') . ':';
			$TestShipperExists = DB_query($SQL, $ErrMsg, $DbgMsg);

			if (DB_num_rows($TestShipperExists) == 1) {
				$BestShipper = $_SESSION['Default_Shipper'];

			} //DB_num_rows($TestShipperExists) == 1
			else {
				$SQL = "SELECT shipper_id
							FROM shippers";
				$TestShipperExists = DB_query($SQL, $ErrMsg, $DbgMsg);

				if (DB_num_rows($TestShipperExists) >= 1) {
					$ShipperReturned = DB_fetch_row($TestShipperExists);
					$BestShipper = $ShipperReturned[0];
				} //DB_num_rows($TestShipperExists) >= 1
				else {
					prnMsg(_('We have a problem') . ' - ' . _('there are no shippers defined') . '. ' . _('Please use the link below to set up shipping or freight companies') . ', ' . _('the system expects the shipping company to be selected or a default freight company to be used'), 'error');
					echo '<a href="' . $RootPath . 'Shippers.php">' . _('Enter') . '/' . _('Amend Freight Companies') . '</a>';
				}
			}
			if (isset($_SESSION['Items' . $Identifier]->ShipVia) and $_SESSION['Items' . $Identifier]->ShipVia != '') {
				$_POST['ShipVia'] = $_SESSION['Items' . $Identifier]->ShipVia;
			} //isset($_SESSION['Items' . $Identifier]->ShipVia) and $_SESSION['Items' . $Identifier]->ShipVia != ''
			else {
				$_POST['ShipVia'] = $BestShipper;
			}
		} //(isset($BestShipper) and $BestShipper == '') and ($_POST['ShipVia'] == '' or !isset($_POST['ShipVia']))
	} //$InputErrors == 0
} //isset($_POST['Update']) or isset($_POST['BackToLineDetails']) or isset($_POST['MakeRecurringOrder'])

if (isset($_POST['MakeRecurringOrder']) and !$InputErrors) {
	echo '<meta http-equiv="Refresh" content="0; url=' . $RootPath . '/RecurringSalesOrders.php?identifier=' . $Identifier . '&amp;NewRecurringOrder=Yes">';
	prnMsg(_('You should automatically be forwarded to the entry of recurring order details page') . '. ' . _('if this does not happen') . '(' . _('if the browser does not support META Refresh') . ') ' . '<a href="' . $RootPath . '/RecurringOrders.php?identifier=' . urlencode($Identifier) . '&amp;NewRecurringOrder=Yes">' . _('click here') . '</a> ' . _('to continue'), 'info');
	include('includes/footer.inc');
	exit;
} //isset($_POST['MakeRecurringOrder']) and !$InputErrors


if (isset($_POST['BackToLineDetails']) and $_POST['BackToLineDetails'] == _('Modify Order Lines')) {
	echo '<meta http-equiv="Refresh" content="0; url=' . $RootPath . '/SelectOrderItems.php?identifier=' . $Identifier . '">';
	prnMsg(_('You should automatically be forwarded to the entry of the order line details page') . '. ' . _('if this does not happen') . '(' . _('if the browser does not support META Refresh') . ') ' . '<a href="' . $RootPath . '/SelectOrderItems.php?identifier=' . urlencode($Identifier) . '">' . _('click here') . '</a> ' . _('to continue'), 'info');
	include('includes/footer.inc');
	exit;

} //isset($_POST['BackToLineDetails']) and $_POST['BackToLineDetails'] == _('Modify Order Lines')

if (isset($_POST['ProcessOrder'])) {
	/*Default OK_to_PROCESS to 1 change to 0 later if hit a snag */
	if ($InputErrors == 0) {
		$OK_to_PROCESS = 1;
	} //$InputErrors == 0
	if ($_POST['FreightCost'] != $OldFreightCost and $_SESSION['DoFreightCalc'] == True) {
		$OK_to_PROCESS = 0;
		prnMsg(_('The freight charge has been updated') . '. ' . _('Please reconfirm that the order and the freight charges are acceptable and then confirm the order again if OK') . ' <br /> ' . _('The new freight cost is') . ' ' . $_POST['FreightCost'] . ' ' . _('and the previously calculated freight cost was') . ' ' . $OldFreightCost, 'warn');
	} //$_POST['FreightCost'] != $OldFreightCost and $_SESSION['DoFreightCalc'] == True
	else {
		/*check the customer's payment terms */
		$SQL = "SELECT daysbeforedue,
				dayinfollowingmonth
			FROM debtorsmaster,
				paymentterms
			WHERE debtorsmaster.paymentterms=paymentterms.termsindicator
			AND debtorsmaster.debtorno = '" . $_SESSION['Items' . $Identifier]->DebtorNo . "'";

		$ErrMsg = _('The customer terms cannot be determined') . '. ' . _('This order cannot be processed because');
		$DbgMsg = _('SQL used to find the customer terms') . ':';
		$TermsResult = DB_query($SQL, $ErrMsg, $DbgMsg);


		$MyRow = DB_fetch_array($TermsResult);
		if ($MyRow['daysbeforedue'] == 0 and $MyRow['dayinfollowingmonth'] == 0) {
			/* THIS IS A CASH SALE NEED TO GO OFF TO 3RD PARTY SITE SENDING MERCHANT ACCOUNT DETAILS AND CHECK FOR APPROVAL FROM 3RD PARTY SITE BEFORE CONTINUING TO PROCESS THE ORDER

			UNTIL ONLINE CREDIT CARD PROCESSING IS PERFORMED ASSUME OK TO PROCESS

			NOT YET CODED     */

			$OK_to_PROCESS = 1;


		} #end if cash sale detected

	} #end if else freight charge not altered
} #end if process order

if (isset($OK_to_PROCESS) and $OK_to_PROCESS == 1 and $_SESSION['ExistingOrder' . $Identifier] == 0) {
	/* finally write the order header to the database and then the order line details */

	$DelDate = FormatDateforSQL($_SESSION['Items' . $Identifier]->DeliveryDate);
	$QuotDate = FormatDateforSQL($_SESSION['Items' . $Identifier]->QuoteDate);
	$ConfDate = FormatDateforSQL($_SESSION['Items' . $Identifier]->ConfirmedDate);

	$Result = DB_Txn_Begin();

	$OrderNo = GetNextTransNo(30);

	if (isset($_FILES['Attachment']) and $_FILES['Attachment']['name'] != '') {

		$UploadTheFile = 'Yes'; //Assume all is well to start off with

		//But check for the worst
		if (mb_strtoupper(mb_substr(trim($_FILES['Attachment']['name']), mb_strlen($_FILES['Attachment']['name']) - 3)) != 'PDF') {
			prnMsg(_('Only pdf files are supported - a file extension of .pdf is expected'), 'warn');
			$UploadTheFile = 'No';
		} elseif ($_FILES['Attachment']['size'] > ($_SESSION['MaxImageSize'] * 1024)) { //File Size Check
			prnMsg(_('The file size is over the maximum allowed. The maximum size allowed in KB is') . ' ' . $_SESSION['MaxImageSize'], 'warn');
			$UploadTheFile = 'No';
		} elseif ($_FILES['Attachment']['type'] != 'application/pdf') { //File Type Check
			prnMsg(_('Only pdf files can be uploaded'), 'warn');
			$UploadTheFile = 'No';
		} elseif ($_FILES['Attachment']['error'] == 6 ) {  //upload temp directory check
			prnMsg( _('No tmp directory set. You must have a tmp directory set in your PHP for upload of files.'), 'warn');
			$UploadTheFile ='No';
		} elseif (file_exists($FileName)) {
			prnMsg(_('Attempting to overwrite an existing item attachment'), 'warn');
			$Result = unlink($FileName);
			if (!$Result) {
				prnMsg(_('The existing attachment could not be removed'), 'error');
				$UploadTheFile = 'No';
			}
		}

		if ($UploadTheFile == 'Yes') {
			$OrderNumber = $OrderNo;
			$Name = $_FILES['Attachment']['name'];
			$Type = $_FILES['Attachment']['type'];
			$Size = $_FILES['Attachment']['size'];
			$fp = fopen($_FILES['Attachment']['tmp_name'], 'r');
			$Content = fread($fp, $Size);
			$Content = addslashes($Content);
			fclose($fp);
			$SQL = "INSERT INTO salesorderattachments VALUES('" . $OrderNumber . "',
															'" . $Name . "',
															'" . $Type . "',
															" . $Size . ",
															'" . $Content . "'
															)";
			$Result = DB_query($SQL);

		}
	}

	$HeaderSQL = "INSERT INTO salesorders (
								orderno,
								debtorno,
								branchcode,
								customerref,
								comments,
								orddate,
								ordertype,
								shipvia,
								deliverto,
								deladd1,
								deladd2,
								deladd3,
								deladd4,
								deladd5,
								deladd6,
								contactphone,
								contactemail,
								salesperson,
								freightcost,
								fromstkloc,
								deliverydate,
								quotedate,
								confirmeddate,
								quotation,
								deliverblind)
							VALUES (
								'" . $OrderNo . "',
								'" . $_SESSION['Items' . $Identifier]->DebtorNo . "',
								'" . $_SESSION['Items' . $Identifier]->Branch . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->CustRef) . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->Comments) . "',
								'" . Date("Y-m-d H:i") . "',
								'" . $_SESSION['Items' . $Identifier]->DefaultSalesType . "',
								'" . $_POST['ShipVia'] . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->DeliverTo) . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd1) . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd2) . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd3) . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd4) . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd5) . "',
								'" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd6) . "',
								'" . $_SESSION['Items' . $Identifier]->PhoneNo . "',
								'" . $_SESSION['Items' . $Identifier]->Email . "',
								'" . $_SESSION['Items' . $Identifier]->SalesPerson . "',
								'" . $_SESSION['Items' . $Identifier]->FreightCost . "',
								'" . $_SESSION['Items' . $Identifier]->Location . "',
								'" . $DelDate . "',
								'" . $QuotDate . "',
								'" . $ConfDate . "',
								'" . $_SESSION['Items' . $Identifier]->Quotation . "',
								'" . $_SESSION['Items' . $Identifier]->DeliverBlind . "'
								)";

	$ErrMsg = _('The order cannot be added because');
	$InsertQryResult = DB_query($HeaderSQL, $ErrMsg);


	$StartOf_LineItemsSQL = "INSERT INTO salesorderdetails (
											orderlineno,
											orderno,
											stkcode,
											unitprice,
											quantity,
											discountpercent,
											narrative,
											poline,
											itemdue)
										VALUES (";
	$DbgMsg = _('The SQL that failed was');
	foreach ($_SESSION['Items' . $Identifier]->LineItems as $StockItem) {
		$LineItemsSQL = $StartOf_LineItemsSQL . "
					'" . $StockItem->LineNumber . "',
					'" . $OrderNo . "',
					'" . $StockItem->StockID . "',
					'" . $StockItem->Price . "',
					'" . $StockItem->Quantity . "',
					'" . floatval($StockItem->DiscountPercent) . "',
					'" . DB_escape_string($StockItem->Narrative) . "',
					'" . $StockItem->POLine . "',
					'" . FormatDateForSQL($StockItem->ItemDue) . "'
				)";
		$ErrMsg = _('Unable to add the sales order line');
		$Ins_LineItemResult = DB_query($LineItemsSQL, $ErrMsg, $DbgMsg, true);

		/*Now check to see if the item is manufactured
		 * 			and AutoCreateWOs is on
		 * 			and it is a real order (not just a quotation)*/

		if ($StockItem->MBflag == 'M' and $_SESSION['AutoCreateWOs'] == 1 and $_SESSION['Items' . $Identifier]->Quotation != 1) { //oh yeah its all on!

			echo '<br />';

			//now get the data required to test to see if we need to make a new WO
			$QOHResult = DB_query("SELECT SUM(quantity) FROM locstock WHERE stockid='" . $StockItem->StockID . "'");
			$QOHRow = DB_fetch_row($QOHResult);
			$QOH = $QOHRow[0];

			$SQL = "SELECT SUM(salesorderdetails.quantity - salesorderdetails.qtyinvoiced) AS qtydemand
					FROM salesorderdetails INNER JOIN salesorders
					ON salesorderdetails.orderno=salesorders.orderno
					WHERE salesorderdetails.stkcode = '" . $StockItem->StockID . "'
					AND salesorderdetails.completed = 0
					AND salesorders.quotation=0";
			$DemandResult = DB_query($SQL);
			$DemandRow = DB_fetch_row($DemandResult);
			$QuantityDemand = $DemandRow[0];

			$SQL = "SELECT SUM((salesorderdetails.quantity-salesorderdetails.qtyinvoiced)*bom.quantity) AS dem
					FROM salesorderdetails INNER JOIN salesorders
					ON salesorderdetails.orderno=salesorders.orderno
					INNER JOIN bom ON salesorderdetails.stkcode=bom.parent
					INNER JOIN stockmaster ON stockmaster.stockid=bom.parent
					WHERE salesorderdetails.quantity-salesorderdetails.qtyinvoiced > 0
					AND bom.component='" . $StockItem->StockID . "'
					AND salesorders.quotation=0
					AND stockmaster.mbflag='A'
					AND salesorderdetails.completed=0";
			$AssemblyDemandResult = DB_query($SQL);
			$AssemblyDemandRow = DB_fetch_row($AssemblyDemandResult);
			$QuantityAssemblyDemand = $AssemblyDemandRow[0];

			$SQL = "SELECT SUM(purchorderdetails.quantityord - purchorderdetails.quantityrecd) as qtyonorder
					FROM purchorderdetails,
						purchorders
					WHERE purchorderdetails.orderno = purchorders.orderno
					AND purchorderdetails.itemcode = '" . $StockItem->StockID . "'
					AND purchorderdetails.completed = 0";
			$PurchOrdersResult = DB_query($SQL);
			$PurchOrdersRow = DB_fetch_row($PurchOrdersResult);
			$QuantityPurchOrders = $PurchOrdersRow[0];

			$SQL = "SELECT SUM(woitems.qtyreqd - woitems.qtyrecd) as qtyonorder
					FROM woitems INNER JOIN workorders
					ON woitems.wo=workorders.wo
					WHERE woitems.stockid = '" . $StockItem->StockID . "'
					AND woitems.qtyreqd > woitems.qtyrecd
					AND workorders.closed = 0";
			$WorkOrdersResult = DB_query($SQL);
			$WorkOrdersRow = DB_fetch_row($WorkOrdersResult);
			$QuantityWorkOrders = $WorkOrdersRow[0];

			//Now we have the data - do we need to make any more?
			$ShortfallQuantity = $QOH - $QuantityDemand - $QuantityAssemblyDemand + $QuantityPurchOrders + $QuantityWorkOrders;

			if ($ShortfallQuantity < 0) { //then we need to make a work order
				//How many should the work order be for??
				if ($ShortfallQuantity + $StockItem->EOQ < 0) {
					$WOQuantity = -$ShortfallQuantity;
				} //$ShortfallQuantity + $StockItem->EOQ < 0
				else {
					$WOQuantity = $StockItem->EOQ;
				}

				$WONo = GetNextTransNo(40);
				$ErrMsg = _('Unable to insert a new work order for the sales order item');
				$InsWOResult = DB_query("INSERT INTO workorders (wo,
												 loccode,
												 requiredby,
												 startdate)
								 VALUES ('" . $WONo . "',
										'" . $_SESSION['DefaultFactoryLocation'] . "',
										CURRENT_DATE,
										CURRENT_DATE)", $ErrMsg, $DbgMsg, true);
				//Need to get the latest BOM to roll up cost
				$CostResult = DB_query("SELECT SUM((stockcosts.materialcost+stockcosts.labourcost+stockcosts.overheadcost)*bom.quantity) AS cost
													FROM stockcosts
													INNER JOIN bom
														ON stockcosts.stockid=bom.component
														AND stockcosts.succeeded=0
													WHERE bom.parent='" . $StockItem->StockID . "'
														AND bom.loccode='" . $_SESSION['DefaultFactoryLocation'] . "'");
				$CostRow = DB_fetch_row($CostResult);
				if (is_null($CostRow[0]) or $CostRow[0] == 0) {
					$Cost = 0;
					prnMsg(_('In automatically creating a work order for') . ' ' . $StockItem->StockID . ' ' . _('an item on this sales order, the cost of this item as accumulated from the sum of the component costs is nil. This could be because there is no bill of material set up ... you may wish to double check this'), 'warn');
				} //is_null($CostRow[0]) or $CostRow[0] == 0
				else {
					$Cost = $CostRow[0];
				}

				// insert parent item info
				$SQL = "INSERT INTO woitems (wo,
											 stockid,
											 qtyreqd,
											 stdcost)
								 VALUES ( '" . $WONo . "',
										 '" . $StockItem->StockID . "',
										 '" . $WOQuantity . "',
										 '" . $Cost . "')";
				$ErrMsg = _('The work order item could not be added');
				$Result = DB_query($SQL, $ErrMsg, $DbgMsg, true);

				//Recursively insert real component requirements - see includes/SQL_CommonFunctions.in for function WoRealRequirements
				WoRealRequirements($WONo, $_SESSION['DefaultFactoryLocation'], $StockItem->StockID);

				$FactoryManagerEmail = _('A new work order has been created for') . ":\n" . $StockItem->StockID . ' - ' . $StockItem->ItemDescription . ' x ' . $WOQuantity . ' ' . $StockItem->Units . "\n" . _('These are for') . ' ' . $_SESSION['Items' . $Identifier]->CustomerName . ' ' . _('there order ref') . ': ' . $_SESSION['Items' . $Identifier]->CustRef . ' ' . _('our order number') . ': ' . $OrderNo;

				if ($StockItem->Serialised and $StockItem->NextSerialNo > 0) {
					//then we must create the serial numbers for the new WO also
					$FactoryManagerEmail .= "\n" . _('The following serial numbers have been reserved for this work order') . ':';

					for ($i = 0; $i < $WOQuantity; $i++) {
						$Result = DB_query("SELECT serialno FROM stockserialitems
												WHERE serialno='" . ($StockItem->NextSerialNo + $i) . "'
												AND stockid='" . $StockItem->StockID . "'");
						if (DB_num_rows($Result) != 0) {
							$WOQuantity++;
							prnMsg(($StockItem->NextSerialNo + $i) . ': ' . _('This automatically generated serial number already exists - it cannot be added to the work order'), 'error');
						} //DB_num_rows($Result) != 0
						else {
							$SQL = "INSERT INTO woserialnos (wo,
																stockid,
																serialno)
													VALUES ('" . $WONo . "',
															'" . $StockItem->StockID . "',
															'" . ($StockItem->NextSerialNo + $i) . "')";
							$ErrMsg = _('The serial number for the work order item could not be added');
							$Result = DB_query($SQL, $ErrMsg, $DbgMsg, true);
							$FactoryManagerEmail .= "\n" . ($StockItem->NextSerialNo + $i);
						}
					} //end loop around creation of woserialnos
					$NewNextSerialNo = ($StockItem->NextSerialNo + $WOQuantity + 1);
					$ErrMsg = _('Could not update the new next serial number for the item');
					$UpdateNextSerialNoResult = DB_query("UPDATE stockmaster SET nextserialno='" . $NewNextSerialNo . "' WHERE stockid='" . $StockItem->StockID . "'", $ErrMsg, $DbgMsg, true);
				} // end if the item is serialised and nextserialno is set

				$EmailSubject = _('New Work Order Number') . ' ' . $WONo . ' ' . _('for') . ' ' . $StockItem->StockID . ' x ' . $WOQuantity;
				//Send email to the Factory Manager
				if ($_SESSION['SmtpSetting'] == 0) {
					mail($_SESSION['FactoryManagerEmail'], $EmailSubject, $FactoryManagerEmail);

				} else {
					include('includes/htmlMimeMail.php');
					$Mail = new htmlMimeMail();
					$Mail->setSubject($EmailSubject);
					$Result = SendmailBySmtp($Mail, array(
						$_SESSION['FactoryManagerEmail']
					));
				}

			} //end if with this sales order there is a shortfall of stock - need to create the WO
		} //end if auto create WOs in on
	} //$_SESSION['Items' . $Identifier]->LineItems as $StockItem

	/* end inserted line items into sales order details */

	$Result = DB_Txn_Commit();
	echo '<br />';
	if ($_SESSION['Items' . $Identifier]->Quotation == 1) {
		prnMsg(_('Quotation Number') . ' ' . $OrderNo . ' ' . _('has been entered'), 'success');
	} //$_SESSION['Items' . $Identifier]->Quotation == 1
	else {
		prnMsg(_('Order Number') . ' ' . $OrderNo . ' ' . _('has been entered'), 'success');
	}

	if (count($_SESSION['AllowedPageSecurityTokens']) > 1) {
		/* Only allow print of packing slip for internal staff - customer logon's cannot go here */

		if ($_POST['Quotation'] == 0) {
			/*then its not a quotation its a real order */

			echo '<table class="selection">
					<tr>
						<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/printer.png" title="' . _('Print') . '" alt="" /></td>
						<td>' . ' ' . '<a target="_blank" href="' . $RootPath . '/PrintCustOrder.php?identifier=' . urlencode($Identifier) . '&amp;TransNo=' . urlencode($OrderNo) . '">' . _('Print packing slip') . ' (' . _('Preprinted stationery') . ')' . '</a></td>
					</tr>';
			echo '<tr>
					<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/printer.png" title="' . _('Print') . '" alt="" /></td>
					<td>' . ' ' . '<a  target="_blank" href="' . $RootPath . '/PrintCustOrder_generic.php?identifier=' . urlencode($Identifier) . '&amp;TransNo=' . urlencode($OrderNo) . '">' . _('Print packing slip') . ' (' . _('Laser') . ')' . '</a></td>
				</tr>';

			echo '<tr>
					<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/reports.png" title="' . _('Invoice') . '" alt="" /></td>
					<td>' . ' ' . '<a href="' . $RootPath . '/ConfirmDispatch_Invoice.php?identifier=' . urlencode($Identifier) . '&amp;OrderNumber=' . urlencode($OrderNo) . '">' . _('Confirm Dispatch and Produce Invoice') . '</a></td>
				</tr>';

			echo '</table>';

		} else {
			/*link to print the quotation */
			echo '<table class="selection">
					<tr>
						<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/reports.png" title="' . _('Order') . '" alt=""></td>
						<td>' . ' ' . '<a href="' . $RootPath . '/PDFQuotation.php?identifier=' . $Identifier . '&amp;QuotationNo=' . $OrderNo . '" target="_blank">' . _('Print Quotation (Landscape)') . '</a></td>
					</tr>
					</table>';
			echo '<table class="selection">
					<tr>
						<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/reports.png" title="' . _('Order') . '" alt="" /></td>
						<td>' . ' ' . '<a href="' . $RootPath . '/PDFQuotationPortrait.php?identifier=' . $Identifier . '&amp;QuotationNo=' . $OrderNo . '" target="_blank">' . _('Print Quotation (Portrait)') . '</a></td>
					</tr>
					</table>';
		}
		echo '<table class="selection">
				<tr>
					<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/sales.png" title="' . _('Order') . '" alt="" /></td>
					<td>' . ' ' . '<a href="' . $RootPath . '/SelectOrderItems.php?identifier=' . urlencode($Identifier) . '&amp;NewOrder=Yes">' . _('Add Another Sales Order') . '</a></td>
				</tr>
				</table>';
	} //count($_SESSION['AllowedPageSecurityTokens']) > 1
	else {
		/*its a customer logon so thank them */
		prnMsg(_('Thank you for your business'), 'success');
	}

	unset($_SESSION['Items' . $Identifier]->LineItems);
	unset($_SESSION['Items' . $Identifier]);
	include('includes/footer.inc');
	exit;

} //isset($OK_to_PROCESS) and $OK_to_PROCESS == 1 and $_SESSION['ExistingOrder' . $Identifier] == 0
elseif (isset($OK_to_PROCESS) and ($OK_to_PROCESS == 1 and $_SESSION['ExistingOrder' . $Identifier] != 0)) {
	/* update the order header then update the old order line details and insert the new lines */

	$DelDate = FormatDateforSQL($_SESSION['Items' . $Identifier]->DeliveryDate);
	$QuotDate = FormatDateforSQL($_SESSION['Items' . $Identifier]->QuoteDate);
	$ConfDate = FormatDateforSQL($_SESSION['Items' . $Identifier]->ConfirmedDate);

	$Result = DB_Txn_Begin();

	/*see if this is a contract quotation being changed to an order? */
	if ($_SESSION['Items' . $Identifier]->Quotation == 0) { //now its being changed? to an order
		$ContractResult = DB_query("SELECT contractref,
											requireddate
									FROM contracts WHERE orderno='" . $_SESSION['ExistingOrder' . $Identifier] . "'
									AND status=1");
		if (DB_num_rows($ContractResult) == 1) { //then it is a contract quotation being changed to an order
			$ContractRow = DB_fetch_array($ContractResult);
			$WONo = GetNextTransNo(40);
			$ErrMsg = _('Could not update the contract status');
			$DbgMsg = _('The SQL that failed to update the contract status was');
			$UpdContractResult = DB_query("UPDATE contracts SET status=2,
															wo='" . $WONo . "'
										WHERE orderno='" . $_SESSION['ExistingOrder' . $Identifier] . "'", $ErrMsg, $DbgMsg, true);
			$ErrMsg = _('Could not insert the contract bill of materials');
			$InsContractBOM = DB_query("INSERT INTO bom (parent,
														 component,
														 workcentreadded,
														 loccode,
														 effectiveafter,
														 effectiveto,
													 	 quantity)
											SELECT contractref,
													stockid,
													workcentreadded,
													'" . $_SESSION['Items' . $Identifier]->Location . "',
													CURRENT_DATE,
													'2099-12-31',
													quantity
											FROM contractbom
											WHERE contractref='" . $ContractRow['contractref'] . "'", $ErrMsg, $DbgMsg);

			$ErrMsg = _('Unable to insert a new work order for the sales order item');
			$InsWOResult = DB_query("INSERT INTO workorders (wo,
															 loccode,
															 requiredby,
															 startdate)
											 VALUES ('" . $WONo . "',
													'" . $_SESSION['Items' . $Identifier]->Location . "',
													'" . $ContractRow['requireddate'] . "',
													CURRENT_DATE)", $ErrMsg, $DbgMsg);
			//Need to get the latest BOM to roll up cost but also add the contract other requirements
			$CostResult = DB_query("SELECT SUM((stockcosts.materialcost+stockcosts.labourcost+stockcosts.overheadcost)*contractbom.quantity) AS cost
									FROM stockcosts
									INNER JOIN contractbom
										ON stockcosts.stockid=contractbom.stockid
										AND stockcosts.succeeded=0
									WHERE contractbom.contractref='" . $ContractRow['contractref'] . "'");
			$CostRow = DB_fetch_row($CostResult);
			if (is_null($CostRow[0]) or $CostRow[0] == 0) {
				$Cost = 0;
				prnMsg(_('In automatically creating a work order for') . ' ' . $ContractRow['contractref'] . ' ' . _('an item on this sales order, the cost of this item as accumulated from the sum of the component costs is nil. This could be because there is no bill of material set up ... you may wish to double check this'), 'warn');
			} //is_null($CostRow[0]) or $CostRow[0] == 0
			else {
				$Cost = $CostRow[0]; //cost of contract BOM
			}
			$CostResult = DB_query("SELECT SUM(costperunit*quantity) AS cost
									FROM contractreqts
									WHERE contractreqts.contractref='" . $ContractRow['contractref'] . "'");
			$CostRow = DB_fetch_row($CostResult);
			//add other requirements cost to cost of contract BOM
			$Cost += $CostRow[0];

			// insert parent item info
			$SQL = "INSERT INTO woitems (wo,
										 stockid,
										 qtyreqd,
										 stdcost)
							 VALUES ( '" . $WONo . "',
									 '" . $ContractRow['contractref'] . "',
									 '1',
									 '" . $Cost . "')";
			$ErrMsg = _('The work order item could not be added');
			$Result = DB_query($SQL, $ErrMsg, $DbgMsg, true);

			//Recursively insert real component requirements - see includes/SQL_CommonFunctions.in for function WoRealRequirements
			WoRealRequirements($WONo, $_SESSION['Items' . $Identifier]->Location, $ContractRow['contractref']);

		} //end processing if the order was a contract quotation being changed to an order
	} //end test to see if the order was a contract quotation being changed to an order


	$HeaderSQL = "UPDATE salesorders SET debtorno = '" . $_SESSION['Items' . $Identifier]->DebtorNo . "',
										branchcode = '" . $_SESSION['Items' . $Identifier]->Branch . "',
										customerref = '" . DB_escape_string($_SESSION['Items' . $Identifier]->CustRef) . "',
										comments = '" . DB_escape_string($_SESSION['Items' . $Identifier]->Comments) . "',
										ordertype = '" . $_SESSION['Items' . $Identifier]->DefaultSalesType . "',
										shipvia = '" . $_POST['ShipVia'] . "',
										deliverydate = '" . FormatDateForSQL(DB_escape_string($_SESSION['Items' . $Identifier]->DeliveryDate)) . "',
										quotedate = '" . FormatDateForSQL(DB_escape_string($_SESSION['Items' . $Identifier]->QuoteDate)) . "',
										confirmeddate = '" . FormatDateForSQL(DB_escape_string($_SESSION['Items' . $Identifier]->ConfirmedDate)) . "',
										deliverto = '" . DB_escape_string($_SESSION['Items' . $Identifier]->DeliverTo) . "',
										deladd1 = '" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd1) . "',
										deladd2 = '" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd2) . "',
										deladd3 = '" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd3) . "',
										deladd4 = '" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd4) . "',
										deladd5 = '" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd5) . "',
										deladd6 = '" . DB_escape_string($_SESSION['Items' . $Identifier]->DelAdd6) . "',
										contactphone = '" . $_SESSION['Items' . $Identifier]->PhoneNo . "',
										contactemail = '" . $_SESSION['Items' . $Identifier]->Email . "',
										salesperson = '" . $_SESSION['Items' . $Identifier]->SalesPerson . "',
										freightcost = '" . $_SESSION['Items' . $Identifier]->FreightCost . "',
										fromstkloc = '" . $_SESSION['Items' . $Identifier]->Location . "',
										printedpackingslip = '" . $_POST['ReprintPackingSlip'] . "',
										quotation = '" . $_SESSION['Items' . $Identifier]->Quotation . "',
										deliverblind = '" . $_SESSION['Items' . $Identifier]->DeliverBlind . "'
						WHERE salesorders.orderno='" . $_SESSION['ExistingOrder' . $Identifier] . "'";

	$DbgMsg = _('The SQL that was used to update the order and failed was');
	$ErrMsg = _('The order cannot be updated because');
	$InsertQryResult = DB_query($HeaderSQL, $ErrMsg, $DbgMsg, true);


	foreach ($_SESSION['Items' . $Identifier]->LineItems as $StockItem) {
		/* Check to see if the quantity reduced to the same quantity
		as already invoiced - so should set the line to completed */
		if ($StockItem->Quantity == $StockItem->QtyInv) {
			$Completed = 1;
		} //$StockItem->Quantity == $StockItem->QtyInv
		else {
			/* order line is not complete */
			$Completed = 0;
		}

		$LineItemsSQL = "UPDATE salesorderdetails SET unitprice='" . $StockItem->Price . "',
													quantity='" . $StockItem->Quantity . "',
													discountpercent='" . floatval($StockItem->DiscountPercent) . "',
													completed='" . $Completed . "',
													poline='" . $StockItem->POLine . "',
													itemdue='" . FormatDateForSQL($StockItem->ItemDue) . "'
						WHERE salesorderdetails.orderno='" . $_SESSION['ExistingOrder' . $Identifier] . "'
						AND salesorderdetails.orderlineno='" . $StockItem->LineNumber . "'";

		$DbgMsg = _('The SQL that was used to modify the order line and failed was');
		$ErrMsg = _('The updated order line cannot be modified because');
		$Upd_LineItemResult = DB_query($LineItemsSQL, $ErrMsg, $DbgMsg, true);

	} //$_SESSION['Items' . $Identifier]->LineItems as $StockItem

	/* updated line items into sales order details */

	$Result = DB_Txn_Commit();
	$Quotation = $_SESSION['Items' . $Identifier]->Quotation;
	unset($_SESSION['Items' . $Identifier]->LineItems);
	unset($_SESSION['Items' . $Identifier]);

	if ($Quotation) { //handle Quotations and Orders print after modification
		prnMsg(_('Quotation Number') . ' ' . $_SESSION['ExistingOrder' . $Identifier] . ' ' . _('has been updated'), 'success');

		/*link to print the quotation */
		echo '<br /><table class="selection">
				<tr>
					<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/reports.png" title="' . _('Order') . '" alt=""></td>
					<td>' . ' ' . '<a href="' . $RootPath . '/PDFQuotation.php?identifier=' . $Identifier . '&amp;QuotationNo=' . $_SESSION['ExistingOrder' . $Identifier] . '" target="_blank">' . _('Print Quotation (Landscape)') . '</a></td>
				</tr>
				</table>';
		echo '<br /><table class="selection">
				<tr>
					<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/reports.png" title="' . _('Order') . '" alt="" /></td>
					<td>' . ' ' . '<a href="' . $RootPath . '/PDFQuotationPortrait.php?identifier=' . $Identifier . '&amp;QuotationNo=' . $_SESSION['ExistingOrder' . $Identifier] . '" target="_blank">' . _('Print Quotation (Portrait)') . '</a></td>
				</tr>
				</table>';
	} //$Quotation
	else {
		prnMsg(_('Order Number') . ' ' . $_SESSION['ExistingOrder' . $Identifier] . ' ' . _('has been updated'), 'success');

		echo '<br />
			<table class="selection">
			<tr>
			<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/printer.png" title="' . _('Print') . '" alt="" /></td>
			<td><a target="_blank" href="' . $RootPath . '/PrintCustOrder.php?identifier=' . urlencode($Identifier) . '&amp;TransNo=' . urlencode($_SESSION['ExistingOrder' . $Identifier]) . '">' . _('Print packing slip - pre-printed stationery') . '</a></td>
			</tr>';
		echo '<tr>
			<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/printer.png" title="' . _('Print') . '" alt="" /></td>
			<td><a  target="_blank" href="' . $RootPath . '/PrintCustOrder_generic.php?identifier=' . urlencode($Identifier) . '&amp;TransNo=' . urlencode($_SESSION['ExistingOrder' . $Identifier]) . '">' . _('Print packing slip') . ' (' . _('Laser') . ')' . '</a></td>
		</tr>';
		echo '<tr>
			<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/reports.png" title="' . _('Invoice') . '" alt="" /></td>
			<td><a href="' . $RootPath . '/ConfirmDispatch_Invoice.php?identifier=' . urlencode($Identifier) . '&amp;OrderNumber=' . urlencode($_SESSION['ExistingOrder' . $Identifier]) . '">' . _('Confirm Order Delivery Quantities and Produce Invoice') . '</a></td>
		</tr>';
		echo '<tr>
			<td><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/sales.png" title="' . _('Order') . '" alt="" /></td>
			<td><a href="' . $RootPath . '/SelectSalesOrder.php?identifier=' . urlencode($Identifier) . '">' . _('Select A Different Order') . '</a></td>
		</tr>
		</table>';
	} //end of print orders
	include('includes/footer.inc');
	exit;
} //isset($OK_to_PROCESS) and ($OK_to_PROCESS == 1 and $_SESSION['ExistingOrder' . $Identifier] != 0)


if (isset($_SESSION['Items' . $Identifier]->SpecialInstructions) and mb_strlen($_SESSION['Items' . $Identifier]->SpecialInstructions) > 0) {
	prnMsg($_SESSION['Items' . $Identifier]->SpecialInstructions, 'info');
} //isset($_SESSION['Items' . $Identifier]->SpecialInstructions) and mb_strlen($_SESSION['Items' . $Identifier]->SpecialInstructions) > 0
echo '<p class="page_title_text" ><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/inventory.png" title="' . _('Delivery') . '" alt="" />' . ' ' . _('Delivery Details') . '</p>';

echo '<p class="page_title_text" ><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/customer.png" title="' . _('Customer') . '" alt="" />' . ' ' . _('Customer Code') . ' :<b> ' . stripslashes($_SESSION['Items' . $Identifier]->DebtorNo) . '<br />';
echo '</b>&nbsp;' . _('Customer Name') . ' :<b> ' . $_SESSION['Items' . $Identifier]->CustomerName . '</b></p>';


echo '<form action="' . $_SERVER['PHP_SELF'] . '?identifier=' . $Identifier . '" method="post"  enctype="multipart/form-data">';
echo '<input type="hidden" name="FormID" value="' . $_SESSION['FormID'] . '" />';


/*Display the order with or without discount depending on access level*/
if (in_array(2, $_SESSION['AllowedPageSecurityTokens'])) {
	echo '<table>';

	if ($_SESSION['Items' . $Identifier]->Quotation == 1) {
		echo '<tr>
				<th colspan="7">' . _('Quotation Summary') . '</th>
			</tr>';
	} //$_SESSION['Items' . $Identifier]->Quotation == 1
	else {
		echo '<tr>
				<th colspan="7">' . _('Order Summary') . '</th>
			</tr>';
	}
	echo '<tr>
				<th>' . _('Item Code') . '</th>
				<th>' . _('Item Description') . '</th>
				<th>' . _('Quantity') . '</th>
				<th>' . _('Unit') . '</th>
				<th>' . _('Price') . '</th>
				<th>' . _('Discount') . ' %</th>
				<th>' . _('Total') . '</th>
			</tr>';

	$_SESSION['Items' . $Identifier]->total = 0;
	$_SESSION['Items' . $Identifier]->totalVolume = 0;
	$_SESSION['Items' . $Identifier]->totalWeight = 0;
	$k = 0; //row colour counter

	foreach ($_SESSION['Items' . $Identifier]->LineItems as $StockItem) {
		$LineTotal = $StockItem->Quantity * $StockItem->Price * (1 - $StockItem->DiscountPercent);
		$DisplayLineTotal = locale_number_format($LineTotal, $_SESSION['Items' . $Identifier]->CurrDecimalPlaces);
		$DisplayPrice = locale_number_format($StockItem->Price, $_SESSION['Items' . $Identifier]->CurrDecimalPlaces);
		$DisplayQuantity = locale_number_format($StockItem->Quantity, $StockItem->DecimalPlaces);
		$DisplayDiscount = locale_number_format(($StockItem->DiscountPercent * 100), 2);


		if ($k == 1) {
			echo '<tr class="EvenTableRows">';
			$k = 0;
		} //$k == 1
		else {
			echo '<tr class="OddTableRows">';
			$k = 1;
		}

		echo '<td>' . $StockItem->StockID . '</td>
			<td title="' . $StockItem->LongDescription . '">' . $StockItem->ItemDescription . '</td>
			<td class="number">' . $DisplayQuantity . '</td>
			<td>' . $StockItem->Units . '</td>
			<td class="number">' . $DisplayPrice . '</td>
			<td class="number">' . $DisplayDiscount . '</td>
			<td class="number">' . $DisplayLineTotal . '</td>
		</tr>';

		$_SESSION['Items' . $Identifier]->total = $_SESSION['Items' . $Identifier]->total + $LineTotal;
		$_SESSION['Items' . $Identifier]->totalVolume = $_SESSION['Items' . $Identifier]->totalVolume + ($StockItem->Quantity * $StockItem->Volume);
		$_SESSION['Items' . $Identifier]->totalWeight = $_SESSION['Items' . $Identifier]->totalWeight + ($StockItem->Quantity * $StockItem->Weight);
	} //$_SESSION['Items' . $Identifier]->LineItems as $StockItem

	$DisplayTotal = number_format($_SESSION['Items' . $Identifier]->total, 2);
	echo '<tr class="EvenTableRows">
			<td colspan="6" class="number"><b>' . _('TOTAL Excl Tax/Freight') . '</b></td>
			<td class="number">' . $DisplayTotal . '</td>
		</tr>
		</table>';

	$DisplayVolume = locale_number_format($_SESSION['Items' . $Identifier]->totalVolume,5);
	$DisplayWeight = locale_number_format($_SESSION['Items' . $Identifier]->totalWeight, 2);
	echo '<br />
		<table>
		<tr class="EvenTableRows">
			<td>' . _('Total Weight') . ':</td>
			<td class="number">' . $DisplayWeight . '</td>
			<td>' . _('Total Volume') . ':</td>
			<td class="number">' . $DisplayVolume . '</td>
		</tr>
		</table>';

} //in_array(2, $_SESSION['AllowedPageSecurityTokens'])
else {
	/*Display the order without discount */

	echo '<div class="centre"><b>' . _('Order Summary') . '</b></div>
	<table class="selection">
	<tr>
		<th>' . _('Item Description') . '</th>
		<th>' . _('Quantity') . '</th>
		<th>' . _('Unit') . '</th>
		<th>' . _('Price') . '</th>
		<th>' . _('Total') . '</th>
	</tr>';

	$_SESSION['Items' . $Identifier]->total = 0;
	$_SESSION['Items' . $Identifier]->totalVolume = 0;
	$_SESSION['Items' . $Identifier]->totalWeight = 0;
	$k = 0; // row colour counter
	foreach ($_SESSION['Items' . $Identifier]->LineItems as $StockItem) {
		$LineTotal = $StockItem->Quantity * $StockItem->Price * (1 - $StockItem->DiscountPercent);
		$DisplayLineTotal = locale_number_format($LineTotal, $_SESSION['Items' . $Identifier]->CurrDecimalPlaces);
		$DisplayPrice = locale_number_format($StockItem->Price, $_SESSION['Items' . $Identifier]->CurrDecimalPlaces);
		$DisplayQuantity = locale_number_format($StockItem->Quantity, $StockItem->DecimalPlaces);

		if ($k == 1) {
			echo '<tr class="OddTableRows">';
			$k = 0;
		} //$k == 1
		else {
			echo '<tr class="EvenTableRows">';
			$k = 1;
		}
		echo '<td>' . $StockItem->ItemDescription . '</td>
				<td class="number">' . $DisplayQuantity . '</td>
				<td>' . $StockItem->Units . '</td>
				<td class="number">' . $DisplayPrice . '</td>
				<td class="number">' . $DisplayLineTotal . '</font></td>
			</tr>';

		$_SESSION['Items' . $Identifier]->total = $_SESSION['Items' . $Identifier]->total + $LineTotal;
		$_SESSION['Items' . $Identifier]->totalVolume = $_SESSION['Items' . $Identifier]->totalVolume + $StockItem->Quantity * $StockItem->Volume;
		$_SESSION['Items' . $Identifier]->totalWeight = $_SESSION['Items' . $Identifier]->totalWeight + $StockItem->Quantity * $StockItem->Weight;

	} //$_SESSION['Items' . $Identifier]->LineItems as $StockItem

	$DisplayTotal = locale_number_format($_SESSION['Items' . $Identifier]->total, $_SESSION['Items' . $Identifier]->CurrDecimalPlaces);

	$DisplayVolume = locale_number_format($_SESSION['Items' . $Identifier]->totalVolume,5);
	$DisplayWeight = locale_number_format($_SESSION['Items' . $Identifier]->totalWeight, 2);
	echo '<table class="selection">
			<tr>
				<td>' . _('Total Weight') . ':</td>
				<td>' . $DisplayWeight . '</td>
				<td>' . _('Total Volume') . ':</td>
				<td>' . $DisplayVolume . '</td>
			</tr>
		</table>';

}

echo '<table class="selection">
	<tr>
		<td>' . _('Deliver To') . ':</td>
		<td><input type="text" size="42" autofocus="autofocus" required="required" maxlength="40" name="DeliverTo" value="' . stripslashes($_SESSION['Items' . $Identifier]->DeliverTo) . '" /></td>
	</tr>';

echo '<tr>
	<td>' . _('Deliver from the warehouse at') . ':</td>
	<td><select required="required" name="Location">';

// BEGIN: **********************************************************************
$SQL = "SELECT locations.loccode,
				locationname
			FROM locations
			INNER JOIN locationusers
				ON locationusers.loccode=locations.loccode
				AND locationusers.userid='" . $_SESSION['UserID'] . "'
				AND locationusers.canupd=1
			WHERE locations.allowinvoicing='1'
			ORDER BY locations.locationname";
$ErrMsg = _('The stock locations could not be retrieved');
$DbgMsg = _('SQL used to retrieve the stock locations was') . ':';

$StkLocsResult = DB_query($SQL, $ErrMsg, $DbgMsg);
// COMMENT: What if there is no authorized locations available for this user?
while ($MyRow = DB_fetch_array($StkLocsResult)) {
	echo '<option', ($_SESSION['Items' . $Identifier]->Location == $MyRow['loccode'] ? ' selected="selected"' : ''), ' value="', $MyRow['loccode'], '">', $MyRow['locationname'], '</option>';
}
echo '</select>
		</td>
	</tr>';
// END: ************************************************************************

// Set the default date to earliest possible date if not set already
if (!isset($_SESSION['Items' . $Identifier]->DeliveryDate)) {
	$_SESSION['Items' . $Identifier]->DeliveryDate = Date($_SESSION['DefaultDateFormat'], $EarliestDispatch);
} //!isset($_SESSION['Items' . $Identifier]->DeliveryDate)
if (!isset($_SESSION['Items' . $Identifier]->QuoteDate)) {
	$_SESSION['Items' . $Identifier]->QuoteDate = Date($_SESSION['DefaultDateFormat'], $EarliestDispatch);
} //!isset($_SESSION['Items' . $Identifier]->QuoteDate)
if (!isset($_SESSION['Items' . $Identifier]->ConfirmedDate)) {
	$_SESSION['Items' . $Identifier]->ConfirmedDate = Date($_SESSION['DefaultDateFormat'], $EarliestDispatch);
} //!isset($_SESSION['Items' . $Identifier]->ConfirmedDate)

// The estimated Dispatch date or Delivery date for this order
echo '<tr>
		<td>' . _('Estimated Delivery Date') . ':</td>
		<td><input class="date" alt="' . $_SESSION['DefaultDateFormat'] . '" type="text" size="15" maxlength="14" name="DeliveryDate" value="' . $_SESSION['Items' . $Identifier]->DeliveryDate . '" /></td>
	</tr>';
// The date when a quote was issued to the customer
echo '<tr>
		<td>' . _('Quote Date') . ':</td>
		<td><input class="date" alt="' . $_SESSION['DefaultDateFormat'] . '" type="text" size="15" maxlength="14" name="QuoteDate" value="' . $_SESSION['Items' . $Identifier]->QuoteDate . '" /></td>
	</tr>';
// The date when the customer confirmed their order
echo '<tr>
		<td>' . _('Confirmed Order Date') . ':</td>
		<td><input class="date" alt="' . $_SESSION['DefaultDateFormat'] . '" type="text" size="15" maxlength="14" name="ConfirmedDate" value="' . $_SESSION['Items' . $Identifier]->ConfirmedDate . '" /></td>
	</tr>
	<tr>
		<td>' . _('Delivery Address 1') . ':</td>
		<td><input type="text" size="42" required="required" maxlength="40" name="BrAdd1" value="' . $_SESSION['Items' . $Identifier]->DelAdd1 . '" /></td>
	</tr>
	<tr>
		<td>' . _('Delivery Address 2') . ':</td>
		<td><input type="text" size="42" maxlength="40" name="BrAdd2" value="' . $_SESSION['Items' . $Identifier]->DelAdd2 . '" /></td>
	</tr>
	<tr>
		<td>' . _('Delivery Address 3') . ':</td>
		<td><input type="text" size="42" maxlength="40" name="BrAdd3" value="' . $_SESSION['Items' . $Identifier]->DelAdd3 . '" /></td>
	</tr>
	<tr>
		<td>' . _('Delivery Address 4') . ':</td>
		<td><input type="text" size="42" maxlength="40" name="BrAdd4" value="' . $_SESSION['Items' . $Identifier]->DelAdd4 . '" /></td>
	</tr>
	<tr>
		<td>' . _('Delivery Address 5') . ':</td>
		<td><input type="text" size="42" maxlength="40" name="BrAdd5" value="' . $_SESSION['Items' . $Identifier]->DelAdd5 . '" /></td>
	</tr>';
echo '<tr>
		<td>' . _('Country') . ':</td>
		<td><select name="BrAdd6">';
foreach ($CountriesArray as $CountryEntry => $CountryName){
	if (isset($_POST['BrAdd6']) AND (strtoupper($_POST['BrAdd6']) == strtoupper($CountryName))){
		echo '<option selected="selected" value="' . $CountryName . '">' . $CountryName .'</option>';
	}elseif (!isset($_POST['BrAdd6']) AND $CountryName == $_SESSION['Items'.$Identifier]->DelAdd6) {
		echo '<option selected="selected" value="' . $CountryName . '">' . $CountryName .'</option>';
	} else {
		echo '<option value="' . $CountryName . '">' . $CountryName .'</option>';
	}
}
echo '</select></td>
	</tr>';
echo '<tr>
		<td>' . _('Contact Phone Number') . ':</td>
		<td><input type="text" size="25" maxlength="25" name="PhoneNo" value="' . $_SESSION['Items' . $Identifier]->PhoneNo . '" /></td>
	</tr>
	<tr>
		<td>' . _('Contact Email') . ':</td><td><input type="email" size="40" maxlength="38" name="Email" value="' . $_SESSION['Items' . $Identifier]->Email . '" /></td>
	</tr>
	<tr>
		<td>' . _('Customer Reference') . ':</td>
		<td><input type="text" size="25" maxlength="25" name="CustRef" value="' . $_SESSION['Items' . $Identifier]->CustRef . '" /></td>
	</tr>
	<tr>
		<td>' . _('Comments') . ':</td>
		<td><textarea name="Comments" cols="31" rows="5">' . $_SESSION['Items' . $Identifier]->Comments . '</textarea></td>
	</tr>';

if (isset($SupplierLogin) and $SupplierLogin == 0) {
	echo '<input type="hidden" name="SalesPerson" value="' . $_SESSION['Items' . $Identifier]->SalesPerson . '" />
				<input type="hidden" name="DeliverBlind" value="1" />
				<input type="hidden" name="FreightCost" value="0" />
				<input type="hidden" name="ShipVia" value="' . $_SESSION['Items' . $Identifier]->ShipVia . '" />
				<input type="hidden" name="Quotation" value="0" />';
} //isset($SupplierLogin) and $SupplierLogin == 0
else {
	echo '<tr>
				<td>' . _('Sales person') . ':</td>
				<td><select name="SalesPerson">';
	$SalesPeopleResult = DB_query("SELECT salesmancode, salesmanname FROM salesman WHERE current=1");
	if (!isset($_POST['SalesPerson']) and $_SESSION['SalesmanLogin'] != NULL) {
		$_SESSION['Items' . $Identifier]->SalesPerson = $_SESSION['SalesmanLogin'];
	} //!isset($_POST['SalesPerson']) AND $_SESSION['SalesmanLogin'] != NULL

	while ($SalesPersonRow = DB_fetch_array($SalesPeopleResult)) {
		if ($SalesPersonRow['salesmancode'] == $_SESSION['Items' . $Identifier]->SalesPerson) {
			echo '<option selected="selected" value="' . $SalesPersonRow['salesmancode'] . '">' . $SalesPersonRow['salesmanname'] . '</option>';
		} //$SalesPersonRow['salesmancode'] == $_SESSION['Items' . $Identifier]->SalesPerson
		else {
			echo '<option value="' . $SalesPersonRow['salesmancode'] . '">' . $SalesPersonRow['salesmanname'] . '</option>';
		}
	} //$SalesPersonRow = DB_fetch_array($SalesPeopleResult)

	echo '</select></td>
			</tr>';

	/* This field will control whether or not to display the company logo and
	address on the packlist */

	echo '<tr>
				<td>' . _('Packlist Type') . ':</td>
				<td><select name="DeliverBlind">';

	if ($_SESSION['Items' . $Identifier]->DeliverBlind == 2) {
		echo '<option value="1">' . _('Show Company Details/Logo') . '</option>';
		echo '<option selected="selected" value="2">' . _('Hide Company Details/Logo') . '</option>';
	} //$_SESSION['Items' . $Identifier]->DeliverBlind == 2
	else {
		echo '<option selected="selected" value="1">' . _('Show Company Details/Logo') . '</option>';
		echo '<option value="2">' . _('Hide Company Details/Logo') . '</option>';
	}
}

echo '</select></td></tr>';
if (isset($_SESSION['PrintedPackingSlip']) AND $_SESSION['PrintedPackingSlip'] == 1) {
	echo '<tr>
							   <td>' . _('Reprint packing slip') . ':</td>
							   <td><select name="ReprintPackingSlip">';
	echo '<option value="0">' . _('Yes') . '</option>';
	echo '<option selected="selected" value="1">' . _('No') . '</option>';
	echo '</select> ' . _('Last printed') . ': ' . ConvertSQLDate($_SESSION['DatePackingSlipPrinted']) . '</td></tr>';
} //isset($_SESSION['PrintedPackingSlip']) AND $_SESSION['PrintedPackingSlip'] == 1
else {
	echo '<tr><td><input type="hidden" name="ReprintPackingSlip" value="0" /></td></tr>';
}

echo '<tr>
		<td>' . _('Charge Freight Cost ex tax') . ':</td>
		<td><input type="text" class="number" size="10" maxlength="12" name="FreightCost" value="' . $_SESSION['Items' . $Identifier]->FreightCost . '" /></td>';

if ($_SESSION['DoFreightCalc'] == true) {
	echo '<td><input type="submit" name="Update" value="' . _('Recalc Freight Cost') . '" /></td>';
} //$_SESSION['DoFreightCalc'] == true
echo '</tr>';

if ((!isset($_POST['ShipVia']) OR $_POST['ShipVia'] == '') AND isset($_SESSION['Items' . $Identifier]->ShipVia)) {
	$_POST['ShipVia'] = $_SESSION['Items' . $Identifier]->ShipVia;
} //(!isset($_POST['ShipVia']) OR $_POST['ShipVia'] == '') AND isset($_SESSION['Items' . $Identifier]->ShipVia)

echo '<tr>
		<td>' . _('Freight/Shipper Method') . ':</td>
		<td><select name="ShipVia">';
$ErrMsg = _('The shipper details could not be retrieved');
$DbgMsg = _('SQL used to retrieve the shipper details was') . ':';

$SQL = "SELECT shipper_id, shippername FROM shippers";
$ShipperResults = DB_query($SQL, $ErrMsg, $DbgMsg);
while ($MyRow = DB_fetch_array($ShipperResults)) {
	if ($MyRow['shipper_id'] == $_POST['ShipVia']) {
		echo '<option selected="selected" value="' . $MyRow['shipper_id'] . '">' . $MyRow['shippername'] . '</option>';
	} //$MyRow['shipper_id'] == $_POST['ShipVia']
	else {
		echo '<option value="' . $MyRow['shipper_id'] . '">' . $MyRow['shippername'] . '</option>';
	}
} //$MyRow = DB_fetch_array($ShipperResults)

echo '</select></td></tr>';


echo '<tr>
		<td>' . _('Quotation Only') . ':</td>
		<td><select name="Quotation">';
if ($_SESSION['Items' . $Identifier]->Quotation == 1) {
	echo '<option selected="selected" value="1">' . _('Yes') . '</option>';
	echo '<option value="0">' . _('No') . '</option>';
} //$_SESSION['Items' . $Identifier]->Quotation == 1
else {
	echo '<option value="1">' . _('Yes') . '</option>';
	echo '<option selected="selected" value="0">' . _('No') . '</option>';
}
echo '</select></td></tr>';

echo '<tr>
		<td>' . _('Order Attachment') . '</td>
		<td><input type="file" name="Attachment" id="Attachment" /></td>
	</tr>';

echo '</table>';

echo '<div class="centre"><input type="submit" name="BackToLineDetails" value="' . _('Modify Order Lines') . '" /><br />';

if ($_SESSION['ExistingOrder' . $Identifier] == 0) {
	echo '<br /><br /><input type="submit" name="ProcessOrder" value="' . _('Place Order') . '" />';
	echo '<br /><br /><input type="submit" name="MakeRecurringOrder" value="' . _('Create Recurring Order') . '" />';
} //$_SESSION['ExistingOrder' . $Identifier] == 0
else {
	echo '<br /><input type="submit" name="ProcessOrder" value="' . _('Commit Order Changes') . '" />';
}

echo '</form>';
include('includes/footer.inc');
?>