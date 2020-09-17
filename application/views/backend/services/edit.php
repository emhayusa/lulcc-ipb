 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Services 
    </h1>
    <ol class="breadcrumb">
       <li><a href="backend/dashboard">Home</a></li>
       <li><a href="backend/services">Services</a></li>
       <li class="active">Form Edit Service</li>
   </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/services/update", array('class' => 'form-horizontal')); ?>
  <input type="hidden" id="id" name="id" value="<?php echo $data->id_service; ?>" />
  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">Services Form</div>
                </div>
            </div>
            <div class="panel-body">
                <label for="selectServicesType" class="col-sm-2 control-label">Services Type</label>
                <div class="col-sm-10 "> 
                    <?php
                    $service_type = array(
                        '' => '- pilih type -', 
                        '0' => 'ArcGIS Tile',
                        '1' => 'ArcGIS Mapserver', 
                        '2' => 'OGC', 
                    );                        
                    echo form_dropdown('ServicesType', $service_type, set_value('ServicesType',$data->type), '
                        <select class="selectbox" id="ServicesType" ');
                        ?>
                        <span class="text-danger"><?php echo form_error('ServicesType'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUserRole" class="col-sm-2 control-label">User Role</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="RoleId" name="RoleId" placeholder="Role Id" value="<?php echo set_value('RoleId', $data->role_id); ?>">
                        <span class="text-danger"><?php echo form_error('RoleId'); ?></span>      
                    </div>
                </div>      
                <div class="form-group">
                    <label for="inputServicesName" class="col-sm-2 control-label">Commodity</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="CommodityId" name="CommodityId" placeholder="Commodity Id" value="<?php echo set_value('CommodityId', $data->commodity_id); ?>">
                        <span class="text-danger"><?php echo form_error('CommodityId'); ?></span>      
                    </div>
                </div>    
                <div class="form-group">
                    <label for="inputServicesName" class="col-sm-2 control-label">Services Name</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="ServicesName" name="ServicesName" placeholder="Services Name" value="<?php echo set_value('ServicesName', $data->name); ?>">
                        <span class="text-danger"><?php echo form_error('ServicesName'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputURLServices" class="col-sm-2 control-label">URL Services</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="URLServices" name="URLServices" placeholder="URL Services"  value="<?php echo set_value('URLServices', $data->url); ?>">
                        <span class="text-danger"><?php echo form_error('URLServices'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                        <label for="inputLayer" class="col-sm-2 control-label">Layer</label>
                        <div class="col-sm-10">
                            <input type="input" class="form-control" id="Layer" name="Layer" placeholder="Layer"  value="<?php echo set_value('Layer', $data->layer); ?>">
                            <span class="text-danger"><?php echo form_error('Layer'); ?></span>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="card-title">
                        <div class="title">Metadata</div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="textDefinition" class="col-sm-2 control-label">Definition</label>
                        <div class="col-sm-10">
                            <textarea class="textarea" placeholder="input definition" id="definition" name="definition"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo set_value('definition', $data->definition); ?></textarea>
                            <span class="text-danger"><?php echo form_error('definition'); ?></span>
                        </div>                            
                    </div>
                    <div class="form-group">
                        <label for="inputResolution" class="col-sm-2 control-label">Resolution</label>
                        <div class="col-sm-10">
                            <input type="input" class="form-control" id="Resolution" name="Resolution" placeholder="Resolution"  value="<?php echo set_value('Resolution', $data->resolution); ?>">
                            <span class="text-danger"><?php echo form_error('Resolution'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputCoverage" class="col-sm-2 control-label">Coverage</label>
                        <div class="col-sm-10">
                            <input type="input" class="form-control" id="Coverage" name="Coverage" placeholder="Coverage"  value="<?php echo set_value('Coverage', $data->coverage); ?>">
                            <span class="text-danger"><?php echo form_error('Coverage'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDataSource" class="col-sm-2 control-label">Data Source</label>
                        <div class="col-sm-10">
                            <input type="input" class="form-control" id="DataSource" name="DataSource" placeholder="Data Source"  value="<?php echo set_value('DataSource', $data->data_source); ?>">
                            <span class="text-danger"><?php echo form_error('DataSource'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputYear" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-10">
                            <input type="input" class="form-control" id="Year" name="Year" placeholder="Year"  value="<?php echo set_value('Year', $data->year); ?>">
                            <span class="text-danger"><?php echo form_error('Year'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputFrequency" class="col-sm-2 control-label">Frequency</label>
                        <div class="col-sm-10">
                            <input type="input" class="form-control" id="Frequency" name="Frequency" placeholder="Frequency"  value="<?php echo set_value('Frequency', $data->frequency); ?>">
                            <span class="text-danger"><?php echo form_error('Frequency'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textDefinition" class="col-sm-2 control-label">Limitations (accuracy, data collection method, etc.)</label>
                        <div class="col-sm-10">
                            <textarea class="textarea" placeholder="input Limitation" id="Limitation" name="Limitation"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo set_value('Limitation', $data->limitation); ?></textarea>
                            <span class="text-danger"><?php echo form_error('Limitation'); ?></span>
                        </div>                            
                    </div>                     
                    <div class="form-group">
                        <label for="inputLicense" class="col-sm-2 control-label">License</label>
                        <div class="col-sm-10">
                            <input type="input" class="form-control" id="License" name="License" placeholder="License"  value="<?php echo set_value('License', $data->license); ?>">
                            <span class="text-danger"><?php echo form_error('License'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textCitation" class="col-sm-2 control-label">Citation</label>
                        <div class="col-sm-10">
                            <textarea class="textarea" placeholder="input Citation" id="Citation" name="Citation"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo set_value('Citation', $data->citation); ?></textarea>
                            <span class="text-danger"><?php echo form_error('Citation'); ?></span>
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