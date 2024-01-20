<?php



//buy_modal

//print_r($_POST);




?>


<!-- Modal -->
<div id="buy_modal" class="modal fade modal-lg" role="dialog">
  <div class="modal-dialog" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title"><?php if(!$found_user['user_nickname']){ echo $found_user['user_fname'].' '.$found_user['user_lname']; }else{ echo $found_user['user_nickname']; } ?></h4>
      </div>
      <div id="member_modal_body" class="modal-body">
        
        <div class="row">
        	<div class="col-sm-12" align="center">
            	<img id="modal-pic" src="" class="img-circle" style="width:200px;">
            </div>
        </div>
        <div class="row">
            <div class="content-secondary col-sm-12" style="padding:10px;">
                <div class="col-6 pull-left">
                
                    <h3 id="dsply_purchamount"></h3>
                    
                </div>
                <div class="col-6 pull-right">
                
                    <div id="dsply_purchsebutton"  data-id="" >
                        <button id="buy_player_now" name="" class="btn btn-green btn-md">Buy Now</button>
                    </div>
                    
                </div>
            </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>