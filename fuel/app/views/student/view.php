<section class="col-md-9 col-md-offset-1 student-details">

	<section class="col-md-3 photo-column">

		<!-- Photo Column -->
		<div class="row">
			<div class="col-md-12">
				<div class="thumbnail">
				<?php echo Asset::img('default.jpg'); ?>
					<div class="caption">
						<p>Awards</p>
						<div class="btn-group">
							<a href="#" class="btn btn-primary btn-sm" role="button"><i class="fa-solid fa-award"></i></a>
							<a href="#" class="btn btn-primary btn-sm" role="button"><i class="fa-solid fa-award"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>

	<section class="col-md-9 details-column">

		<div class="col-md-2">
			<!-- Start of Navigation -->
			<ul class="nav nav-pills nav-stacked" role="tablist" id="information-tags">
				<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa-solid fa-square-caret-right"></i> Personal</a></li>
				<li role="presentation" class=""><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa-solid fa-square-caret-right"></i> Guardian</a></li>
				<li role="presentation" class=""><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa-solid fa-square-caret-right"></i> Medical</a></li>
				<li role="presentation" class=""><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa-solid fa-square-caret-right"></i> Sports</a></li>
			</ul>
			<!-- End Of Navigation -->
		</div>
		<div class="col-md-10">
			<!-- Start Of Panels -->
			<div class="tab-content" id="information-panels">
				<div role="tabpanel" class="tab-pane active show" id="home">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th></th>
								<th>Lastname</th>
								<th>Firstname</th>
								<th>Middlename</th>
								<th>Suffix</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Name</td>
								<td><?php echo $student->lastname; ?></td>
								<td><?php echo $student->firstname; ?></td>
								<td><?php echo $student->middlename; ?></td>
								<td><?php echo $student->suffix; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane" id="profile">Profile`</div>
				<div role="tabpanel" class="tab-pane" id="messages">Messages</div>
				<div role="tabpanel" class="tab-pane" id="settings">Settings</div>
			</div>
			<!-- End Of Panels -->
		</div>

	</section>

</section>
<style>
	#information-tags a {
		pointer-events: none;
	}
	#information-tags li {
		cursor:pointer;
	}
</style>