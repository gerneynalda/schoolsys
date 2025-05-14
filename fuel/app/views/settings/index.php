<section class="col-md-4">
     
    <h3>Change Password</h3>
    <?php if(Session::get_flash('error')): ?>
        <div class="alert alert-danger">
            <p><strong><?php echo Session::get_flash('error') ?></strong></p>
        </div>
    <?php endif; ?>
    <?php if(Session::get_flash('success')): ?>
        <div class="alert alert-success">
            <p><strong><?php echo Session::get_flash('success') ?></strong></p>
        </div>
    <?php endif; ?>
    <form action="<?php echo Uri::create('settings/index')?>" method="POST">
        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="text" class="form-control" id="old_password" placeholder="Old Password required" name="old_password">
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="text" class="form-control" id="new_password" placeholder="New Password required" name="new_password">
        </div>
        <div class="form-group">
            <label for="reenter_password">Re-enter Password</label>
            <input type="text" class="form-control" id="reenter_password" placeholder="Re-enter Password requried" name="reenter_password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</section>