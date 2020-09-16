 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Reporting 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/reporting">Reporting</a></li>
       <li class="active">Form Add Reporting</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/reporting/insert", array('class' => 'form-horizontal')); ?> 

  <div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">Reporting Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputProvince" class="col-sm-2 control-label">Province</label>
                    <div class="col-sm-10">
                        <!--<input type="input" class="form-control" id="Province" name="Province" placeholder="Province" value="<?php //echo set_value('Province'); ?>">-->
                        <?php
                        $style_provinsi='class="form-control input-sm" id="provinsi_id" name="provinsi_id"  onChange="tampilKabupaten()"';
                        echo form_dropdown('provinsi_id',$provinsi,'',$style_provinsi);
                        ?>
                        <span class="text-danger"><?php echo form_error('provinsi_id'); ?></span>      
                    </div>
                </div>                
                <div class="form-group">
                    <label for="inputKabupaten" class="col-sm-2 control-label">District</label>
                    <div class="col-sm-10">
                        <!--<input type="input" class="form-control" id="Kabupaten" name="Kabupaten" placeholder="Kabupaten" value="<?php //echo set_value('Kabupaten'); ?>">-->
                        <?php
                        $style_kabupaten='class="form-control input-sm" id="kabupaten_id" name="kabupaten_id" onChange="tampilKecamatan()"';
                        echo form_dropdown("kabupaten_id",array('Pilih Kabupaten'=>'- Choose District -'),'',$style_kabupaten);
                        ?>
                        <span class="text-danger"><?php echo form_error('kabupaten_id'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputKecamatan" class="col-sm-2 control-label">Sub District</label>
                    <div class="col-sm-10">
                        <!--<input type="input" class="form-control" id="Kecamatan" name="Kecamatan" placeholder="Kecamatan" value="<?php //echo set_value('Kecamatan'); ?>">-->
                        <?php
                        $style_kecamatan='class="form-control input-sm" id="kecamatan_id" name="kecamatan_id" onChange="tampilKelurahan()"';
                        echo form_dropdown("kecamatan_id",array('Pilih Kecamatan'=>'- Choose Sub District -'),'',$style_kecamatan);
                        ?>
                        <span class="text-danger"><?php echo form_error('kecamatan_id'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputForestGain" class="col-sm-2 control-label">Forest Gain</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="forest_gain" name="forest_gain" placeholder="Forest Gain" value="<?php echo set_value('forest_gain'); ?>">
                        <span class="text-danger"><?php echo form_error('forest_gain'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputOilPalm" class="col-sm-2 control-label">Oil Palm</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="oil_palm" name="oil_palm" placeholder="Oil Palm" value="<?php echo set_value('oil_palm'); ?>">
                        <span class="text-danger"><?php echo form_error('oil_palm'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPaddy" class="col-sm-2 control-label">Paddy</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="Paddy" name="Paddy" placeholder="Paddy" value="<?php echo set_value('Paddy'); ?>">
                        <span class="text-danger"><?php echo form_error('Paddy'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputRubber" class="col-sm-2 control-label">Rubber</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="rubber" name="Rubber" placeholder="Rubber" value="<?php echo set_value('Rubber'); ?>">
                        <span class="text-danger"><?php echo form_error('Rubber'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputCoccoa" class="col-sm-2 control-label">Coccoa</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="coccoa" name="Coccoa" placeholder="Coccoa" value="<?php echo set_value('Coccoa'); ?>">
                        <span class="text-danger"><?php echo form_error('Coccoa'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputCoffe" class="col-sm-2 control-label">Coffe</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="coffe" name="Coffe" placeholder="Coffe" value="<?php echo set_value('Coffe'); ?>">
                        <span class="text-danger"><?php echo form_error('Coffe'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputOthers" class="col-sm-2 control-label">Others</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="Others" name="Others" placeholder="Others" value="<?php echo set_value('Others'); ?>">
                        <span class="text-danger"><?php echo form_error('Others'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputForestLoss" class="col-sm-2 control-label">Forest Loss</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="forest_loss" name="forest_loss" placeholder="forest_loss" value="<?php echo set_value('forest_loss'); ?>">
                        <span class="text-danger"><?php echo form_error('forest_loss'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputYear" class="col-sm-2 control-label">Year</label>
                    <div class='col-sm-10'>
						<input type='text' class="form-control" name="Year" id='datepicker' />
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
<script>
function tampilKabupaten()
 {
	 kdprop = document.getElementById("provinsi_id").value;
	 $.ajax({
		 url:"<?php echo base_url();?>chain/pilih_kabupaten/"+kdprop+"",
		 success: function(response){
		 $("#kabupaten_id").html(response);
		 },
		 dataType:"html"
	 });
	 return false;
 }
 
 function tampilKecamatan()
 {
	 kdkab = document.getElementById("kabupaten_id").value;
	 $.ajax({
		 url:"<?php echo  base_url();?>chain/pilih_kecamatan/"+kdkab+"",
		 success: function(response){
		 $("#kecamatan_id").html(response);
		 },
		 dataType:"html"
	 });
	 return false;
 }
</script>

<script type="text/javascript">
			$(function () {
				$('#datetimepicker').datetimepicker({
					format: 'DD MMMM YYYY HH:mm',
                });
				
				$('#datepicker').datetimepicker({
					format: 'DD/MMMM/YYYY',
				});
				
				$('#timepicker').datetimepicker({
					format: 'HH:mm'
				});
			});
</script>

<?php echo form_close();?>