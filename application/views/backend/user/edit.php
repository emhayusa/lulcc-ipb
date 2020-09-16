 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        User 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/user">User</a></li>
     <li class="active">Form Edit User</li>
 </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/user/update", array('class' => 'form-horizontal')); ?>
  <input type="hidden" id="id" name="id" value="<?php echo $data->id_user; ?>" />

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
                        <input type="input" class="form-control" id="FullName" name="FullName" placeholder="Full Name" value="<?php echo set_value('FullName', $data->fullname); ?>">
                        <span class="text-danger"><?php echo form_error('FullName'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="Email" name="Email" placeholder="Email" value="<?php echo set_value('Email', $data->email); ?>">
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
                            echo form_dropdown('Role', $roles, set_value('Role', $data->role_id), '
                        <select class="selectbox" id="Role" ');
                        ?>
                     
                        <span class="text-danger"><?php echo form_error('Role'); ?></span>      
                    </div>
                </div>                       

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>