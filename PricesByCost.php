<?php

include('includes/session.inc');
$Title = _('Update of Prices By A Multiple Of Cost');
include('includes/header.inc');

echo '<p class="page_title_text" ><img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/inventory.png" title="' . _('Inventory') . '" alt="" />' . ' ' . _('Update Price By Cost') . '</p>';

if (isset($_POST['submit']) or isset($_POST['update'])) {
	if ($_POST['Margin'] == '') {
		header('Location: PricesByCost.php');
	}
	if ($_POST['Comparator'] == 1) {
		$Comparator = '<=';
	} else {
		$Comparator = '>=';
	}
	/*end of else Comparator */
	if ($_POST['StockCat'] != 'all') {
		$Category = " AND stockmaster.categoryid = '" . $_POST['StockCat'] . "'";
	} else {
		$Category = '';
	}
	/*end of else StockCat */

	$SQL = "SELECT 	stockmaster.stockid,
					stockmaster.description,
					prices.debtorno,
					prices.branchcode,
					(stockcosts.materialcost + stockcosts.labourcost + stockcosts.overheadcost) as cost,
					prices.price as price,
					prices.debtorno AS customer,
					prices.branchcode AS branch,
					prices.startdate,
					prices.enddate,
					currencies.decimalplaces,
					currencies.rate
				FROM stockmaster
				INNER JOIN prices
					ON stockmaster.stockid=prices.stockid
				INNER JOIN stoccosts
					ON stockmaster.stockid=stockcosts.stockid
					AND stockcosts.succeeded=0
				INNER JOIN currencies
					ON prices.currabrev=currencies.currabrev
				WHERE stockmaster.discontinued = 0
				" . $Category . "
				AND   prices.price" . $Comparator . "(stockcosts.materialcost + stockcosts.labourcost + stockcosts.overheadcost) * '" . filter_number_format($_POST['Margin']) . "'
				AND prices.typeabbrev ='" . $_POST['SalesType'] . "'
				AND prices.currabrev ='" . $_POST['CurrCode'] . "'
				AND (prices.enddate>=CURRENT_DATE OR prices.enddate='0000-00-00')";
	$Result = DB_query($SQL);
	$numrow = DB_num_rows($Result);

	if ($_POST['submit'] == 'Update') {
		//Update Prices
		$PriceCounter = 0;
		while ($MyRow = DB_fetch_array($Result)) {
			/*The logic here goes like this:
			 * 1. If the price at the same start and end date already exists then do nowt!!
			 * 2. If not then check if a price with the start date of today already exists - then we should be updating it
			 * 3. If not either of the above then insert the new price
			 */
			$SQLTestExists = "SELECT price FROM prices
								WHERE stockid = '" . $_POST['StockID_' . $PriceCounter] . "'
								AND prices.typeabbrev ='" . $_POST['SalesType'] . "'
								AND prices.currabrev ='" . $_POST['CurrCode'] . "'
								AND prices.debtorno ='" . $_POST['DebtorNo_' . $PriceCounter] . "'
								AND prices.branchcode ='" . $_POST['BranchCode_' . $PriceCounter] . "'
								AND prices.startdate ='" . $_POST['StartDate_' . $PriceCounter] . "'
								AND prices.enddate ='" . $_POST['EndDate_' . $PriceCounter] . "'
								AND prices.price ='" . filter_number_format($_POST['Price_' . $PriceCounter]) . "'";
			$TestExistsResult = DB_query($SQLTestExists);
			if (DB_num_rows($TestExistsResult) == 0) { //the price doesn't currently exist
				//now check to see if a new price has already been created from start date of today

				$SQLTestExists = "SELECT price FROM prices
									WHERE stockid = '" . $_POST['StockID_' . $PriceCounter] . "'
									AND prices.typeabbrev ='" . $_POST['SalesType'] . "'
									AND prices.currabrev ='" . $_POST['CurrCode'] . "'
									AND prices.debtorno ='" . $_POST['DebtorNo_' . $PriceCounter] . "'
									AND prices.branchcode ='" . $_POST['BranchCode_' . $PriceCounter] . "'
									AND prices.startdate ='CURRENT_DATE'";
				$TestExistsResult = DB_query($SQLTestExists);
				if (DB_num_rows($TestExistsResult) == 1) {
					//then we are updating
					$SQLUpdate = "UPDATE prices	SET price = '" . filter_number_format($_POST['Price_' . $PriceCounter]) . "'
									WHERE stockid = '" . $_POST['StockID_' . $PriceCounter] . "'
									AND prices.typeabbrev ='" . $_POST['SalesType'] . "'
									AND prices.currabrev ='" . $_POST['CurrCode'] . "'
									AND prices.debtorno ='" . $_POST['DebtorNo_' . $PriceCounter] . "'
									AND prices.branchcode ='" . $_POST['BranchCode_' . $PriceCounter] . "'
									AND prices.startdate ='CURRENT_DATE'
									AND prices.enddate ='" . $_POST['EndDate_' . $PriceCounter] . "'";
					$ResultUpdate = DB_query($SQLUpdate);
				} else { //there is not a price already starting today so need to create one
					//update the old price to have an end date of yesterday too
					$SQLUpdate = "UPDATE prices	SET enddate = '" . FormatDateForSQL(DateAdd(Date($_SESSION['DefaultDateFormat']), 'd', -1)) . "'
									WHERE stockid = '" . $_POST['StockID_' . $PriceCounter] . "'
									AND prices.typeabbrev ='" . $_POST['SalesType'] . "'
									AND prices.currabrev ='" . $_POST['CurrCode'] . "'
									AND prices.debtorno ='" . $_POST['DebtorNo_' . $PriceCounter] . "'
									AND prices.branchcode ='" . $_POST['BranchCode_' . $PriceCounter] . "'
									AND prices.startdate ='" . $_POST['StartDate_' . $PriceCounter] . "'
									AND prices.enddate ='" . $_POST['EndDate_' . $PriceCounter] . "'";
					$Result = DB_query($SQLUpdate);
					//we need to add a new price from today
					$SQLInsert = "INSERT INTO prices (	stockid,
														price,
														typeabbrev,
														currabrev,
														debtorno,
														branchcode,
														startdate
													) VALUES (
														'" . $_POST['StockID_' . $PriceCounter] . "',
														'" . filter_number_format($_POST['Price_' . $PriceCounter]) . "',
														'" . $_POST['SalesType'] . "',
														'" . $_POST['CurrCode'] . "',
														'" . $_POST['DebtorNo_' . $PriceCounter] . "',
														'" . $_POST['BranchCode_' . $PriceCounter] . "',
														'CURRENT_DATE'
													)";
					$ResultInsert = DB_query($SQLInsert);
				}
			}
			$PriceCounter++;
		} //end while loop
		DB_free_result($Result); //clear the old result
		$Result = DB_query($SQL); //re-run the query with the updated prices
		$numrow = DB_num_rows($Result); // get the new number - should be the same!!
	}

	$SQLcat = "SELECT categorydescription
				FROM stockcategory
				WHERE categoryid='" . $_POST['StockCat'] . "'";
	$ResultCat = DB_query($SQLcat);
	$CategoryRow = DB_fetch_array($ResultCat);

	$SQLtype = "SELECT sales_type
				FROM salestypes
				WHERE typeabbrev='" . $_POST['SalesType'] . "'";
	$ResultType = DB_query($SQLtype);
	$SalesTypeRow = DB_fetch_array($ResultType);

	if (isset($CategoryRow['categorgdescription'])) {
		$CategoryText = $CategoryRow['categorgdescription'] . ' ' . _('category');
	} else {
		$CategoryText = _('all Categories');
	}
	/*end of else Category */

	echo '<div class="page_help_text">' . _('Items in') . ' ' . $CategoryText . ' ' . _('With Prices') . ' ' . $Comparator . '' . $_POST['Margin'] . ' ' . _('times') . ' ' . _('Cost in Price List') . ' ' . $SalesTypeRow['sales_type'] . '</div><br /><br />';

	if ($numrow > 0) { //the number of prices returned from the main prices query is
		echo '<table class="selection">
				<thead>
					<tr>
						<th class="SortedColumn">' . _('Code') . '</th>
						<th class="SortedColumn">' . _('Description') . '</th>
						<th class="SortedColumn">' . _('Customer') . '</th>
						<th class="SortedColumn">' . _('Branch') . '</th>
						<th class="SortedColumn">' . _('Start Date') . '</th>
						<th>' . _('End Date') . '</th>
						<th>' . _('Cost') . '</th>
						<th>' . _('GP %') . '</th>
						<th>' . _('Price Proposed') . '</th>
						<th>' . _('List Price') . '</th>
					<tr>
				</thead>';
		$k = 0; //row colour counter
		echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . '" method="post" id="update">';
		echo '<input type="hidden" name="FormID" value="' . $_SESSION['FormID'] . '" />';
		echo '<input type="hidden" value="' . $_POST['StockCat'] . '" name="StockCat" />
			<input type="hidden" value="' . $_POST['Margin'] . '" name="Margin" />
			<input type="hidden" value="' . $_POST['CurrCode'] . '" name="CurrCode" />
			<input type="hidden" value="' . $_POST['Comparator'] . '" name="Comparator" />
			<input type="hidden" value="' . $_POST['SalesType'] . '" name="SalesType" />';

		$PriceCounter = 0;
		echo '<tbody>';
		while ($MyRow = DB_fetch_array($Result)) {

			if ($k == 1) {
				echo '<tr class="EvenTableRows">';
				$k = 0;
			} else {
				echo '<tr class="OddTableRows">';
				$k = 1;
			}
			//get cost
			if ($MyRow['cost'] == '') {
				$Cost = 0;
			} else {
				$Cost = $MyRow['cost'];
			}
			/*end of else Cost */

			//variables for update
			echo '<input type="hidden" value="' . $MyRow['stockid'] . '" name="StockID_' . $PriceCounter . '" />
				<input type="hidden" value="' . $MyRow['debtorno'] . '" name="DebtorNo_' . $PriceCounter . '" />
				<input type="hidden" value="' . $MyRow['branchcode'] . '" name="BranchCode_' . $PriceCounter . '" />
				<input type="hidden" value="' . $MyRow['startdate'] . '" name="StartDate_' . $PriceCounter . '" />
				<input type="hidden" value="' . $MyRow['enddate'] . '" name="EndDate_' . $PriceCounter . '" />';
			//variable for current margin
			if ($MyRow['price'] != 0) {
				$CurrentGP = (($MyRow['price'] / $MyRow['rate']) - $Cost) * 100 / ($MyRow['price'] / $MyRow['rate']);
			} else {
				$CurrentGP = 0;
			}
			//variable for proposed
			$ProposedPrice = $Cost * filter_number_format($_POST['Margin']);
			if ($MyRow['enddate'] == '0000-00-00') {
				$EndDateDisplay = _('No End Date');
			} else {
				$EndDateDisplay = ConvertSQLDate($MyRow['enddate']);
			}
			echo '  <td>' . $MyRow['stockid'] . '</td>
					<td>' . $MyRow['description'] . '</td>
					<td>' . $MyRow['customer'] . '</td>
					<td>' . $MyRow['branch'] . '</td>
					<td>' . ConvertSQLDate($MyRow['startdate']) . '</td>
					<td>' . $EndDateDisplay . '</td>
					<td class="number">' . locale_number_format($Cost, $_SESSION['CompanyRecord']['decimalplaces']) . '</td>
					<td class="number">' . locale_number_format($CurrentGP, 1) . '%</td>
					<td class="number">' . locale_number_format($ProposedPrice, $MyRow['decimalplaces']) . '</td>
					<td><input type="text" class="number" name="Price_' . $PriceCounter . '" required="required" maxlength="14" size="10" value="' . locale_number_format($MyRow['price'], $MyRow['decimalplaces']) . '" /></td>
				</tr> ';
			$PriceCounter++;
		} //end of looping
		echo '</tbody>
				<tr>
					<td style="text-align:right" colspan="4">
						<input type="submit" name="submit" value="' . _('Update') . '" onclick="return MakeConfirm(\'' . _('If the prices above do not have a commencement date as today, this will create new prices with commencement date of today at the entered figures and update the existing prices with historical start dates to have an end date of yesterday. Are You Sure?') . '\');" />
					</td>
					<td style="text-align:left" colspan="3">
						<a href="' . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . '"><input type="submit" value="' . _('Back') . '" /></a>
					</td>
				</tr>
			</table>
		</form>';
	} else {
		prnMsg(_('There were no prices meeting the criteria specified to review'), 'info');
		echo '<br /><div class="centre"><a href="' . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . '">' . _('Back') . '<a/></div>';
	}
} else {
	/*The option to submit was not hit so display form */
	echo '<div class="page_help_text">' . _('Prices can be displayed based on their relation to cost') . '</div><br />';
	echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . '" method="post">';
	echo '<input type="hidden" name="FormID" value="' . $_SESSION['FormID'] . '" />';
	echo '<table class="selection">';

	$SQL = "SELECT categoryid, categorydescription
			  FROM stockcategory
			  ORDER BY categorydescription";
	$Result1 = DB_query($SQL);
	echo '<tr>
			<td>' . _('Category') . ':</td>
			<td><select required="required" name="StockCat">';
	echo '<option value="all">' . _('All Categories') . '</option>';
	while ($MyRow1 = DB_fetch_array($Result1)) {
		echo '<option value="' . $MyRow1['categoryid'] . '">' . $MyRow1['categorydescription'] . '</option>';
	}
	echo '</select></td></tr>';
	echo '<tr>
			<td>' . _('Price') . '
				<select required="required" name="Comparator">
					<option value="1">' . _('Less than or equal to') . '</option>
					<option value="2">' . _('Greater than or equal to') . '</option>';
	if ($_SESSION['WeightedAverageCosting'] == 1) {
		echo '</select>' . ' ' . _('Average Cost') . ' x </td>';
	} else {
		echo '</select>' . ' ' . _('Standard Cost') . ' x </td>';
	}
	if (!isset($_POST['Margin'])) {
		$_POST['Margin'] = 1;
	}
	echo '<td><input type="text" class="number" name="Margin" required="required" maxlength="8" size="8" value="' . $_POST['Margin'] . '" /></td></tr>';
	$Result = DB_query("SELECT typeabbrev, sales_type FROM salestypes");
	echo '<tr>
			<td>' . _('Sales Type') . '/' . _('Price List') . ':</td>
			<td><select required="required" name="SalesType">';
	while ($MyRow = DB_fetch_array($Result)) {
		if ($_POST['SalesType'] == $MyRow['typeabbrev']) {
			echo '<option selected="selected" value="' . $MyRow['typeabbrev'] . '">' . $MyRow['sales_type'] . '</option>';
		} else {
			echo '<option value="' . $MyRow['typeabbrev'] . '">' . $MyRow['sales_type'] . '</option>';
		}
	} //end while loop
	DB_data_seek($Result, 0);
	$Result = DB_query("SELECT currency, currabrev FROM currencies");
	echo '</select>
			</td></tr>';
	echo '<tr>
			<td>' . _('Currency') . ':</td>
			<td><select required="required" name="CurrCode">';
	while ($MyRow = DB_fetch_array($Result)) {
		if (isset($_POST['CurrCode']) and $_POST['CurrCode'] == $MyRow['currabrev']) {
			echo '<option selected="selected" value="' . $MyRow['currabrev'] . '">' . $MyRow['currency'] . '</option>';
		} else {
			echo '<option value="' . $MyRow['currabrev'] . '">' . $MyRow['currency'] . '</option>';
		}
	} //end while loop
	DB_data_seek($Result, 0);
	echo '</select></td></tr>';
	echo '</table>
		<div class="centre">
			<input type="submit" name="submit" value="' . _('Submit') . '" />
		</div>';
	echo '</form>';
}
/*end of else not submit */
include('includes/footer.inc');
?>