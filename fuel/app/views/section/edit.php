<h2>Editing <span class='muted'>Section</span></h2>
<br>

<?php echo render('section/_form'); ?>
<p>
	<?php echo Html::anchor('section/view/'.$section->id, 'View'); ?> |
	<?php echo Html::anchor('section', 'Back'); ?></p>
