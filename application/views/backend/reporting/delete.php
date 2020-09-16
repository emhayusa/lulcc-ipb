 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Reporting 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/reporting">Reporting</a></li>
       <li class="active">Form Delete Reporting</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/reporting/remove", array('class' => 'form-horizontal')); ?>
  <input type="hidden" id="id" name="id" value="<?php echo $data->id_reporting; ?>" />
  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">Reporting Delete</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-2">Province</div>
                    <div class="col-sm-10">
                        <?php echo $data->province_id; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Kabupaten</div>
                    <div class="col-sm-10">
                        <?php echo $data->kabupaten_id; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Kecamatan</div>
                    <div class="col-sm-10">
                        <?php echo $data->kecamatan_id; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Forest Gain</div>
                    <div class="col-sm-10">
                        <?php echo $data->forest_gain; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Oil Palm</div>
                    <div class="col-sm-10">
                        <?php echo $data->oil_palm; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Paddy</div>
                    <div class="col-sm-10">
                        <?php echo $data->paddy; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Rubber</div>
                    <div class="col-sm-10">
                        <?php echo $data->rubber; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Coccoa</div>
                    <div class="col-sm-10">
                        <?php echo $data->coccoa; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Coffe</div>
                    <div class="col-sm-10">
                        <?php echo $data->coffe; ?>      
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Others</div>
                    <div class="col-sm-10">
                        <?php echo $data->others; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Forest Loss</div>
                    <div class="col-sm-10">
                        <?php echo $data->forest_loss; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Year</div>
                    <div class="col-sm-10">
                        <?php echo $data->time; ?>
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