<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<!--<link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">-->

<title>Domain Whois Monitor</title>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col">
			<div class="py-5 text-center">
				Filter :
				<a href="<?php echo site_url('Home/index'); ?>">Default</a>
				|
				<a href="<?php echo site_url('Home/index/dan'); ?>">Dan.com</a>
				|
				<a href="<?php echo site_url('Home/index/hugedomains'); ?>">NameBright / HugeDomains</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Domain</th>
							<th>Create Date</th>
							<th>Exp Date</th>
							<th>Status</th>
							<th>Name Servers</th>
							<th>Last Checked</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($domains as $domain) :
							$class = $class_link = '';
							$diff = time() - $domain['expiration_date'];
							$diff = $diff / (24 * 3600);

							$diff_2 = $domain['expiration_date'] - time();
							$diff_2 = $diff_2 / (24 * 3600);

							if (1 == $domain['is_available']) {
								$class = 'table-success';
								$class_link = 'text-dark';
							} else if ($diff >= 7) {
								$class = 'table-danger';
								$class_link = 'text-dark';
							} else if ($diff >= 0) {
								$class = 'table-warning';
								$class_link = 'text-dark';
							} else if ($diff_2 > 0 && $diff_2 <= 7) {
								$class = 'table-primary';
								$class_link = 'text-dark';
							}
						?>
						<tr valign="top" class="<?php echo $class; ?>">
							<td>
								<a href="http://<?php echo $domain['domain_name']; ?>" target="_blank" rel="external nofollow noopener noreferrer" data-toggle="tooltip" data-placement="top" title="<?php echo $domain['domain_id']; ?>" class="<?php echo $class_link; ?> <?php if (0 == $domain['is_available'] && 0 == $domain['expiration_date']) : ?> text-muted<?php endif; ?>"><?php echo $domain['domain_name']; ?></a>
							</td>
							<td>
								<?php if (1 == $domain['is_available']) : ?>
								<span class="badge badge-success">NOT REGISTERED</span>
								<?php else : ?>
								<?php echo date('j F Y', $domain['creation_date']); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php if (1 == $domain['is_available']) : ?>
								<span class="badge badge-success">NOT REGISTERED</span>
								<?php else : ?>
								<?php echo date('j F Y', $domain['expiration_date']); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php if (1 == $domain['is_available']) : ?>
								<span class="badge badge-success">NOT REGISTERED</span>
								<?php else : ?>
								<?php echo nl2br($domain['domain_status']); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php if (1 == $domain['is_available']) : ?>
								<span class="badge badge-success">NOT REGISTERED</span>
								<?php else : ?>
								<?php echo nl2br($domain['nameservers']); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php echo date('r', $domain['last_check']); ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha512-Oy5BruJdE3gP9+LMJ11kC5nErkh3p4Y0GawT1Jrcez4RTDxODf3M/KP3pEsgeOYxWejqy2SPnj+QMpgtvhDciQ==" crossorigin="anonymous"></script>
<script>
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})
</script>
</body>
</html>