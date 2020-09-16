 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        kabupaten 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/kabupaten">kabupaten</a></li>
       <li class="active">Form Edit kabupaten</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/kabupaten/update", array('class' => 'form-horizontal')); ?>
  <input type="hidden" id="id" name="id" value="<?php echo $data->id_kabupaten; ?>" />

  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">kabupaten Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputKabupatenName" class="col-sm-2 control-label">Kabupaten Name</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="KabupatenName" name="KabupatenName" placeholder="Kabupaten Name" value="<?php echo set_value('KabupatenName', $data->nama_kabupaten); ?>">
                        <span class="text-danger"><?php echo form_error('KabupatenName'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputKabupatenCode" class="col-sm-2 control-label">Kabupaten Code</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="KabupatenCode" name="KabupatenCode" placeholder="Kabupaten Code" value="<?php echo set_value('KabupatenCode', $data->id_kabupaten); ?>">
                        <span class="text-danger"><?php echo form_error('KabupatenCode'); ?></span>      
                    </div>
                </div>    
                <div class="form-group">
                    <label for="inputProvinceCode" class="col-sm-2 control-label">Province</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="ProvinceCode" name="ProvinceCode" placeholder="Province" value="<?php echo set_value('ProvinceCode', $data->id_provinsi); ?>">
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