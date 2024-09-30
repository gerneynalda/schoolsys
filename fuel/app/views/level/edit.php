<h2>Editing <span class='muted'>Level</span></h2>
<br>

<?php echo render('level/_form'); ?>
<p>
	<?php echo Html::anchor('level/view/'.$level->id, 'View'); ?> |
	<?php echo Html::anchor('level', 'Back'); ?></p>
