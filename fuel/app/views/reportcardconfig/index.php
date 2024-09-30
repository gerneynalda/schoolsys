<!-- Report Card Template, Curriculum, Sheet List -->
<section class="col-md-3 report-card-template-curriculum-sheet-master-list">

	<!-- Report Card Template Master List -->
	<div class="panel panel-primary report-card-template-master-list">
		<div class="panel-heading">
			<h3 class="panel-title">Report Card Template</h3>
		</div>
		<div class="panel-body">
			<form>
				<div class="form-group">
					<input type="text" class="form-control" id="search-report-card-template" placeholder="Search Report Card Template" />
				</div>
			</form>
		</div>
		<div class="list">
			<ul class="list-group" id="report-card-template-list">
			<!-- Report Card Template List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-sm btn-primary" id="report-card-template-modal-trigger" ><i class="fa-solid fa-plus"></i></button>
			</div>
		</div>
	</div>

	<!-- Curriculum Master List -->
	<div class="panel panel-primary curriculum-master-list">
		<div class="panel-heading">
			<h3 class="panel-title">Curriculum List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="curriculum-list">
			<!-- Curriculum List -->
			</ul>
		</div>
		<div class="panel-footer">
			<!-- <div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></button>
			</div> -->
		</div>
	</div>

	<!-- Strand Master List -->
	<div class="panel panel-primary curriculum-master-list">
		<div class="panel-heading">
			<h3 class="panel-title">Strand List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="strand-list">
			<!-- Strand List -->
			</ul>
		</div>
		<div class="panel-footer">
			<!-- <div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></button>
			</div> -->
		</div>
	</div>
	
</section>

<section class="col-md-4 config-options">

	<!-- Sheet List -->
	<div class="panel panel-primary sheet-list">
		<div class="panel-heading">
			<h3 class="panel-title">Sheet List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="sheet-list">
			<!-- Sheet List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-sm btn-primary" id="add-sheet"><i class="fa-solid fa-plus"></i></button>
			</div>
		</div>
	</div>
	
	<!-- configuration -->
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Configuration options</h3>
		</div>
		<div class="panel-body">
			<!-- panel body -->
			<form action="" id="configuration-form">
				<div class="form-group config-type">
					<select name="configuratin-type" id="configuration-type" class="form-control">
						<option value="">Select Configuration Type</option>
						<option value="lrn">LRN</option>
						<option value="name">Student Name</option>
						<option value="adviser">Adviser Name</option>
						<option value="level">Grade Level</option>
						<option value="section">Section</option>
						<option value="schoolyear">School Year</option>
						<option value="track">Track</option>
						<option value="subject">Subject</option>
						<option value="trait">Trait</option>
						<option value="attendance">Attendance</option>
					</select>
				</div>
				<div class="form-group subject-config" style="display:none;">
					<select name="subject-id" id="subject-id" class="form-control">
						<option value="">Select Subject</option>
					</select>
				</div>
				<div class="form-group trait-config" style="display:none;">
					<select name="trait-id" id="trait-id" class="form-control">
						<option value="">Select Trait</option>
						<option value="1">This is a trait 1</option>
						<option value="2">This is a trait 2</option>
						<option value="3">This is a trait 3</option>
					</select>
				</div>
				<div class="form-group semester-config" style="display:none;">
					<select name="semester-id" id="semester-id" class="form-control">
						<option value="">Select Semester</option>
					</select>
				</div>
				<div class="form-group period-config" style="display:none;">
					<select name="period-id" id="period-id" class="form-control">
						<option value="">Select Period</option>
					</select>
				</div>
				<!-- Attendance Options -->
				 <div class="form-group schoolyear-config" style="display:none;">
					<select name="" id="schoolyear-id" class="form-control">
						<option value="">Select School Year</option>
						<?php if(isset($schoolyears)): ?>
							<?php foreach($schoolyears as $schoolyear): ?>
								<option value="<?php echo $schoolyear->id ?>"><?php echo $schoolyear->name ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				 </div>
				<div class="form-group month-config"  style="display:none;">
					<select name="" id="month-id" class="form-control">
						<option value="">Select Month</option>
					</select>
				</div>
				<div class="form-group attendance-type-config" style="display:none;">
					<select name="" id="attendance-type" class="form-control">
						<option value="">Select Attendance Type</option>
						<option value="days_present">Days Present</option>
						<option value="days_tardy">Days Tardy</option>
					</select>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="cell-coordinate" placeholder="cell coordinate" />
				</div>
			</form>
		</div>
		<div class="panel-footer">
			<!-- panel footer -->
			<button class="btn btn-primary btn-sm" id="save-config"><i class="fa-solid fa-save"></i></button>
		</div>
	</div>

</section>

<section class="col-md-5 config-sheet-list">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title" id="configuration-sheet-name">&nbsp;</h3>
		</div>
		<!-- <div class="panel-body"> -->
			<!-- panel-body -->
		<!-- </div> -->
		<div class="list" id="sheet-configurations">
			<!-- list of configurations -->
		</div>
		<div class="panel-footer">
			<!-- panel footer -->
			<button class="btn btn-primary btn-sm" id="save-config-to-database"><i class="fa-solid fa-save"></i> save to db</button>
			<button class="btn btn-primary btn-sm" id="get-config-to-database"><i class="fa-solid fa-database"></i> retrieve config from db</button>
		 	<p class="text-muted"><i class="fa-solid fa-info-circle"></i> List of items on this configurations</p>
		</div>
	</div>
</section>


<!-- MODALS -->
 <!-- Upload Report Card Template Modal -->
<div class="modal report-card-template-modal" tabindex="-1" role="dialog" id="report-card-template-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Upload A Report Card Template</h4>
			</div>
			<div class="modal-body">
				<form action="">
					<input type="file" name="file" id="report-card-template-upload-input">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="close-reportcard-template-modal">Close</button>
				<button type="button" class="btn btn-primary" id="save-reportcard-template"><i class="fa-solid fa-save"></i> Save</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

