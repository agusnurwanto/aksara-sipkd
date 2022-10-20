<?php 
namespace Modules\Penatausahaan\Controllers\Spm;
/**
 * Penatausahaan > TBP
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Spm extends \Aksara\Laboratory\Core
{
	private $_table									= 'ANTARBYR';

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');

        $this->_sub_unit							= service('request')->getGet('sub_unit');
        $this->_status								= service('request')->getGet('status');

        if(!$this->_sub_unit)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
        }

		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{
			// Jika Tab Di pilih
		if(!$this->_status || $this->_status == 24) //LS
		{
			$this
			->where('ANTARBYR.KDSTATUS', 24)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 24, //LS
				)
			)
			;
		}
		elseif($this->_status) //TU
		{
			$this
			->where('ANTARBYR.KDSTATUS', 23)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 23, //TU
				)
			)
			;
		}
		elseif($this->_status) //GU
		{
			$this
			->where('ANTARBYR.KDSTATUS', 22)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 22, //GU
				)
			)
			;
		}
		elseif($this->_status) //UP
		{
			$this
			->where('ANTARBYR.KDSTATUS', 21)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 21, //UP
				)
			)
			;
		}
		$this
		->where
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit
			)
		);
		
		$header										= $this->_header();
		$this->set_title('Surat Perintah Membayar')
		->set_description
		('
			<ul class="nav nav-tabs mt-1">
				<li class="nav-item">
					<a class="nav-link --xhr' . (!$this->_status || $this->_status == 24 ? ' active' : null) . '" href="' . current_page(null, array('status' => 24)) . '">
						LS
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link --xhr' . ($this->_status == 23 ? ' active' : null) . '" href="' . current_page(null, array('status' => 23)) . '">
						TU
					</a>
				</li>
				' . ($header->KDLEVEL == 3 ? '
				<li class="nav-item">
					<a class="nav-link --xhr' . ($this->_status == 22 ? ' active' : null) . '" href="' . current_page(null, array('status' => 22)) . '">
						GU
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link --xhr' . ($this->_status == 21 ? ' active' : null) . '" href="' . current_page(null, array('status' => 21)) . '">
						UP
					</a>
				</li>
				' : NULL) . '
			</ul>
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
				'penatausahaan/spm/sub_unit'		=> 'Sub Unit'
			)
		)
		->unset_column('UNITKEY, KDSTATUS, KEYBEND, IDXSKO, IDXTTD, KDP3, IDXKODE, NOREG, KETOTOR, NOKONTRAK')
		->unset_field('UNITKEY')
		->unset_view('UNITKEY')
		/*
		->column_order('NOBPK, URAIBPK, TGLBPK')
		->set_alias
		(
			array
			(
				'NOBPK'								=> 'Nomor',
				'URAIBPK'							=> 'Uraian',
				'TGLBPK'							=> 'Tanggal'
			)
		)*/
		->set_field('NOSPM', 'hyperlink', 'penatausahaan/spm/rinci', array('spm' => 'NOSPM'))
		/*->set_field
		(
			array
			(
				'TGLBPK'							=> 'datepicker',
				'TGLVALID'							=> 'datepicker',
				'PENERIMA'							=> 'textarea',
				'URAIBPK'							=> 'textarea',
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
		->set_relation
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
				'UNITKEY'							=> $this->_sub_unit
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
		->select('DAFTUNIT.NMUNIT, DAFTUNIT.KDLEVEL')
		->get_where('DAFTUNIT', array('DAFTUNIT.UNITKEY' => $this->_sub_unit), 1)
		->row();
		
		return $query;
	}
}
