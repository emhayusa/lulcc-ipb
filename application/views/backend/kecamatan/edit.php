 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        kecamatan 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/kecamatan">kecamatan</a></li>
       <li class="active">Form Edit kecamatan</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/kecamatan/update", array('class' => 'form-horizontal')); ?>
  <input type="hidden" id="id" name="id" value="<?php echo $data->id_kecamatan; ?>" />

  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">kecamatan Form</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputKecamatanName" class="col-sm-2 control-label">Kecamatan Name</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="KecamatanName" name="KecamatanName" placeholder="Kecamatan Name" value="<?php echo set_value('KecamatanName', $data->nama_kecamatan); ?>">
                        <span class="text-danger"><?php echo form_error('KecamatanName'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputKecamatanCode" class="col-sm-2 control-label">Kecamatan Code</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="KecamatanCode" name="KecamatanCode" placeholder="Kecamatan Code" value="<?php echo set_value('KecamatanCode', $data->id_kecamatan); ?>">
                        <span class="text-danger"><?php echo form_error('KecamatanCode'); ?></span>      
                    </div>
                </div>                  
                <div class="form-group">
                    <label for="inputKabupatenCode" class="col-sm-2 control-label">Kabupaten</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="KabupatenCode" name="KabupatenCode" placeholder="Kabupaten Code" value="<?php echo set_value('KabupatenCode', $data->id_kabupaten); ?>">
                        <span class="text-danger"><?php echo form_error('KabupatenCode'); ?></span>      
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