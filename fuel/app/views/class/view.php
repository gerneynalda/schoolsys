<h2>Viewing <span class='muted'>#<?php echo $class->id; ?></span></h2>

<p>
	<strong>Level id:</strong>
	<?php echo $class->level_id; ?></p>
<p>
	<strong>Section id:</strong>
	<?php echo $class->section_id; ?></p>

<?php echo Html::anchor('class/edit/'.$class->id, 'Edit'); ?> |
<?php echo Html::anchor('class', 'Back'); ?>