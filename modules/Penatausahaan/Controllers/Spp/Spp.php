<?php 
namespace Modules\Penatausahaan\Controllers\Spp;
/**
 * Penatausahaan > TBP
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Spp extends \Aksara\Laboratory\Core
{
	private $_table									= 'SPP';

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
			->where('SPP.KDSTATUS', 24)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 24, //LS
				)
			)
			->set_field('NOSPP', 'hyperlink', 'penatausahaan/spp/rinci', array('spp' => 'NOSPP'))
			;
		}
		elseif($this->_status == 23) //TU
		{
			$this
			->where('SPP.KDSTATUS', 23)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 23, //TU
				)
			)
			->set_field('NOSPP', 'hyperlink', 'penatausahaan/spp/rinci', array('spp' => 'NOSPP'))
			;
		}
		elseif($this->_status == 22) //GU
		{
			$this
			->where('SPP.KDSTATUS', 22)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 22, //GU
				)
			)
			->set_field('NOSPP', 'hyperlink', 'penatausahaan/spp/rinci', array('spp' => 'NOSPP'))
			;
		}
		elseif($this->_status == 21) //UP
		{
			$this
			->where('SPP.KDSTATUS', 21)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 21, //UP
				)
			)
			->set_field('NOSPP', 'hyperlink', 'penatausahaan/spp/up', array('spp' => 'NOSPP'))
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
		$this->set_title('Surat Permintaan Pembayaran')
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
				'penatausahaan/spp/sub_unit'		=> 'Sub Unit'
			)
		)
		->unset_column('UNITKEY, KDSTATUS, IDXKODE, IDXTTD, KD_BULAN, NOKONTRAK, NOREG, KETOTOR, PENOLAKAN, NIP, URAI_BEND, KDP3, STATUS')
		->unset_field('UNITKEY, KDSTATUS, IDXTTD, IDXKODE, STATUS')
		->unset_view('UNITKEY, KDSTATUS, IDXTTD, IDXKODE, STATUS')
		->column_order('NOSPP, TGSPP, TGLVALID')
		->set_alias
		(
			array
			(
				'NOSPP'								=> 'Nomor',
				'NOSKO'								=> 'No SPD',
				'IDXSKO'							=> 'No SPD',
				'TGSPP'								=> 'Tanggal',
				'TGLVALID'							=> 'Tanggal Sah',
				'KD_BULAN'							=> 'Untuk Bulan',
				'KETOTOR'							=> 'Dasar Pengeluaran',
				'KEYBEND'							=> 'Bendahara',
				'PENOLAKAN'							=> 'Penolakan',
				'NOKONTRAK'							=> 'No Kontrak',
				'NOREG'								=> 'No Reg SPP',
				'KEPERLUAN'							=> 'Keperluan',
			)
		)
		->set_relation
		(
			'IDXSKO',
			'SKO.IDXSKO',
			'{SKO.NOSKO}',
			array
			(
				'SKO.UNITKEY'						=> $this->_sub_unit
			),
			NULL,
			// order
			'SKO.NOSKO'
		)
		->set_field
		(
			array
			(
				'TGSPP'								=> 'datepicker',
				'TGLVALID'							=> 'datepicker',
				'NOSPP'								=> 'textarea',
				'KEPERLUAN'							=> 'textarea',
				'KETOTOR'							=> 'textarea',
				'KD_BULAN'							=> 'monthpicker',
			)
		)
		->set_field
		(
			'PENOLAKAN',
			'radio',
			array
			(
				0									=> '<label class="badge bg-primary">Ditolak</label>',
				1									=> '<label class="badge bg-warning">Diterima</label>',
			)
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
		->field_position
		(
			array
			(
				'IDXSKO'							=> 2,
				'KDP3'								=> 2,
				'NOREG'								=> 2,
				'KETOTOR'							=> 2,
				'NOKONTRAK'							=> 3,
				'KEPERLUAN'							=> 3,
				'PENOLAKAN'							=> 4,
				'STATUS'								=> 4,
			)
		)
		/*->set_relation
		(
			'MTGKEY',
			'MATANGR.MTGKEY',
			'{MATANGR.NMPER}',
			NULL,
			NULL,
			'MATANGR.KDPER'
		)
		->set_relation
		(
			'KDKEGUNIT',
			'MKEGIATAN.KDKEGUNIT',
			'{MKEGIATAN.NUKEG}. {MKEGIATAN.NMKEGUNIT}',
			//where (null)
			NULL,
			NULL,
			// order
			'MKEGIATAN.NUKEG'
		)
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
		)*/
		//->group_by('SPP.UNITKEY, SPP.NOSPP, SPP.KDSTATUS, SPP.KD_BULAN, SPP.KEYBEND, SPP.IDXSKO, SPP.IDXTTD, SPP.KDP3, SPP.IDXKODE, SPP.NOREG, SPP.KETOTOR, SPP.NOKONTRAK, SPP.KEPERLUAN, SPP.PENOLAKAN, SPP.TGLVALID, SPP.TGSPP, SPP.STATUS, SKO.NOSKO, SKO.IDXSKO, BEND.NIP, JBEND.URAI_BEND, BEND.KEYBEND')
		->order_by
		(
			array
			(
				'TGSPP'								=> 'DESC'
			)
		)
		//->debug('query')
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
