<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Student Information</h3>
	</div>
	<div class="panel-body">
		<?php echo Form::open(); ?>
			<fieldset>

				<div class="form-group">
					<?php echo Form::label('Lrn', 'lrn', array('class'=>'control-label')); ?>
					<?php echo Form::input('lrn', Input::post('lrn', isset($student) ? $student->lrn : ''), array('class' => 'form-control', 'placeholder'=>'Lrn', 'autofocus' => 'autofocus')); ?>
				</div>

				<div class="form-group">
					<?php echo Form::label('Lastname', 'lastname', array('class'=>'control-label')); ?>
					<?php echo Form::input('lastname', Input::post('lastname', isset($student) ? $student->lastname : ''), array('class' => 'form-control', 'placeholder'=>'Lastname')); ?>
				</div>

				<div class="form-group">
					<?php echo Form::label('Firstname', 'firstname', array('class'=>'control-label')); ?>
					<?php echo Form::input('firstname', Input::post('firstname', isset($student) ? $student->firstname : ''), array('class' => 'form-control', 'placeholder'=>'Firstname')); ?>
				</div>

				<div class="form-group">
					<?php echo Form::label('Middlename', 'middlename', array('class'=>'control-label')); ?>
					<?php echo Form::input('middlename', Input::post('middlename', isset($student) ? $student->middlename : ''), array('class' => 'form-control', 'placeholder'=>'Middlename')); ?>
				</div>

				<div class="form-group">
					<?php echo Form::label('Suffix', 'suffix', array('class'=>'control-label')); ?>
					<?php echo Form::input('suffix', Input::post('suffix', isset($student) ? $student->suffix : ''), array('class' => 'form-control', 'placeholder'=>'Suffix')); ?>
				</div>

				<div class="form-group">
					<?php echo Form::label('Gender', 'gender', array('class'=>'control-label')); ?>
					<?php echo Form::input('gender', Input::post('gender', isset($student) ? $student->gender : ''), array('class' => 'form-control', 'placeholder'=>'Gender')); ?>
				</div>

				<div class="form-group">
					<?php echo Form::label('Birthdate', 'birthdate', array('class'=>'control-label')); ?>
					<?php echo Form::input('birthdate', Input::post('birthdate', isset($student) ? $student->birthdate : ''), array('class' => 'form-control', 'placeholder'=>'Birthdate')); ?>
				</div>

				<div class="form-group">
					<?php echo Form::label('Contact No.', 'contact_no', array('class'=>'control-label')); ?>
					<?php echo Form::input('contact_no', Input::post('contact_no', isset($student) ? $student->contact_no : ''), array('class' => 'form-control', 'placeholder'=>'Contact No.')); ?>
				</div>

				<div class="form-group">
					<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>
				</div>

			</fieldset>
		<?php echo Form::close(); ?>
	</div>
</div>