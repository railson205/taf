<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_service
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->load->library('email');

        $config = [
            'protocol'    => 'smtp',
            'smtp_host'   => 'smtp.gmail.com',
            'smtp_port'   => 587,
            'smtp_user'   => 'testetaf73@gmail.com',
            'smtp_pass'   => 'kdrc txys aesg ijsm',
            'smtp_crypto' => 'tls',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
        ];

        $this->CI->email->initialize($config);
        $this->CI->email->from('testetaf73@gmail.com', 'Sistema CBMCE');
    }

    public function enviar($para, $assunto, $mensagem)
    {
        $this->CI->email->to($para);
        $this->CI->email->subject($assunto);
        $this->CI->email->message($mensagem);

        return $this->CI->email->send();
    }
}
