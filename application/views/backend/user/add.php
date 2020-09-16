 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        User 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/user">User</a></li>
     <li class="active">Form Add User</li>
 </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/user/insert", array('class' => 'form-horizontal')); ?>   


  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">User Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputFullName" class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="FullName" name="FullName" placeholder="Full Name" value="<?php echo set_value('FullName'); ?>">
                        <span class="text-danger"><?php echo form_error('FullName'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputuserName" class="col-sm-2 control-label">User Name</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="UserName" name="UserName" placeholder="User Name" value="<?php echo set_value('UserName'); ?>">
                        <span class="text-danger"><?php echo form_error('UserName'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="Password" name="Password" placeholder="Password" value="<?php echo set_value('Password'); ?>">
                        <span class="text-danger"><?php echo form_error('Password'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword2" class="col-sm-2 control-label">Re-Type Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="Password2" name="Password2" placeholder="Re-Type Password" value="<?php echo set_value('Password2'); ?>">
                        <span class="text-danger"><?php echo form_error('Password2'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="Email" name="Email" placeholder="Email" value="<?php echo set_value('Email'); ?>">
                        <span class="text-danger"><?php echo form_error('Email'); ?></span>      
                    </div>
                </div>
                
                <div class="form-group ">
                    <label for="selectRole" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10 "> 
                        <?php
                            $roles = array(
                                '' => '- pilih role -',
                            );
                            foreach ($datas as $d) {
                                # code...
                                $roles[$d->id_role] = $d->level;
                            }
                            echo form_dropdown('Role', $roles, set_value('Role'), '
                        <select class="selectbox" id="Role" ');
                        ?>                     
                        <span class="text-danger"><?php echo form_error('Role'); ?></span>      
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>