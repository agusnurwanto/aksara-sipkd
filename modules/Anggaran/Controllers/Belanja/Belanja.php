<?php 
namespace Modules\Anggaran\Controllers\Belanja;
/**
 * Anggaran > Belanja > Belanja
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Belanja extends \Aksara\Laboratory\Core
{
	//private $_table									= 'RASKD';
	private $_table									= 'RASKDETD';	

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');

        $this->_sub_unit							= service('request')->getGet('sub_unit');

        if(!$this->_sub_unit)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
        }

		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{
		$header										= $this->_header();
		$tahap 										= $this->_tahap();
		$this->set_title('Anggaran Pendapatan')
		->set_description
		('			
			<div class="row">
				<div class="col-4 col-sm-2 text-muted text-sm">
					SUB UNIT
				</div>
				<div class="col-8 col-sm-10 font-weight text-sm">
					' . $header->NMUNIT . '
				</div>
				<div class="col-4 col-sm-2 text-muted text-sm">
					TAHAPAN
				</div>
				<div class="col-8 col-sm-10 font-weight text-sm">
					' . $tahap->URAIAN . '
				</div>
			</div>
		')
		->set_icon('mdi mdi-rhombus-split')
		->unset_action('create, update, delete')
		->unset_column('MTGKEY, UNITKEY, KDTAHAP, KDNILAI, INCLSUBTOTAL, IDSTDHARGA, JUMBYEK, SATUAN')
		->unset_field('MTGKEY, UNITKEY, KDTAHAP, KDNILAI, INCLSUBTOTAL, IDSTDHARGA')
		->unset_view('MTGKEY, UNITKEY, KDTAHAP, KDNILAI, INCLSUBTOTAL, IDSTDHARGA')
		->column_order('MTGKEY, KDJABAR, URAIAN, EKSPRESI, TARIF, SUBTOTAL')
		->set_field
		(
			array
			(
				'TARIF'								=> 'price_format',
				'SUBTOTAL'							=> 'price_format'
			)
		)
		->set_default
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit
			)
		)
		->where
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit,
				'KDTAHAP'							=> $tahap->KDTAHAP,
			)
		)	

		->set_alias
		(
			array
			(
				'KDJABAR'							=> 'Kode',
				'URAIAN'							=> 'Tahap',
				'EKSPRESI'							=> 'Koefisien',
				'TARIF'								=> 'Tarif',
				'SUBTOTAL'							=> 'Subtotal',
			)
		)	

		->order_by
		(
			array
			(
				'RASKDETD.UNITKEY'						=> 'ASC',
				'RASKDETD.KDTAHAP'						=> 'DESC'
			)
		)
		->render($this->_table);
	}
	
	private function _header()
	{
		$query                                      = $this->model
		->select('DAFTUNIT.NMUNIT')
		->get_where('DAFTUNIT', array('DAFTUNIT.UNITKEY' => $this->_sub_unit), 1)
		->row();
		
		return $query;
	}

	private function _tahap()
	{
		$query                                      = $this->model
		->select('TAHAP.KDTAHAP, TAHAP.URAIAN')		
		->order_by
		(
			array
			(
				'CAST(KDTAHAP AS int)'				=> 'DESC'
			)
		)
		->get_where('TAHAP', array(), 1)
		->row();
		
		return $query;
	}
}
