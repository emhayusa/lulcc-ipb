<div class="container">
<div class="row m-5">
	<div class="col-3"></div>
	<div class="col-6">
		<div class="card">
			<div class="card-header text-white bg-secondary">
				Forgot Password?
			</div>
			<div class="card-body">
				<?php echo form_open("login/forgot") ?>
					<div class="form-group">  
                     <label>Enter Email</label>  
                     <input type="email" name="email" class="form-control" value="<?php echo $this->session->flashdata("email");?>" />  
                     <span class="text-danger"><?php echo form_error('email'); ?></span>                 
                </div>  
                  <?php echo '<div class="'.$this->session->flashdata("class_forgot").'">'.$this->session->flashdata("message_name_forgot").'</div>';  ?>
                <div class="form-group"> 
                	 <button type="button" class="btn btn-danger" onclick="window.location.href='login'">Batal</button>
                     <button type="submit" class="btn btn-success">Kirim Link Reset Password</button>
	            </div>  				
				 <?php echo form_close();?>
			</div>
		</div>
	</div>
</div>

</div>
