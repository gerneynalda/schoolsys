
<section class="col-md-6 col-md-offset-3">

	<h2>Edit <span class='muted'>Student</span></h2>

	<?php echo Session::get_flash('success') ? "<div class='alert alert-success'><strong>".Session::get_flash('success')."</strong></div>": "" ?>
	<?php echo Session::get_flash('error') ? "<div class='alert alert-success'><strong>".Session::get_flash('success')."</strong></div>": "" ?>

    <?php echo render('student/_form'); ?>
	<p>
		<?php echo Html::anchor('student/view/'.$student->id, 'View'); ?> |
		<?php echo Html::anchor('student', 'Back'); ?>
	</p>

</section>