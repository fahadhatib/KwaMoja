<?php

include('includes/session.inc');
$Title = _('EDI Message Format');
include('includes/header.inc');

if (isset($_GET['PartnerCode'])) {
	$PartnerCode = $_GET['PartnerCode'];
} elseif (isset($_POST['PartnerCode'])) {
	$PartnerCode = $_POST['PartnerCode'];
}

if (isset($_GET['MessageType'])) {
	$MessageType = $_GET['MessageType'];
} elseif (isset($_POST['MessageType'])) {
	$MessageType = $_POST['MessageType'];
}

if (isset($_GET['SelectedMessageLine'])) {
	$SelectedMessageLine = $_GET['SelectedMessageLine'];
} elseif (isset($_POST['SelectedMessageLine'])) {
	$SelectedMessageLine = $_POST['SelectedMessageLine'];
}


if (isset($_POST['NewEDIInvMsg'])) {
	$SQL = "INSERT INTO edimessageformat (partnercode,
						messagetype,
						sequenceno,
						section,
						linetext)
			SELECT '" . $PartnerCode . "',
				'INVOIC',
				sequenceno,
				section,
				linetext
			FROM edimessageformat
			WHERE partnercode='DEFAULT'
			AND messagetype='INVOIC'";

	$ErrMsg = _('There was an error inserting the default template invoice message records for') . ' ' . $PartnerCode . ' ' . _('because');
	$Result = DB_query($SQL, $ErrMsg);
}

$InputError = 0;
if ($InputError != 1 and isset($_POST['update'])) {

	/*SelectedMessageLine could also exist if submit had not been clicked this code would not run in this case cos submit is false of course  see the delete code below*/
	if (!isset($SelectedMessageLine)) {
		$SelectedMessageLine = '';
	}
	$SQL = "UPDATE edimessageformat
			SET partnercode='" . $PartnerCode . "',
				messagetype='" . $MessageType . "',
				section='" . $_POST['Section'] . "',
				sequenceno='" . $_POST['SequenceNo'] . "',
				linetext='" . $_POST['LineText'] . "'
			WHERE id = '" . $SelectedMessageLine . "'";
	$Result = DB_query($SQL);
	$Msg = _('Message line updated');
	unset($SelectedMessageLine);

} elseif ($InputError != 1 and isset($_POST['submit'])) {

	/*Selected group is null cos no item selected on first time round so must be adding a record must be submitting new entries in the new message line form */

	$SQL = "INSERT INTO edimessageformat (
				partnercode,
				messagetype,
				section,
				sequenceno,
				linetext)
			VALUES (
				'" . $PartnerCode . "',
				'" . $MessageType . "',
				'" . $_POST['Section'] . "',
				'" . $_POST['SequenceNo'] . "',
				'" . $_POST['LineText'] . "'
				)";
	$Msg = _('Message line added');
	//run the SQL from either of the above possibilites
	$Result = DB_query($SQL);
	unset($SelectedMessageLine);

} elseif (isset($_GET['delete'])) {
	//the link to delete a selected record was clicked instead of the submit button


	$SQL = "DELETE FROM edimessageformat WHERE id='" . $_GET['delete'] . "'";
	$Result = DB_query($SQL);
	$Msg = _('The selected message line has been deleted');

}
if (isset($Msg)) {
	prnMsg($Msg, 'success');
}

echo '<form onSubmit="return VerifyForm(this);" method="post" class="noPrint" action="' . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . '">';
echo '<div>';
echo '<input type="hidden" name="FormID" value="' . $_SESSION['FormID'] . '" />';

echo '<br />
	<p class="page_title_text noPrint" ><img src="' . $RootPath . '/css/' . $Theme . '/images/maintenance.png" title="' . _('Search') . '" alt="" />' . ' ' . $Title . '</p>';

if (!isset($SelectedMessageLine)) {

	/* A message line could be posted when one has been edited and is being updated or GOT when selected for modification SelectedMessageLine will exist because it was sent with the page in a GET .
	If its the first time the page has been displayed with no parameters
	then none of the above are true and the list of message lines will be displayed with
	links to delete or edit each. These will call the same page again and allow update/input
	or deletion of the records*/

	$SQL = "SELECT id,
				section,
				sequenceno,
				linetext
			FROM edimessageformat
			WHERE partnercode='" . $PartnerCode . "'
			AND messagetype='" . $MessageType . "'
			ORDER BY sequenceno";

	$Result = DB_query($SQL);

	echo '<table class="selection">
			<tr>
				<th colspan="5"><h3>' . _('Definition of') . ' ' . $MessageType . ' ' . _('for') . ' ' . $PartnerCode . '</h3></th>
			</tr>
			<tr>
				<th>' . _('Section') . '</th>
				<th>' . _('Sequence') . '</th>
				<th>' . _('Format String') . '</th>
			</tr>';

	$k = 0; //row colour counter
	while ($MyRow = DB_fetch_row($Result)) {

		if ($k == 1) {
			echo '<tr class="EvenTableRows">';
			$k = 0;
		} else {
			echo '<tr class="OddTableRows">';
			++$k;
		}


		printf('<td>%s</td>
				<td class="number">%s</td>
				<td>%s</td>
				<td><a href="%s&amp;SelectedMessageLine=%s">' . _('Edit') . '</a></td>
				<td><a href="%s&amp;delete=%s">' . _('Delete') . '</a></td>
				</tr>', $MyRow[1], $MyRow[2], $MyRow[3], htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'), $MyRow[0], htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'), $MyRow[0]);

	} //END WHILE LIST LOOP
	echo '</table><br />';
	if (DB_num_rows($Result) == 0) {
		echo '<div class="centre">
				<input tabindex="1" type="submit" name="NewEDIInvMsg" value="' . _('Create New EDI Invoice Message From Default Template') . '" />
			</div>
			<br />';
	}
} //end of ifs SelectedLine is not set




if (isset($SelectedMessageLine)) {
	//editing an existing message line

	$SQL = "SELECT messagetype,
			partnercode,
			section,
			sequenceno,
			linetext
		FROM edimessageformat
		WHERE id='" . $SelectedMessageLine . "'";

	$Result = DB_query($SQL);
	$MyRow = DB_fetch_array($Result);

	$_POST['Section'] = $MyRow['section'];
	$_POST['SequenceNo'] = $MyRow['sequenceno'];
	$_POST['LineText'] = $MyRow['linetext'];

	echo '<div class="centre"><a href="' . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . '?MessageType=INVOIC&amp;PartnerCode=' . $MyRow['partnercode'] . '">' . _('Review Message Lines') . '</a></div>';

	echo '<input type="hidden" name="SelectedMessageLine" value="' . $SelectedMessageLine . '" />';
	echo '<input type="hidden" name="MessageType" value="' . $MyRow['messagetype'] . '" />';
	echo '<input type="hidden" name="PartnerCode" value="' . $MyRow['partnercode'] . '" />';
} else { //end of if $SelectedMessageLine only do the else when a new record is being entered
	echo '<input type="hidden" name="MessageType" value="' . $MessageType . '" />';
	echo '<input type="hidden" name="PartnerCode" value="' . $PartnerCode . '" />';
}

echo '<table class="selection">';

if ($MyRow['messagetype'] != '') {
	echo '<tr>
			<th colspan="2">' . _('Definition of') . ' ' . $MyRow['messagetype'] . ' ' . _('for') . ' ' . $MyRow['partnercode'] . '</th>
		</tr>';
}

echo '<tr>
		<td>' . _('Section') . ':</td>
		<td>';
echo '<select minlength="0" tabindex="2" name="Section">';

if ($_POST['Section'] == 'Heading') {
	echo '<option selected="selected" value="Heading">' . _('Heading') . '</option>';
} else {
	echo '<option value="Heading">' . _('Heading') . '</option>';
}

if (isset($_POST['Section']) and $_POST['Section'] == 'Detail') {
	echo '<option selected="selected" value="Detail">' . _('Detail') . '</option>';
} else {
	echo '<option value="Detail">' . _('Detail') . '</option>';
}
if (isset($_POST['Section']) and $_POST['Section'] == 'Summary') {
	echo '<option selected="selected" value="Summary">' . _('Summary') . '</option>';
} else {
	echo '<option value="Summary">' . _('Summary') . '</option>';
}

echo '</select>';

if (!isset($_POST['SequenceNo'])) {
	$_POST['SequenceNo'] = '';
}
if (!isset($_POST['LineText'])) {
	$_POST['LineText'] = '';
}


echo '</td></tr>';

echo '<tr><td>Sequence Number:</td>';
echo '<td><input tabindex="3" type="text" name="SequenceNo" size="3" minlength="0" maxlength="3" value="' . $_POST['SequenceNo'] . '" />';
echo '</td></tr>';
echo '<tr><td>' . _('Line Text') . ':' . '</td>';
echo '<td>';
echo '<input tabindex="4" type="text" name="LineText" size="50" minlength="0" maxlength="50" value="' . $_POST['LineText'] . '" />';
echo '</td></tr>';
echo '</table><br />';
if (isset($_GET['SelectedMessageLine'])) {
	echo '<div class="centre"><input tabindex="5" type="submit" name="update" value="' . _('Update Information') . '" /></div>';
} else {
	echo '<div class="centre"><input tabindex="5" type="submit" name="submit" value="' . _('Enter Information') . '" /></div>';
}
echo '</div>';
echo '</form>';

include('includes/footer.inc');
?>