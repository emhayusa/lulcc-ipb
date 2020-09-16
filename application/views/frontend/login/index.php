<div class="container">
<div class="row m-5">
    <div class="col-3"></div>
	<div class="col-6">
		<div class="card">
			<div class="card-header text-white bg-secondary">
				Login
			</div>
			<div class="card-body">
				 <?php 
			if($this->session->userdata('status') != "loginuser"){
			?>
				<?php echo form_open("login") ?>
					<div class="form-group">  
                     <label>Enter Username</label>  
                     <input type="text" name="username" class="form-control" value="<?php echo set_value('username'); ?>" />  
                     <span class="text-danger"><?php echo form_error('username'); ?></span>                 
                </div>  
                <div class="form-group">  
                     <label>Enter Password</label>  
                     <input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" />  
                     <span class="text-danger"><?php echo form_error('password'); ?></span>  
                </div>  
                <?php echo '<div class="'.$this->session->flashdata("class").'">'.$this->session->flashdata("message_name").'</div>';  ?>
                <div class="form-group">  
                     <button type="submit" class="btn btn-primary">Login</button>
					 <?php //<span class="fgr">Forgot <a href="login/forgot">password?</a></span> ?>
                </div>  
				<?php 
				echo form_close();
				
			}else{
				echo "Anda sudah logged in.";
			}
			?>
			</div>
		</div>
	</div>
</div>


</div>
