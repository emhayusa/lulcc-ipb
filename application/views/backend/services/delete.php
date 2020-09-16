 <div id="page-wrapper" >
        <div class="header"> 
          <h1 class="page-header">
            Services 
          </h1>
          <ol class="breadcrumb">
           <li><a href="backend/dashboard">Home</a></li>
           <li><a href="backend/services">Services</a></li>
           <li class="active">Form Delete Service</li>
         </ol> 

       </div>

        <div id="page-inner"> 
		<?php echo form_open("backend/services/remove", array('class' => 'form-horizontal')); ?>
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
                            <div class="form-group">
                                <div class="col-sm-2">Services Name</div>
                                <div class="col-sm-10">
                                    <?php echo $data->name; ?>      
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">URL Services</div>
                                <div class="col-sm-10">
                                    <?php echo $data->url; ?>
                                </div>
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
                                <div class="col-sm-2">Definition</div>
                                <div class="col-sm-10">
                                   <?php echo $data->definition; ?>
                                </div>                            
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Resolution</div>
                                <div class="col-sm-10">
                                    <?php echo $data->resolution; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Coverage</div>
                                <div class="col-sm-10">
                                    <?php echo $data->coverage; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Data Source</div>
                                <div class="col-sm-10">
                                    <?php echo $data->data_source; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Year</div>
                                <div class="col-sm-10">
                                   <?php echo $data->year; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Frequency</div>
                                <div class="col-sm-10">
                                    <?php echo $data->frequency; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Accuracy</div>
                                <div class="col-sm-10">
                                    <?php echo $data->accuracy; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Method</div>
                                <div class="col-sm-10">
                                    <?php echo $data->method; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">License</div>
                                <div class="col-sm-10">
                                    <?php echo $data->license; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Citation</div>
                                <div class="col-sm-10">
                                    <?php echo $data->citation; ?>
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
		<?php echo form_close();?>