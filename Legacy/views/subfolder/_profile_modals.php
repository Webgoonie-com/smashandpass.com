<div class="modal fade" id="updateProfilePhotoModal" tabindex="-1" role="dialog" aria-labelledby="updateProfilePhotoModalLabel" aria-hidden="true">
  <div id="profile_photomodal" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" align="center">
        <h5 align="center" class="modal-title" id="verifyEmailCode">Update Your Profile Photo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>        
      </div>
      <div class="modal-body">
            
            <div id="choose_photo_block" class="row justify-content-center">
              <div class="col-sm-12">
             
            
            	<div class="row">
                  <div id="profile_actions_block">
                	<div id="still_upload" name="#dropzone-tab" class="col-sm-6">
                      <p id="images"><i class="fa fa-camera"></i> Upload New Photo </p>
                	</div>
                	<div class="col-sm-6" data-dismiss="modal">
                      <p><i class="fa fa-hand-o-down"></i> Cancel </p>
                	</div>
				  </div>
                </div>

            	<div class="row">
                	<div id="modal_photo_flow" class="col-sm-12">
                   
                   <div class="">
                   <div class="row justify-content-center" align="center">
                   <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
<span class="sr-only">Loading...</span>
					</div>
					</div>

                    </div>
                </div>
            
              </div>	
            </div>
      
        
        	<div id="crop_photo_block" class="row justify-content-center" style="display:none;">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                          <div class="panel-body">
                          
                          
                            <div id="frst_photo_cropper" class="row" style="display:none;">
                                <div class="col-md-4 text-center">
                                    <div id="upload-image"></div>
                                </div>
                                <div id="mid_column4" class="col-md-4 text-center">
                                <div class="row">
                                    <strong>Crop your new uploaded image:</strong>
                                    <button class="btn btn-success cropped_image">Crop Image</button>

                                </div>                                    
                                </div>			
                                <div id="crop-dropzone" class="col-md-4 crop_preview">
                                    <div id="upload-image-i"></div>
                                </div>
                            </div>








							<div id="sec_photo_cropper" class="row" style="display:none;">


                                    <div class="container">
                                             <div class="col-sm-4">
                                    
                                    
                                             
                                                        <div id="demo-basic"></div>
                                             
                                             
                                             
                                             
                                             </div>
                                             <div class="col-sm-4">
                                    			<strong>Crop your selected image:</strong>
                                                <button id="process_blob" class="btn btn-success sec_cropped_image" type="button">Process Blob</button>
                                             </div>
                                    
                                            <div class="col-sm-4 sec_crop_preview">
                                                <div id="sec_upload-image-i"></div>
                                            </div>
                                    
                                    
                                            <div class="col-sm-4">
                                                <div id="sec_upload-image-b"></div>
                                            </div>
                                
                                    </div>                            
                            
                            
                            
                            </div>
                          
                          
                          
                          </div>
                        </div>			
                    </div>

            </div>
            
      
      
      </div>
      <div class="modal-footer" align="center">
        <button id="ii" href="#" data-dismiss="modal" class="btn btn-block btn-lg has-warning"> Close</button>
      </div>
    </div>
  </div>
</div>





<div id="about_memodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div  class="modal-dialog modal-lg" role="document">
    <div class="modal-content">


<div class="modal-content"> 
<div class="modal-header"> 
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> 
	<h4 class="modal-title" id="gridModalLabel">Edit About Me</h4> 
</div> 
    <div class="modal-body">
    <div class="form-group">
    <label>Edit Your About Me About Me:</label>
    <textarea id="edit_thisaboutme" class="form-control"><?php echo $row_user['user_aboutme']; ?></textarea>
    </div>
    </div> 
    <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
        <button id="write_aboutme" type="button" data-dismiss="modal" class="btn btn-primary">Save changes</button> 
    </div> 
</div>

    </div>
  </div>
</div>

