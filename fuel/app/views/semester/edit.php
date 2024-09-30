<h2>Editing <span class='muted'>Semester</span></h2>
<br>

<?php echo render('semester/_form'); ?>
<p>
	<?php echo Html::anchor('semester/view/'.$semester->id, 'View'); ?> |
	<?php echo Html::anchor('semester', 'Back'); ?></p>
