<h2>Viewing <span class='muted'>#<?php echo $section->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $section->name; ?></p>

<?php echo Html::anchor('section/edit/'.$section->id, 'Edit'); ?> |
<?php echo Html::anchor('section', 'Back'); ?>