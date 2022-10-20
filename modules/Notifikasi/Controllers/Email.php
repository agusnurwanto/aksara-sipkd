<?php namespace Modules\Notifikasi\Controllers;
/**
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email extends \Aksara\Laboratory\Core
{
	private $_table									= 'notifikasi__email';
	
	public function __construct()
	{
		parent::__construct();
		
		//$this->set_permission();
		$this->set_theme('backend');
		
		$this->unset_action('create, update, delete');
	}
	
	public function index()
	{
		$this->set_title('Email')
		->set_icon('mdi mdi-email')
		
		->unset_column('id')
		->unset_field('id, status')
		->unset_view('id')
		
		->add_action('toolbar', 'send', 'Kirim Ulang', 'btn-info --xhr', 'mdi mdi-send', array(''), false)
		
		->set_field
		(
			array
			(
				//'message'							=> 'textarea',
				'timestamp'								=> 'datepicker'
			)
		)
		->field_position
		(
			array
			(
				'message'							=> 2
			)
		)
		->set_field
		(
			'status',
			'radio',
			array
			(
				'0'									=> '<span class="badge badge-warning">Pending</span>',
				'1'									=> '<span class="badge badge-success">Terkirim</span>'
			)
		)
		
		->set_validation
		(
			array
			(
				'message'							=> 'required',
				'email'								=> 'required|valid_email',
				'timestamp'								=> 'required|valid_date',
				'status'							=> 'boolean'
			)
		)
		
		->order_by
		(
			array
			(
				'timestamp'								=> 'DESC'
			)
		)
		
		->render($this->_table);
	}
	
	public function send()
	{
		$this->_send();
	}
	
	private function _send()
	{
		$failed										= 0;
		
		$query										= $this->model->get_where
		(
			$this->_table,
			array
			(
				'status'							=> 0
			)
		)
		->result();
		
		if(!$query)
		{
			return throw_exception(200, 'Tidak ada antrian pengiriman email', current_page('../'));
		}
		
		/**
		 * to working with Google SMTP, make sure to activate less secure apps setting
		 */
		$host										= get_setting('smtp_host');
		$port										= get_setting('smtp_port');
		$username									= get_setting('smtp_username');
		$password									= (get_setting('smtp_password') ? service('encrypter')->decrypt(base64_decode(get_setting('smtp_password'))) : '');
		$sender_email								= (get_setting('smtp_email_masking') ? get_setting('smtp_email_masking') : service('request')->getServer('SERVER_ADMIN'));
		$sender_name								= (get_setting('smtp_sender_masking') ? get_setting('smtp_sender_masking') : get_setting('app_name'));
		
		foreach($query as $key => $val)
		{
			$mail									= new PHPMailer();
			
			try
			{
				$mail->IsSMTP();
				
				$mail->Timeout						= 5;
				$mail->Mailer						= 'smtp';
				$mail->SMTPAuth						= true;
				$mail->SMTPSecure					= 'ssl';
				$mail->Port							= $port;
				$mail->Host							= $host;
				$mail->Username						= $username;
				$mail->Password						= $password;
				
				$mail->IsHTML(true);
				$mail->AddAddress($val->email);
				$mail->SetFrom($username, $sender_name);
				
				$mail->Subject						= 'GeekTech Email Notifier';
				$mail->Body							= nl2br($val->message);
				
				$mail->send();
				
				/**
				 * Update sent status
				 */
				$this->model->update
				(
					$this->_table,
					array
					(
						'status'					=> 1
					),
					array
					(
						'id'						=> $val->id
					)
				);
			}
			catch(\Throwable $e)
			{
				$failed++;
			}
		}
		
		return throw_exception(301, 'Sebanyak <b>' . number_format(sizeof($query) - $failed) . '</b> dari <b>' . number_format(sizeof($query)) . '</b> email berhasil dikirim ulang.', current_page('../'));
	}
}
