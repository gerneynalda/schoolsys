<section class="col-md-12">
	<?php if ($students): ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr style="background:green; color:white;">
					<!-- <th style="width:80px;"></th> -->
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
					<!-- <td class="student-photo">
						<?php //echo Asset::img("default_01.jpg"); ?>
					</td> -->
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
								<?php //echo Html::anchor('student/view/'.$student->id, '<i class="fa-solid fa-eye"></i>', array('class' => 'btn btn-default btn-sm', 'target'=>"_blank")); ?>
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