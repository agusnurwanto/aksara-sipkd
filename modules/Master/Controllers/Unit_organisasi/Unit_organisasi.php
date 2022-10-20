<?php 
namespace Modules\Master\Controllers\Unit_organisasi;
//use Config\Validation;

/**
 * Master > Unit_organisasi > Unit_organisasi
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Unit_organisasi extends \Aksara\Laboratory\Core
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
		
		$this->set_title('Unit Organisasi')
		->add_filter($this->_filter())
		->set_icon('mdi mdi-rhombus-split')
		->unset_column('UNITKEY, KDLEVEL, ALAMAT, TELEPON')
		->unset_view('UNITKEY, KDLEVEL, ALAMAT, TELEPON')
		->unset_action('create, update, delete')
		->set_field('NMUNIT', 'hyperlink', 'master/unit_organisasi/sub_unit', array('sub_unit' => 'KDUNIT'))
		->set_alias
		(
			array
			(
				'KDUNIT'							=> 'Kode',
				'NMUNIT'							=> 'Unit Organisasi'
			)
		)
		->where
		(
			array
			(
				'KDLEVEL'							=> 3
			)
		)
		->order_by
		(
			array
			(
				'KDUNIT'							=> 'ASC'
			)
		)
		//->debug('params')
		->select
		('
			DAFTUNIT.KDUNIT AS count_sub
		')
		->merge_content('{count_sub}', 'Jumlah Sub Unit', 'callback_count_sub')
		->render($this->_table);
	}

	public function count_sub($params = array())
	{
		if(!isset($params['count_sub'])) return false;
		
		$query										= $this->model->select
		('
			count(*) as total
		')
		->like
		(
			array
			(
				'KDUNIT'						=> $params['count_sub']
			)
		)	
		->get_where
		(
			'DAFTUNIT',
			array
			(
				'DAFTUNIT.KDLEVEL'					=> 4
			)
		)
		->row('total');
		
		return '<span class="badge bg-success">' . $query . '</span> Sub Unit';
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
