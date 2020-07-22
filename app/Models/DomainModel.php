<?php namespace App\Models;

use CodeIgniter\Model;

class DomainModel extends Model
{
	protected $table = 'domains';

	public function getDomains($options = []) {
		$options['filter'] = trim(strtolower($options['filter']));

		$db = \Config\Database::connect();

		$data = [];

		if ('' == $options['filter']) {
			$query   = $db->query('SELECT * FROM domains WHERE is_available = 1 AND last_check > 0 ORDER BY domain_name ASC LIMIT 100');
			$results = $query->getResultArray();

			foreach ($results as $r) {
				ksort($r);
				$data[] = $r;
			}

			$query   = $db->query('SELECT * FROM domains WHERE is_available = 0 AND last_check > 0 ORDER BY expiration_date ASC, last_check ASC, domain_id ASC LIMIT 100');
			$results = $query->getResultArray();

			foreach ($results as $r) {
				ksort($r);
				$data[] = $r;
			}
		} else if ('dan' == $options['filter']) {
			$query   = $db->query("SELECT * FROM domains WHERE nameservers LIKE '%dan.com%' OR nameservers LIKE '%undeveloped%' ORDER BY domain_name ASC");
			$results = $query->getResultArray();

			foreach ($results as $r) {
				ksort($r);
				$data[] = $r;
			}
		} else if ('hugedomains' == $options['filter']) {
			$query   = $db->query("SELECT * FROM domains WHERE nameservers LIKE '%bright%' OR nameservers LIKE '%hugedomains%' ORDER BY domain_name ASC");
			$results = $query->getResultArray();

			foreach ($results as $r) {
				ksort($r);
				$data[] = $r;
			}
		}

		return $data;
	}

	public function get_for_cron($options = []) {
		if (!isset($options['filter'])) {
			$options['filter'] = '';
		}

		if (!isset($options['limit'])) {
			$options['limit'] = 3;
		}

		$now = time();
		$time_limit = $now - (3600 * 24);

		$db = \Config\Database::connect();

		$q = 'SELECT * FROM domains WHERE ';

		if ('expired' == $options['filter']) {
			$q .= ' expiration_date <= '.time().' AND ';
			$q .= ' last_check <=  '.$time_limit;
		} else if ('new' == $options['filter']) {
			$q .= ' last_check = 0 ';
		} else {
			$q .= ' last_check <= '.$time_limit.' ';
		}

		$q .= ' ORDER BY last_check ASC, domain_id ASC ';

		if (false !== $options['limit']) {
			$q .= ' LIMIT '.intval($options['limit']);
		}

		$query   = $db->query($q);

		$results = $query->getResultArray();

		$data = [];

		foreach ($results as $r) {
			$data[] = $r;
		}

		return $data;
	}

	public function reset_stuck_domains() {
		$db = \Config\Database::connect();

		$q = "UPDATE domains SET last_check = 0 WHERE is_available = 0 AND expiration_date = 0 AND last_check > 0";

		$query = $db->query($q);

		return true;
	}

	public function try_insert($domain_name) {
		$domain_name = trim($domain_name);
		if ('' == $domain_name) {
			return false;
		}

		$db = \Config\Database::connect();

		$domain_name = strtolower($db->escapeString($domain_name));

		$q = "SELECT COUNT(*) as x_count FROM domains WHERE LOWER(domain_name) = '$domain_name' LIMIT 1";
		//var_dump($q);

		$query = $db->query($q);

		$r = $query->getRowArray();

		if (intval($r['x_count']) > 0) {
			return false;
		}

		$builder = $db->table($this->table);

		$data = [
			'domain_name' => $domain_name
		];

		$builder->insert($data);

		return true;
	}

	public function update_domain($id, $data = []) {
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);

		if (!is_array($data)) {
			$data = [];
		}

		$data['last_check'] = time();

		$builder->where('domain_id', intval($id));
		$builder->update($data);

		return true;
	}
}