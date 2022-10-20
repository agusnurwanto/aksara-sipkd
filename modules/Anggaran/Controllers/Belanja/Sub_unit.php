<?php 
namespace Modules\Anggaran\Controllers\Belanja;

/**
 * Anggaran > Belanja > Sub Unit
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sub_unit extends \Aksara\Laboratory\Core
{
	private $_table									= 'DAFTUNIT';

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');
		$this->_unit					 		   	= service('request')->getGet('unit');		
		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{
		$tahap 										= $this->_tahap();		
		// Filter
        if($this->_unit && 'all' != $this->_unit)
        {
			$this->where
			(
				array
				(
					'DAFTUNITUK.UNITKEYSKPD'		=> $this->_unit
				)
			);
        }
		
		$this->set_title('Sub Unit')
		->add_filter($this->_filter())
		->set_description
		('			
			<div class="row">				
				<div class="col-4 col-sm-2 text-muted text-sm">
					TAHAPAN
				</div>
				<div class="col-8 col-sm-10 font-weight text-sm">
					' . $tahap->URAIAN . '
				</div>
			</div>
		')
		->set_icon('mdi mdi-rhombus-split')
		->unset_column('UNITKEY, KDLEVEL, TYPE, AKROUNIT, ALAMAT, TELEPON, UNITKEYUK, UNITKEYSKPD')
		->unset_view('UNITKEY, KDLEVEL, TYPE, AKROUNIT, ALAMAT, TELEPON, UNITKEYUK, UNITKEYSKPD')
		->unset_action('create, update, delete')
		->set_field('NMUNIT', 'hyperlink', 'anggaran/belanja', array('sub_unit' => 'UNITKEY'))
		->set_alias
		(
			array
			(
				'KDUNIT'							=> 'Kode',
				'NMUNIT'							=> 'Sub Unit'
			)
		)
			
		->set_relation
		(
			'UNITKEY',
			'DAFTUNITUK.UNITKEYUK',
			'{DAFTUNITUK.UNITKEYUK} {DAFTUNITUK.UNITKEYSKPD}',
			array
			(
				'DAFTUNITUK.UNITKEYSKPD'			=> $this->_unit				
			),
			NULL,
			'DAFTUNIT.KDUNIT'
		)	
		->where_in('KDLEVEL', [3,4])
		
		->order_by
		(
			array
			(
				'KDUNIT'							=> 'ASC'
			)
		)
		//->debug('params')
		// ->select
		// ('
		// 	DAFTUNIT.UNITKEY AS pagu_sub_unit
		// ')
		// ->merge_content('{pagu_sub_unit}', 'Pagu', 'callback_pagu_sub_unit')
		->render($this->_table);
	}

	public function pagu_sub_unit($params = array())
	{
		$tahap 										= $this->_tahap();
		if(!isset($params['pagu_sub_unit'])) return false;
		$query										= $this->model->select
		('			
			Sum(RASKD.NILAI) AS total
		')		
		->join
		(
			'DAFTUNIT',
			'DAFTUNIT.UNITKEY = RASKD.UNITKEY'
		)				
		->get_where
		(
			'RASKD',
			array
			(
				'RASKD.UNITKEY'						=> $params['pagu_sub_unit'],
				'RASKD.KDTAHAP'						=> $tahap->KDTAHAP,
			)
			
		)		
		->row('total');
		
		return  '<b class="text">Rp. ' . (isset($query) ? number_format($query, 2) : '0') . '</b>';
	}

	private function _tahap()
	{
		$query                                      = $this->model
		->select('TAHAP.KDTAHAP, TAHAP.URAIAN')		
		->order_by
		(
			array
			(
				'CAST(KDTAHAP AS int)'							=> 'DESC'
			)
		)
		->get_where('TAHAP', array(), 1)
		->row();
		
		return $query;
	}

	private function _filter()
	{
		$output										= null;
		$query										= $this->model
                                                    ->select('DAFTUNIT.UNITKEY, DAFTUNIT.KDUNIT, DAFTUNIT.NMUNIT')
                                                    ->order_by('DAFTUNIT.KDUNIT ASC')
                                                    ->get_where('DAFTUNIT', array('DAFTUNIT.KDLEVEL' => 3))
                                                    ->result();
		if($query)
		{
			foreach($query as $key => $val)
			{
				$output								.= '<option value="' . $val->UNITKEY . '"' . ($val->UNITKEY == $this->_unit ? ' selected' : '') . '>' . $val->NMUNIT . '</option>';
			}
		}
		$output										= '
			<select name="unit" class="form-control input-sm bordered" placeholder="Filter On Reseller">
				<option value="all">Select All Unit</option>
				' . $output . '
			</select>
		';
		return $output;
	}
}
