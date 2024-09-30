<h2>Editing <span class='muted'>Class</span></h2>
<br>

<?php echo render('class/_form'); ?>
<p>
	<?php echo Html::anchor('class/view/'.$class->id, 'View'); ?> |
	<?php echo Html::anchor('class', 'Back'); ?></p>
