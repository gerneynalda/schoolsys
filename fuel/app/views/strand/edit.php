<h2>Editing <span class='muted'>Strand</span></h2>
<br>

<?php echo render('strand/_form'); ?>
<p>
	<?php echo Html::anchor('strand/view/'.$strand->id, 'View'); ?> |
	<?php echo Html::anchor('strand', 'Back'); ?></p>
