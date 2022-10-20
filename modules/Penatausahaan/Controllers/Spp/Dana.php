<?php 
namespace Modules\Penatausahaan\Controllers\Spp;
/**
 * Penatausahaan > TBP > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Dana extends \Aksara\Laboratory\Core
{
	private $_table									= 'SPPDETRDANA';

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');

        $this->_sub_unit							= service('request')->getGet('sub_unit');
        $this->_spp									= service('request')->getGet('spp');

        if(!$this->_sub_unit)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
        }
        if(!$this->_spp)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('spp'));
        }

		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{
		$header										= $this->_header();
		$this->set_title('Surat Permintaan Pembayaran Rinci')
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
					SPP
				</div>
				<div class="col-8 col-sm-10 font-weight text-sm">
					' . $header->NOSPP . '
				</div>
			</div>
		')
		->set_icon('mdi mdi-rhombus-split')
		->set_breadcrumb
		(
			array
			(
				'penatausahaan/spp/sub_unit'		=> 'Sub Unit',
				'../'								=> 'SPP'
			)
		)
		/*->unset_column('UNITKEY, NOSPP, NOJETRA')
		->unset_field('UNITKEY, NOSPP, NOJETRA')
		->unset_view('UNITKEY, NOSPP, NOJETRA')
		->set_field
		(
			array
			(
				'NILAI'								=> 'price_format',
			)
		)
		->set_relation
		(
			'MTGKEY',
			'MATANGR.MTGKEY',
			'{MATANGR.KDPER} {MATANGR.NMPER}',
			array
			(
				'MATANGR.MTGLEVEL'					=> 6
			),
			NULL,
			array
			(
				'MATANGR.KDPER'						=> 'ASC'
			),
			NULL,
			50
		)
		->set_relation
		(
			'KDKEGUNIT',
			'MKEGIATAN.KDKEGUNIT',
			'{MKEGIATAN.NUKEG}. {MKEGIATAN.NMKEGUNIT}',
			array
			(
				'MKEGIATAN.LEVELKEG'				=> 2,
				'MPGRM.UNITKEY'						=> $this->_sub_unit,
			),
			array
			(
				array
				(
					'MPGRM',
					'MPGRM.IDPRGRM = MKEGIATAN.IDPRGRM'
				), 				
			),
			array
			(
				'MKEGIATAN.NUKEG'					=> 'ASC'
			),
			NULL,
			50
		)
		->field_prepend
		(
			array
			(
				'NILAI'    							=> 'Rp',
			)
		)
		->field_position
		(
			array
			(
				'NILAI'								=> 2,
			)
		)
		->set_default
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit,
				'NOSPP'								=> $this->_spp,
				'NOJETRA'							=> 21,
			)
		)
		->where
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit,
				'NOSPP'								=> $this->_spp,
				'NOJETRA'							=> 21,
			)
		)*/
		/*
		->column_order('NUKEG, NMKEGUNIT, NMJETRA, NILAI')
		->field_order('KDKEGUNIT, NOJETRA, NILAI, MTGKEY')
		->view_order('KDKEGUNIT, NOJETRA, NILAI, MTGKEY')
		->set_relation
		(
			'NOJETRA',
			'JTRNLKAS.NOJETRA',
			'{JTRNLKAS.NMJETRA}',
			//where (null)
			NULL,
			NULL,
			// order
			'JTRNLKAS.NMJETRA'
		)
		/*
		->set_validation
		(
			array
			(
				'NOBPK'								=> 'required',
				'KDSTATUS'							=> 'required',
				'STPANJAR'							=> 'required',
				'STTUNAI'							=> 'required',
				'STBANK'							=> 'required',
				'IDXKODE'							=> 'required',
				'KEYBEND'							=> 'required',
				'TGLBPK'							=> 'required',
				'PENERIMA'							=> 'required',
				'URAIBPK'							=> 'required',
				'TGLVALID'							=> 'required',
				'NOBA'								=> 'required',
				'KDBANK'							=> 'required',
				'NOREK'								=> 'required',
			)
		)
		->order_by
		(
			array
			(
				'TGLBPK'							=> 'DESC'
			)
		)*/
		->render($this->_table);
	}
	
	private function _header()
	{
		$query                                      = $this->model
		->select('DAFTUNIT.NMUNIT, SPP.NOSPP')
		->join('DAFTUNIT', 'DAFTUNIT.UNITKEY = SPP.UNITKEY', 'INNER')
		->get_where('SPP', array('SPP.NOSPP' => $this->_spp), 1)
		->row();
		
		return $query;
	}
}
