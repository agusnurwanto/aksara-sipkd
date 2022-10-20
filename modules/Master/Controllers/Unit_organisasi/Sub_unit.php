<?php 
namespace Modules\Master\Controllers\Unit_organisasi;
//use Config\Validation;

/**
 * Penatausahaan > TBP > Sub Unit
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
		$this->_unit					 		   = service('request')->getGet('sub_unit');
		if(!$this->_unit)
        {
            return throw_exception(301, 'Silakan memilih Unit terlebih dahulu...', go_to('unit_organisasi'));
        }		

		// must be called after set_theme()
		$this->database_config(1);
	}

	public function index()
	{
		$header										= $this->_header();
		// Filter
        if($this->_unit && 'all' != $this->_unit)
        {
			$this->like
			(
				array
				(
					'KDUNIT'						=> $this->_unit
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
		->set_description
		('			
			<div class="row">
				<div class="col-4 col-sm-2 text-muted text-sm">
					UNIT
				</div>
				<div class="col-8 col-sm-10 font-weight text-sm">
					' . $header->NMUNIT . '
				</div>
			</div>
		')
		->set_icon('mdi mdi-rhombus-split')
		->unset_column('UNITKEY, KDLEVEL, AKROUNIT, ALAMAT, TELEPON')
		->unset_view('UNITKEY, KDLEVEL, AKROUNIT, ALAMAT, TELEPON')
		->unset_action('create, update, delete')
		//->set_field('NMUNIT', 'hyperlink', 'penatausahaan/sp2d_bku', array('sub_unit' => 'UNITKEY'))
		->set_alias
		(
			array
			(
				'KDUNIT'							=> 'Kode',
				'NMUNIT'							=> 'Sub Unit'
			)
		)		
		->where
		(
			array
			(
				'KDLEVEL'							=> 4
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
		->render($this->_table);
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
				$output								.= '<option value="' . $val->KDUNIT . '"' . ($val->KDUNIT == $this->_unit ? ' selected' : '') . '>' . $val->NMUNIT . '</option>';
			}
		}
		$output										= '
			<select name="sub_unit" class="form-control input-sm bordered" placeholder="Filter On Unit">
				<option value="all">Select All Unit</option>
				' . $output . '
			</select>
		';
		return $output;
	}

	private function _header()
	{
		$query                                      = $this->model
		->select('DAFTUNIT.NMUNIT')
		->get_where('DAFTUNIT', array('DAFTUNIT.KDLEVEL' => 3, 'DAFTUNIT.KDUNIT' => $this->_unit), 1)
		->row();
		
		return $query;
	}
}
