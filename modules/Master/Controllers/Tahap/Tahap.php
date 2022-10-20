<?php 
namespace Modules\Master\Controllers\Tahap;

/**
 * Master > Unit_organisasi > Unit_organisasi
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Tahap extends \Aksara\Laboratory\Core
{
	private $_table									= 'TAHAP';

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
		$this->set_title('Tahap')		
		->set_icon('mdi mdi-rhombus-split')		
		->unset_action('delete')		
		->set_alias
		(
			array
			(
				'KDTAHAP'							=> 'Kode',
				'URAIAN'							=> 'Tahap'
			)
		)		
		/*->set_field
		(
			array
			(
				'KDTAHAP'							=> 'price_format',
			)
		)*/		
		->order_by
		(
			array
			(
				'CAST(KDTAHAP AS int)'				=> 'DESC'
			)
		)
		//->debug('params')		
		->render($this->_table);
	}
}
