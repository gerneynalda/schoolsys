<section class="col-md-2">
	<!-- Search & Filter -->
	 <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Search Students</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<input type="text" class="form-control" name="name" placeholder="Name" />
			</div>
		</div>
		<div class="panel-footer">
			<button class="btn btn-primary btn-md">Find</button>
		</div>
	 </div>
</section>
<section class="col-md-10">
	<?php if ($students): ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr style="background:green; color:white;">
					<th style="width:80px;"></th>
					<th>Lrn</th>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>Suffix</th>
					<th>Gender</th>
					<th>Birthdate</th>
					<th>Contact No.</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($students as $student): ?>		
				<tr>
					<td class="student-photo">
						<?php echo Asset::img("default_01.jpg"); ?>
					</td>
					<td><?php echo $student->lrn; ?></td>
					<td><?php echo $student->lastname; ?></td>
					<td><?php echo $student->firstname; ?></td>
					<td><?php echo $student->middlename; ?></td>
					<td><?php echo $student->suffix; ?></td>
					<td><?php echo $student->gender; ?></td>
					<td><?php echo $student->birthdate; ?></td>
					<td><?php echo $student->contact_no; ?></td>
					<td>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php echo Html::anchor('student/view/'.$student->id, '<i class="fa-solid fa-eye"></i>', array('class' => 'btn btn-default btn-sm', 'target'=>"_blank")); ?>
								<?php echo Html::anchor('student/edit/'.$student->id, '<i class="fa-solid fa-pen-to-square"></i>', array('class' => 'btn btn-default btn-sm')); ?>							
							</div>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	<?php else: ?>

		<div class="alert alert-info text-center">
			<strong>No Students.</strong>
		</div>

	<?php endif; ?>
</section>