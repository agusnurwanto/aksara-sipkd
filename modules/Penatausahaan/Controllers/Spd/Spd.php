<?php 
namespace Modules\Penatausahaan\Controllers\Spd;
/**
 * Penatausahaan > TBP
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Spd extends \Aksara\Laboratory\Core
{
	private $_table									= 'SKO';

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
		$this->set_title('Surat Penyediaan Dana')
		->set_description
		('
			<div class="row">
				<div class="col-4 col-sm-2 text-muted text-sm">
					SUB UNIT
				</div>
				<div class="col-8 col-sm-10 font-weight text-sm">
					' . $header->NMUNIT . '
				</div>
			</div>
		')
		->set_icon('mdi mdi-rhombus-split')
		->set_breadcrumb
		(
			array
			(
				'penatausahaan/spd/sub_unit'		=> 'Sub Unit'
			)
		)
		->unset_column('UNITKEY, IDXSKO, KD_BULAN1, KD_BULAN2, KEYBEND, IDXTTD, IDXKODE, IDXDASK, KDDSR, NOSKDPA, TGLSKDPA, TGLVALID')
		->unset_field('UNITKEY')
		->unset_view('UNITKEY')
		->column_order('NOSKO, TGLSKO, KETERANGAN')
		->set_alias
		(
			array
			(
				'NOSKO'								=> 'Nomor',
				'TGLSKO'							=> 'Tanggal'
			)
		)
		->set_field('KETERANGAN', 'hyperlink', 'penatausahaan/spd/rinci', array('sub_unit' => 'UNITKEY', 'spd' => 'IDXSKO'))
		->set_field
		(
			array
			(
				'TGLSKO'							=> 'datepicker',
				'TGLVALID'							=> 'datepicker',
				'KETERANGAN'						=> 'textarea',
			)
		)
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
		/*->set_relation
		(
			'KDSTATUS',
			'STATTRS.KDSTATUS',
			'{STATTRS.LBLSTATUS}',
			//where (null)
			NULL,
			NULL,
			// order
			'STATTRS.KDSTATUS'
		)
		->set_relation
		(
			'IDXKODE',
			'ZKODE.IDXKODE',
			'{ZKODE.URAIAN}',
			//where (null)
			NULL,
			NULL,
			// order
			'ZKODE.URAIAN'
		)
		->set_relation
		(
			'KEYBEND',
			'BEND.KEYBEND',
			'{BEND.NIP} - {JBEND.URAI_BEND}',
			//where (null)
			NULL,
			array
			(
				array
				(
					'JBEND',
					'JBEND.JNS_BEND = BEND.JNS_BEND'
				), 
			),
			// order
			'BEND.NIP'
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
		)*/
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
				'UNITKEY'							=> $this->_sub_unit
			)
		)
		->order_by
		(
			array
			(
				'TGLSKO'							=> 'DESC'
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
}
