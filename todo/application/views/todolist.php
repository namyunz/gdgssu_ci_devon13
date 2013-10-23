<link href="/MAMP/todo/application/views/todolist.css" rel="stylesheet">

<div class="row">
	<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		<div class="control-wrap">
			<?php echo anchor('/member/signout/','Sign Out',array('type'=>'button','class'=>'btn btn-danger btn-block')); ?>
		</div>

		<div class="list-wrap">
			<ul class="list-group">
				<?php foreach ($list as $element): ?>
				<li class="list-group-item">
					<h4 class="list-group-item-heading"><?php echo $element['contents']; ?></h4>
					<p class="list-group-item-text"><?php echo $element['date']; ?></p>
					<?php 
						if(!$element['is_done'])
						{
							echo anchor('/lists/done/'.$this->uri->segment(3).'/'.$element['todo_id'],'Done',array('type'=>'button','class'=>'btn btn-info btn-sm'));
						}
					?>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
		<div class="add-wrap">
			<?php echo validation_errors(); ?>

			<?php echo form_open('/lists/addTodo/'.$this->uri->segment(3)); ?>
				<div class="form-group">
					<input type="text" class="form-control" id="contents" name="contents" placeholder="Enter Text">
				</div>
				<button type="submit" class="btn btn-default">Add</button>
			</form>
		</div>
	</div>
</div>