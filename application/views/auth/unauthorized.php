<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Unauthorized Access</h1>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="error-page">
			<h2 class="headline text-danger">401</h2>
			<div class="error-content">
				<h3><i class="fas fa-exclamation-triangle text-danger"></i> Unauthorized!</h3>
				<p>
					You do not have permission to access this page.
					Meanwhile, you may <a href="<?= base_url() . 'C_Auth/Logout' ?>">logout</a>.
				</p>
			</div>
		</div>
	</section>
</div>
