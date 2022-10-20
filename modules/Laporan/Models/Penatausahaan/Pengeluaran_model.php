<?php
namespace Modules\Laporan\Models\Penatausahaan;

class Pengeluaran_model extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config(1);
	}
	
    public function tbp($params)
    {
        //print_r($params); exit;
        $data_query									= $this->query
		(
			'BEGIN SET NOCOUNT ON EXEC WSPR_BPK ?, ? END',
			array
			(
                $params['tbp'],
                2
			)
		)
		->result();
        print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query
        );

        return $output;
    }
	
    public function spp($params)
    {
        //print_r($params); exit;
		$spp_query									= $this->select
		('
			SPP.UNITKEY, 
			SPP.NOSPP,
			SPP.IDXKODE,
			BEND.NIP,
		')
		->join('BEND', 'SPP.KEYBEND = BEND.KEYBEND', 'INNER')
		->get_where
		(
			'SPP',
			array
			(
				'SPP.UNITKEY'						=> $params['unit'],
				'SPP.NOSPP'							=> $params['spp']
			), 1
		)
		->row();
        //print_r($spp_query); exit;
        $data_query									= $this->query
		(
			'BEGIN SET NOCOUNT ON EXEC WSPR_SPP77 ?, ?, ?, ? END',
			array
			(
                $spp_query->IDXKODE,
                $spp_query->NOSPP,
                $spp_query->NIP,
                $spp_query->UNITKEY
			)
		)
		->result();
        print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query
        );

        return $output;
    }
	
	public function invoice_company($params = array())
	{
        if($params['company'] == "all" || $params['company'] == null)
        {
            $params['company']							= "'%'";
        }
		
		/*if($params['company'] != 'all')
		{
			$this->where('ta__invoice.id', $params['company']);
			$company_query									= NULL;
			$company_query									= $this->select
			('
				ref__orica.photo, 
				ref__orica.company
			')
			->get_where
			(
				'ref__orica',
				array
				(
					'ref__orica.id'						=> $params['company']
				), 1
			)
			->row();
		}
		else
		{
			$company_query									= NULL;
			WHERE
				CAST(ta__invoice.id_company AS VARCHAR) LIKE ' . $params['company'] . '
		}*/
		
		$data_query									= $this->query
		('
			SELECT
				ta__invoice.date, 
				ref__reseller.reseller, 
				ta__invoice.description, 
				ta__invoice.quantity, 
				ta__invoice.price, 
				ta__invoice.amount, 
				ta__invoice.ppn, 
				ta__invoice.total_amount, 
				ta__invoice.term_of_payment, 
				ta__invoice.invoice_no
			FROM
				ta__invoice
			INNER JOIN ref__reseller ON ta__invoice.id_reseller = ref__reseller.id
		')
		->result();
		
		print_r($this->last_query());exit;
		$output										= array
		(
			//'company'								=> $company_query,
			'data'									=> $data_query
		);
		print_r($output);exit;
		return $output;
	}
}
