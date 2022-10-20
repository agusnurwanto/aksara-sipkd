<?php
namespace Modules\Laporan\Models;

class Anggaran_model extends \Aksara\Laboratory\Model
{
	public function invoice_company($params = array())
	{
        if($params['company'] == "all" || $params['company'] == null)
        {
            $params['company']							= '%';
			$company_query									= NULL;
        }
		else
		{
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
			WHERE
				CAST(ta__invoice.id_company AS VARCHAR) LIKE \'' . $params['company'] . '\'
		')
		->result();
		
		//print_r($this->last_query());exit;
		$output										= array
		(
			'company'								=> $company_query,
			'data'									=> $data_query
		);
		//print_r($output);exit;
		return $output;
	}
}
