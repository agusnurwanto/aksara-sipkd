<?php

namespace Aksara\Modules\Pages\Controllers;

/**
 * Pages > Contact
 *
 * @author			Aby Dahana <abydahana@gmail.com>
 * @profile			abydahana.github.io
 * @website			www.aksaracms.com
 * @since			version 4.0.0
 * @copyright		(c) 2021 - Aksara Laboratory
 */

class Contact extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		if($this->valid_token(service('request')->getPost('_token')))
		{
			return $this->_send_message();
		}
		
		$this->set_title(phrase('contact_us'))
		->set_icon('mdi mdi-phone-classic')
		->set_description(phrase('submit_your_inquiry_or_question_to_us'))
		
		->render();
	}
	
	public function _send_message()
	{
		$this->form_validation->setRule('full_name', phrase('full_name'), 'required');
		$this->form_validation->setRule('email', phrase('email'), 'required|valid_email');
		$this->form_validation->setRule('subject', phrase('subject'), 'required');
		$this->form_validation->setRule('messages', phrase('messages'), 'required');
		$this->form_validation->setRule('copy', phrase('send_copy'), 'boolean');
		
		if($this->form_validation->run(service('request')->getPost()) === false)
		{
			return throw_exception(400, $this->form_validation->getErrors());
		}
		
		$this->model->insert
		(
			'inquiries',
			array
			(
				'sender_email'						=> service('request')->getPost('email'),
				'sender_full_name'					=> service('request')->getPost('full_name'),
				'subject'							=> service('request')->getPost('subject'),
				'messages'							=> service('request')->getPost('messages'),
				'timestamp'							=> date('Y-m-d H:i:s')
			)
		);
		
		if(service('request')->getPost('copy'))
		{
			/**
			 * to working with Google SMTP, make sure to activate less secure apps setting
			 */
			$this->email							= \Config\Services::email();
			
			$host									= get_setting('smtp_host');
			$username								= get_setting('smtp_username');
			$password								= (get_setting('smtp_password') ? service('encrypter')->decrypt(base64_decode(get_setting('smtp_password'))) : '');
			$sender_email							= (get_setting('smtp_email_masking') ? get_setting('smtp_email_masking') : (service('request')->getServer('SERVER_ADMIN') ? service('request')->getServer('SERVER_ADMIN') : 'webmaster@' . service('request')->getServer('SERVER_NAME')));
			$sender_name							= (get_setting('smtp_sender_masking') ? get_setting('smtp_sender_masking') : get_setting('app_name'));
			
			$this->email							= \Config\Services::email();
			
			if($host && $username && $password)
			{
				$config['userAgent']       			= 'Aksara';
				$config['protocol']					= 'smtp';
				$config['SMTPCrypto']				= 'ssl';
				$config['SMTPTimeout']				= 5;
				$config['SMTPHost']					= (strpos($host, '://') !== false ? trim(substr($host, strpos($host, '://') + 3)) : $host);
				$config['SMTPPort']					= get_setting('smtp_port');
				$config['SMTPUser']					= $username;
				$config['SMTPPass']					= $password;
			}
			else
			{
				$config['protocol']					= 'mail';
			}
			
			$config['charset']						= 'utf-8';
			$config['newline']						= "\r\n";
			$config['mailType']						= 'html'; // text or html
			$config['wordWrap']						= true;
			$config['validation']					= true; // bool whether to validate email or not
			
			$this->email->initialize($config);	
			
			$this->email->setFrom($sender_email, $sender_name);
			$this->email->setTo(service('request')->getPost('email'));
			
			$this->email->setSubject(service('request')->getPost('subject'));
			$this->email->setMessage(service('request')->getPost('messages'));
			
			if(!$this->email->send())
			{
				//return throw_exception(400, array('message' => $this->email->printDebugger('header')));
			}
		}
		
		return throw_exception(301, phrase('your_inquiry_has_been_sent'), current_page());
	}
}
