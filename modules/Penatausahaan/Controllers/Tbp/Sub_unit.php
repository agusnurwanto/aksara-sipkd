<?php 
namespace Modules\Penatausahaan\Controllers\Tbp;
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
		->set_field('NMUNIT', 'hyperlink', 'penatausahaan/tbp', array('sub_unit' => 'UNITKEY'))
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
		//->SELECT('SUM(SPPDETR.NILAI) AS LS')
		//->JOIN('SPPDETR', 'SPPDETR.UNITKEY = DAFTUNIT.UNITKEY', 'LEFT')
		/*->join('
			(
				SELECT
					SPP.UNITKEY,
					Sum(SPPDETR.NILAI) AS LS
				FROM
					SPPDETR
				INNER JOIN SPP ON SPP.UNITKEY = SPPDETR.UNITKEY AND SPP.NOSPP = SPPDETR.NOSPP
				GROUP BY
					SPP.UNITKEY
			) AS SPP', 
				'SPP.UNITKEY = DAFTUNIT.UNITKEY', 'LEFT')*/
		//->debug('params')
		//->GROUP_BY('UNITKEY')
		/*->select
		('
			DAFTUNIT.UNITKEY AS id_total
		')
		->merge_content('{id_total}', 'SPP', 'callback_label_spp')*/
		->render($this->_table);
	}
	
	public function label_spp($params = array())
	{
		if(!isset($params['id_total'])) return false;
		$output										= null;
		$query										= $this->model->query
		('
			SELECT
				SUM(SPPDETR.NILAI) AS total
			FROM
				SPPDETR
			WHERE
				SPPDETR.UNITKEY	= ' . $params['id_total'] . '
		')
		->row('total');
		return '
			<a href="" class="--modal" style="white-space:nowrap">
				<span class="badge badge-success float-right">' . (isset($query) ? number_format_indo($query, 2) : '0') . '</span>
			</a>
		';
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
