<h2>Viewing <span class='muted'>#<?php echo $schoolyear->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $schoolyear->name; ?></p>

<?php echo Html::anchor('schoolyear/edit/'.$schoolyear->id, 'Edit'); ?> |
<?php echo Html::anchor('schoolyear', 'Back'); ?>