<?php
/**
* SendMailSmtpClass
* @author Ipatov Evgeniy <admin@vk-book.ru>
* @author PK <pavel@karasev.ru>
* инструкция	https://qna.habr.com/q/1016160
* инструкция	https://yandex.ru/support/business/domains/dns-editor.html
*/

class smtp {

    /**
    *
    * @var string $smtp_username    -   логин
    * @var string $smtp_password    -   пароль
    * @var string $smtp_host        -   хост
    * @var string $smtp_from        -   от кого
    * @var integer $smtp_port       -   порт
    * @var string $smtp_charset     -   кодировка
    *
    */
    public $smtp_username;
    public $smtp_password;
    public $smtp_host;
    public $smtp_port;
    public $smtp_charset;
    
    public $smtp_from;
    public $boundary;
    public $addFile;
    public $multipart;



    public function __construct($smtp_username = null, $smtp_password = null, $smtp_host = null, $smtp_port = null, $smtp_charset = null)
    {
        $this->smtp_username    =   $smtp_username  ??  SMTP_USER;
        $this->smtp_password    =   $smtp_password  ??  SMTP_PASS;
        $this->smtp_host        =   $smtp_host      ??  SMTP_HOST;
        $this->smtp_port        =   $smtp_port      ??  SMTP_PORT;
        $this->smtp_charset     =   $smtp_charset   ??  'utf-8';
        
       

		// разделитель файлов
        $this->addFile          =   false;
        $this->boundary         =   '--'. md5(uniqid(time()));
        $this->multipart        =   '';
    }

    /**
    * Отправка письма
    *
    * @param string $mailTo - получатель письма
    * @param string $subject - тема письма
    * @param string $message - тело письма
    * @param string $smtp_from - отправитель
    *
    * @return bool|string В случаи отправки вернет true, иначе текст ошибки
	*
    */
    function send($mailTo, $subject, $message, $smtp_from = null)
    {
        $smtp_from          =   $smtp_from  ??  SMTP_FROM;
        $message            =   $this->messageTrim($message);
        
		// подготовка содержимого письма к отправке
        $contentMail        =   $this->getContentMail($subject, $message, $smtp_from, $mailTo);
        $errorNumber        =   '';
        $errorDescription   =   '';
		
        
        try
        {
            if(!$socket = fsockopen($this->smtp_host, $this->smtp_port, $errorNumber, $errorDescription, 30)){
                throw new Exception($errorNumber.".".$errorDescription);
            }
            if (!$this->_parseServer($socket, "220")){
                throw new Exception('Connection error');
            }
            

			$server_name = $_SERVER["SERVER_NAME"];
            fputs($socket, "EHLO $server_name\r\n");
			if(!$this->_parseServer($socket, "250")){
				// если сервер не ответил на EHLO, то отправляем HELO
				fputs($socket, "HELO $server_name\r\n");
				if (!$this->_parseServer($socket, "250")) {
					fclose($socket);
					throw new Exception('Error of command sending: HELO');
				}
			}

            fputs($socket, "AUTH LOGIN\r\n");
            if (!$this->_parseServer($socket, "334")) {
                fclose($socket);
                throw new Exception('Autorization error 1');
            }

            fputs($socket, base64_encode($this->smtp_username) . "\r\n");
            if (!$this->_parseServer($socket, "334")) {
                fclose($socket);
                throw new Exception('Autorization error 2');
            }

            fputs($socket, base64_encode($this->smtp_password) . "\r\n");
            if (!$this->_parseServer($socket, "235")) {
                fclose($socket);
                throw new Exception('Autorization error 3');
            }

            fputs($socket, "MAIL FROM: <".$this->smtp_username.">\r\n");
            if (!$this->_parseServer($socket, "250")) {
                fclose($socket);
                throw new Exception('Error of command sending: MAIL FROM');
            }

			$mailTo = str_replace(" ", "", $mailTo);
			$emails_to_array = explode(',', $mailTo);


			foreach($emails_to_array as $email) {
				fputs($socket, "RCPT TO: <{$email}>\r\n");
				if (!$this->_parseServer($socket, "250")) {
					fclose($socket);
					throw new Exception('Error of command sending: RCPT TO');
				}
			}


            fputs($socket, "DATA\r\n");
            if (!$this->_parseServer($socket, "354")) {
                fclose($socket);
                throw new Exception('Error of command sending: DATA');
            }

            fputs($socket, $contentMail."\r\n.\r\n");
            if (!$this->_parseServer($socket, "250")) {
                fclose($socket);
                throw new Exception("E-mail didn't sent");
            }

            fputs($socket, "QUIT\r\n");
            fclose($socket);
        } catch (Exception $e) {
            return  $e->getMessage();
        }
        return true;
    }
    
    
    
	// добавление файла в письмо
	function addFile($path)
    {
		$file = @fopen($path, "rb");
		if(!$file) {
			throw new Exception("File `{$path}` didn't open");
		}
		$data = fread($file,  filesize( $path ) );
		fclose($file);
		$filename = basename($path);
        $multipart = '';
		$multipart .=  "\r\n--{$this->boundary}\r\n";
		$multipart .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";
		$multipart .= "Content-Transfer-Encoding: base64\r\n";
		$multipart .= "Content-Disposition: attachment; filename=\"$filename\"\r\n";
		$multipart .= "\r\n";
		$multipart .= chunk_split(base64_encode($data));

		$this->multipart .= $multipart;
		$this->addFile = true;
	}
    
	
	# удалить лишние пробелы из письма
	#
	private function messageTrim($str)
	{
	    $str    =   preg_replace('#\n|^\s+#', '', $str);
	    
	    return $str;
	}
	
	
	// парсинг ответа сервера
    private function _parseServer($socket, $response)
    {
        $responseServer = '';
        while (@substr($responseServer, 3, 1) != ' ') {
            if (!($responseServer = fgets($socket, 256))) {
                return false;
            }
        }
        if (!(substr($responseServer, 0, 3) == $response)) {
            return false;
        }
        return true;
    }

	// подготовка содержимого письма
	private function getContentMail($subject, $message, $smtp_from, $mailTo)
    {
		$contentMail  =  "Date: " . date("D, d M Y H:i:s") . " UT\r\n";
        $contentMail .=  'Subject: ' . $subject. "\r\n";


		// заголовок письма
		$headers  =  "MIME-Version: 1.0\r\n";

		// кодировка письма
		if($this->addFile){
			// если есть файлы
			$headers  .=  "Content-Type: multipart/mixed; boundary=\"{$this->boundary}\"\r\n";
		}
        else {
			$headers  .=  "Content-type: text/html; charset={$this->smtp_charset}\r\n";
		}

		$headers    .= "From: $smtp_from\r\n"; // от кого письмо
        $headers    .= "To: ".$mailTo."\r\n";
        $contentMail .= $headers . "\r\n";


		if($this->addFile) {
			// если есть файлы
			$multipart  = "--{$this->boundary}\r\n";
			$multipart .= "Content-Type: text/html; charset=utf-8\r\n";
			$multipart .= "Content-Transfer-Encoding: base64\r\n";
			$multipart .= "\r\n";
			$multipart .= chunk_split(base64_encode($message));

			// файлы
			$multipart .= $this->multipart;
			$multipart .= "\r\n--{$this->boundary}--\r\n";

			$contentMail .= $multipart;
		}
        else {
			$contentMail .= $message ."\r\n";
		}


		return $contentMail;
	}

}
