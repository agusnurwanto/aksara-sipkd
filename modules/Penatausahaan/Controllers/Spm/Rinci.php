<?php 
namespace Modules\Penatausahaan\Controllers\Spm;
/**
 * Penatausahaan > TBP > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
	private $_table									= 'SPMDETB';

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');

        $this->_sub_unit							= service('request')->getGet('sub_unit');
        $this->_spm									= service('request')->getGet('spm');

        if(!$this->_sub_unit)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
        }
        if(!$this->_spm)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('spm'));
        }

		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{
		//$header										= $this->_header();
		$this->set_title('Surat Perintah Membayar Rinci')
		->set_description
		('
			<ul class="nav nav-tabs mt-1">
				<li class="nav-item">
					<a class="nav-link --xhr' . (!service('request')->getGet('status') ? ' active' : null) . '" href="' . current_page(null, array('status' => null, 'company' => 1)) . '">
						Rinci
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link --xhr' . (!service('request')->getGet('status') ? ' active' : null) . '" href="' . current_page(null, array('status' => null, 'company' => 1)) . '">
						Potongan
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link --xhr' . (service('request')->getGet('status') == 'kni' ? ' active' : null) . '" href="' . current_page(null, array('status' => 'kni', 'company' => 2)) . '">
						Pajak
					</a>
				</li>
			</ul>
		')
		->set_icon('mdi mdi-rhombus-split')
		/*->unset_column('MTGKEY, UNITKEY, NOBPK')
		->unset_field('UNITKEY, NOBPK')
		->unset_view('MTGKEY, UNITKEY, NOBPK')
		->column_order('NUKEG, NMKEGUNIT, NMJETRA, NILAI')
		->field_order('KDKEGUNIT, NOJETRA, NILAI, MTGKEY')
		->view_order('KDKEGUNIT, NOJETRA, NILAI, MTGKEY')
		->set_field
		(
			array
			(
				'NILAI'								=> 'price_format',
			)
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
		->set_relation
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
		->set_default
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit,
				'NOBPK'								=> $this->_spm,
			)
		)
		->where
		(
			array
			(
				'UNITKEY'							=> $this->_sub_unit,
				'NOBPK'								=> $this->_spm,
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
				BPK.NOBPK = ' . $this->_spm . '
		')
		->row();*/
		
		$query                                      = $this->model
		->select('DAFTUNIT.NMUNIT, BPK.NOBPK')
		->join('DAFTUNIT', 'DAFTUNIT.UNITKEY = BPK.UNITKEY', 'INNER')
		->get_where('BPK', array('BPK.NOBPK' => $this->_spm), 1)
		->row();
		
		return $query;
	}
}
