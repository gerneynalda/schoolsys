<h2>Viewing <span class='muted'>#<?php echo $level->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $level->name; ?></p>

<?php echo Html::anchor('level/edit/'.$level->id, 'Edit'); ?> |
<?php echo Html::anchor('level', 'Back'); ?>