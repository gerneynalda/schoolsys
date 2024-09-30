<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Level id', 'level_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('level_id', Input::post('level_id', isset($class) ? $class->level_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Level id')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Section id', 'section_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('section_id', Input::post('section_id', isset($class) ? $class->section_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Section id')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>