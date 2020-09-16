 <div id="page-wrapper" >
    <div class="header"> 
      <h1 class="page-header">
        Setting 
    </h1>
    <ol class="breadcrumb">
     <li><a href="backend/dashboard">Home</a></li>
     <li><a href="backend/setting">Setting</a></li>
     <li class="active">Form Setting</li>
 </ol> 

</div>

<div id="page-inner"> 
  <?php echo form_open("backend/setting/insert", array('class' => 'form-horizontal')); ?>   

  <div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="card-title">
                    <div class="title">Setting Form</div>
                </div>
            </div>
            <div class="panel-body">
            <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Logo</th>
                <th>Title</th> 
                <th>Footer</th>
                <th>About</th>
              </tr>
            </thead>
            <tbody>
            <?php $no=0; foreach($datas as $p ): $no++;?>
			<tr class="odd gradeX">
				<td>
                <img src="<?php echo base_url();?>assets/images/<?php echo $p->logo;?>" height="100px" width="100px" >
				</td>	
				<td valign="middle">
				<?php echo $p->title;?>
				</td>
				<td>
				<?php  echo $p->footer;?>
				</td>
                <td>
				<?php  echo $p->about;?>
				</td>
				<td class="center">
				<a href="<?php echo site_url('backend/setting/edit/'.$p->id_setting);?>">
				<i class="fa fa-pencil-square-o"></i>edit</a>
				</td>
			</tr>
		    <?php endforeach;?>


                  </tbody>
                </table>
              </div>                            
            </div>
          </div>
          <!--End Advanced Tables -->
                <!--
                <div class="form-group">
                    <label for="inputTitle" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="Title" name="Title" placeholder="Title" value="<?php //echo set_value('Title'); ?>">
                        <span class="text-danger"><?php //echo form_error('Title'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputFile" class="col-sm-2 control-label">Logo WebGIS</label>
                    <div class="col-sm-7 control-label">
                        <input type="file" id="LogoWebgis" name="LogoWebgis" placeholder="Logo Webgis"  value="<?php //echo set_value('LogoWebgis'); ?>">
                        <span class="text-danger"><?php //echo form_error('LogoWebgis'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="textinfo" class="col-sm-2 control-label">Information</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" id="Information" name="Information" placeholder="input Information" value="<?php //echo set_value('Information'); ?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        <span class="text-danger"><?php //echo form_error('Information'); ?></span>      
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputFooter" class="col-sm-2 control-label">Footer</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="Footer" name="Footer" placeholder="Footer" value="<?php echo set_value('Footer'); ?>">
                        <span class="text-danger"><?php //echo form_error('Footer'); ?></span>      
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
                <!-- END FORM-->

            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>