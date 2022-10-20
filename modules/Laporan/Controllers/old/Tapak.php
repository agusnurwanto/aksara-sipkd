<?php namespace Modules\Laporan\Controllers;

class Tapak extends \Aksara\Laboratory\Core
{
	private $_title;
	private $_pageSize;
	private $_output;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		$this->unset_action('create, read, update, delete, export, print, pdf');
		
		if('dropdown' == service('request')->getPost('trigger'))
		{
			return $this->_dropdown();
		}
		else if('krk' == service('request')->getGet('fetch'))
		{
			return $this->_krk(true);
		}
		
		$this->_print_date							= (service('request')->getGet('print-date') ? service('request')->getGet('print-date') : date('Y-m-d'));
		
		$this->report								= new \Modules\Laporan\Models\Krk_model();
		
		$this->_template							= 'Modules\Laporan\Views\\' . service('request')->uri->getSegment(2) . (service('request')->uri->getSegment(3) ? '\\' . service('request')->uri->getSegment(3) : null);
		
		helper(array('custom', 'coordinate'));
	}
	
	public function index()
	{
		$this->set_title('Laporan Rencana Tapak')
		->set_icon('mdi mdi-chart-line-stacked')
		->set_output('results', $this->_report_list())
		->render();
	}
	
	private function _report_list()
	{
		return array
		(
			array
			(
				'title'								=> 'Surat Permohonan',
				'description'						=> 'Cetak Surat Permohonan yang dibuat otomatis oleh sistem',
				'icon'								=> 'mdi-file-document-outline',
				'color'								=> 'bg-secondary',
				'placement'							=> 'left',
				'controller'						=> 'permohonan',
				'parameter'							=> array
				(
					'krk'						    => $this->_krk(),
					'print_date'					=> $this->_print_date()
				)
			),
			array
			(
				'title'								=> 'Keterangan Rencana Kota',
				'description'						=> 'Lembar KRK',
				'icon'								=> 'mdi-map-search-outline',
				'color'								=> 'bg-secondary',
				'placement'							=> 'left',
				'controller'						=> 'krk',
				'parameter'							=> array
				(
					'krk'						    => $this->_krk(),
					'print_date'					=> $this->_print_date()
				)
			),
			array
			(
				'title'								=> 'Register KRK',
				'description'						=> 'Laporan pendaftaran KRK',
				'icon'								=> 'mdi-account-clock-outline',
				'color'								=> 'bg-secondary',
				'placement'							=> 'right',
				'controller'						=> 'register',
				'parameter'							=> array
				(
					'periode'					    => $this->_period(),
					'print_date'					=> $this->_print_date()
				)
			),
			array
			(
				'title'								=> 'Kendali KRK',
				'description'						=> 'Laporan kendali KRK',
				'icon'								=> 'mdi-format-list-checks',
				'color'								=> 'bg-secondary',
				'placement'							=> 'right',
				'controller'						=> 'kendali',
				'parameter'							=> array
				(
					'krk'						    => $this->_krk(),
					'print_date'					=> $this->_print_date()
				)
			)
		);
	}
	
	private function _execute()
	{
		/* prepare object data */
		$data										= array
		(
			'title'									=> $this->_title,
			'logo_laporan'							=> get_image('settings', (isset($header->logo_laporan) ? $header->logo_laporan : get_setting('app_icon')), 'thumb'),
			'tanggal_cetak'							=> $this->_print_date,
			'pageSize'							    => $this->_pageSize,
			'results'								=> $this->_output
		);
		
		if(in_array(service('request')->getGet('method'), array('embed', 'download', 'export')))
		{
			/**
			 * Method document
			 */
			$this->_output							= view($this->_template, $data);
			
			$this->document							= new \Aksara\Libraries\Document;
			
			$this->document->pageSize($this->_pageSize);
			
			return $this->document->generate($this->_output, $this->_title, service('request')->getGet('method'));
		}
		
		echo view($this->_template, $data);
	}
	
	private function _krk($partial = false)
	{
		$limit										= 50;
		$offset										= (service('request')->getPost('page') > 1 ? (service('request')->getPost('page') * $limit) - $limit : 0);
		
		$query										= $this->model->select
		('
			CONCAT(app__users.first_name, \' \', app__users.last_name) AS pemohon,
			ta__krk.id,
			ta__krk.kode,
			ta__krk.timestamp
		')
		->join
		(
			'app__users',
			'app__users.user_id = ta__krk.user_id'
		)
		->limit($limit, $offset)
		->get_where
		(
			'ta__krk',
			array
			(
			)
		)
		->result();
		
		if($query)
		{
			if($partial)
			{
				$option								= array();
			}
			else
			{
				$option								= '<option value="">Silakan pilih KRK</option>';
			}
			
			foreach($query as $key => $val)
			{
				$val->kode							= sprintf('%06d', $val->kode) . '/' . date('m', strtotime($val->timestamp)) . '.' . sprintf('%03d', $val->id) . '/DPUP/' . date('Y', strtotime($val->timestamp));
				
				if($partial)
				{
					$option[]						= array
					(
						'id'						=> $val->id,
						'text'						=> $val->kode . ' (' . $val->pemohon . ')'
					);
				}
				else
				{
					$option							.= '<option value="' . $val->id . '">' . $val->kode . ' (' . $val->pemohon . ')</option>';
				}
			}
			
			if($partial)
			{
				return make_json
				(
					array
					(
						'pagination'				=> array
						(
							'more'					=> (sizeof($option) >= $limit ? true : false)
						),
						'results'					=> $option
					)
				);
			}
			else
			{
				return '
					<div class="form-group mb-3">
						<label class="text-muted d-block">
							Kode KRK
						</label>
						<select name="krk" class="form-control form-control-sm" placeholder="Silakan pilih KRK" data-href="' . current_page(null, array('fetch' => 'krk')) . '" data-limit="' . $limit . '">
							' . $option . '
						</select>
					</div>
				';
			}
		}
	}
	
	private function _period()
	{
		$options									= '
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group mb-3">
						<label class="text-muted d-block">
							Periode Awal
						</label>
						<input type="text" name="start_date" class="form-control form-control-sm bordered" placeholder="Pilih Tanggal" value="01 January ' . date("Y") . '" data-format="dd MM yyyy" role="datepicker" readonly />
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group mb-3">
						<label class="text-muted d-block">
							Periode Akhir
						</label>
						<input type="text" name="end_date" class="form-control form-control-sm bordered" placeholder="Pilih Tanggal" value="' . date('d M Y') . '" data-format="dd MM yyyy" role="datepicker" readonly />
					</div>
				</div>
			</div>
		';
		
		return $options;
	}
	
	private function _print_date()
	{
		$options									= '
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group mb-3">
						<label class="text-muted d-block">
							Tanggal Cetak
						</label>
						<input type="text" name="print-date" class="form-control form-control-sm bordered" placeholder="Pilih Tanggal" value="' . date('d M Y') . '" data-format="dd MM yyyy" role="datepicker" readonly />
					</div>
				</div>
			</div>
		';
		
		return $options;
	}
}

	