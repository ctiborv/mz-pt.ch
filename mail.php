<?php
// Assign contact info
//$emailComp = "bureau@mz-pt.ch";
$emailComp = "mm@mz-pt.ch";


$name = stripcslashes($_POST['name']);
$emailAddr = stripcslashes($_POST['email']);
$issue = stripcslashes($_POST['issue']);
$comment = stripcslashes($_POST['message']);
$subject = stripcslashes($_POST['subject']);
$headers = "Content-type: text/html; charset=utf-8 \r\n";
$headers .= "To: <$emailComp> \r\n";
$headers .= "From: Feedback sender <$emailAddr> \r\n";
$headers .= "X-Mailer: PHP/" . phpversion();
$contactMessage ="<div>
<p><strong>Name:</strong> $name <br />
<strong>E-mail:</strong> $emailAddr <br />
<strong>Issue:</strong> $issue </p>
<p><strong>Message:</strong> $comment </p>
<p><strong>Sending IP:</strong> $_SERVER[REMOTE_ADDR]<br />
<strong>Sent via:</strong> $_SERVER[HTTP_HOST]</p>
</div>";
// Send and check the message status

$response = (mail($emailComp, $subject, $contactMessage, $headers) ) ? "success" : "failure" ;
$output = json_encode(array("response" => $response));

$headers = "Content-type: text/html; charset=iso-utf-8 \r\n";
$headers .= "To: <$emailAddr> \r\n";
$headers .= "From: MZ Partner <$emailComp> \r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$odpoved="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<title>MZ Partner Trading</title>
</head>
<body bgcolor=\"#FFFFFF\">
<table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border: 1px solid #282828;\" align=\"left\">
	<tr>
		<td width=\"800\" height=\"115\"><img src=\"http://mz-pt.ch/images/top-logo.png\" width=\"800\" height=\"115\" alt=\"\"></td>
	</tr>
	<tr>
		<td width=\"800\" height=\"50\" background=\"http://mz-pt.ch/images/top-text.png\" align=\"center\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; font-style:normal; font-weight:bold; color:#FFFFFF;\">
			<p>mm@mz-pt.ch | +41 76 652 12 70</p>
		</td>
	</tr>
	<tr>
		<td width=\"800\" height=\"133\"><img src=\"http://mz-pt.ch/images/top-images.png\" width=\"800\" height=\"133\" alt=\"\"></td>
	</tr>
	<tr>
		<td style=\"padding:20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-style:normal; font-weight: normal;\">
			<p>Bonjour à vous ! <br />
                                <br />
Nous avons pris note de votre visite et nous vous remercions.<br />
Nos conseillers de construction seront heureux de vous contacter très rapidement.<br />
<br />
Dans l’attente  de vous rencontrer veuillez  recevoir nos sincères salutations.<br />
<br />
<strong>Team MZ Partner trading</strong>
</p>
		</td>
	</tr>
	<tr>
		<td width=\"800\" height=\"62\"><img src=\"http://mz-pt.ch/images/bottom-home.png\" width=\"800\" height=\"62\" alt=\"\"></td>
	</tr>
	<tr>
		<td width=\"800\" height=\"50\" bgcolor=\"#282828\" align=\"center\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; font-style:normal; font-weight:bold; color:#FFFFFF;\">
			<p>MZ Partner Trading  |  Rte de Corcelles 5  |  Payerne 1530  |  +41 76 652 12 70</p>
		</td>
	</tr>
</table>
</body>
</html>


";
mail($emailAddr,'Bonjour à vous !',$odpoved,$headers);
header('content-type: application/json; charset=utf-8');
echo($output);
?>