<?php namespace Modules\Laporan\Controllers\Penatausahaan;

class Pengeluaran extends \Aksara\Laboratory\Core
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
		
		$this->_unit								= (service('request')->getGet('unit') ? service('request')->getGet('unit') : 'all');
		$this->_tbp									= (service('request')->getGet('tbp') ? service('request')->getGet('tbp') : NULL);
		$this->_spp									= (service('request')->getGet('spp') ? service('request')->getGet('spp') : NULL);
		$this->_spm									= (service('request')->getGet('spm') ? service('request')->getGet('spm') : NULL);
		$this->_print_date							= (service('request')->getGet('print-date') ? service('request')->getGet('print-date') : date('Y-m-d'));
		
		$this->report								= new \Modules\Laporan\Models\Penatausahaan\Pengeluaran_model();
		
		$this->_template							= 'Modules\Laporan\Views\\' . service('request')->uri->getSegment(2) . (service('request')->uri->getSegment(3) ? '\\' . service('request')->uri->getSegment(3) : null);
		
		helper(array('custom', 'coordinate'));

        if('dropdown' == service('request')->getPost('trigger'))
        {
            return $this->_dropdown();
        }
	}
	
	public function index()
	{
		$this->set_title('Penatausahaan Pengeluaran')
		->set_icon('mdi mdi-chart-bar-stacked')
		->set_output('results', $this->_report_list())
		->render();
	}
	
	public function tbp()
	{
		if(!$this->_tbp)
		{
			return throw_exception(403, 'Silakan Pilih TBP terlebih dahulu...', current_page('../'));
		}
		
		$params										= array
		(
			'unit'									=> $this->_unit,
			'tbp'									=> $this->_tbp
		);
		
		$this->_title								= 'Tanda Bukti Pembayaran';
		$this->_output								= $this->report->tbp($params);
		
		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();
		
		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 'shortlink');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);
		
		$this->_execute();
	}
	
	public function spp()
	{
		if(!$this->_spp)
		{
			return throw_exception(403, 'Silakan Pilih SPP terlebih dahulu...', current_page('../'));
		}
		
		$params										= array
		(
			'unit'									=> $this->_unit,
			'spp'									=> $this->_spp
		);
		
		$this->_title								= 'Surat Permintaan Pembayaran';
		$this->_output								= $this->report->spp($params);
		
		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();
		
		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 'shortlink');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);
		
		$this->_execute();
	}
	
	public function spm()
	{
		if(!$this->_spm)
		{
			return throw_exception(403, 'Silakan Pilih SPM terlebih dahulu...', current_page('../'));
		}
		
		$params										= array
		(
			'unit'									=> $this->_unit,
			'spm'									=> $this->_spm
		);
		
		$this->_title								= 'Surat Perintah Membayar';
		$this->_output								= $this->report->spm($params);
		
		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();
		
		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 'shortlink');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);
		
		$this->_execute();
	}
	
	private function _report_list()
	{
		return array
		(
			array
			(
				'title'								=> 'Tanda Bukti Pengeluaran',
				'description'						=> 'Tanda Bukti Pengeluaran',
				'icon'								=> 'mdi-file-document-outline',
				'color'								=> 'bg-primary',
				'placement'							=> 'left',
				'controller'						=> 'tbp',
				'parameter'							=> array
				(
					//'periode'					    => $this->_period(),
					'tbp'						    => $this->_tbp(),
					//'print_date'					=> $this->_print_date()
				)
			),
			array
			(
				'title'								=> 'SPP',
				'description'						=> 'Surat Permintaan Pembayaran',
				'icon'								=> 'mdi-map-search-outline',
				'color'								=> 'bg-info',
				'placement'							=> 'left',
				'controller'						=> 'spp',
				'parameter'							=> array
				(
					'spp'						    => $this->_spp()
				)
			),
			array
			(
				'title'								=> 'SPM',
				'description'						=> 'Surat Perintah Membayar',
				'icon'								=> 'mdi-account-clock-outline',
				'color'								=> 'bg-primary',
				'placement'							=> 'right',
				'controller'						=> 'spm',
				'parameter'							=> array
				(
					'spm'						    => $this->_spm(),
					//'print_date'					=> $this->_print_date()
				)
			),/*
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
					//'krk'						    => $this->_krk(),
					'print_date'					=> $this->_print_date()
				)
			)*/
		);
	}
	
	private function _execute()
	{
		/* prepare object data */
		$data										= array
		(
			'title'									=> $this->_title,
			//'company'								=> get_image('settings', (isset($header->logo_laporan) ? $header->logo_laporan : get_setting('app_icon')), 'thumb'),
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

	/*private function _tbp()
	{
		$this->model->database_config(1);
		$query		= $this->model->query
					('
						SELECT
							BPK.NOBPK, 
							BPK.IDXKODE
						FROM
							BPK
					')
					->result();

		if($query)
		{
			$options						= NULL;
			foreach($query as $key => $val)
			{
				$options					.= '<option value="' . $val->NOBPK . '">' . $val->NOBPK . '</option>';
			}
			return '
				<div class="form-group mb-1">
					<label class="control-label mb-1">
						TBP
					</label>
					<select name="nobpk" class="form-control report-dropdown">
						' . $options . '
					</select>
				</div>
			';
		}
	}*/

    private function _tbp($label = null)
    {
        $query                                      = null;
        $options                                    = null;
        $output										= null;

		$this->database_config(1);
        // Super Admin, AdminPemeriksa
        if(in_array(get_userdata('group_id'), array(1, 2)))
        {
            $query									= $this->model
                                                    ->select
                                                    ('
                                                        DAFTUNIT.UNITKEY,
                                                        DAFTUNIT.KDLEVEL,
                                                        DAFTUNIT.KDUNIT,
                                                        DAFTUNIT.NMUNIT
			                                        ')
													->order_by('DAFTUNIT.KDUNIT')
													->or_where_in('DAFTUNIT.KDLEVEL', array(3, 4))
                                                    ->get('DAFTUNIT') //, array('DAFTUNIT.KDLEVEL' => (3, 4))
                                                    //->get_where_in('DAFTUNIT', array('DAFTUNIT.KDLEVEL' => (3, 4))
                                                    ->result_array();
            if($query)
            {
                $options							= null;
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['UNITKEY'] . '">' . $val['KDUNIT'] . ' ' . $val['NMUNIT'] . '</option>';
                }
                $output								.= '
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Unit
                                                            </label>
                                                            <select name="unit" class="form-control" data-to-change="tbp">
                                                                <option value="">Silakan pilih Unit</option>
                                                                ' . $options . '
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                TBP
                                                            </label>
                                                            <select name="tbp" class="form-control report-dropdown" disabled>
                                                                <option value="">Silakan pilih Unit terlebih dahulu</option>
                                                            </select>
                                                        </div>
                                                    ';
            }
        }
        // Grup Sub Unit
        /*elseif(in_array(get_userdata('group_id'), array(7, 8)))
        {
            $query									= $this->model
                                                    ->select('ta__kegiatan_sub.id, ta__kegiatan_sub.kd_keg_sub, ta__kegiatan_sub.kegiatan_sub')
                                                    ->join('ta__kegiatan','ta__kegiatan.id = ta__kegiatan_sub.id_keg')
                                                    ->join('ta__program','ta__kegiatan.id_prog = ta__program.id')
                                                    ->order_by('kd_keg_sub')
                                                    ->get_where('ta__kegiatan_sub', array('ta__kegiatan_sub.id_keg' => $this->_sub_unit))
                                                    ->result_array();

            if($query)
            {
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['id'] . '">' . $val['kd_keg_sub'] . '. ' . $val['kegiatan_sub'] . '</option>';
                }
            }

            $output								    .= '
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Sub Kegiatan
                                                            </label>
                                                            <select name="sub_kegiatan" class="form-control form-control-sm report-dropdown sub_kegiatan" ' . $to_change_label . '>
                                                                <option value="">Silakan pilih Sub Unit</option>
                                                                ' . $options . '
                                                            </select>
                                                        </div>
                                                        ' . ($label ? '
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    ' . $label . '
                                                                </label>
                                                                <br />
                                                                <select name="' . $label . '" class="form-control form-control-sm ' . $label . '" disabled>
                                                                    <option value="">Silakan pilih Sub Kegiatan terlebih dahulu</option>
                                                                </select>
                                                            </div>
                                                        ' : null) . '
                                                    ';
        }*/
        else
        {
            return false;
        }

        return $output;
    }

    private function _spp($label = null)
    {
        $query                                      = null;
        $options                                    = null;
        $output										= null;

		$this->database_config(1);
        // Super Admin, AdminPemeriksa
        if(in_array(get_userdata('group_id'), array(1, 2)))
        {
            $query									= $this->model
                                                    ->select
                                                    ('
                                                        DAFTUNIT.UNITKEY,
                                                        DAFTUNIT.KDLEVEL,
                                                        DAFTUNIT.KDUNIT,
                                                        DAFTUNIT.NMUNIT
			                                        ')
													->order_by('DAFTUNIT.KDUNIT')
													->or_where_in('DAFTUNIT.KDLEVEL', array(3, 4))
                                                    ->get('DAFTUNIT') //, array('DAFTUNIT.KDLEVEL' => (3, 4))
                                                    //->get_where_in('DAFTUNIT', array('DAFTUNIT.KDLEVEL' => (3, 4))
                                                    ->result_array();
            if($query)
            {
                $options							= null;
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['UNITKEY'] . '">' . $val['KDUNIT'] . ' ' . $val['NMUNIT'] . '</option>';
                }
                $output								.= '
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Unit
                                                            </label>
                                                            <select name="unit" class="form-control" data-to-change="spp">
                                                                <option value="">Silakan pilih Unit</option>
                                                                ' . $options . '
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                SPP
                                                            </label>
                                                            <select name="spp" class="form-control report-dropdown" disabled>
                                                                <option value="">Silakan pilih Unit terlebih dahulu</option>
                                                            </select>
                                                        </div>
                                                    ';
            }
        }
        // Grup Sub Unit
        /*elseif(in_array(get_userdata('group_id'), array(7, 8)))
        {
            $query									= $this->model
                                                    ->select('ta__kegiatan_sub.id, ta__kegiatan_sub.kd_keg_sub, ta__kegiatan_sub.kegiatan_sub')
                                                    ->join('ta__kegiatan','ta__kegiatan.id = ta__kegiatan_sub.id_keg')
                                                    ->join('ta__program','ta__kegiatan.id_prog = ta__program.id')
                                                    ->order_by('kd_keg_sub')
                                                    ->get_where('ta__kegiatan_sub', array('ta__kegiatan_sub.id_keg' => $this->_sub_unit))
                                                    ->result_array();

            if($query)
            {
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['id'] . '">' . $val['kd_keg_sub'] . '. ' . $val['kegiatan_sub'] . '</option>';
                }
            }

            $output								    .= '
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Sub Kegiatan
                                                            </label>
                                                            <select name="sub_kegiatan" class="form-control form-control-sm report-dropdown sub_kegiatan" ' . $to_change_label . '>
                                                                <option value="">Silakan pilih Sub Unit</option>
                                                                ' . $options . '
                                                            </select>
                                                        </div>
                                                        ' . ($label ? '
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    ' . $label . '
                                                                </label>
                                                                <br />
                                                                <select name="' . $label . '" class="form-control form-control-sm ' . $label . '" disabled>
                                                                    <option value="">Silakan pilih Sub Kegiatan terlebih dahulu</option>
                                                                </select>
                                                            </div>
                                                        ' : null) . '
                                                    ';
        }*/
        else
        {
            return false;
        }

        return $output;
    }

    private function _spm($label = null)
    {
        $query                                      = null;
        $options                                    = null;
        $output										= null;

		$this->database_config(1);
        // Super Admin, AdminPemeriksa
        if(in_array(get_userdata('group_id'), array(1, 2)))
        {
            $query									= $this->model
                                                    ->select
                                                    ('
                                                        DAFTUNIT.UNITKEY,
                                                        DAFTUNIT.KDLEVEL,
                                                        DAFTUNIT.KDUNIT,
                                                        DAFTUNIT.NMUNIT
			                                        ')
													->order_by('DAFTUNIT.KDUNIT')
													->or_where_in('DAFTUNIT.KDLEVEL', array(3, 4))
                                                    ->get('DAFTUNIT') //, array('DAFTUNIT.KDLEVEL' => (3, 4))
                                                    //->get_where_in('DAFTUNIT', array('DAFTUNIT.KDLEVEL' => (3, 4))
                                                    ->result_array();
            if($query)
            {
                $options							= null;
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['UNITKEY'] . '">' . $val['KDUNIT'] . ' ' . $val['NMUNIT'] . '</option>';
                }
                $output								.= '
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Unit
                                                            </label>
                                                            <select name="unit" class="form-control" data-to-change="spm">
                                                                <option value="">Silakan pilih Unit</option>
                                                                ' . $options . '
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                SPM
                                                            </label>
                                                            <select name="spm" class="form-control report-dropdown" disabled>
                                                                <option value="">Silakan pilih Unit terlebih dahulu</option>
                                                            </select>
                                                        </div>
                                                    ';
            }
        }
        // Grup Sub Unit
        /*elseif(in_array(get_userdata('group_id'), array(7, 8)))
        {
            $query									= $this->model
                                                    ->select('ta__kegiatan_sub.id, ta__kegiatan_sub.kd_keg_sub, ta__kegiatan_sub.kegiatan_sub')
                                                    ->join('ta__kegiatan','ta__kegiatan.id = ta__kegiatan_sub.id_keg')
                                                    ->join('ta__program','ta__kegiatan.id_prog = ta__program.id')
                                                    ->order_by('kd_keg_sub')
                                                    ->get_where('ta__kegiatan_sub', array('ta__kegiatan_sub.id_keg' => $this->_sub_unit))
                                                    ->result_array();

            if($query)
            {
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['id'] . '">' . $val['kd_keg_sub'] . '. ' . $val['kegiatan_sub'] . '</option>';
                }
            }

            $output								    .= '
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Sub Kegiatan
                                                            </label>
                                                            <select name="sub_kegiatan" class="form-control form-control-sm report-dropdown sub_kegiatan" ' . $to_change_label . '>
                                                                <option value="">Silakan pilih Sub Unit</option>
                                                                ' . $options . '
                                                            </select>
                                                        </div>
                                                        ' . ($label ? '
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    ' . $label . '
                                                                </label>
                                                                <br />
                                                                <select name="' . $label . '" class="form-control form-control-sm ' . $label . '" disabled>
                                                                    <option value="">Silakan pilih Sub Kegiatan terlebih dahulu</option>
                                                                </select>
                                                            </div>
                                                        ' : null) . '
                                                    ';
        }*/
        else
        {
            return false;
        }

        return $output;
    }

    private function _dropdown()
    {
        $primary									= service('request')->getPost('value');
        $selector									= service('request')->getPost('selector');
        $suggestions								= array();

        if('tbp' == $selector)
        {
			$this->model->database_config(1);
            $query									= $this->model
                ->select('BPK.NOBPK, BPK.IDXKODE')
                ->order_by('BPK.NOBPK')
                ->get_where('BPK', array('BPK.UNITKEY' => $primary))
                ->result_array();
            if($query)
            {
                foreach($query as $key => $val)
                {
                    $suggestions[]					= array
					(
						'id'						=> $val['NOBPK'],
						'text'						=> $val['NOBPK']
					);
                }
            }
        }
        elseif('spp' == $selector)
        {
			$this->model->database_config(1);
            $query									= $this->model
                ->select('SPP.NOSPP')
                ->order_by('SPP.NOSPP')
                ->get_where('SPP', array('SPP.UNITKEY' => $primary))
                ->result_array();
            if($query)
            {
                foreach($query as $key => $val)
                {
                    $suggestions[]					= array
					(
						'id'						=> $val['NOSPP'],
						'text'						=> $val['NOSPP']
					);
                }
            }
        }
        elseif('spm' == $selector)
        {
			$this->model->database_config(1);
            $query									= $this->model
                ->select('ANTARBYR.NOSPM')
                ->order_by('ANTARBYR.NOSPM')
                ->get_where('ANTARBYR', array('ANTARBYR.UNITKEY' => $primary))
                ->result_array();
            if($query)
            {
                foreach($query as $key => $val)
                {
                    $suggestions[]					= array
					(
						'id'						=> $val['NOSPM'],
						'text'						=> $val['NOSPM']
					);
                }
            }
        }

        make_json
        (
            array
            (
                'suggestions'						=> $suggestions,
                'selector'							=> $selector
            )
        );
    }
	
	private function _period()
	{
		$options									= '
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group mb-3">
						<label class="text-muted d-block">
							First Period
						</label>
						<input type="text" name="start_date" class="form-control bordered" placeholder="Pilih Tanggal" value="01 January ' . date("Y") . '" data-format="dd MM yyyy" role="datepicker" readonly />
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group mb-3">
						<label class="text-muted d-block">
							Last Period
						</label>
						<input type="text" name="end_date" class="form-control bordered" placeholder="Pilih Tanggal" value="' . date('d M Y') . '" data-format="dd MM yyyy" role="datepicker" readonly />
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
							Print Date
						</label>
						<input type="text" name="print-date" class="form-control bordered" placeholder="Pilih Tanggal" value="' . date('d M Y') . '" data-format="dd MM yyyy" role="datepicker" readonly />
					</div>
				</div>
			</div>
		';
		
		return $options;
	}
}
