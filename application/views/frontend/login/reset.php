<div class="container">
<div class="row m-5">
	<div class="col-3"></div>
	<div class="col-6">
		<div class="card">
			<div class="card-header text-white bg-secondary">
				Reset Password
			</div>
			<div class="card-body">
			
			<?php 
			if(!isset($cek_token)){
			?>
				<?php echo form_open("login/reset/".$token) ?>
					<input type="hidden" name="token" class="form-control" value="<?php echo $token; ?>"/>
					<div class="form-group">  
                     <label>Password</label>  
                     <input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>"/>  
                     <span class="text-danger"><?php echo form_error('password'); ?></span>  
                </div>
                <div class="form-group">  
                     <label>Konfirmasi Password</label>  
                     <input type="password" name="passconf" class="form-control" value="<?php echo set_value('passconf'); ?>"/>  
                     <span class="text-danger"><?php echo form_error('passconf'); ?></span>  
                </div>  
                  <?php echo '<div class="'.$this->session->flashdata("class_forgot").'">'.$this->session->flashdata("message_name_forgot").'</div>';  ?>
                <div class="form-group"> 
                	 <button type="button" class="btn btn-danger" onclick="window.location.href='login'">Batal</button>
                     <button type="submit" class="btn btn-success">Reset Password</button>
	            </div>  				
				 <?php echo form_close();?>
			<?php 
			}else{
			    ?>
			    <div class="alert alert-danger" role="alert">
  				<h4 class="alert-heading">Error</h4>
  				<p>Token invalid or expired!</p>
			<?php 
			}
			?>
			</div>
		</div>
	</div>
</div>

</div>
