<h2>Editing <span class='muted'>Schoolyear</span></h2>
<br>

<?php echo render('schoolyear/_form'); ?>
<p>
	<?php echo Html::anchor('schoolyear/view/'.$schoolyear->id, 'View'); ?> |
	<?php echo Html::anchor('schoolyear', 'Back'); ?></p>
