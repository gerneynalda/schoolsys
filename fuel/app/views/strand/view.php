<h2>Viewing <span class='muted'>#<?php echo $strand->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $strand->name; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $strand->description; ?></p>

<?php echo Html::anchor('strand/edit/'.$strand->id, 'Edit'); ?> |
<?php echo Html::anchor('strand', 'Back'); ?>