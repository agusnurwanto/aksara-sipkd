<?php 
namespace Modules\Anggaran\Controllers\Pendapatan;
//use Config\Validation;

/**
 * Anggaran > Pendapatan > Sub Unit
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
		$this->_unit					 		   = service('request')->getGet('unit');

		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{
			// Filter
        if($this->_unit && 'all' != $this->_unit)
        {
			$this->where
			(
				array
				(
					'UNITKEY'						=> $this->_unit
				)
			);
        }
		
		$this->set_title('Sub Unit')
		->add_filter($this->_filter())
		->set_breadcrumb
		(
			array
			(
				'dashboard'							=> NULL
			)
		)
		->set_icon('mdi mdi-rhombus-split')
		->unset_column('UNITKEY, KDLEVEL, AKROUNIT, ALAMAT, TELEPON, TYPE')
		->unset_view('UNITKEY, KDLEVEL, AKROUNIT, ALAMAT, TELEPON, TYPE')
		->unset_action('create, update, delete')
		->set_field('NMUNIT', 'hyperlink', 'anggaran/pendapatan', array('sub_unit' => 'UNITKEY'))
		->set_alias
		(
			array
			(
				'KDUNIT'							=> 'Kode',
				'NMUNIT'							=> 'Sub Unit'
			)
		)
		->or_where_in('KDLEVEL', array(3,4))
		->order_by
		(
			array
			(
				'KDUNIT'							=> 'ASC'
			)
		)
		
		// ->select
		// ('
		// 	DAFTUNIT.UNITKEY AS pagu_sub_unit
		// ')
		// ->merge_content('{pagu_sub_unit}', 'PAGU', 'callback_pagu_sub_unit')
		->render($this->_table);
	}

	// public function pagu_sub_unit($params = array())
	// {
	// 	//$tahap 										= $this->_tahap();
	// 	if(!isset($params['pagu_sub_unit'])) return false;
	// 	$query										= $this->model->select
	// 	('			
	// 		SUM(RASKD.NILAI) AS total
	// 	')		
	// 	->join
	// 	(
	// 		'DAFTUNITUK',
	// 		'DAFTUNITUK.UNITKEYUK = RASKD.UNITKEY'
	// 	)				
	// 	->get_where
	// 	(
	// 		'RASKD',
	// 		array
	// 		(
	// 			'RASKD.UNITKEY'						=> $params['pagu_sub_unit'],
	// 			//'RASKD.KDTAHAP'						=> $tahap->KDTAHAP,
	// 		)	
	// 	->row('total');
	// 	return  '<b class="text">Rp. ' . (isset($query) ? number_format($query, 2) : '0') . '</b>';
	// }

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
