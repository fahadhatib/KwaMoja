<?php

include('includes/session.inc');

$Title = _('Maintain ABC ranking groups');

include('includes/header.inc');

echo '<p class="page_title_text" >
		<img src="', $RootPath, '/css/', $_SESSION['Theme'], '/images/maintenance.png" title="', $Title, '" alt="', $Title, '" />', ' ', $Title, '
	</p>';

if (isset($_GET['Delete'])) {
	$CheckSQL = "SELECT groupid FROM abcstock WHERE groupid='" . $_GET['SelectedGroupID'] . "'";
	$CheckResult = DB_query($CheckSQL);
	if (DB_num_rows($CheckResult) == 0) {
		$SQL = "DELETE FROM abcgroups WHERE groupid='" . $_GET['SelectedGroupID'] . "'";
		$Result = DB_query($SQL);
		prnMsg(_('ABC Ranking group number') . ' ' . $_GET['SelectedGroupID'] . ' ' . _('has been deleted'), 'success');
		echo '<div class="centre">
				<a href="', htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'), '">', _('View all the ranking groups'), '</a>
			</div>';
		include('includes/footer.inc');
		exit;
	} else {
		prnMsg(_('ABC Ranking group number') . ' ' . $_GET['SelectedMethodID'] . ' ' . _('cannot be deleted as it already has been run'), 'error');
	}
}

if (isset($_POST['Submit'])) {
	$InputError = 0;
	if ($_POST['GroupID'] == '') {
		$InputError++;
		prnMsg(_('The group id field cannot be left empty'), 'error');
	}
	if (!filter_var($_POST['GroupID'], FILTER_VALIDATE_INT)) {
		$InputError++;
		prnMsg(_('The group id field must be numeric'), 'error');
	}
	if ($_POST['GroupName'] == '') {
		$InputError++;
		prnMsg(_('The group name field cannot be left empty'), 'error');
	}
	if (mb_strlen($_POST['GroupName']) > 40) {
		$_POST['GroupName'] = substr($_POST['GroupName'], 0, 40);
		prnMsg(_('The group name cannot be more than 40 characters long, it has been shortened to') . ' ' . $_POST['GroupName'], 'info');
	}
	if ($_POST['MethodID'] == '') {
		$InputError++;
		prnMsg(_('You must select a ranking method.'), 'error');
	}
	if (!filter_var($_POST['APercent'], FILTER_VALIDATE_INT)) {
		$InputError++;
		prnMsg(_('The A percentage field must be numeric'), 'error');
	}
	if (!filter_var($_POST['BPercent'], FILTER_VALIDATE_INT)) {
		$InputError++;
		prnMsg(_('The B percentage field must be numeric'), 'error');
	}
	if (!filter_var($_POST['CPercent'], FILTER_VALIDATE_INT)) {
		$InputError++;
		prnMsg(_('The C percentage field must be numeric'), 'error');
	}

	if (($_POST['APercent'] + $_POST['BPercent'] + $_POST['CPercent']) != 100) {
		$InputError++;
		prnMsg(_('The percentage fields must add up to 100'), 'error');
	}

	if (!filter_var($_POST['Months'], FILTER_VALIDATE_INT)) {
		$InputError++;
		prnMsg(_('The number of months field must be numeric'), 'error');
	}

	if ($InputError == 0) {
		$SQL = "INSERT INTO abcgroups ( groupid,
										groupname,
										methodid,
										apercentage,
										bpercentage,
										cpercentage,
										zerousage,
										months
									) VALUES (
										'" . $_POST['GroupID'] . "',
										'" . $_POST['GroupName'] . "',
										'" . $_POST['MethodID'] . "',
										'" . $_POST['APercent'] . "',
										'" . $_POST['BPercent'] . "',
										'" . $_POST['CPercent'] . "',
										'" . $_POST['ZeroUsage'] . "',
										'" . $_POST['Months'] . "'
									)";
		$InputResult = DB_query($SQL);
		prnMsg(_('The ranking group has been successfully saved to the database'), 'success');
		echo '<div class="centre">
				<a href="', htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'), '">', _('View all the ranking groups'), '</a>
			</div>';
		include('includes/footer.inc');
		exit;
	}

} else {
	$SQL = "SELECT groupid,
					groupname,
					methodname,
					apercentage,
					bpercentage,
					cpercentage,
					zerousage,
					months
				FROM abcgroups
				INNER JOIN abcmethods
					ON abcgroups.methodid=abcmethods.methodid";
	$Result = DB_query($SQL);
	echo '<table class="selection" summary="', _('List of ABC Ranking Methods'), '">
			<tr>
				<th colspan="10">
					<h3>', _('List of ABC Ranking Groups'), '
						<img src="', $RootPath, '/css/', $_SESSION['Theme'], '/images/printer.png" class="PrintIcon" title="', _('Print'), '" alt="', _('Print'), '" onclick="window.print();" />
					</h3>
				</th>
			</tr>
			<tr>
				<th>', _('ID'), '</th>
				<th>', _('Group name'), '</th>
				<th>', _('Method name'), '</th>
				<th>', _('% in A category'), '</th>
				<th>', _('% in B category'), '</th>
				<th>', _('% in C category'), '</th>
				<th>', _('If Zero Usage'), '</th>
				<th>', _('Months in calculation'), '</th>
			</tr>';

	while ($MyRow = DB_fetch_array($Result)) {
		echo '<tr class="OddTableRows">
				<td>', $MyRow['groupid'], '</td>
				<td>', $MyRow['groupname'], '</td>
				<td>', $MyRow['methodname'], '</td>
				<td>', $MyRow['apercentage'], '</td>
				<td>', $MyRow['bpercentage'], '</td>
				<td>', $MyRow['cpercentage'], '</td>
				<td>', $MyRow['zerousage'], '</td>
				<td>', $MyRow['months'], '</td>
				<td><a href="', htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'), '?SelectedGroupID=', urlencode($MyRow['groupid']), '&amp;Delete=1" onclick="return MakeConfirm(\'' . _('Are you sure you wish to delete this ranking group?') . '\', \'Confirm Delete\', this);">', _('Delete'), '</a></td>
			</tr>';
	}
	echo '</table>';

	echo '<form action="', htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'), '" method="post" id="ABCMethods">';
	echo '<input type="hidden" name="FormID" value="', $_SESSION['FormID'], '" />';

	echo '<table>
			<tr>
				<th colspan="2">
					<h3>', _('Ranking Group Details'), '</h3>
				</th>
			</tr>
			<tr class="EvenTableRows">
				<td>', _('Group ID'), '</td>
				<td><input type="text" size="3" required="required" class="number" name="GroupID" /></td>
			</tr>
			<tr class="OddTableRows">
				<td>', _('Group Description'), '</td>
				<td><input type="text" size="30" maxlength="40" name="GroupName" value="" /></td>
			</tr>';

	$SQL = "SELECT methodid,
					methodname
				FROM abcmethods";
	$Result = DB_query($SQL);

	echo '<tr class="EvenTableRows">
			<td>', _('Ranking method'), '</td>
			<td>
				<select required="required" name="MethodID">
					<option value=""></option>';
	while ($MyRow = DB_fetch_array($Result)) {
		echo '<option value="', $MyRow['methodid'], '">', $MyRow['methodname'], '</option>';
	}
	echo '</select>
			</td>
		</tr>';

	echo '<tr class="OddTableRows">
			<td>', _('Percentage in A Category'), '</td>
			<td><input required="required" type="text" size="3" class="integer" name="APercent" value="10" /></td>
		</tr>
		<tr class="EvenTableRows">
			<td>', _('Percentage in B Category'), '</td>
			<td><input required="required" type="text" size="3" class="integer" name="BPercent" value="30" /></td>
		</tr>
		<tr class="OddTableRows">
			<td>', _('Percentage in C Category'), '</td>
			<td><input required="required" type="text" size="3" class="integer" name="CPercent" value="60" /></td>
		</tr>
		<tr class="EvenTableRows">
			<td>', _('If zero movement in period put itmes in'), '</td>
			<td>
				<select name="ZeroUsage">
					<option value="C">C</option>
					<option value="D">D</option>
				</select>
			</td>
		</tr>
		<tr class="OddTableRows">
			<td>', _('Months of Movement to include'), '</td>
			<td><input required="required" type="text" size="3" class="number" name="Months" value="12" /></td>
		</tr>';

	echo '</table>';
	echo '<div class="centre">
			<input type="submit" name="Submit" value="Save" />
		</div>';
	echo '</form>';
}

include('includes/footer.inc');

?>