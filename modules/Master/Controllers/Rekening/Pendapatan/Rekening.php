<?php 
namespace Modules\Master\Controllers\Rekening\Pendapatan;

/**
 * Master > Rekening > Pendapatan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rekening extends \Aksara\Laboratory\Core
{
	private $_table									= 'MATANGD';

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
			$this->like
			(
				array
				(
					'KDPER'						=> $this->_unit
				)
			);
        }
		
		$this->set_title('Rekening Pendapatan')
		->add_filter($this->_filter())
		->set_icon('mdi mdi-rhombus-split')
		->unset_column('MTGKEY, MTGLEVEL, KDKHUSUS')
		->unset_view('MTGKEY, MTGLEVEL, KDKHUSUS')
		->unset_action('create, update, delete')
		->set_alias
		(
			array
			(
				'KDPER'							=> 'Kode',
				'NMPER'							=> 'Uraian'
			)
		)
		->order_by
		(
			array
			(
				'KDPER'							=> 'ASC'
			)
		)
		//->debug('params')	
		->render($this->_table);
	}
	
	private function _filter()
	{
		$output										= null;
		$query										= $this->model
                                                    ->select('MATANGD.KDPER, MATANGD.NMPER, MATANGD.MTGLEVEL')
                                                    ->order_by('MATANGD.KDPER ASC')
                                                    ->get_where('MATANGD', array('MATANGD.MTGLEVEL' => 1))
                                                    ->result();
		if($query)
		{
			foreach($query as $key => $val)
			{
				$output								.= '<option value="' . $val->KDPER . '"' . ($val->KDPER == $this->_unit ? ' selected' : '') . '>' . $val->NMPER . '</option>';
			}
		}
		$output										= '
			<select name="unit" class="form-control input-sm bordered" placeholder="Filter On Reseller">
				<option value="all">Select All</option>
				' . $output . '
			</select>
		';
		return $output;
	}
}
