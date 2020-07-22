<?php namespace App\Controllers;

use App\Models\DomainModel;
use CodeIgniter\Controller;
use Iodev\Whois\Factory;

class Cron extends BaseController
{
	public function update_domains($filter = '') {
		set_time_limit(0);
		ignore_user_abort(true);

		$data = [];

		$m_domain = new DomainModel();

		$data['domains'] = $m_domain->get_for_cron([
			'filter' => $filter
		]);

		//var_dump($data['domains']);

		if ([] == $data['domains']) {
			echo 'All are processed.';
			return true;
		}

		echo '<head>';
		echo '<meta http-equiv="refresh" content="'.mt_rand(10, 20).'">';
		echo '</head>';

		echo 'Start...';
		echo '<ol>';

		$whois = Factory::get()->createWhois();

		foreach ($data['domains'] as $d) {
			echo '<li>#'.$d['domain_id'].' - '.$d['domain_name'].' - ';

			if ($whois->isDomainAvailable($d['domain_name'])) {
				$m_domain->update_domain($d['domain_id'], [
					'is_available' => 1
				]);
			} else {
				$info = $whois->loadDomainInfo($d['domain_name']);

				//echo '<pre>';var_dump($info);echo '</pre>';

				$m_domain->update_domain($d['domain_id'], [
					'is_available' => 0,
					'registrar' => $info->registrar,
					'nameservers' => implode("\r\n", $info->nameServers),
					'domain_status' => implode("\r\n", $info->states),
					'creation_date' => $info->creationDate,
					'expiration_date' => $info->expirationDate
				]);
			}

			echo '...done</li>';

			if (count($data['domains']) > 1) {
				sleep(1);
			}
		}
		echo '</ol>';

		$data['domains'] = $m_domain->get_for_cron([
			'filter' => $filter,
			'limit' => false
		]);

		echo 'All done, '.count($data['domains']).' left.';
	}

	//--------------------------------------------------------------------

}
