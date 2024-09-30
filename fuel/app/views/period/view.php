<h2>Viewing <span class='muted'>#<?php echo $period->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $period->name; ?></p>

<?php echo Html::anchor('period/edit/'.$period->id, 'Edit'); ?> |
<?php echo Html::anchor('period', 'Back'); ?>