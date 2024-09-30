<h2>Editing <span class='muted'>Curriculum</span></h2>
<br>

<?php echo render('curriculum/_form'); ?>
<p>
	<?php echo Html::anchor('curriculum/view/'.$curriculum->id, 'View'); ?> |
	<?php echo Html::anchor('curriculum', 'Back'); ?></p>
