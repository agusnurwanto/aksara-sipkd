<?php 
namespace Modules\Master\Controllers\Rekening\Pendapatan;
//use Config\Validation;

/**
 * Master > Rekening > Pendapatan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Akun extends \Aksara\Laboratory\Core
{
	private $_table									= 'MATANGD';

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');		

		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{		
		$this->set_title('Aakun - Rekening Pendapatan')		
		->set_icon('mdi mdi-rhombus-split')
		->unset_column('MTGKEY, MTGLEVEL, KDKHUSUS')
		->unset_view('MTGKEY, MTGLEVEL, KDKHUSUS')
		->unset_action('create, update, delete')
		->set_field('NMPER', 'hyperlink', 'master/rekening/pendapatan/kelompok', array('KDPER' => 'KDPER'))
		->set_alias
		(
			array
			(
				'KDPER'							=> 'Kode',
				'NMPER'							=> 'Uraian'
			)
		)
		->where
		(
			array
			(
				'MTGLEVEL'						=> 1
			)
		)
		->order_by
		(
			array
			(
				'KDPER'							=> 'ASC'
			)
		)
		//->debug('params')	
		->render($this->_table);
	}
}
