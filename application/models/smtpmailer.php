<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/packages/mailer/class.phpmailer.php');

class smtpmailer {

    private $__config;
	private $__router;
    public $__params;
    private $__db;
    
    private $proformamodel;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
        $this->__db = registry::register("db");
    }

    function wyslij_maila_smtp($do, $temat, $wiadomosc, $plik = NULL){

        $tresc = '';
        
        $mail = new PHPMailer(true);
        
        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP(); 
        $mail->isHTML(true); 
        $mail->SMTPAuth   = true; 
        $mail->SMTPSecure = "ssl";                 
        $mail->Port       = '465';                    
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->Username   = 'marcelrosa1999@gmail.com';     
        $mail->Password   = '!Tacrac!66!';
        
        if(!empty($plik))
        $mail -> AddAttachment($plik); 	

        $mail->IsSendmail();  
        
        $mail->From       = 'info@khbemiddeling.nl';
        $mail->FromName   = 'KH Bemiddeling';
        $mail->AddAddress('kw-53@wp.pl', 'someName');
        $mail->Subject  = $temat;

        $mail->WordWrap   = 80; 

        $tresc .= $wiadomosc;

        $mail->MsgHTML($tresc);
        $mail->IsHTML(true); 
        
        if(!$mail->Send()) 
        {
            print_r('aaa');
            return 0;
        } else 
        {
            print_r('bbb');
            return 1;
        }
        
}

}
?>