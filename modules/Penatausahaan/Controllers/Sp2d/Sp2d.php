<?php 
namespace Modules\Penatausahaan\Controllers\Sp2d;
/**
 * Penatausahaan > TBP
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sp2d extends \Aksara\Laboratory\Core
{
	private $_table									= 'SP2DDETR';

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
		$this->set_title('Surat Perintah Pencairan Dana')
		->set_description
		('
			<ul class="nav nav-tabs mt-1">
				<li class="nav-item">
					<a class="nav-link --xhr' . (!service('request')->getGet('status') ? ' active' : null) . '" href="' . current_page(null, array('status' => null, 'company' => 1)) . '">
						UP
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link --xhr' . (service('request')->getGet('status') == 'kni' ? ' active' : null) . '" href="' . current_page(null, array('status' => 'kni', 'company' => 2)) . '">
						LS
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link --xhr' . (service('request')->getGet('status') == 'ocs' ? ' active' : null) . '" href="' . current_page(null, array('status' => 'ocs', 'company' => 3)) . '">
						GU
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link --xhr' . (service('request')->getGet('status') == 'all' ? ' active' : null) . '" href="' . current_page(null, array('status' => 'all')) . '">
						TU
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
		->set_icon('mdi mdi-rhombus-split')
		->set_breadcrumb
		(
			array
			(
				'penatausahaan/sp2d/sub_unit'		=> 'Sub Unit'
			)
		)
		/*->unset_column('UNITKEY, TGLVALID, PENERIMA, STPANJAR, STTUNAI, STBANK, NOBA, KDBANK, NOREK, LBLSTATUS, URAIAN, NIP, URAI_BEND')
		->unset_field('UNITKEY')
		->unset_view('UNITKEY')
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
		->set_field('NOSP2D', 'hyperlink', 'penatausahaan/sp2d/rinci', array('sp2d' => 'NOSP2D'))
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
		->select('DAFTUNIT.NMUNIT')
		->get_where('DAFTUNIT', array('DAFTUNIT.UNITKEY' => $this->_sub_unit), 1)
		->row();
		
		return $query;
	}
}
