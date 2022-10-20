<?php 
namespace Modules\Penatausahaan\Controllers\Tbp;
/**
 * Penatausahaan > TBP > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
	private $_table									= 'BPKDETR';

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');

        $this->_sub_unit							= service('request')->getGet('sub_unit');
        $this->_tbp									= service('request')->getGet('tbp');

        if(!$this->_sub_unit)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
        }
        if(!$this->_tbp)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('tbp'));
        }

		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{
		//$header										= $this->_header();
		$this->set_title('Tanda Bukti Pengeluaran Rinci')
		/*->set_description
		('
			<div class="row">
				<div class="col-4 col-sm-2 text-muted text-sm">
					SUB UNIT
				</div>
				<div class="col-8 col-sm-10 font-weight text-sm">
					' . $header->NMUNIT . '
				</div>
			</div>
		')*/
		->set_icon('mdi mdi-rhombus-split')
		->unset_column('MTGKEY, UNITKEY, NOBPK, NOJETRA')
		->unset_field('UNITKEY, NOBPK, NOJETRA')
		->unset_view('MTGKEY, UNITKEY, NOBPK')
		->column_order('NUKEG, KDPER, NILAI')
		->field_order('KDKEGUNIT, MTGKEY, NILAI')
		->view_order('KDKEGUNIT, MTGKEY, NOJETRA, NILAI')
		->set_field
		(
			array
			(
				'NILAI'								=> 'price_format',
			)
		)
		->set_alias
		(
			array
			(
				'KDKEGUNIT'							=> 'Sub Kegiatan',
				'MTGKEY'							=> 'Rekening',
			)
		)
		->merge_content('{NUKEG}.{NMKEGUNIT}', 'Sub Kegiatan')
		->merge_content('{KDPER}.{NMPER}', 'Rekening')
		/*->set_relation
		(
			'NOJETRA',
			'JTRNLKAS.NOJETRA',
			'{JTRNLKAS.NMJETRA}',
			//where (null)
			NULL,
			NULL,
			// order
			'JTRNLKAS.NMJETRA'
		)*/
		->set_relation
		(
			'MTGKEY',
			'MATANGR.MTGKEY',
			'{MATANGR.KDPER} {MATANGR.NMPER}',
			NULL,
			NULL,
			array
			(
				'MATANGR.KDPER'					=> 'ASC'
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
				'MKEGIATAN.LEVELKEG'			=> 2,
				'MPGRM.UNITKEY'					=> $this->_sub_unit
			),
			array
			(
				array
				(
					'MPGRM',
					'MPGRM.IDPRGRM = MKEGIATAN.IDPRGRM'
				)
			),
			// order
			array
			(
				'MKEGIATAN.NUKEG'				=> 'ASC'
			),
			NULL,
			50
		)
		->set_default
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit,
				'NOBPK'								=> $this->_tbp,
				'NOJETRA'							=> 21,
			)
		)
		->where
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit,
				'NOBPK'								=> $this->_tbp,
			)
		)
		->field_prepend
		(
			array
			(
				'NILAI'    							=> 'Rp',
			)
		)
		/*
		->field_position
		(
			array
			(
				'IDXKODE'							=> 2,
				'KEYBEND'							=> 2,
				'TGLBPK'							=> 3,
				'PENERIMA'							=> 3,
				'URAIBPK'							=> 3,
				'TGLVALID'							=> 3,
				'NOBA'								=> 4,
				'KDBANK'							=> 4,
				'NOREK'								=> 4,
			)
		)
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
		/*$query                                      = $this->model->query
		('
			SELECT
				DAFTUNIT.NMUNIT, 
				BPK.NOBPK
			FROM
				BPK
			INNER JOIN DAFTUNIT ON DAFTUNIT.UNITKEY = BPK.UNITKEY
			WHERE
				BPK.NOBPK = ' . $this->_tbp . '
		')
		->row();*/
		
		$query                                      = $this->model
		->select('DAFTUNIT.NMUNIT, BPK.NOBPK')
		->join('DAFTUNIT', 'DAFTUNIT.UNITKEY = BPK.UNITKEY', 'INNER')
		->get_where('BPK', array('BPK.NOBPK' => $this->_tbp), 1)
		->row();
		
		return $query;
	}
}
