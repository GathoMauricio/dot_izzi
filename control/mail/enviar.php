<?php
    require_once 'lib/swift_required.php';
     

  //create the transport
    /*$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587)
      ->setUsername('softrain.evaluaciones@gmail.com')
      ->setPassword('softrain1234')
    ;*/


    $transport = Swift_SmtpTransport::newInstance('mail.dotredes.com', 587)
      ->setUsername('contacto@dotredes.com')
      ->setPassword('contacto')
    ;

    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance('Wonderful Subject')
      ->setFrom(array('contacto@dotredes.com' => 'Evaluaciones'))
      ->setTo(array('mauricio2769@gmail.com'=> 'A name'))
      ->setBody('Test Message Body')
    ;


    $result = $mailer->send($message);
    echo $result;


?>