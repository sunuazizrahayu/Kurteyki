<?php if (!empty($midtrans) OR $site['payment_method'] == 'Midtrans' AND !empty($site['page_type']) AND $site['page_type'] == 'payment'): ?>
	<?php if ($site['payment_midtrans']['status_production'] == 'Yes'): ?>
		<script src="https://app.midtrans.com/snap/snap.js" data-client-key="<?php echo $site['payment_midtrans']['client_key'] ?>"></script>	
	<?php endif ?>
	<?php if ($site['payment_midtrans']['status_production'] == 'No'): ?>	
		<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $site['payment_midtrans']['client_key'] ?>"></script>
	<?php endif ?>
<?php endif ?>