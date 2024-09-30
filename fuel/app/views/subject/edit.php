<h2>Editing <span class='muted'>Subject</span></h2>
<br>

<?php echo render('subject/_form'); ?>
<p>
	<?php echo Html::anchor('subject/view/'.$subject->id, 'View'); ?> |
	<?php echo Html::anchor('subject', 'Back'); ?></p>
