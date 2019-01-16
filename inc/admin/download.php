<table>
	<tr>
		<td>City</td>
		<td>Days</td>
		<td>Hours</td>
		<td>Date</td>
		<td>Name</td>
		<td>Phone</td>
		<td>Email</td>
		<td>Donde nos conoció?</td>
		<td>Discount Percentage</td>
		<td>Fraction Price</td>
		<td>Total</td>
		<td>PayU TransaccionId</td>
		<td>PayU Signature</td>
		<td>PayU Response</td>
		<td>PayU Confirm</td>
	</tr>
	<?php
	foreach ($bookings as $key) {
	?>
	<tr>
		<td><?php echo $key->city; ?></td>
		<td><?php echo $key->days; ?></td>
		<td><?php echo $key->hours; ?></td>
		<td><?php echo $key->date; ?></td>
		<td><?php echo $key->name; ?></td>
		<td><?php echo $key->phone; ?></td>
		<td><?php echo $key->email; ?></td>
		<td><?php echo $key->meet; ?></td>
		<td><?php echo $key->discount_percentage; ?></td>
		<td><?php echo $key->fraction_price; ?></td>
		<td><?php echo CURRENCY_SYMBOL . " " . number_format($key->total_price, 2) . " " . CURRENCY; ?></td>
		<td><?php echo $key->transactionid; ?></td>
		<td><?php echo $key->signature; ?></td>
		<td><?php echo $key->response; ?></td>
		<td><?php echo $key->confirm; ?></td>
	</tr>
	<?php
	}
	?>
</table>