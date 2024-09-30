<h2>Viewing <span class='muted'>#<?php echo $subject->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $subject->name; ?></p>

<?php echo Html::anchor('subject/edit/'.$subject->id, 'Edit'); ?> |
<?php echo Html::anchor('subject', 'Back'); ?>