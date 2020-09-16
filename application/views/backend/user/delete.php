 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        User 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/user">User</a></li>
       <li class="active">Form Delete User</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/user/remove", array('class' => 'form-horizontal')); ?>
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
                    <div class="col-sm-2">Full Name</div>
                    <div class="col-sm-10">
                        <?php echo $data->fullname; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Username</div>
                    <div class="col-sm-10">
                        <?php echo $data->username; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Password</div>
                    <div class="col-sm-10">
                        <?php echo $data->password; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Email</div>
                    <div class="col-sm-10">
                        <?php echo $data->email; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">role</div>
                    <div class="col-sm-10">
                        <?php echo $data->role_id; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<?php echo form_close();?>