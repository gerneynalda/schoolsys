<section class="container-fluid school-days-container">
	<div class="col-md-4">
		<!-- school year list -->
		 <div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">School Year List</h3>
			</div>
			<div class="panel-body">
				<div class="list">
					<?php echo isset($schoolyear_list) ? $schoolyear_list : '' ?>
				</div>
			</div>
			<div class="panel-footer">
				<div class="button-groups">
					<button class="btn btn-primary btn-sm"><i class="fa-solid fa-save"></i></button>
				</div>
			</div>
		 </div>
		<!-- month list and input no of days field -->
		 <div class="panel panel-primary" style="flex-grow: 0; height: auto;">
			<div class="panel-heading">
				<h3 class="panel-title">Select Month & Input No. Of Days</h3>
			</div>
			<div class="panel-body" style="padding: 15px;">
				<form action="">
					<div class="form-group">
						<select name="month" id="month-selected" class="form-control">
							<option value="January">January</option>
							<option value="February">February</option>
							<option value="March">March</option>
							<option value="April">April</option>
							<option value="May">May</option>
							<option value="June">June</option>
							<option value="July">July</option>
							<option value="August">August</option>
							<option value="September">September</option>
							<option value="October">October</option>
							<option value="November">November</option>
							<option value="December">December</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="no-of-days">
					</div>
				</form>
			</div>
			<div class="panel-footer">
				<div class="btn-group">
					<button class="btn btn-primary btn-sm" id="add-schooldays-btn"><i class="fa-solid fa-plus"></i></button>
				</div>
			</div>
		 </div>
	</div>
	<div class="col-md-4">
		<!-- school years schooldays per month -->
		<div class="panel panel-primary schoolyear-schooldays">
			<div class="panel-heading">
				<h3 class="panel-title" id="current-selected-schoolyear-name">Select A School Year</h3>
			</div>
			<div class="panel-body">
				<ul class="list-group" id="schoolyears-schooldays">
					<!-- This are the list of school days in this schoolyear in a month. -->
				</ul>
			</div>
			<div class="panel-footer">
				<div class="btn-group">
					<button class="btn btn-primary btn-sm" id="save-schooldays-btn"><i class="fa-solid fa-save"></i></button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<!-- edit no of days of a month in school year -->
	</div>
</section>

<div class="loader-wrapper" id="loader" style="display:none;">
	<?php echo Asset::img("loader.gif", ["class"=>"loader", "alt"=>"loader image"]) ?>
</div>