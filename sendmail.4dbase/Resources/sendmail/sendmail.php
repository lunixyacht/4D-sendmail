<?php
require 'vendor/autoload.php';

function SM_send($datas) {

	$A_Datas = \json_decode($datas, true); // Tableau Associatif

	// Create the Transport
	$transport = Swift_SmtpTransport::newInstance ($A_Datas['Host'], $A_Datas['Port']);
	if(isset($A_Datas['Username']))
  		$transport->setUsername($A_Datas['Username']); 
  	if(isset($A_Datas['Password']))
  		$transport->setPassword($A_Datas['Password']);

  	// Create the Mailer using your created Transport
	$mailer = Swift_Mailer::newInstance($transport);

  	// Create a message
	$message = Swift_Message::newInstance($A_Datas['Subject']);

	// ---- From ---- //
	$email = null;
	$email = getEmail($A_Datas['From']);
	$name  = getName($A_Datas['From']);
	if (is_null($name)) {
		$message->setFrom(array( $email ));
	} else {
		$message->setFrom(array( $email => $name));
	}
	
	//---- TO ---- //
	$email = null;
	$email = getEmail($A_Datas['To']);
	$name  = getName($A_Datas['To']);
	if (\is_null($name)) {
		$message->setTo(array( $email ));
	} else {
		$message->setTo(array( $email => $name));
	}
	
	// ---- Sender ---- //
	$email = null;
	$email = getEmail($A_Datas['Sender']);
	if (!is_null($email)) {
		$message->setSender($email);
	}

	
	$message->setBody($A_Datas['Body']); 


	// ---- Placer ici les certificats ----//
	/**
	$smimeSigner = Swift_Signers_SMimeSigner::newInstance();
	$smimeSigner->setSignCertificate('/path/to/certificate.pem', array('/path/to/private-key.pem', 'passphrase'));
	$message->attachSigner($smimeSigner);
	**/
	
	// Send the message
	if (! $mailer->send ( $message, $failures )) {
		$response ['errors'] = $failures;
	} else {
		$response ['message']= $message->toString ();
    }

    return ( \json_encode ( $response ));

}


function getEmail($string) {

	$pattern = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
	
	$aFind = array();

	if(preg_match($pattern, $string, $aFind )){
		$email = $aFind[0];
    }

	return $email;
	
	$pattern = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
	if(preg_match($pattern, $value, $aFind )){
        $email = $aFind[0];
    }
    return $email; 
}

function getName($string) { // On cherche les nom

	$patterntag = '/<(.*)>/is';
	$name = ''; 

	if ($string != '') {
		$name = preg_replace($patterntag,"", $string );
    }

    if (getEmail($string) ===  $name) {
    	return null;
    } else {
    	return $name;
    }
}
