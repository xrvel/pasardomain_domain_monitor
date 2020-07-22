<?php namespace App\Controllers;

use App\Models\DomainModel;
use CodeIgniter\Controller;

class Util extends BaseController
{
	public function insert_domains() {
		set_time_limit(0);
		ignore_user_abort(true);

		$file = FCPATH . '..' . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'words.txt';
		$s = file_get_contents($file);
		$a = explode("\n", $s);

		$m_domain = new DomainModel();

		echo 'Started';

		$data = [];

		foreach ($a as $b) {
			$b = trim($b);
			if ('' != $b) {
				if (!in_array($b, $data)) {
					$data[] = $b;
				}
			}
		}

		natcasesort($data);

		file_put_contents($file, implode("\r\n", $data));

		echo '<ol>';
		foreach ($data as $b) {
			$try = $m_domain->try_insert($b.'.com');

			if ($try) {
				echo '<li>';
				echo $b.' : ';
				echo ($try) ? ' inserted':' NOT inserted';
				echo '</li>';
			}
		}
		echo '</ol>';

		echo 'Finished';
	}

	public function reset_stuck_domains() {
		$m_domain = new DomainModel();

		$m_domain->reset_stuck_domains();

		echo 'Finished';
	}

	//--------------------------------------------------------------------

}
