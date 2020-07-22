<?php namespace App\Controllers;

use App\Models\DomainModel;
use CodeIgniter\Controller;

date_default_timezone_set('Asia/Jakarta');

class Home extends BaseController
{
	public function index($filter = '') {
		$data = [];

		$m_domain = new DomainModel();

		$data['domains'] = $m_domain->getDomains([
			'filter' => $filter
		]);
		//var_dump($data['domains']);

		//print_r($data);

		return view('template', $data);
	}

	//--------------------------------------------------------------------

}
