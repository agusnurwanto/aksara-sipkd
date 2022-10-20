<?php 
namespace Modules\Penatausahaan\Controllers\Tbp;
/**
 * Penatausahaan > TBP
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Tbp extends \Aksara\Laboratory\Core
{
	private $_table									= 'BPK';

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
		if(!$this->_status || $this->_status == 13) //Penerimaan
		{
			$this
			->set_title('Tanda Bukti Penerimaan')
			->where('BPK.KDSTATUS', 13)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 1, //Penerimaan
					'KDSTATUS'							=> 13, //LS
				)
			)
			->set_field('NOSPP', 'hyperlink', 'penatausahaan/spp/rinci', array('spp' => 'NOSPP'))
			;
		}
		elseif($this->_status == 21) //Pengeluaran
		{
			$this
			->set_title('Tanda Bukti Pengeluaran')
			->where('BPK.KDSTATUS', 21)
			->set_default
			(
				array
				(
					'UNITKEY'							=> $this->_sub_unit,
					'IDXKODE'							=> 2, //Belanja
					'KDSTATUS'							=> 21, //TU
				)
			)
			->set_field('NOSPP', 'hyperlink', 'penatausahaan/spp/rinci', array('spp' => 'NOSPP'))
			;
		}
		
		$header										= $this->_header();
		$this
		->set_icon('mdi mdi-rhombus-split')
		//->set_title('Tanda Bukti Pengeluaran')
		->set_description
		('
			<ul class="nav nav-tabs mt-1">
				<li class="nav-item">
					<a class="nav-link --xhr' . (!$this->_status || $this->_status == 13 ? ' active' : null) . '" href="' . current_page(null, array('status' => 13)) . '">
						Penerimaan
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link --xhr' . ($this->_status == 21 ? ' active' : null) . '" href="' . current_page(null, array('status' => 21)) . '">
						Pengeluaran
					</a>
				</li>
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
		->unset_column('UNITKEY, TGLVALID, PENERIMA, STPANJAR, STTUNAI, STBANK, NOBA, KDBANK, NOREK, LBLSTATUS, URAIAN, NIP, URAI_BEND, IDXKODE')
		->unset_field('UNITKEY')
		->unset_view('UNITKEY')
		->column_order('NOBPK, URAIBPK, TGLBPK')
		->add_action('option', '../../laporan/penatausahaan/pengeluaran/tbp', 'Cetak TBP', 'btn-success ajax', 'mdi mdi-printer', array('unit' => $this->_sub_unit, 'tbp' => 'NOBPK', 'method' => 'preview'), true)
		->set_alias
		(
			array
			(
				'NOBPK'								=> 'Nomor',
				'URAIBPK'							=> 'Uraian',
				'TGLBPK'							=> 'Tanggal'
			)
		)
		->set_field('URAIBPK', 'hyperlink', 'penatausahaan/tbp/rinci', array('tbp' => 'NOBPK'))
		->set_field
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
		/*->set_relation
		(
			'IDXKODE',
			'ZKODE.IDXKODE',
			'{ZKODE.URAIAN}',
			//where (null)
			NULL,
			NULL,
			// order
			'ZKODE.URAIAN'
		)*/
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
