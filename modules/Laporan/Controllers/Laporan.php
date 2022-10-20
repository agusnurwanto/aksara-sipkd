<?php
namespace Modules\Laporan\Controllers;

class Laporan extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
	}
	
	public function index()
	{
		$this->set_title('Laporan')
		->set_icon('mdi mdi-chart-areaspline')
		
		->render();
	}
}
