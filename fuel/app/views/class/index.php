<h2>Listing <span class='muted'>Classes</span></h2>
<br>
<?php if ($classes): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Level id</th>
			<th>Section id</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($classes as $item): ?>		<tr>

			<td><?php echo $item->level_id; ?></td>
			<td><?php echo $item->section_id; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('class/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>						<?php echo Html::anchor('class/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>						<?php echo Html::anchor('class/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>					</div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Classes.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('class/create', 'Add new Class', array('class' => 'btn btn-success')); ?>

</p>
