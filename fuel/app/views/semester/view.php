<h2>Viewing <span class='muted'>#<?php echo $semester->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $semester->name; ?></p>

<?php echo Html::anchor('semester/edit/'.$semester->id, 'Edit'); ?> |
<?php echo Html::anchor('semester', 'Back'); ?>