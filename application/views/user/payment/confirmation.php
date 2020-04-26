<?php $this->load->view('lms/default-app/_layouts/header'); ?>

<?php $this->load->view('user/_layouts/nav-confirmation'); ?>

<form method="POST" enctype="multipart/form-data">
	<div class="container u-mt-medium">                   
		<div class="row">
			<div class="col-12 col-xl-6 offset-xl-3">    

				<div class="c-card u-p-medium u-mb-small u-text-center">  

					<h3>
						<?php echo $confirmation['title'] ?>
					</h3>

					<div class="c-card u-p-small u-mh-large u-mb-medium">  
						<p>
							Jumlah yang harus dibayar
						</p>

						<h2 class="u-text-bold">
							<?php echo $confirmation['amount'] ?>
						</h2>
					</div>

					<p class="u-h4 u-mb-small">
						Silahkan melakukan pemayaran ke rekening dibawah ini.
					</p>

					<table class="c-table">
						<tbody class="c-table__head">
							<tr class="c-table__row">
								<td class="c-table__cell c-table__cell--head u-text-center" colspan="2">
									<img src="<?php echo base_url('storage/assets/user/img/'.$confirmation['transaction_type'].'.png') ?>" alt="demo123">
								</td>
							</tr>
							<tr class="c-table__row">
								<td class="u-border-right u-pv-xsmall u-ph-small u-text-left">
									Bank
								</td>
								<td class="u-border-right u-pv-xsmall u-ph-small u-text-left">
									<?php echo $confirmation['transaction_type'] ?>
								</td>
							</tr>
							<tr class="c-table__row">
								<td class="u-border-right u-pv-xsmall u-ph-small u-text-left">
									Nomor Rekening
								</td>
								<td class="u-border-right u-pv-xsmall u-ph-small u-text-left">
									<?php echo $confirmation['transaction_account_number'] ?>
								</td>
							</tr>
							<tr class="c-table__row">
								<td class="u-border-right u-pv-xsmall u-ph-small u-text-left">
									Penerima
								</td>
								<td class="u-border-right u-pv-xsmall u-ph-small u-text-left">
									<?php echo $confirmation['transaction_receiver'] ?>
								</td>
							</tr>							
						</tbody>
					</table>

				</div>

				<!-- proof upload -->
				<div class="u-h4 u-mb-small">
					<?php echo $this->lang->line('payment_proof_upload'); ?> 
				</div> 
				<div class="c-card u-p-medium u-mb-small">  

					<div class="u-text-center u-mb-medium">

						<div class="u-mb-small">
							<img style="width:250px" class="file-return" src="<?php echo base_url('storage/assets/user/img/proof-default.jpg') ?>" alt="proof">
						</div>

						<input class="custom-input-file" id="my-file" type="file">
						<label tabindex="0" for="my-file" class="custom-input-file-trigger c-btn c-btn--secondary c-btn--custom">Pilih bukti pembayaran</label>

					</div>	

					<div class="c-field u-mb-small">
						<label class="c-field__label">Nama Pengirim</label>
						<input required="" name="name" class="c-input" type="text" value="">
					</div>				

					<div class="c-field u-mb-small">
						<button class="c-btn c-btn--info c-btn--fullwidth">
							<?php echo $this->lang->line('send'); ?> 
						</button>
					</div>

				</div>

			</div>
		</div>
	</div>

</form>

<?php $this->load->view('lms/default-app/_layouts/footer'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		function disableBack() { window.history.forward() }

		window.onload = disableBack();
		window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
	});
</script>