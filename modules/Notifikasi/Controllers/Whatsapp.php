<?php namespace Modules\Notifikasi\Controllers;
/**
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Whatsapp extends \Aksara\Laboratory\Core
{
	private $_table									= 'notifikasi__whatsapp';
	
	public function __construct()
	{
		parent::__construct();
		
		//$this->set_permission();
		$this->set_theme('backend');
		
		$this->unset_action('create, update, delete');
	}
	
	public function index()
	{
		$this->set_title('Whatsapp')
		->set_icon('mdi mdi-whatsapp')
		
		->unset_column('id')
		->unset_field('id, status')
		->unset_view('id')
		
		->add_action('toolbar', 'send', 'Kirim Ulang', 'btn-info --xhr', 'mdi mdi-send', array(''), false)
		
		->set_field
		(
			array
			(
				//'message'							=> 'textarea',
				//'timestamp'						=> 'datepicker'
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
		
		->order_by
		(
			array
			(
				'timestamp'								=> 'DESC'
			)
		)
		
		->set_validation
		(
			array
			(
				'message'							=> 'required',
				'phone'								=> 'required',
				'timestamp'							=> 'required|valid_date',
				'status'							=> 'boolean'
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
		$query										= $this->model->get_where
		(
			$this->_table,
			array
			(
				'status'							=> 0,
				'phone !='							=> ''
			)
		)
		->result();
		
		if(!$query)
		{
			return throw_exception(301, 'Tidak ada antrian pengiriman WhatsApp', current_page('../'));
		}
		
		$failed										= 0;
		
		foreach($query as $key => $val)
		{
			$params									= array
			(
				'key'								=> '86128faab6086aa4dd73c4416894aa5ed4df104bc909488c',
				'phone_no'							=> '+62' . ltrim($val->phone, '0'),
				'message'							=> $val->message,
				'url'								=> ''
			);
			
			try
			{
				$ch									= curl_init('http://116.203.191.58/api/send_message');
				
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_VERBOSE, 0);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
				
				$response							= curl_exec($ch);
				
				curl_close($ch);
				
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
		
		return throw_exception(301, 'Sebanyak <b>' . number_format(sizeof($query) - $failed) . '</b> dari <b>' . number_format(sizeof($query)) . '</b> WhatsApp berhasil dikirim ulang.', current_page('../'));
	}
}
