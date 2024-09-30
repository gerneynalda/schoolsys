
<!-- Level and Section Master List -->
<section class="col-md-3 level-section-master-list">
	<div class="panel panel-primary level-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Level Master List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="level-list-group">	
				<!-- Level List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="create-level-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="panel panel-primary section-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Section Master List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="section-list-group">	
				<!-- Section List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="create-section-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="panel panel-primary teacher-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Teacher Master List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="teacher-list-group">	
				<!-- Teacher List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="create-teacher-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
</section>

<section class="col-md-3 class-schoolyear-master-list">
	<div class="panel panel-primary class-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Class Master List</h3>
		</div>
		<div class="panel-body">
			<form class="form-inline" id="add-class-form">
				<div class="form-group" style="width: 100%;">
					<label class="sr-only" for="class-name-add-class-form">Class Name</label>
					<input type="text" class="form-control" id="class-name-add-class-form" placeholder="Class Name" value="" style="width: 100%;">
				</div>
				<input type="hidden" name="level" id="level-field-add-class-form" value="" />
				<input type="hidden" name="section" id="section-field-add-class-form" value="" />
				<input type="hidden" name="adviser" id="adviser-field-add-class-form" value="" />
			</form>
		</div>
		<div class="list">
			<ul class="list-group" id="class-list-group">	
				<!-- Class List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="save-class-form"><i class="fa-solid fa-save"></i></button>
			</div>
		</div>
	</div>

	<div class="panel panel-primary schoolyear-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> School Year Master List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="schoolyear-list-group">	
				<!-- School Year List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="create-schoolyear-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
</section>

<section class="col-md-3 class-students-list">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title" id="class-students-of-schoolyear" style="margin-bottom:0;">Class: </h3>
			<p class="text-muted" id="class-students-of-schoolyear-adviser" style="margin-bottom:0; color:#fff;">Adviser: <p>
		</div>
		<div class="list">
			<ul class="list-group" id="class-student-list">	
			<!-- Class Students List Of The School Year -->
			</ul>
		</div>
		<div class="panel-footer" id="save-class-students-list">
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-primary btn-sm save-students-to-class"><i class="fa-solid fa-save"></i></button>
					<button type="button" class="btn btn-primary btn-sm list-students-from-class"><i class="fa-solid fa-search"></i></button>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Student Master List -->
<section class="col-md-3 student-master-list">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Student Master List</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal">
				<div class="form-group" style="margin:0;">
					<div class="col-md-12" style="padding:0;">
						<input type="text" class="form-control" id="search-student" placeholder="Search Student">
					</div>
				</div>
			</form>
		</div>
		<div class="list">
			<ul class="list-group" id="student-list-group">	
			<!-- Student List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group">
				<a type="button" class="btn btn-primary btn-sm" href="<?php echo Config::get("base_url")."/student/create" ?>" class="btn btn-primary">
					<i class="fa-solid fa-add"></i>
				</a>
			</div>
		</div>
	</div>
</section>


<!-- MODALS -->	
<!-- Create or Edit Level -->
<div class="modal .fade" tabindex="-1" role="dialog" id="level-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Level</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="level-name-input">Name</label>
					<input type="text" class="form-control" id="level-name-input" placeholder="Name" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="level-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-level-edit-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Create or Edit Section -->
<div class="modal .fade" tabindex="-1" role="dialog" id="section-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Section</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="section-name-input">Name</label>
					<input type="text" class="form-control" id="section-name-input" placeholder="Name" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="section-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-section-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Create or Edit Teacher -->
<div class="modal .fade" tabindex="-1" role="dialog" id="teacher-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Teacher</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="teacher-lastname-input">Lastname</label>
					<input type="text" class="form-control" id="teacher-lastname-input" placeholder="Lastname" autofocus=true />
				</div>
				<div class="form-group">
					<label for="teacher-firstname-input">Firstname</label>
					<input type="text" class="form-control" id="teacher-firstname-input" placeholder="Firstname"/>
				</div>
				<div class="form-group">
					<label for="teacher-middlename-input">Middlename</label>
					<input type="text" class="form-control" id="teacher-middlename-input" placeholder="Middlename"/>
				</div>
				<div class="form-group">
					<label for="teacher-suffix-input">Suffix</label>
					<input type="text" class="form-control" id="teacher-suffix-input" placeholder="Suffix"/>
				</div>
				<button type="button" class="btn btn-primary" id="teacher-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-teacher-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Create or Edit Schoolyear -->
<div class="modal .fade" tabindex="-1" role="dialog" id="schoolyear-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Section</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="schoolyear-name-input">Name</label>
					<input type="text" class="form-control" id="schoolyear-name-input" placeholder="Name" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="schoolyear-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-schoolyear-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- chang class adviser -->
<div class="modal .fade" tabindex="-1" role="dialog" id="class-edit-adviser-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Class Adviser</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="schoolyear-name-input">Select class adviser</label>
					<select class="form-control" id="class-adviser-input">
					</select>
				</div>
				<input type="hidden" name="classid" id="class-id-input" value=""/>
				<button type="button" class="btn btn-primary" id="class-adviser-change-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-class-edit-adviser-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
