<div class="row">
	<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		<div class="sigin-wrap">
			<?php echo validation_errors(); ?>

			<?php echo form_open(base_url()); ?>
				<div class="form-group">
					<label for="exampleInputEmail1">Email</label>
					<input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-default">Sign in</button>
			</form>
		</div>
	</div>
</div>