<?php if ($site['payment_method'] == 'Midtrans'): ?>
	<?php if ($site['payment_midtrans']['status_production'] == 'Yes'): ?>
		<script src="https://app.midtrans.com/snap/snap.js" data-client-key="<?php echo $site['payment_midtrans']['client_key'] ?>"></script>	
	<?php endif ?>
	<?php if ($site['payment_midtrans']['status_production'] == 'No'): ?>	
		<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $site['payment_midtrans']['client_key'] ?>"></script>
	<?php endif ?>
<?php endif ?>
