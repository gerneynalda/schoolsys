
<!-- Curriculum and Strand Master List -->
<section class="col-md-3 curriculum-strand-master-list">
	<div class="panel panel-primary curriculum-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Curriculum Master List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="curriculum-list-group">	
				<!-- Curriculum List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="create-curriculum-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="panel panel-primary strand-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Strand Master List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="strand-list-group">	
				<!-- Strand List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="create-strand-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
</section>

<section class="col-md-3 semester-period-master-list">
	<div class="panel panel-primary semester-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Semester Master List</h3>
		</div>
		<div class="list">
			<div class="list-group" id="semester-list-group">	
				<!-- Semester List -->
			</div>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="create-semester-modal-trigger"><i class="fa-solid fa-plus"></i></button>
			</div>
		</div>
	</div>

	<div class="panel panel-primary period-master-list">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Period Master List</h3>
		</div>
		<div class="list">
			<ul class="list-group" id="period-list-group">	
				<!-- Period List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary btn-sm" id="create-period-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
</section>

<!-- Curriculum Subjects -->
<section class="col-md-3 curriculum-content-list" id="curriculum-subject-panel">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title" id="curriculum-label" style="margin-bottom:0;">Select A Curriculum</h3>
		</div>
		<div class="list" >

			<!-- Curriculum subjects -->
			<ul class="list-group" id="curriculum-subjects"></ul>

		</div>
		<div class="panel-footer">
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-primary btn-sm" id="save-subjects-to-curriculum"><i class="fa-solid fa-save"></i></button>
					<button type="button" class="btn btn-primary btn-sm" id="list-subjects-from-curriculum"><i class="fa-solid fa-search"></i></button>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Curriculum Traits -->
<section class="col-md-3 curriculum-trait-content-list" id="curriculum-trait-panel" style="display:none;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title" id="curriculum-label" style="margin-bottom:0;">Select A Curriculum</h3>
		</div>
		<div class="list" >

			<!-- Curriculum traits -->
			<ul class="list-group" id="curriculum-traits"></ul>

		</div>
		<div class="panel-footer">
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-primary btn-sm" id="save-traits-to-curriculum"><i class="fa-solid fa-save"></i></button>
					<button type="button" class="btn btn-primary btn-sm" id="list-traits-from-curriculum"><i class="fa-solid fa-search"></i></button>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Subject Master List -->
<section class="col-md-3 subject-master-list" id="subject-master-list-panel">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Subject Master List</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal">
				<div class="form-group" style="margin:0;">
					<div class="col-md-12" style="padding:0;">
						<input type="text" class="form-control" id="search-subject" placeholder="Search Subject">
					</div>
				</div>
			</form>
		</div>
		<div class="list">
			<ul class="list-group" id="subject-list-group">	
			<!-- Subject List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-primary btn-sm" id="create-subject-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
</section>

<!-- Trait Master List -->
<section class="col-md-3 trait-master-list" id="trait-master-list-panel" style="display:none;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa-solid fa-list"></i> Trait Master List</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal">
				<div class="form-group" style="margin:0;">
					<div class="col-md-12" style="padding:0;">
						<input type="text" class="form-control" id="search-trait" placeholder="Search trait">
					</div>
				</div>
			</form>
		</div>
		<div class="list">
			<ul class="list-group" id="trait-list-group">	
			<!-- Trait List -->
			</ul>
		</div>
		<div class="panel-footer">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-primary btn-sm" id="create-trait-modal-trigger">
					<i class="fa-solid fa-add"></i>
				</button>
			</div>
		</div>
	</div>
</section>

<!-- MODALS -->	
<!-- Create or Edit Curriculum -->
<div class="modal .fade" tabindex="-1" role="dialog" id="curriculum-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Curriculum</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="curriculum-name-input">Name</label>
					<input type="text" class="form-control" id="curriculum-name-input" placeholder="Name" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="curriculum-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-curriculum-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Create or Edit Strand -->
<div class="modal .fade" tabindex="-1" role="dialog" id="strand-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Strand</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="strand-name-input">Name</label>
					<input type="text" class="form-control" id="strand-name-input" placeholder="Name" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="strand-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-strand-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Create or Edit Semester -->
<div class="modal .fade" tabindex="-1" role="dialog" id="semester-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Semester</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="semester-name-input">Name</label>
					<input type="text" class="form-control" id="semester-name-input" placeholder="Name" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="semester-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-semester-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Create or Edit Period -->
<div class="modal .fade" tabindex="-1" role="dialog" id="period-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Period</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="period-name-input">Name</label>
					<input type="text" class="form-control" id="period-name-input" placeholder="Name" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="period-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-period-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

create-subject-modal-trigger

<!-- Create or Edit Subject -->
<div class="modal .fade" tabindex="-1" role="dialog" id="subject-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Subject</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="period-name-input">Name</label>
					<input type="text" class="form-control" id="subject-name-input" placeholder="Name" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="subject-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-subject-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Create or Edit Trait -->
<div class="modal .fade" tabindex="-1" role="dialog" id="trait-create-edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Trait</h4>
      </div>
      <div class="modal-body">
        
			<form>
				<div class="form-group">
					<label for="trait-name-input">Description</label>
					<input type="text" class="form-control" id="trait-name-input" placeholder="Description" autofocus=true />
				</div>
				<button type="button" class="btn btn-primary" id="trait-save-button"><i class="fa-solid fa-save"></i> save</button>
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-trait-modal"><i class="fa-solid fa-times"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->