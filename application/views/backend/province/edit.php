 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Province 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/province">Province</a></li>
       <li class="active">Form Edit Province</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/province/update", array('class' => 'form-horizontal')); ?>
  <input type="hidden" id="id" name="id" value="<?php echo $data->id_provinsi; ?>" />

  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">Province Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputProvinceName" class="col-sm-2 control-label">Province Name</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="ProvinceName" name="ProvinceName" placeholder="Province Name" value="<?php echo set_value('ProvinceName', $data->nama_provinsi); ?>">
                        <span class="text-danger"><?php echo form_error('ProvinceName'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputProvinceCode" class="col-sm-2 control-label">Province Code</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="ProvinceCode" name="ProvinceCode" placeholder="Province Code" value="<?php echo set_value('ProvinceCode', $data->id_provinsi); ?>">
                        <span class="text-danger"><?php echo form_error('ProvinceCode'); ?></span>      
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