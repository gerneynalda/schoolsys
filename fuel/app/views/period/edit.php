<h2>Editing <span class='muted'>Period</span></h2>
<br>

<?php echo render('period/_form'); ?>
<p>
	<?php echo Html::anchor('period/view/'.$period->id, 'View'); ?> |
	<?php echo Html::anchor('period', 'Back'); ?></p>
