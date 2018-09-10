<?php

    // yhteydet
    $email_to = "info@kotisinulleoy.fi";
    $email_subject = "Yhteydenotto Koti Sinulle Oy www sivuilta";

    function died($error) {
        // virheilmoitukset
        echo "Pahoittelut, jotain meni pieleen!";
        echo "Virheet listattu alla.<br /><br />";
        echo $error."<br /><br />";
        echo "Olkaa hyvä ja yrittäkää uudelleen.<br /><br />";
        die();
    }


    // perus validointi
    if(!isset($_POST['nimi']) ||
        !isset($_POST['sahkoposti']) ||
        !isset($_POST['puhelin']) ||
        !isset($_POST['viesti'])) {
        died('Unohdit täyttää jonkin kentän.');
    }



    $name = $_POST['nimi']; // pakollinen
    $email_from = $_POST['sahkoposti']; // pakollinen
    $telephone = $_POST['puhelin']; // pakollinen
    $message = $_POST['viesti']; // pakollinen

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'ET syöttänyt kelvollista sähköposti osoitetta.<br />';
  }

    $string_exp = "/^[A-Za-z .'-]+$/";

  if(!preg_match($string_exp,$name)) {
    $error_message .= 'Et syöttänyt kelvollista nimeä.<br />';
  }

  if(strlen($message) < 2) {
    $error_message .= 'Viestin pituus ei ole riittävä.<br />';
  }

  if(strlen($error_message) > 0) {
    died($error_message);
  }

    $email_message = "Lomakkeen tiedot.\n\n";


    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }



    $email_message .= "Nimi: ".clean_string($name)."\n";
    $email_message .= "Sähköposti: ".clean_string($email_from)."\n";
    $email_message .= "Puhelin: ".clean_string($telephone)."\n";
    $email_message .= "Viesti: ".clean_string($message)."\n";

// Lähetettävä meili
$headers = 'Lähettäjä: '.$email_from."\r\n".
'Vastaus: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($email_to, $email_subject, $email_message, $headers);
header('Location: otayhteytta.html');
exit();

?>
