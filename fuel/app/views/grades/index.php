<table class="table table-bordered table-grades" id="subject-grades-table">
    <thead>
        <tr id="table-subjects-row"></tr>
    </thead>
    <tbody id="table-students-grade-row"></tbody>
</table>

<div class="loader-wrapper" id="loader" style="display:none;">
<?php echo Asset::img("loader.gif", ["class"=>"loader", "alt"=>"loader image"]) ?>
</div>

<!-- Download Dialog -->
<div class="modal" tabindex="-1" role="dialog" id="download-dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Download Report Card</h4>
			</div>
			<div class="modal-body" id="download-dialog-ui">
				<!--  -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="close-download-dialog-modal">Close</button>
				<button type="button" class="btn btn-primary" id="save-reportcard-template"><i class="fa-solid fa-save"></i> Save</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->