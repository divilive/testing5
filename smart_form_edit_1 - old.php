<?php
// pre($item_flow_array);
// echo "edit list";
// pre($edit_quick_list);
// echo "form list";
/*pre($form_layout);
exit();*/
// echo logged_in_role_id();
// echo $permisson;
// echo $edit_quick_list[0]['form_id'];
/*$this->db->select('item_status');
$this->db->from('process_flow_notification');
$this->db->where('sup_id',$sup_id);
$this->db->where('requestor_role_id',10);
$this->db->order_by('id','desc');
$query = $this->db->get(); 
$result_array = $query->result_array();
echo count($result_array);
echo in_array(array('item_status' => 'Pending'),$result_array);*/
/*$getResult = get_item_status($sup_id);
$checkItemStatusCompleted = in_array(array('item_status' => 'Completed'),$getResult);
$checkItemStatusRejected = in_array(array('item_status' => 'Rejected'),$getResult);
if(count($getResult) > 0){
	if($checkItemStatusCompleted >0 || $checkItemStatusRejected >0){
		$myStatus = 1;
	}
	else{
		if($original_value != ''){
			$myStatus = 1;
		}
	}
}
else{
	if($original_value != ''){
		$myStatus = 1;
	}
}
echo count($getResult);
echo '<br>';
echo $checkItemStatusCompleted;
echo '<br>';
echo $checkItemStatusRejected;
echo '<br>';
echo $myStatus;
echo '<br>';*/

if($this->session->userdata('exist_supplier_data')) {
	$suppliers_info = $this->session->userdata['exist_supplier_data'];
}else{
	$suppliers_info = '';
}
$item_flow_new=array();
// pre($item_flow_array);
// exit;
foreach ($item_flow_array as $if_key => $if_value) {
	$item_flow_status = $if_value['item_status'];
	$item_flow_request_on = $if_value['requested_on'];
	$item_flow_role_id = $if_value['requestor_role_id'];
	$item_receiver_user_id = $if_value['receiver_user_id'];
	$item_modified_on = $if_value['modified_on'];
	$item_process_seq = $if_value['process_seq'];
	$item_flow_role_name = get_role_name($item_flow_role_id);
	$item_flow_role = $item_flow_role_name->name;
	$item_flow_role_id = $item_flow_role_name->id;
	$res_array = get_user_id($sup_id);
	$item_user_name = get_user_name($item_receiver_user_id);
	$itemUserName = isset($item_user_name->name) ? $item_user_name->name : "";
	$item_flow_new[$if_value['process_seq']][$if_value['id']]['item_status']=$item_flow_status;
	$item_flow_new[$if_value['process_seq']][$if_value['id']]['requested_on']=$item_flow_request_on;
	$item_flow_new[$if_value['process_seq']][$if_value['id']]['requestor_role']=$item_flow_role;
	$item_flow_new[$if_value['process_seq']][$if_value['id']]['requestor_role_id']=$item_flow_role_id;
	$item_flow_new[$if_value['process_seq']][$if_value['id']]['receiver_user']=$itemUserName;
	$item_flow_new[$if_value['process_seq']][$if_value['id']]['modified_on']=$item_modified_on;
	$item_flow_new[$if_value['process_seq']][$if_value['id']]['requestor_seq']=$item_process_seq;
}

// pre($item_flow_new);
// exit;
if(isset($edit_quick_list[0]['form_id']) && $edit_quick_list[0]['form_id'] != ""){
	$original_form_id = $edit_quick_list[0]['form_id'];
}
else{
	$original_form_id = '';
}
if(isset($edit_quick_list[0]['status']) && $edit_quick_list[0]['status'] != ""){
	$original_status = $edit_quick_list[0]['status'];
}
else{
	$original_status = 'Pending';
}
$getstatus=item_default_status($original_status);
// echo $original_form_id ;
// echo $original_status;
// if(isset($reject_comment) && $reject_comment != ""){
// 	$reject_comment = trim($reject_comment);
// }
// else{
// 	$reject_comment = '';
// }

if(isset($edit_quick_list[0]['reject_comment']) && $edit_quick_list[0]['reject_comment'] != ""){
	$reject_comment = strtoupper($edit_quick_list[0]['reject_comment']);
}
else{
	$reject_comment = '';
}
// exit();
// echo $reject_comment;
// exit();
$created_by = isset($edit_quick_list[0]['created_by']) ? $edit_quick_list[0]['created_by']  : '';

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
$user_id = logged_in_user_id();

$current_user_name=get_user_name($user_id);
$current_user_name=$current_user_name->name; 

$consolidate_id='';
$get_suplier_master=get_suplier_master($sup_id);
$sup_alei=$get_suplier_master->alei;
$get_request_status=$get_suplier_master->status;


?>
<style>
.container {
    max-width: 1330px !important;
}
.form_group_text {
    /*margin: 1em 0 0.5em 0;*/
    font-weight: bold;
   /* position: relative;
    text-shadow: 0 -1px rgba(0,0,0,0.6);*/
    /*font-size: 19px;
    line-height: 25px;
    background: #1a6aa2;*/
    font-size: 16px;
    line-height: 20px;
    /*background: #056379;*/
    /*background: #355681;
    background: rgb(54, 152, 230);*/
   background: linear-gradient(40deg, #1385d0, #0b2771) !important;
    border: 1px solid #fff;
    padding: 5px 15px;
    color: white;
    border-radius: 0 10px 0 10px;
    box-shadow: inset 0 0 5px rgba(53,86,129, 0.5);
   /* font-family: 'Muli', sans-serif;*/
}
.form_group_text_comments{
	width: 100%;
    font-weight: normal;
    font-size: 16px;
    line-height: 20px;
    background: #2f9cf3e0;
    border: 1px solid #fff;
    padding: 5px 15px;
    color: white;
    border-radius: 0 10px 0 10px;
    box-shadow: inset 0 0 5px rgba(53,86,129, 0.5);
}
/*body{
    	/* background: #1ea0bf; 
    	background: linear-gradient(40deg, #186476, #1baed1) !important;
    }*/
.card{
	margin-bottom: 0px !important;
}
/*.wizard>.steps>ul>li.done .number:after {
    display: inline-block;
    font-size: 1rem;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    transition: all ease-in-out .15s;
}*/
.wizard>.steps>ul>li.done .number {
    content: "" !important;
    display: inline-block;
    font-size: 1rem;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    transition: all ease-in-out .15s;
}
.flow_icon_font{
	font-size: 12px !important;
}
.display_flex{    
	display: flex !important;
}  
 .popover{
    max-width:600px !important;
    max-height:650px;    
 }
 .pop-table tr th{
	padding:5px !important;
	border:1px solid #dedada;
	background:#f1f1f1;
 }.pop-table tr td{
	padding:5px !important;
	border:1px solid #dedada;
 }
 .popover-body {
    max-height: 150px;
    overflow-y: scroll;
}
.popover-body::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

.popover-body::-webkit-scrollbar
{
	width: 5px;
	background-color: #F5F5F5;
}

.popover-body::-webkit-scrollbar-thumb
{
	background-color: #9e9e9e;
	border: 2px solid #9e9e9e;
}
</style>
<?php 


					$card_title = ""; 
					$comment_field = "readonly";
					/*echo $original_status;*/
					$role_id = logged_in_role_id();
					$UserId = logged_in_user_id();
					/*echo $created_by;*/
					$Editable = '';
					$tempEditable = '';
					if(($created_by == $UserId && $original_status == 'Rejected') || ($role_id == 10 && $permisson == 'Yes')){
						$Editable = 'js-example-basic-single';
						$tempEditable = 'js-example-basic-single';
					}
					if($Editable !=''){
						$comment_field = '';	
					}
					$form_details=get_form_details($original_form_id);
					$card_title=$form_details->form_name;
					$button_title=$form_details->button_name;

					$parallel=$form_details->is_parallel;
					$this_form_id=$original_form_id;

					// if($original_form_id == 5){ $card_title = "Quick Add (Ariba) Form"; }
					// else if($original_form_id == 6){ $card_title = "Payment Term Change Form"; 
					// if($original_status == 'Rejected' || $original_status == 'Pending'){ /*$comment_field = '';*/} }
					// else if($original_form_id == 7){ $card_title = "Deactivate Supplier Form"; 
					// if($original_status == 'Rejected' || $original_status == 'Pending'){ /*$comment_field = '';*/} }
					// else if($original_form_id == 8){ $card_title = "Close Supplier for PO Form"; 
					// if($original_status == 'Rejected' || $original_status == 'Pending'){ /*$comment_field = '';*/} }
					$current_sup_supplier_status=get_supplier_status($sup_id);	
					?>
<div class="page-content container">
	<div class="content-wrapper">
		<!-- <center><div class="mb-3" style="margin-top: 5px;color:#fff;"><h1 class="mb-0 font-weight-light"><i class="icon-reading icon-2x"></i><?php echo " $card_title";?></h1></div></center> -->
		<div class="content">
			<div class="card" style="background: #fafafb;border: 3px solid #c79238;margin-bottom: 0px !important;">
			<?php
				$get_approver_flag=get_approver_flag($sup_id);
				if(count($get_approver_flag)>0){
					$flag_comment=strtoupper($get_approver_flag['flag']);
					$flag_approver_name=strtoupper($get_approver_flag['approver_name']);
					$flag_role_name=$get_approver_flag['role_name'];
					$flag_updated_at=$get_approver_flag['updated_at'];
				
			?>
			<div class="border-start border-start-width-3 border-start-primary rounded-end p-3" style="margin:10px;border-left: 5px solid red;background:#ffeceb61">
					<blockquote class="blockquote d-flex mb-0">
					
						
						<!--div class="col-md-1" style="line-height:4;">
						<i class="icon-flag3 me-3 icon-3x text-danger" style="text-shadow: 1px 1px 1px #000,3px 3px 5px #ffeceb; "></i>
						</div-->
						<div class="me-3" style="padding:10px;">
							<span class="btn bg-danger rounded-round btn-icon btn-sm">
								<i class="icon-flag3"></i> 
							</span>
						</div>
						<div style="font-size:12px;text-align: left;"><b><?php echo htmlspecialchars(strip_tags($flag_comment));?></b>
							<footer class="blockquote-footer mb-0" style="font-size:11px;color: red;"><?php echo $flag_approver_name;?> <cite title="Source Title">(<?php echo $flag_role_name;?>)</cite><div class="fs-sm mt-1" style="font-size:10px;color:#333;"><?php echo $flag_updated_at;?></div></footer>
							
						</div>
					</blockquote>
				</div>
				<?php } ?>
				<div class="card-header header-elements-sm-inline	">
					<h5 class="card-title"><strong><i class="icon-reading icon-2x"></i><?php echo " $card_title";?></strong></h5>
					<!-- <h2 class="mb-0 font-weight-light card-title"><i class="icon-reading icon-2x"></i><?php echo " $card_title";?></h2> -->
					<div class="header-elements">
						<!-- <div class="list-icons"> -->
							
	                		<?php
						
	                		echo '<div class="pr-1 text-center pb-1"><span class="badge bg-info-400"><b class="font-size-lg">Request ID :'.$sup_id.'</b></span><br></div>';
	                		// echo $permisson;
	                		
	                		$display_label_name=$form_details->label_display;
							$getstatus=item_default_status($original_status);
						    $label_color=$getstatus->color;
							//$to_role_id=get_to_role_id($original_form_id,$role_id,"Completed",$sup_id);
						  	$max_role_id=get_max_role_id($original_form_id,$sup_id);


	                		//if($permisson == 'Yes'){	

	 					// 		if($role_id==1){
	 					// 			if($original_form_id == 6 || $original_form_id == 7 || $original_form_id == 8 ){
	 					// 				if($original_form_id == 6){ $viewName = "ERP"; }
	 					// 				else if($original_form_id == 7 || $original_form_id == 8){ $viewName = "TS"; }
		 				// 				if($original_status == 'Rejected'){
		 				// 					$getstatus=item_default_status($original_status);
							// 	            $label_color=$getstatus->color;
			 			// 					/*echo '<button type="button" name="update_btn" id="update_btn" class="btn btn-primary">Update<i class="icon-paperplane ml-2"></i></button>';*/
			 			// 					echo '<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$original_status.'</b></span>';
		 				// 				}
		 				// 				else{
		 				// 					$getstatus=item_default_status($original_status);
							// 	            $label_color=$getstatus->color;
							// 	            if($original_status == 'Completed'){
				   //              				$Display_status = 'Request has been uploaded to '.$viewName.'';
				   //              			}
			 			// 					else if($original_status == 'Pending'){
				   //              				$Display_status = 'Request sent for '.$viewName.' upload';
				   //              			}
				   //              			else{
				   //              				$Display_status = $original_status;	
				   //              			}
			 			// 					echo '<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_status.'</b></span>';
		 				// 				}
	 					// 			}
	 					// 			else{
		 				// 				$getstatus=item_default_status($original_status);
							//             $label_color=$getstatus->color;
							//             if($original_status == 'Completed'){
				   //              				$Display_status = 'Request has been uploaded to Ariba';
				   //              			}
			 			// 					else if($original_status == 'Pending'){
				   //              				$Display_status = 'Request sent for Ariba upload';
				   //              			}
				   //              			else{
				   //              				$Display_status = $original_status;	
				   //              			}
		 				// 				echo '<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_status.'</b></span>';
	 					// 			}

	 					// 		}	
							// }
	      //           		if($permisson=="No"){
						  	// echo $original_status;
							
							$get_form_label_name=get_form_label_name($sup_id);
						     if($max_role_id<>$role_id){
	                			if($original_status == 'Rejected'){
							    	$Display_label_status = 'Request has been rejected';
	 								$label_button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
 								}else if($original_status == 'Completed'){
			                		//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
			                		$Display_label_status = 'Request Completed';
			                		$label_button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
			                	}else if($original_status == 'Closed'){
			                		//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
			                		$Display_label_status = 'Request Closed';
			                		$label_button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
			                	}else{
			                		$Display_label_status = 'Request Pending at '.$get_form_label_name;
			                		$label_button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
			                	}
								
	                		//}
	                			echo '<div class="pr-1 text-center pb-1">'.$label_button_display.'</div>';
	                		}else{
	                			if($original_status == 'Rejected'){
							    	$Display_label_status = 'Request has been rejected';
	 								$label_button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
 								}else if($original_status == 'Completed'){
			                		//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
			                		$Display_label_status = 'Request Completed';
			                		$label_button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
			                	}else if($original_status == 'Closed'){
			                		//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
			                		$Display_label_status = 'Request Closed';
			                		$label_button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
			                	}else{
			                		$Display_label_status = '';
			                		$label_button_display='';
			                	}
			                	echo '<div class="pr-1 text-center pb-1">'.$label_button_display.'</div>';
	                		}
	                		?>
	                	<!-- </div> -->
                	</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 pb-0">
							<span class="wizard-form steps-basic wizard clearfix mt-0" action="#" data-fouc="" role="application" id="steps-uid-0">
							   <div class="steps clearfix">
							   	<ul role="tablist" class="d-none">
									<?php
									$CI =& get_instance();
									$CI->load->model('Smartform_Model');

							 	//$login_get_all = $CI->Login_Model->fetch_all('user_roles', array('user_id' => $user_id));
								
									// pre($item_flow_array);
									// exit;
									// print_r(array_column($item_flow_array, 'requestor_role_id'));
									// echo in_array(3, array_column($item_flow_array, 'requestor_role_id'));
									$items = array_column($item_flow_array, 'item_status', 'requestor_role_id');
									$edit_items = array_column($edit_quick_list, 'field_value', 'field_id');
									// echo '<pre>';
									// print_r($edit_quick_list);exit;
									// print_r($edit_items);
									// if(array_search(3, array_column($item_flow_array, 'requestor_role_id')) !== false) {
									//     echo "FOUND";
									// } else {
									//     echo "Not Found";
									// }
									// pre($item_flow_array);
									
									$flow_count = 1;
									foreach ($item_flow_array as $item_flow_key => $item_flow_value) {
									# code...
										
									$item_flow_status = $item_flow_value['item_status'];
									$item_flow_request_on = $item_flow_value['requested_on'];
									$item_flow_role_id = $item_flow_value['requestor_role_id'];
									$item_receiver_user_id = $item_flow_value['receiver_user_id'];
									$item_flow_role_name = get_role_name($item_flow_role_id);
									$res_array = get_user_id($sup_id);
									$item_user_name = get_user_name($item_receiver_user_id);
									$itemUserName = isset($item_user_name->name) ? "(".$item_user_name->name.")<br>" : '';
									// pre($res_array);

									// $item_user_id = isset($res_array[$item_flow_role_id]) ? $res_array[$item_flow_role_id] : '';
									// $itemUserName = '';
									// if($item_user_id != ''){
									// 	
										// pre($item_user_name);
										
									//}	
									// // $item_user_id = isset($res_array[$item_flow_role_id]) ? $res_array[$item_flow_role_id] : "";

									// if($item_flow_value['receiver_role_id'] != 0  && $item_flow_value['item_status'] == 'Completed'){
									// 	$item_flow_status = 'Pending';
									// }	
									if($item_flow_status == 'Pending'){ $sts_display_name="P"; $class_type = ""; }
						         	elseif($item_flow_status == 'Rejected'){ $sts_display_name="R"; $class_type = "error"; }
						         	elseif($item_flow_status == 'Completed'){ $sts_display_name="C"; $class_type = "success"; }
							         	?>
							         	 <li class="<?php echo 'done '.$class_type;?>" aria-disabled="false" aria-selected="false" title = "<?php echo $item_flow_status;?>">
								         	<a id="steps-uid-0-t-0" href="#" aria-controls="steps-uid-0-p-0" class="font-size-xs">
								         		<span class="number" style="font-weight: bold;"><?php  echo $sts_display_name;?></span><b><?php echo $item_flow_role_name->name;?></b><br><span class="text-warning"><?php echo $itemUserName;?></span><span class=""><?php echo $item_flow_request_on;?></span>
							         		</a>
							         	</li>
								         
						         	<?php
						         	$flow_count++;
									}?>
							     </ul>
							     <ul role="tablist">
							     	<?php
									
							     	$i=0;
							     	if(logged_in_role_id() !=10){
							     		foreach($item_flow_new as $item_flow_new_key => $item_flow_new_value){
							     			// pre($item_flow_new_value);

							     			if(in_array_r('Rejected', $item_flow_new_value)){
							     				$sts_display_name="R";
							     				$item_flow_status="Rejected";
							     				$class_type="error";
							     			}else if(in_array_r('Pending', $item_flow_new_value)){
							     				$sts_display_name="P";
							     				$item_flow_status="Pending";
							     				$class_type="";
							     			}else{
							     				$sts_display_name="C";
							     				$item_flow_status="Completed";
							     				$class_type="success";
							     			}
							     			//echo in_array_r("Irix", $b) 
							     			?>
											<li class="<?php echo 'done '.$class_type;?>" aria-disabled="false" aria-selected="false">
									         	<a id="steps-uid-0-t-0" href="#" aria-controls="steps-uid-0-p-0" class="font-size-xs">
									         		<span class="number" style="font-weight: bold;" title = "<?php echo $item_flow_status;?>"><?php  echo $sts_display_name;?></span>
								         			<?php
								         			$j=0;
							     			foreach ($item_flow_new_value as $item_flow_new_value_key => $item_flow_new_value_value) {

							     				 	if ($item_flow_new_value_value['item_status']=='Pending') {
										                $status_icon = '<i class="icon-checkmark4 text-primary flow_icon_font"></i>';
										                $textclass="text-primary";
										                $bgclass="bg-primary";
										            }
										            else if ($item_flow_new_value_value['item_status']=='Completed') {
										                $status_icon = '<i class="icon-checkmark4 text-success flow_icon_font"></i>';
										                $textclass="text-success";
										                $bgclass="bg-success";
										            }
										            else if ($item_flow_new_value_value['item_status']=='Rejected') {
										                $status_icon = '<i class="icon-cross3 text-danger flow_icon_font"></i>';
										                 $textclass="text-danger";
										                 $bgclass="bg-danger";
										            }

												$pop_title=$item_flow_new_value_value['item_status'];
												$pop_content="";
												//$test="<b>Request Date</b>: ".date('Y-m-d',strtotime($item_flow_new_value_value['requested_on']));
												// echo $item_flow_new_value_value['modified_on'];
												if($item_flow_new_value_value['modified_on']<>'0000-00-00 00:00:00'){
													if($i!=0){
														//$test.="<br><b>Modified Date</b>:".date('Y-m-d',strtotime($item_flow_new_value_value['modified_on']));
													}
												}
												
												/*$get_email_sent_to_role=get_email_sent_to_role($sup_id,$item_flow_new_value_value['requestor_role_id'],$item_flow_new_value_value['requestor_seq']);
												//pre($get_email_sent_to_role);
												if(count($get_email_sent_to_role)>0){
												$pop_content.="<table class='pop-table'><tr class='$bgclass'><td colspan='3'><center><span class='text-center' style='font-weight:bold;'>$pop_title</span></center></td></tr><tr><th>Email</th><th>Requested on</th><th>Updated on</th></tr>";
													foreach($get_email_sent_to_role as $get_email_sent_to_role_key => $get_email_sent_to_role_value){
														$updated_Date="<center> - </center>";	 
														$updated_style="";	 
														if($item_flow_new_value_value['receiver_user']<>''){
															$receiver_user=get_user_email_by_name($item_flow_new_value_value['receiver_user']);
															// pre($receiver_user);

															$receiver_email_id=$receiver_user->email;
															if($receiver_email_id == strtolower($get_email_sent_to_role_value['to_user'])){
																if($item_flow_new_value_value['modified_on']<>"0000-00-00 00:00:00"){
																	$updated_Date=$item_flow_new_value_value['modified_on'];
																}else{
																	$updated_Date="<center> - </center>";
																}
																$updated_style="style='font-weight:bold;'";	 
															}else{
																$updated_Date="<center> - </center>";
																$updated_style="";
															}
														
														}
														if($updated_Date<>"0000-00-00 00:00:00"){
															$updated_Date=$updated_Date;
														}else{
															$updated_Date="<center> - </center>";
														}
														$pop_content.="<tr $updated_style>";
														$pop_content.="<td>".$get_email_sent_to_role_value['to_user']."</td>";
														$pop_content.="<td>".$get_email_sent_to_role_value['req_date']."</td>";
														$pop_content.="<td>".$updated_Date."</td>";
														$pop_content.="</tr>";
													}
													$pop_content.="</table>";
												}*/
												
												
												$input_val='"'.$sup_id.'|'.$item_flow_new_value_value['requestor_role_id'].'| |'.$item_flow_new_value_value['requestor_seq'].'"';
												$id_val=$sup_id.'_'.$item_flow_new_value_value['requestor_role_id'].'_'.$item_flow_new_value_value['requestor_seq'];
												$mod_date='';
												if($item_flow_new_value_value['modified_on']<>'0000-00-00 00:00:00'){
													$mod_date="(".$item_flow_new_value_value['modified_on'].")";
												}else{
													$mod_date="(".$item_flow_new_value_value['requested_on'].")";
												}
												?>
								     			<div><?php if($j>=0){ echo "<br>";}else{echo'';}  if($i!=0){echo"<b onclick='get_track_mail_list($input_val)' style='cursor:pointer;'>";}?><?php echo '<b><i style="font-size: 0.9rem;" class="fa fa-lightbulb-o" aria-hidden="true"></i> </b>'. $item_flow_new_value_value['requestor_role'].' '. $status_icon;?></b><?php if($item_flow_new_value_value['receiver_user']<>'') { ?><br><span class="text-warning"><?php echo $item_flow_new_value_value['receiver_user'].$mod_date;?></span><br><?php } ?></div>
							     			<?php $i++;$j++;
							     			}?></a> 
								         	</li>
							     			
							    		<?php
							    		}
						    		}
						    		else{
						    			echo '<br><br>';
						    		}
							    	?>
							     </ul>
							   </div>
							   <div class="content clearfix"></div>
							</span>
						</div>
					</div>
					<!-- <form name= 'quick_add' id= 'quick_add' class= 'form-validate-jquery' method='post' enctype='multipart/form-data'> -->
					<?php echo form_open(base_url().'smartform/quick_update', array('name' => 'quick_update', 'id' => 'quick_update', 'class' => 'form-validate-jquery', 'enctype' => 'multipart/form-data', 'method' => 'post'), ''); ?>						
						<fieldset class="mb-3">		

							<div class="row">				
								<?php
								
								/*$group_list_array=array();

									foreach ($list_form_group as $list_key => $list_value) {
									$group_list_array[$list_value['id']]=$list_value['group_name'];

									}

									$group_array=array();
									$field_seq_array=array();
									foreach ($form_group_seq as $group_key => $group_value) {
									$group_array[$group_value['group_seq']]=$group_value['group_id'];
									$field_seq_array[$list_value['group_id']][$group_value['group_seq']]=$list_value['group_name'];
									}
									ksort($group_array);

									//pre($group_array_sort);
									foreach ($group_array as $group_array_key => $group_array_value) {
									$group_name= $group_list_array[$group_array_value];

									}
								*/
								/*echo "<pre>";print_r($form_layout);
								exit();*/
								$people_soft_value='';
								$division_value='';
								$category_value='';
								$group_array=array();
								foreach ($form_layout as $key => $value) {
									$group_array[$value['group_seq']]=$value['group_id'];
								}
								$group_list_array=array();
								foreach ($list_form_group as $list_key => $list_value) {
											$group_list_array[$list_value['id']]=$list_value['group_name'];
									
								}

								$gorup_order_array=array();
								$gorup_size_array=array();
								
								
								foreach($group_array as $form_group_key => $form_group_value){
									foreach ($form_layout as $key => $value_array) {
										 if($value_array['group_id']==$form_group_value){
												$gorup_order_array[$form_group_value][$value_array['field_seq']]=$value_array['id'];
												$gorup_size_array[$form_group_value]=$value_array['group_size'];
										}
									}
								}
									
									$validation_array=array();
									//pre($edit_quick_list);exit;
									//pre($group_list_array);
									//pre($gorup_order_array);
									$new_group_array=array();
									$form_field_id_array=array();
									foreach($gorup_order_array as $group_order_key => $group_order_value){
										$new_group_array=$gorup_order_array[$group_order_key];
										$col_size=$gorup_size_array[$group_order_key];
										$group_name=$group_list_array[$group_order_key];
										//pre($group_order_key);
										echo '<div class="col-md-'.$col_size.'">
											<div class="form_group_text card-title">'.$group_name.'</div>';
										foreach($new_group_array as $group_order_key => $group_order_value_array){
											
											$value=get_field_details_from_layout($form_layout,'id',$group_order_value_array);
											$edit_value=get_field_details_from_layout($edit_quick_list,'field_id',$group_order_value_array);
											if(count($edit_value)>0){
												$original_value=trim($edit_value['field_value']);
											}else{
												$original_value="";
											}
											
											if($edit_value['field_id']==62)
											{																	
												$division_value = trim($edit_value['field_value']);	
											}
											
											if($edit_value['field_id']==63)
											{																	
												$category_value = trim($edit_value['field_value']);	
											}
											$myStatus = 0;
											if($value['is_view'] == 1 || $value['is_view_update'] == 1 || $value['is_not_visible'] == 1 ){
												if($value['is_show_once_filled'] == 1){
													
													if($get_request_status =='Completed' || $get_request_status == 'Rejected'){
														$myStatus = 1;
													}
													else{
														if($original_value != ''){
															$myStatus = 1;
														}else{
															$myStatus = 0;
														}
													}
												}
												else{
													$myStatus = 1;
												}
											}
															
															if($myStatus == 1){																
																/*NOTE:HK START*/
																$readonly = 'readonly';
														        $pointer_events="pointer-events:none;cursor: not-allowed;";
														        $Editable = $tempEditable;
														        // if($original_form_id == 6 || $original_form_id == 7 || $original_form_id == 8){
														        if($Editable !=''){
														            $readonly = ''; 
														            $pointer_events= ''; 
														            $comment_field = '';	
														        }
														        if($value['is_not_visible'] != 1 || $value['is_show_once_filled'] == 1){ 
														            $tempEditable = $Editable;
														            $Editable = '';
														            $readonly = 'readonly';
														            $comment_field = 'readonly';
														            $pointer_events="pointer-events:none;cursor: not-allowed;";
														        } 


																// if($value['id']==79){
																// 		if ($role_id==16){
																// 			$check_permission_edit_79=check_permission_approve($sup_id,$original_status,$original_form_id);
																// 			if($check_permission_edit_79['is_approve']==1){
																// 				$readonly = ''; 
																// 				$pointer_events= ''; 
																// 				$comment_field = '';
																// 				$Editable = 'js-example-basic-single';
																// 				$tempEditable = 'js-example-basic-single';
																// 			}	
																// 			//echo  "test";exit;
																// 		}else {
																// 			$check_field_visible_function=check_field_visible_function($sup_id,$logged_in_role_id,$original_form_id);
																// 			if($check_field_visible_function==0){
																// 				$tempEditable = $Editable;
																// 				$Editable = '';
																// 				$readonly = 'readonly';
																// 				$comment_field = 'readonly';
																// 				$pointer_events="pointer-events:none;cursor: not-allowed;display:none;";
																// 			}else{
																// 				$tempEditable = $Editable;
																// 				$Editable = '';
																// 				$readonly = 'readonly';
																// 				$comment_field = 'readonly';
																// 				$pointer_events="pointer-events:none;cursor: not-allowed;";	
																// 			}
																// 		}
																// }

														        /*NOTE:HK END*/
																if($value['id']==$group_order_value_array){

																	$is_required = '';

																	$star = '';

																	$CI =& get_instance(); 
																	$CI->load->model('Smartform_Model');
																	$field_required_check=$CI->Smartform_Model->field_required_check($sup_id,$value['form_layout_id'],'edit');
																	//pre($form_layout_id.$field_required_check);
																	//echo $form_layout_id.' - '.$value['form_layout_id'].''.$value['id'];
																	$retrun_val=array();
																	if(count($field_required_check)>0){
																		foreach($field_required_check as $key => $value_req_val){
																			$retrun_val=explode('|',$value_req_val);
																			//pre($retrun_val);
																			$is_required_val = $retrun_val[0];
																			$validation_class = $retrun_val[1];
																			if($is_required_val=='1'){
																				$is_required = 'required';
																				$star="*";
																				$validation_class =$validation_class;
																				
																			}else{
																				$is_required = '';
																				$validation_class = "";
																			    $star="";
																				
																			}
																		}
																    }else{
																		if ($value['required']==1) {

																			$is_required = 'required';
	
																			$star="*";
																			if ($value['validation_class']<>'') {	
	
																				$validation_class = $value['validation_class'];
		
																			}else{
		
																				$validation_class = "";
		
																			}
	
																		}else{
																			$is_required = '';
																			$validation_class = "";
																			$star="";
																		}
																	}

																	if($value['is_required_check']==1){ 
																		$data_attr_required="check_required";
																	}else{
																		$data_attr_required="";
																	}
																	$default_values = "";
																	/*if ($value['id']=='1.1.11') {
																	if ($value['id']==15) {
																		$default_values = logged_in_user_email();
																	}									
																	else{
																		$default_values = $value['default_values'];
																	}
																	*/
																	if ($value['input_rules']=='uppercase') {	
																		/*$styl='style="text-transform:uppercase;"';*/
																		$styl='text-uppercase';
																	}

																	if($value['input_length']<>''){
																		$max_len = 'maxlength="'.$value['input_length'].'"';
																	}

																	$is_defalut_display=$value['is_defalut_display'];
																	$is_populate_field=$value['is_populate_field'];
																	$associated_field_id=$value['associated_field_id'];
																	$form_layout_id=$value['form_layout_id'];
																	$def_view_class = '';
																	if ($is_defalut_display==0) {	
																	
																		$field_visible=$CI->Smartform_Model->check_field_visible($original_form_id,$sup_id,$form_layout_id);
																		/*if($original_value<>''){
																			$def_view_lclass = '';
																		}else{
																			// $def_view_class = 'd-none';
																			$def_view_class = '';
																			$is_required='';
																		}
																		if($form_layout_id==575){
																			echo $field_visible;
																		} */
																		$def_view_class=$field_visible;
																	}
																	$pop_field_class = '';
																	if ($is_populate_field==1) {	
																		$pop_field_class = 'on_select_change'; 
																	}
																	$data_id='';
																	if ($associated_field_id<>''){
																		$data_id = "data-id='".$associated_field_id."'";
																	}

																	if ($value['validation_class']<>'') {	
																		$validation_class = $value['validation_class'];
																	}
																	if($original_value <> ""){
																		$default_values = $original_value;
																	}
																	
																	 
																	if (strpos($value['field_id'], '2.') === 0) {
																		if($original_value==""){
																			$def_view_class='d-none';
																		}
																	}
																	
																	$max_length_field=$value['input_length'];
																	$data_type=$value['data_type'];

																	$field_id='data-popup="popover" title="" data-html="true" data-original-title="<b class=\'text-danger text-center\'>'.$value['field_id'].'</b>" data-placement="right" data-trigger="hover"';

																	$note_text_label = '';
																	if ($value['id']==42) {
																		$note_text_label = '<br><span class="font-size-xs text-danger">Choose from existing list of Legal names (must type at least 3 characters to populate search) and ensure the Supplier doesn\'t already exist before typing a new one. Click on the <b class="font-size-sm">Browse button </b> if you would like to view the Supplier Legal Name list with search functionality.</span>';
																	}
																	if ($value['id']==51) {
																		$note_text_label = '<br><span class="font-size-xs text-primary"> Only use this field if you need to extend the supplier to non-standard locations. For more details, see FAQs for "Location Codes".</span>';
																	}

																	$language = $this->session->userdata('site_lang');   
																	$label_text = 'field_name_'.strtolower($language);
																	$final_question = $value[$label_text];
																	if($final_question==''){
																		$final_question = $value['field_name_english'];
																	}
																	
																	$field_label='<div class="col-md-6"><label class="font-weight-semibold" '.$field_id.'>'.$final_question.'<span class="text-danger" id="star_'.$value['id'].'">'.$star.'</span>'.$note_text_label.'</label></div>';
																	/*$readonly = 'readonly';
																	$pointer_events="pointer-events:none;cursor: not-allowed;";HK*/
																	// if($original_form_id == 6 || $original_form_id == 7 || $original_form_id == 8){
																	/*if($Editable !=''){
																		$readonly = '';	
																	}HK*/
																		/*if($original_status == 'Rejected'){
																			$readonly = '';
																		}*/
																	// }
																	
																	if ($value['field_type']=='1') {
																		// echo $value['id'];
																		if($max_length_field<>''){
																			$validation_array[$value['id']]['maxlength']=$max_length_field;
																		}
																		if($data_type<>'' && $data_type<>'text'){
																			$validation_array[$value['id']][$data_type]="true";
																		}
																		
																		//$validation_array[$value['id']]['required']='depends:function(){ $(this).val($.trim($(this).val())); return true; }';
	        
																		if($value['autofill'] == 1){
																			$autofill = 'autocomplete="nope"';
																		}
																		else{
																			$autofill = '';
																		}

																		$autocomplete='';
																		if ($value['id']==42) {
																		$autocomplete='autocomplete';
																		?>
																		<style>
																		.ui-autocomplete {
																			position: absolute;
																			z-index: 1000;
																			cursor: default;
																			padding: 0;
																			margin-top: 2px;
																			list-style: none;
																			background-color: #ffffff;
																			border: 1px solid #ccc
																			-webkit-border-radius: 5px;
																			-moz-border-radius: 5px;
																			border-radius: 5px;
																			-webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
																			-moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
																			box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
																		}
																		.ui-autocomplete > li {
																			padding: 3px 20px;
																		}
																		.ui-autocomplete > li.ui-state-focus {
																			background-color: #DDD;
																		}
																		.ui-helper-hidden-accessible {
																			display: none;
																		}
																		</style>
																		<script type="text/javascript">
																		$(function() {
																$( "#42" ).autocomplete({
																	
																	source: function( request, response ) {
																		var search_keyword = document.getElementById('42').value.trim();
																		//Fetch data
																		if (search_keyword!='') {
																			if (search_keyword.length>=3) {
																				$.ajax({
																					url: '<?php echo base_url();?>smartform/get_alei_auto_complete',
																					type: 'post',
																					dataType: "json",
																					async: false,
																					data: {
																						search_keyword:search_keyword,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'
																					},
																					success: function( data ) {
																						response(data.sup_legal_name);
																						response($.map(data, function (item) {
																							return {
																								label: item.sup_legal_name+'|'+item.alei+'|'+item.country,
																								value: item.sup_legal_name
																							};
																						}));
																						return data;
																					}
																				});
																			}
																		}
																		
																		
																		else{
																			$( "#42" ).val('');
																			alert('Space not allowed!');
																			$.alert({
																				title: 'Alert!',
																				content: 'Space not allowed!',
																			});
																			return false;
																		}
																		
																	},
																	select: function (event, ui) {
																		//Set selection
																		$('#42').val(ui.item.value); // display the selected text
																		event.preventDefault();
																		$(this).val(ui.item.value);
																		var keywords= ui.item.sup_legal_name;
																		$("#keywords").val(keywords);
																		select_supplier_autocomplete(ui.item.label);
																		return false;
																	}
																});
															});
																		</script>
																		<?php
																		// $autocomplete
																		}
																		$valueArray = "";
																		$extraStyle = "";
																		$dnb = "";
																		$inputgroup_start = "";
																		$inputgroup_end = "";
																		if($value['id']==50){
																			echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'">
																				'.$field_label.'';
																			echo '<div class="col-md-6">';

																			if($default_values==''){
																					echo '<input type="text" name="50[]" id="50_remove" class="form-control form-control-sm text-uppercase" disabled >
																					';
																			}
																			else{
																				echo '<input type="text" name="50[]" id="50_remove" class="form-control form-control-sm text-uppercase d-none" disabled>
																					';
																			}
																			echo '<div class="row">';
																			$getDropdownValue = get_default_values_dropdown(47);
																			$userInputValue = explode('||', $default_values);	
																			$existVal = array();
																			foreach ($userInputValue as $inputKey => $inputValue) {
																				
																				$arrayValue = explode(':', $inputValue);

																				// if (strpos($arrayValue[0], ', ') !== FALSE)
																				// {
																				//     $arrayValue[0] = str_replace(',  ','__',$arrayValue[0]);	
																				// }
																				$existVal[$arrayValue[0]] = $arrayValue[1];
																			}
																			// pre($default_values);
																			// pre($existVal);
																			// exit;
																			$i=1;
																			foreach ($getDropdownValue as $Key => $Value) {
																				$displayValueId = str_replace([' ','(',')','.',','],'__',$Value['display_value']);																		
																				// if (strpos($Value['display_value'], ', ') !== FALSE){ 
																				//     $Value['display_value'] = str_replace(',  ','__',$Value['display_value']);	
																				// }	

																				if (array_key_exists($Value['display_value'], $existVal)) {
																				    echo '<div class="col-md-12 mb-2 div_remove" id="'.$displayValueId.'">
																							<div class="input-group">
																								<span class="input-group-prepend">
																									<span class="input-group-text" id="" style="padding: .3125rem .75rem;">'.strtoupper($Value['display_value']).'</span>
																								</span>
																								<input type="text" name="50[]" id="50_'.$displayValueId.'" class="form-control form-control-sm text-uppercase  50_user_input checksupplierlength dynamic_text_box" value="'.htmlspecialchars(trim($existVal[$Value['display_value']])).'" '.$readonly.' data-id="'.$Value['display_value'].'" required">
																							</div>
																						</div>';
																				}
																				else{
																					echo '<div class="col-md-12 mb-2 d-none div_remove" id="'.$displayValueId.'">
																							<div class="input-group">
																								<span class="input-group-prepend">
																									<span class="input-group-text" id="" style="padding: .3125rem .75rem;">'.strtoupper($Value['display_value']).'</span>
																								</span>
																								<input type="text" name="50[]" id="50_'.$displayValueId.'" class="form-control form-control-sm text-uppercase 50_user_input" data-id="'.$Value['display_value'].'"">
																							</div>
																						</div>';
																				}		
																				$i++;
																			}
																			echo '</div></div></div>';																
																		}
																		else if($value['id']==42){
																			//echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'">';
																			//echo '<div class="col-md-'.$value['field_size'].'">/<input type="text" name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm '.$styl.' '.$validation_class.' " placeholder="'.$value['place_holder'].'" '.$is_required.' value="'.$default_values.'" '.$autofill.' '.$readonly.' '.$max_len.'></div>';
																			//echo '</div>';
																			
																			if(isset($suppliers_info[$value['id']])){
																				$default_values=$suppliers_info[$value['id']];
																			}
																			if($readonly<>''){
																				$btn_disable="disabled";
																			}else{
																				$btn_disable="";
																			}
																			
																			echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																			'.$field_label.'
																			<div class="col-md-5">
																			<input type="text"  name="'.$value['id'].''.$valueArray.'" id="'.$value['id'].'"class="form-control form-control-sm '.$styl.' '.$validation_class.' " placeholder="'.$value['place_holder'].'" '.$is_required.' value="'.htmlspecialchars($default_values).'" '.$autofill.' '.$max_len.' '.$readonly.'>';
																			$suppliers_validated=check_for_validated_alei($default_values);
																			if($suppliers_validated==""){
																					echo "<span class='text-danger'><b>*** -  ALEI not validated</b></span>";
																			}
																			else if(isset($suppliers_info['validated'])){ 
																				if($suppliers_info['validated']==''){
																				echo "<span class='text-danger'><b>*** -  ALEI not validated</b></span>";
																				}
																			}
																			
																			echo '</div><div class="col-md-1"><input type="button" name="borwse_supplier" id="borwse_supplier" class="btn btn-sm btn-warning" value="Browse" data-toggle="modal" data-target="#modal_theme_primary" onclick="searchSupplier(1)" '.$btn_disable.'></div></div>';
																		}else if($value['id']==51){
																			if(isset($suppliers_info[$value['id']])){
																				$default_values=$suppliers_info[$value['id']];
																			}
																			if($value['id']==51 ){
																				if($default_values==''){
																					$default_values='Default MDM SOP';
																				}
																			}else{
																				$people_soft_value=$default_values;
																			}	
																			echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">';
																			echo '<div class="col-md-6"><label class="font-weight-semibold" '.$field_id.'>'.$final_question.$note_text_label.'</label></div>';
																			echo '<div class="col-md-'.$value['field_size'].'">
																					<input type="text" name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm '.$styl.' " placeholder="'.$value['place_holder'].'" value="'.htmlspecialchars($default_values).'" '.$autofill.' '.$readonly.' '.$max_len.'>
																				</div>';
																			echo '</div>';
																		}
																		else{
																			/*echo $default_values;*/
																			if(isset($suppliers_info[$value['id']])){
																				$default_values=$suppliers_info[$value['id']];
																			}
																			if($value['id']==51 ){
																				if($default_values==''){
																					$default_values='Default MDM SOP';
																				}
																			}	
																			echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																			'.$field_label.'';
																			echo '<div class="col-md-'.$value['field_size'].'">
																					<input type="text" name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm '.$styl.' '.$validation_class.' " placeholder="'.$value['place_holder'].'" '.$is_required.' value="'.htmlspecialchars($default_values).'" '.$autofill.' '.$readonly.' '.$max_len.'>
																				</div>';
																			echo '</div>';
																		}
																		
																	}
																	else if ($value['field_type']=='2') {
																		// pre($value);
																		// $pointer_events="pointer-events:none;cursor: not-allowed;";
																		// $pointer_events="";

																		if (strpos($value['default_values'], 'table_') !== false) {
																			if(isset($suppliers_info[$value['id']])){
																				$default_values=$suppliers_info[$value['id']];
																			}
																		    $options = explode('_', $value['default_values'],2);
																			$original_list_id = explode('_', strtolower($default_values));
																			//pre($original_list_id);
																		    /*$country_name= '';
																		    $state_name= '';
																		    $city_name= '';*/
																		    $CI =& get_instance();
																			$CI->load->model('Userhome_Model');
																			if($options[1] == 'countries'){
																				$list_country = $CI->Userhome_Model->get_list($options[1],null,null,null,null,'country_name','ASC');
																				if(isset($original_list_id[0]) && $original_list_id[0] !='table'){
																					$country_name = $original_list_id[0];
																				}
																				/*echo $country_name;*/
																			}
																			else if($options[1] == 'states'){
																				// echo $options[1];
																				$list_state =  get_state($country_name);
																				if(isset($original_list_id[0]) && $original_list_id[0] !='table'){
																					$state_name = strtolower($original_list_id[0]);
																				}
																				/*pre($list_state );*/
																				/*echo $state_name;*/
																			}
																			else if($options[1] == 'cities'){
																				$list_city = get_city($state_name);
																				if(isset($original_list_id[0]) && $original_list_id[0] !='table'){
																					$city_name = strtolower($original_list_id[0]);
																				}
																				/*echo $city_name;*/
																			}
																			
																			
																			// echo $original_list_id[0];
																			if($options[1] == 'countries'){
																				echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																						'.$field_label.'
																					<div class="col-md-'.$value['field_size'].'">
																					<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" '.$data_id.'  data-required-check="'.$data_attr_required.'">';
																						echo '<option value="">SELECT</option>';
																						foreach ($list_country as $options_key => $options_value) {
																							if((isset($original_list_id[0])) && ($original_list_id[0]== strtolower($options_value->country_name)))
																								{ $selected = "selected"; }
																							else { $selected = ""; }

																							echo '<option value="'.$options_value->country_name.'" '.$selected .'>'.strtoupper($options_value->country_name).'</option>';	
																						}
																						echo'</select>
																					</div>
																				</div>';
																			}
																			else if($options[1] == 'states'){
																				$other_value = '';
																				$selectOther = '';
																				$listDummy = array_map(function($e) {
																				    return is_object($e) ? strtolower($e->state_name) : '';
																				}, $list_state);
																				// pre($list_state);
																				if($value['is_view'] == 1){

																					if(!empty($listDummy) && $state_name!=''){
																						  /*echo 'Not FOUND!';*/
																						if (array_search($state_name, $listDummy) === FALSE){
																						  $other_value = $state_name;
																						  if($other_value!=''){
																						  $state_name = 'Other';
																						  $selectOther = 'selected'; 
																						  }
																						}
																					}
																					elseif($state_name!=''){
																						$other_value = $state_name;
																						
																						if($other_value!=''){
																						  $state_name = 'Other';
																						  $selectOther = 'selected'; 
																						  }
																					}
																				}
																				else{
																					/*if(!empty($listDummy)){*/
																						if (array_search($state_name, $listDummy) === FALSE){
																						  // echo 'Not FOUND!';
																						  $other_value = $state_name;
																						  if($other_value!=''){
																						  $state_name = 'Other';
																						  $selectOther = 'selected'; 
																						  }



																						  
																						}
																					/*}*/
																				}
																				/*echo $state_name;*/
																				echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																						'.$field_label.'
																					<div class="col-md-'.$value['field_size'].'">
																					<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" data-other-value="'.$other_value.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																						echo '<option value="">SELECT</option>';
																							foreach ($list_state as $options_key => $options_value) {
																								if((isset($state_name)) && ($state_name == strtolower($options_value->state_name)))
																									{ $selected = "selected"; }
																								else { $selected = ""; }
																								echo '<option value="'.$options_value->state_name.'" '.$selected .'>'.strtoupper($options_value->state_name).'</option>';		
																							}
																							echo '<option value="Other" '.$selectOther.'>OTHER</option>';
																							echo'</select>
																						</div>
																				</div>';
																			}
																			else if($options[1] == 'cities'){
																				$other_value = '';
																				$selectOther = '';
																				$listDummy = array_map(function($e) {
																				    return is_object($e) ? strtolower($e->city_name) : '';
																				}, $list_city);
																				if($city_name!=''){
																					if (array_search($city_name, $listDummy) === FALSE){
																					 
																					  $other_value = $city_name;
																					  if($other_value!=''){
																						  $city_name = 'Other';
																						  $selectOther = 'selected'; 
																						}
																					}
																				}
																					
																				echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																						'.$field_label.'
																					<div class="col-md-'.$value['field_size'].'">
																					<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" data-other-value="'.$other_value.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																						echo '<option value="">SELECT</option>';
																							foreach ($list_city as $options_key => $options_value) {
																								if((isset($city_name)) && ($city_name == strtolower($options_value->city_name)))
																									{ $selected = "selected"; }
																								else { $selected = ""; }
																								echo '<option value="'.$options_value->city_name.'" '.$selected .'>'.strtoupper($options_value->city_name).'</option>';	
																							}
																							echo '<option value="Other" '.$selectOther.'>OTHER</option>';
																							echo'</select>
																						</div>
																				</div>';
																			} 

																			/*if(array_search('Other', array_column($options, 'field_value')) !== false) {*/
																		    echo '<div class="form-group row row_hide_other" id="row_hide_other_'.$value['id'].'">
																					<div class="col-md-6">&nbsp;</div>	
																					<div class="col-md-'.$value['field_size'].'">
																					<input type="text" class="form-control checkother form-control-sm  '.$styl.'" name="'.$value['id'].'_other" id="'.$value['id'].'_other" placeholder="If other please specify" '.$readonly.'>
																				</div>
																			</div>';
																			/*}*/
																		}
																		else if (strpos($value['default_values'], 'table||') !== false) {
																		    $options = explode('||', $value['default_values']);
																		    $CI =& get_instance();
																			$CI->load->model('Userhome_Model');
																			$tableName = isset($options[1]) ? $options[1]  : '';
																			$tableFieldValue = isset($options[2]) ? $options[2]  : '';
																			$tableDisplayValue = isset($options[3]) ? $options[3]  : '';
																			$tableColumn = isset($options[4]) ? $options[4]  : '';
																			$tableOrderBy = isset($options[5]) ? $options[5]  : '';
																			if($tableName != '' && $tableFieldValue != ''){
																				$list_table_values = $CI->Userhome_Model->get_list($tableName,null,null,null,null,$tableColumn,$tableOrderBy);
																				$default_values_array=explode(',',$default_values);
																				$id_check=$value['id'];

																				echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																				'.$field_label.'
																				<div class="col-md-'.$value['field_size'].'">
																				<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																				echo '<option value="">SELECT</option>';
																				if($id_check==63){
																						if(!empty($list_table_values)){
																							foreach ($list_table_values as $options_key => $options_value) {
																								$optionDisplay = isset($options_value->$tableDisplayValue) ? ' - '.$options_value->$tableDisplayValue  : '';
																								$optionValue = isset($options_value->$tableFieldValue) ? $options_value->$tableFieldValue  : '';
																								$optionValueId = isset($options_value->id) ? $options_value->id  : '';
																								$optionStatus = isset($options_value->status) ? $options_value->status  : '';

																								if(in_array($optionValueId,$default_values_array)){ 
																									$selected = "selected";
																								}
																								else { $selected = ""; }

																								if($optionStatus==0){
																									if($original_status == "Completed"){
																										echo '<option value="'.$optionValueId.'" '.$selected.'>'.strtoupper($optionValue.''.$optionDisplay).'</option>';
																									}
																								}else{
																									echo '<option value="'.$optionValueId.'" '.$selected.'>'.strtoupper($optionValue.''.$optionDisplay).'</option>';
																									

																								}
																							}
																						}
																					}else{
																					if(!empty($list_table_values)){
																						foreach ($list_table_values as $options_key => $options_value) {
																							$optionDisplay = isset($options_value->$tableDisplayValue) ? ' - '.$options_value->$tableDisplayValue  : '';
																							$optionValue = isset($options_value->$tableFieldValue) ? $options_value->$tableFieldValue  : '';
																							$optionValueId = isset($options_value->id) ? $options_value->id  : '';

																							if(in_array($optionValueId,$default_values_array)){ 
																								$selected = "selected";
																							}
																							else { $selected = ""; }
																							echo '<option value="'.$optionValueId.'" '.$selected.'>'.strtoupper($optionValue.''.$optionDisplay).'</option>';
																						}
																					}
																				}
																					echo'</select>
																					</div>
																					</div>';
																				}

																			/*if(array_search('Other', array_column($options, 'field_value')) !== false) {*/
																		    echo '<div class="form-group row row_hide_other" id="row_hide_other_'.$value['id'].'">
																					<div class="col-md-6">&nbsp;</div>	
																					<div class="col-md-'.$value['field_size'].'">
																					<input type="text" class="form-control checkother form-control-sm '.$styl.' " name="'.$value['id'].'_other" id="'.$value['id'].'_other" placeholder="If other please specify" '.$readonly.'>
																				</div>
																			</div>';
																			/*}*/
																		}
																		else{
																			/*if ($value['id']=='1.1.14') {*/
																			/*if ($value['id']==20) {
																				$options[] = 'Yes';	
																				echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'">
																							'.$field_label.'
																						<div class="col-md-'.$value['field_size'].'">
																						<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" '.$data_id.'>';
																							foreach ($options as $options_key => $options_value) {
																								if($options_value == $default_values)
																									{ $selected = "selected"; }
																								else { $selected = ""; }
																								echo '<option value="'.$options_value.'" '.$selected.'>'.strtoupper($options_value).'</option>';
																							}		
																					echo'</select>
																					</div>
																				</div>';
																			}*/
																			/*else if($value['id']=='1.1.15'){*/
																			if($value['id']==22){
																				$options = array();
																				// $options[] = 'New ERP supplier';	
																				$options = get_default_values_dropdown($value['id']);
																				// pre($options);
																				$Not_echo = '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																							'.$field_label.'
																						<div class="col-md-'.$value['field_size'].'">
																						<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																							foreach ($options as $options_key => $options_value) {
																								if($options_value['id'] == $default_values)
																									{ $selected = "selected"; }
																								else { $selected = ""; }
																								// echo $options_value['field_value'];
																								$Not_echo .= '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';
																							}		
																					$Not_echo .='</select>
																					</div>
																				</div>';
																			}
																			/*else if($value['id']=='1.1.40' || $value['id']=='1.1.39'){*/
																			else if($value['id']==53 || $value['id']==52){
																				// $options = explode('||', $value['default_values']);
																				$options = get_default_values_dropdown($value['id']);
																				/*pre($options);*/
																				//echo $default_values;
																				echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																							'.$field_label.'
																						<div class="col-md-'.$value['field_size'].'">
																						<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																							echo '<option value="">SELECT</option>';
																							foreach ($options as $options_key => $options_value) {
																								if($options_value['id'] == $default_values)
																									{ $selected = "selected"; }
																								else { $selected = ""; }
																								echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper($options_value['field_value'].' - '.$options_value['display_value']).'</option>';
																							}		
																					echo'</select>
																					</div>
																				</div>';
																			}
																			else{
																				$extra_value = "";
																				/*if($value['id']==53 || $value['id']==52 || $value['id']==71){*/
																				if($value['id']==71){
																						$extra_value = "yes";
																				}
																				// $options = explode('||', $value['default_values']);
																				$options = get_default_values_dropdown($value['id']);
																				/*pre($options);*/
																				// echo $default_values;
																				// $asdf = array_search($default_values, array_column($options, 'field_value'));
																				// echo $asdf;
																				$other_value = '';
																				$selectOther = '';
																				if (array_search($default_values, array_column($options, 'id')) === FALSE){
																				  // echo 'Not FOUND!';
																				  $other_value = $default_values;
																				  if($other_value!=''){
																					  $default_values = 'Other';
																				  }
																				  // $selectOther = 'selected';
																				}
																				/*if($value['id']==71 && $default_values == 415){
																					$other_value = $default_values;
																				  // $default_values = '415';
																				}*/
																				// echo $default_values;
																				// echo $value['id'];
																				if($value['id']==79){
																					if($role_id==16 && $original_status=="Pending"){
																						$check_field_edit_function=check_field_edit_function($sup_id,$role_id,$original_form_id);
																						//echo $check_field_edit_function;
																							if($check_field_edit_function==0){
																								echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'" data-field-id="'.$value['id'].'">
																										'.$field_label.'
																									<div class="col-md-'.$value['field_size'].'">
																									<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' other_select '.$pop_field_class.'" '.$is_required.' style="pointer-events:none;cursor: not-allowed;"  data-other-value="'.$other_value.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																										echo '<option value="">SELECT12</option>';

																										
																										foreach ($options as $options_key => $options_value) {
																											if($options_value['id'] == $default_values || $options_value['field_value'] == $default_values)
																												{ $selected = "selected"; }
																											else { $selected = ""; }
																											/*echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';*/
																											echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper((isset($extra_value) && $extra_value!='' && $options_value['display_value']!='Other') ? $options_value['field_value'].' - '.$options_value['display_value'] : $options_value['display_value']).'</option>';
																										}		
																								echo'</select>
																								</div>
																							</div>';
																							}else{
																								//echo $check_field_edit_function;exit;
																								echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'" data-field-id="'.$value['id'].'">
																										'.$field_label.'
																									<div class="col-md-'.$value['field_size'].'">
																									<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' other_select js-example-basic-single '.$pop_field_class.'" '.$is_required.' data-other-value="'.$other_value.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																										echo '<option value="">SELECT</option>';

																										
																										foreach ($options as $options_key => $options_value) {
																											if($options_value['id'] == $default_values || $options_value['field_value'] == $default_values)
																												{ $selected = "selected"; }
																											else { $selected = ""; }
																											/*echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';*/
																											echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper((isset($extra_value) && $extra_value!='' && $options_value['display_value']!='Other') ? $options_value['field_value'].' - '.$options_value['display_value'] : $options_value['display_value']).'</option>';
																										}		
																								echo'</select>
																								</div>
																							</div>';
																							}
																						}else{
																							if($default_values<>''){
																								echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'" data-field-id="'.$value['id'].'">
																								'.$field_label.'
																								<div class="col-md-'.$value['field_size'].'">
																								<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.'other_select '.$pop_field_class.'" '.$is_required.' style="pointer-events:none;cursor: not-allowed;" data-other-value="'.$other_value.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																									echo '<option value="">SELECT</option>';

																									
																									foreach ($options as $options_key => $options_value) {
																										if($options_value['id'] == $default_values || $options_value['field_value'] == $default_values)
																											{ $selected = "selected"; }
																										else { $selected = ""; }
																										/*echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';*/
																										echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper((isset($extra_value) && $extra_value!='' && $options_value['display_value']!='Other') ? $options_value['field_value'].' - '.$options_value['display_value'] : $options_value['display_value']).'</option>';
																									}		
																							echo'</select>
																							</div>
																						</div>';
																							}else{
																								echo '<div class="d-none form-group row '.$value['id'].'" id="'.$form_layout_id.'" data-field-id="'.$value['id'].'">
																								'.$field_label.'
																									<div class="col-md-'.$value['field_size'].'">
																									<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.'other_select '.$pop_field_class.'" '.$is_required.' style="pointer-events:none;cursor: not-allowed;" data-other-value="'.$other_value.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																										echo '<option value="">SELECT</option>';

																										
																										foreach ($options as $options_key => $options_value) {
																											if($options_value['id'] == $default_values || $options_value['field_value'] == $default_values)
																												{ $selected = "selected"; }
																											else { $selected = ""; }
																											/*echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';*/
																											echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper((isset($extra_value) && $extra_value!='' && $options_value['display_value']!='Other') ? $options_value['field_value'].' - '.$options_value['display_value'] : $options_value['display_value']).'</option>';
																										}		
																								echo'</select>
																								</div>
																							</div>';
																							}
																						}
																				}else{
																					echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																								'.$field_label.'
																							<div class="col-md-'.$value['field_size'].'">
																							<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" data-other-value="'.$other_value.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																								echo '<option value="">SELECT</option>';

																								foreach ($options as $options_key => $options_value) {
																									if($options_value['id'] == $default_values  || $options_value['field_value'] == $default_values)
																										{ $selected = "selected"; }
																									else { $selected = ""; }
																									/*echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';*/
																									echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper((isset($extra_value) && $extra_value!='' && $options_value['display_value']!='Other') ? $options_value['field_value'].' - '.$options_value['display_value'] : $options_value['display_value']).'</option>';
																								}		
																								// echo '<option value="Other" '.$selectOther.'>OTHER</option>';
																						echo'</select>
																						</div>
																					</div>';
																				}
																			}

																			if(array_search('Other', array_column($options, 'field_value')) !== false) {
																			    echo '<div class="form-group row row_hide_other" id="row_hide_other_'.$value['id'].'">
																						<div class="col-md-6">&nbsp;</div>	
																						<div class="col-md-'.$value['field_size'].'">
																						<input type="text" class="form-control checkother form-control-sm  '.$styl.' " name="'.$value['id'].'_other" id="'.$value['id'].'_other" placeholder="If other please specify" '.$readonly.'>
																					</div>
																				</div>';
																			}
																		}
																		
																	}
																	else if ($value['field_type']=='3') {
																		
																		?>
																		<script>
																			
																			$(document).ready(function() {
																		        $('#<?php echo $value['id']; ?>').multiselect({
																		        });
																		    }); 
																		</script>
																		<?php
																		$label_id = $value['id'];
																		$options = get_default_values_dropdown($value['id']);	
																		$default_values_array=explode('||',$default_values);
																		// pre($default_values_array);
																		// pre($options);
																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'" data-field-id="'.$value['id'].'">
																					'.$field_label.'
																				<div class="col-md-'.$value['field_size'].'">';
																				if($value['id']==47){
																				if($Editable != ''){
																					// echo '<select name="'.$value['id'].'[]" id="'.$value['id'].'" class="form-control form-control-sm select_onchange  '.$validation_class.' '.$pop_field_class.'" '.$is_required.'  multiple="multiple" data-fouc '.$data_id.'>';
																					// 	foreach ($options as $options_key => $options_value) {
																					// 		if(in_array($options_value['display_value'],$default_values_array))
																					// 				//if($options_value->po_bu_code == $default_values)
																					// 					{ $selected = "selected"; }
																					// 				else { $selected = ""; }
																					// 		echo '<option value="'.$options_value['display_value'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';
																					// 	}		
																					// echo'</select>';

																					echo '<select name="'.$value['id'].'[]" id="'.$value['id'].'" class="form-control form-control-sm select_onchange checkdynamic_selectbox '.$validation_class.' '.$pop_field_class.' multiselect-display-values" '.$is_required.'  multiple="multiple" data-fouc '.$data_id.'>';
															
																						foreach ($options as $options_key => $options_value) {
																							if(in_array($options_value['display_value'],$default_values_array))
																									//if($options_value->po_bu_code == $default_values)
																										{ $selected = "selected"; }
																									else { $selected = ""; }
																							echo '<option value="'.$options_value['display_value'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';
																						}

																						echo'</select>
																						<div id="values-area-'.$label_id.'" class="mt-2 font-weight-bold"></div>';
																				
																					}
																				else{
																					$multiselect_value = '';
																					foreach ($options as $options_key => $options_value) {
																							if(in_array($options_value['display_value'],$default_values_array))
																								{ 
																									if($multiselect_value==''){
																										$multiselect_value .= '<span class="" main_field_id="'.$value['id'].'"  newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span>'; 
																									}else{
																										$multiselect_value .= ', <span class="" main_field_id="'.$value['id'].'"  newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span>'; 
																									}
																								}
																					}
																					if($multiselect_value<>''){
																					echo '<div id="preview_'.$value['id'].'" class="preview_1459 mt-2 font-weight-bold alert alert-info">';
																						echo $multiselect_value; 
																					echo'</div>';
																					}
																					

																				}
																				}else if($value['id']==77){
																				if($Editable != ''){

																					echo '<select name="'.$value['id'].'[]" id="'.$value['id'].'" class="form-control form-control-sm select_onchange checkdynamic_selectbox '.$validation_class.' '.$pop_field_class.' multiselect-display-values" '.$is_required.'  multiple="multiple" data-fouc '.$data_id.'>';
															
																						foreach ($options as $options_key => $options_value) {
																							if(in_array($options_value['display_value'],$default_values_array))
																									//if($options_value->po_bu_code == $default_values)
																										{ $selected = "selected"; }
																									else { $selected = ""; }
																							echo '<option value="'.$options_value['display_value'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';
																						}
																								
																					echo'</select>
																						<div id="values-area-'.$label_id.'" class="mt-2 font-weight-bold"></div>';


																					// echo '<select name="'.$value['id'].'[]" id="'.$value['id'].'" class="form-control form-control-sm select_onchange  '.$validation_class.' '.$pop_field_class.'" '.$is_required.'  multiple="multiple" data-fouc '.$data_id.'>';
																					// 	foreach ($options as $options_key => $options_value) {
																					// 		if(in_array($options_value['display_value'],$default_values_array))
																					// 				//if($options_value->po_bu_code == $default_values)
																					// 					{ $selected = "selected"; }
																					// 				else { $selected = ""; }
																					// 		echo '<option value="'.$options_value['display_value'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';
																					// 	}		
																					// echo'</select>';
																				
																					}
																				else{
																					$multiselect_value = '';
																					foreach ($options as $options_key => $options_value) {
																					
																							if(in_array($options_value['display_value'],$default_values_array))
																								{ 
																									if($multiselect_value==''){
																										$multiselect_value = '<span class="" main_field_id="'.$value['id'].'"  newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span>'; 
																									}else{
																									$multiselect_value .= ', <span class="" main_field_id="'.$value['id'].'"  newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span> &nbsp;&nbsp;'; 
																									}
																								
																								}
																								// else{
																									// foreach ($default_values_array as $d_key => $d_val) {
																										// $multiselect_value .= '<span class="badge badge-secondary select_onchange" main_field_id="'.$value['id'].'"  newid="'.$d_val.'" spanvalue="'.$d_val.'">'.strtoupper($d_val).'</span> &nbsp;&nbsp;';
																									// }
																								// }
																					}
																					if($multiselect_value<>''){
																					echo '<div id="preview_'.$value['id'].'" class="preview_1459 mt-2 font-weight-bold alert alert-info">';
																						echo $multiselect_value; 
																					echo'</div>';
																					}

																				}
																				}else{
																				
																				//pre($default_values_array);
																					if($Editable != ''){
																						// echo '<select name="'.$value['id'].'[]" id="'.$value['id'].'" class="form-control form-control-sm select_onchange  '.$validation_class.' '.$pop_field_class.'" '.$is_required.'  multiple="multiple" data-fouc '.$data_id.'>';
																						// foreach ($options as $options_key => $options_value) {
																						// if(in_array($options_value['display_value'],$default_values_array))
																						// //if($options_value->po_bu_code == $default_values)
																						// { $selected = "selected"; }
																						// else if(in_array($options_value['display_value'],$default_values_array))
																						// //if($options_value->po_bu_code == $default_values)
																						// { $selected = "selected"; }
																						// else { $selected = ""; }
																						// echo '<option value="'.$options_value['display_value'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';
																						// }		
																						// echo'</select>';

																					echo '<select name="'.$value['id'].'[]" id="'.$value['id'].'" class="form-control form-control-sm select_onchange checkdynamic_selectbox '.$validation_class.' '.$pop_field_class.' multiselect-display-values" '.$is_required.'  multiple="multiple" data-fouc '.$data_id.'>';
															
																						foreach ($options as $options_key => $options_value) {
																							if(in_array($options_value['display_value'],$default_values_array))
																							//if($options_value->po_bu_code == $default_values)
																							{ $selected = "selected"; }
																							else if(in_array($options_value['display_value'],$default_values_array))
																							//if($options_value->po_bu_code == $default_values)
																							{ $selected = "selected"; }
																							else { $selected = ""; }
																							echo '<option value="'.$options_value['display_value'].'" '.$selected.'>'.strtoupper($options_value['display_value']).'</option>';
																						}	
																								
																					echo'</select>
																						<div id="values-area-'.$label_id.'" class="mt-2 font-weight-bold"></div>';
																						

																					}else{
																									$multiselect_value = '';
																									foreach ($options as $options_key => $options_value) {
																											if(in_array($options_value['display_value'],$default_values_array))
																												{ 
																													if($multiselect_value==""){
																														$multiselect_value= '<span class=" select_onchange" main_field_id="'.$value['id'].'" newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span>';
																													}else{
																														$multiselect_value .= ', <span class=" select_onchange" main_field_id="'.$value['id'].'" newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span>';
																													}
																												
																												

																												}
																									}
																									if($multiselect_value<>''){
																										echo '<div id="preview_'.$value['id'].'" class="preview_1459 mt-2 font-weight-bold alert alert-info">';
																											echo $multiselect_value; 
																										echo'</div>';
																					}

																								}																					
																					}
																		echo '</div>
																		</div>';	
																		
																	}
																	else if ($value['field_type']=='4') {
																		$options = explode('||', $value['default_values']);
																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																						'.$field_label.'
																					<div class="col-md-'.$value['field_size'].'">';
																					foreach ($options as $options_key => $options_value) {
																						echo '<div class="form-check">
																								<label class="form-check-label">
																									<input type="radio" class="form-check-input  '.$validation_class.' " name="'.$value['id'].'" id="'.$value['id'].'" '.$is_required.'>
																									'.$options_value.'
																								</label>
																							</div>';	
																					}	

																			echo'</div>
																			</div>';
																	}
																	else if ($value['field_type']=='5') {
																		$options = explode('||', $value['default_values']);
																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																						'.$field_label.'
																					<div class="col-md-'.$value['field_size'].'">';
																					
																					foreach ($options as $options_key => $options_value) {
																						echo '<div class="form-check">
																								<label class="form-check-label">
																									<input type="checkbox" class="form-check-input '.$validation_class.' " name="'.$value['id'].'" id="'.$value['id'].'" '.$is_required.'>
																									'.$options_value.'
																								</label>
																							</div>';	
																					}	

																			echo'</div>
																			</div>';
																			
																	}
																	else if ($value['field_type']=='7') {
																		if($value['autofill'] == 1){
																				$autofill = 'autocomplete="nope"';
																			}
																			else{
																				$autofill = '';
																			}
																		if($value['id']== 24){
																			$comment_value = '';
																			foreach ($supplier_comments as $key_comments => $value_comments) {
																				$comment_value = strtoupper($value_comments['comment']);
																				$comment_value = strip_tags($comment_value);
																				break;
																			}
																			echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																							'.$field_label.'
																						<div class="col-md-'.$value['field_size'].'">
																							<textarea name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' '.$styl.' " placeholder="'.$value['place_holder'].'" '.$is_required.' col="30" row="3" '.$autofill.'  '.$comment_field.'>'.$comment_value.'</textarea>
																						</div>
																					</div>';
																		}
																		else{
																			echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																							'.$field_label.'
																						<div class="col-md-'.$value['field_size'].'">
																							<textarea name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm '.$validation_class.' '.$styl.' " placeholder="'.$value['place_holder'].'" '.$is_required.' col="30" row="3" '.$autofill.'  '.$comment_field.'>'.$default_values.'</textarea>
																						</div>
																					</div>';
																		}
																	}
																	// File Upload
																	else if ($value['field_type']=='8') {
																		// echo $default_values;
																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'" data-field-id="'.$value['id'].'">
																		'.$field_label.'
																			<div class="col-md-'.$value['field_size'].'">';
																				echo '<input type="hidden" class="form-control h-auto check_input_files" name="'.$value['id'].'_oldfile" id="'.$value['id'].'_oldfile" value="'.$default_values.'">';
																				
																				if($value['id']==1459){
																					if($Editable !=''){
																						echo '<input type="file" accept="'.FILE_EXTENSION_UPLOAD_INPUT.'"  class="form-control h-auto '.$validation_class.' " name="'.$value['id'].'" id="'.$value['id'].'" mutliple onchange="ValidateMultipleInput('.$value['id'].');">';
																					}
																					$supplier_upload_file=$CI->Smartform_Model->check_supplier_upload_file($sup_id,$value['id']);
																					if(count($supplier_upload_file)>0){
																					if ($value['id'] == 194 || $value['id'] == 195 || $value['id'] == 198 || $value['id'] == 199 || $value['id'] == 213 || $value['id'] == 233 || $value['id'] == 246 || $value['id'] == 255 || $value['id'] == 257 || $value['id'] == 262 || $value['id'] == 265 || $value['id'] == 267 || $value['id'] == 273 || $value['id'] == 279 || $value['id'] == 282 || $value['id'] == 284 || $value['id'] == 286 || $value['id'] == 289 || $value['id'] == 291 || $value['id'] == 295 || $value['id'] == 298 || $value['id'] == 330) {
																							$upload_path = SUPPLIER_UPLOAD_PATH;
																						}
																						else{
																							$upload_path = UPLOAD_PATH;
																						}
																						echo '<div id="preview_1459" class="preview_1459 mt-2 font-weight-bold alert alert-info">';
																						foreach($supplier_upload_file as $fileKey => $fileValue){
																							$delFilename="'".$fileValue['file_name']."'";
																							if($Editable !=''){
																							echo '<span class="field_id_'.$value['id'].'" id="file_'.$fileValue['id'].'"><a href="'.$upload_path.'payterm_file/'.$fileValue['file_name'].'"  download target="_blank"><b>'.$fileValue['display_name'].'</b></a>&nbsp;&nbsp;&nbsp;<i class="icon-trash mr-2 text-danger" style="cursor:pointer;" onclick="removeUploadedFile('.$fileValue['id'].','.$delFilename.','.$value['id'].')"></i></span></br>';
																							}else{
																							echo '<span id="file_'.$fileValue['id'].'"><a href="'.$upload_path.'payterm_file/'.$fileValue['file_name'].'" target="_blank"><b>'.$fileValue['display_name'].'</b></a></span></br>';
																							}
																							}
																						echo '</div>';
																					}else{
																						echo '<div id="preview_1459" class="preview_1459 mt-2 font-weight-bold alert alert-info">';
																										echo '<b>No Files Found</b>';
																								echo'</div>';
																						}
																					}else{
																					if($Editable !=''){
																						echo '<input type="file" accept=".doc,.docx,.pdf,.xlsx,.xls,.ppt, .pptx"  class="form-control h-auto '.$validation_class.' " name="'.$value['id'].'" id="'.$value['id'].'" onchange="ValidateSingleInput(this);">';
																					}
																					if($default_values == ''){
																						echo '<br><span class="badge badge-secondary" style="/*font-size:14px;*/">NO FILES FOUND</span>';
																					}
																					else{
																						if ($value['id'] == 194 || $value['id'] == 195 || $value['id'] == 198 || $value['id'] == 199 || $value['id'] == 213 || $value['id'] == 233 || $value['id'] == 246 || $value['id'] == 255 || $value['id'] == 257 || $value['id'] == 262 || $value['id'] == 265 || $value['id'] == 267 || $value['id'] == 273 || $value['id'] == 279 || $value['id'] == 282 || $value['id'] == 284 || $value['id'] == 286 || $value['id'] == 289 || $value['id'] == 291 || $value['id'] == 295 || $value['id'] == 298 || $value['id'] == 330) {
																							$upload_path = SUPPLIER_UPLOAD_PATH;
																						}
																						else{
																							$upload_path = UPLOAD_PATH;
																						}
																						echo '<br><a href="'.$upload_path.'payterm_file/'.$default_values.'" download target="_blank"><span class="badge badge-secondary" style="font-size:14px;">Click here to view the loaded file</span></a>';
																					}
																				}
																				
																		echo '</div>
																		</div>';
																	}
																	// Date field
																	else if ($value['field_type']=='9') {
																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'" data-field-id="'.$value['id'].'">
																		'.$field_label.'
																			<div class="col-md-'.$value['field_size'].'">';
																				$date_style='';
																				if($readonly<>''){
																					$date_style='style="pointer-events:none;cursor: not-allowed;"';
																				}
																				echo'<input type="text" class="form-control h-auto '.$validation_class.'" name="'.$value['id'].'" id="'.$value['id'].'" value="'.$default_values.'" '.$date_style.' >
																			</div>
																		</div>';
																	?>
																	<input type="hidden" value="<?php echo $value['default_values'];?>" id="<?php echo $value['id'];?>_date_default_values">
																	<script>		
																		$(function() {
																			/*var date_default_values = <?php $date_default_values;?>*/
																			var date_default_values = $('#<?php echo $value['id'];?>_date_default_values').val();
																			var date = new Date();
																			var currentMonth = date.getMonth();
																			var currentDate = date.getDate();
																			var currentYear = date.getFullYear();
																			/*console.log("<?php echo $value['id']; ?>_"+date_default_values+"_testdate");*/
																			if(date_default_values == 'past'){
																				$("#<?php echo $value['id']; ?>").datepicker({showOn: 'focus',changeMonth: true,
																					changeYear: true,dateFormat: 'yy-mm-dd',
																					maxDate: new Date(currentYear, currentMonth, currentDate)
																				});
																			}
																			else if(date_default_values == 'future'){
																				$("#<?php echo $value['id']; ?>").datepicker({showOn: 'focus',changeMonth: true,
																					changeYear: true,dateFormat: 'yy-mm-dd',
																					minDate: new Date(currentYear, currentMonth, currentDate)
																				});
																			}
																			else{
																				$("#<?php echo $value['id']; ?>").datepicker({showOn: 'focus',changeMonth: true,
																					changeYear: true,dateFormat: 'yy-mm-dd'
																				});
																			}
																		});
																		
																	</script>
																	<?php
																	}
																	// <input type="file" class="form-control h-auto" name="'.$value['id'].'" id="'.$value['id'].'" >
																}
															}
													// }
													
												}
										echo'</div>';
									}
									 

								$validate_array_json=json_encode($validation_array);
								// pre($validate_array_json);

								?>
								
							</div>
						</fieldset>						
						<div class="d-flex justify-content-end align-items-center">
							<input type="hidden" value="<?php echo $original_form_id;?>" id="form_id" name="form_id">
							<input type="hidden" value="<?php echo $original_status;?>" id="status" name="status">
							<input type="hidden" value="<?php echo $sup_id;?>" id="sup_id" name="sup_id">
							<input type="hidden" value="<?php echo $sup_alei;?>" id="alei" name="alei">
							<input type="hidden"  id="submit_value" name="submit_value">


							<?php
							$current_supplier_details=get_supplier_value_by_field($sup_id,15);
							$current_supplier_legalname=get_supplier_value_by_field($sup_id,42);
							$exist_supplier_email=$current_supplier_details->field_value;
							$exist_supplier_legalname=$current_supplier_legalname->field_value;
							if($current_supplier_email<>$exist_supplier_email){
								$submit_check="yes";
								$verified="yes";
								$legal_name=$get_suplier_master->legal_name;
								$associated_request_ids=get_associated_request_ids($current_supplier_email,$legal_name);
							}else{
								$associated_request_ids='';
							}
							
							?>	
							<input type="hidden" value="<?php echo $legal_name;?>" id="selected_legal_name" name="selected_legal_name">	
							<input type="hidden" name="clone_request_id_supplier_info" id="clone_request_id_supplier_info" value="<?php echo $verified; ?>" > 
							<input type="hidden" name="verified_sts" id="verified_sts" value="<?php echo $verified; ?>" > 
							<input type="hidden" name="associated_requests_ids" id="associated_requests_ids" value="<?php echo $associated_request_ids; ?>" > 
							<input type="hidden" name="submit_check" id="submit_check" value="<?php echo $submit_check; ?>" > 
							<input type="hidden" name="sup_clone_access_permission" id="sup_clone_access_permission" value="" > 
							<input type="hidden" name="selected_supplier_email" id="selected_supplier_email" value="<?php echo $exist_supplier_email; ?>" >
							<input type="hidden" name="selected_supplier_legalname" id="selected_supplier_legalname" value="<?php echo $exist_supplier_legalname; ?>" >
							<input type="hidden" name="supplier_completed_status" id="supplier_completed_status" value="<?php echo $current_sup_supplier_status; ?>" >
							<input type="hidden" name="pop_title" id="pop_title" value="<?php echo $pop_title; ?>" >
							<?php 
								$get_rmv_btn_status=sup_clone_button_status($sup_id);
								// pre($get_rmv_btn_status);
								if (is_array($get_rmv_btn_status)) {
								    $legal_name_Intrack = $get_rmv_btn_status['supplier_legalname'];
								    $sup_email_Intrack = $get_rmv_btn_status['supplier_email_address'];
								}	

							 if($role_id==1){
							 	 if(!empty($get_rmv_btn_status) && $original_status == 'Rejected' && $current_sup_supplier_status==0){?>			
							 	 	<input type="hidden" name="legal_name_Intrack" id="legal_name_Intrack" value="<?php echo $legal_name_Intrack; ?>" >
									<input type="hidden" name="sup_email_Intrack" id="sup_email_Intrack" value="<?php echo $sup_email_Intrack; ?>" >							
							 	 	<button type="button" class="btn btn-danger " name="remove_sup_info_cloned_edit" id="remove_sup_info_cloned_edit" onclick='remove_sup_cloned_info_edit()'>Remove cloned Supplier Info <i class="icon-user-cancel ml-2"></i></button> &nbsp; &nbsp;
 
							 <?php
							 	 }
							 }							
							?>
							<?php
							$button_display='';
							// echo $permisson;
							$role_id = logged_in_role_id();
							if($reject_comment <> ''){
										// echo '<span class="float-left text-danger" style="text-align: left"><b>Reject comments :</b> <br>'.$reject_comment.'</span>';
									}

							$display_label_name=$form_details->label_display;
							$getstatus=item_default_status($original_status);
						    $label_color=$getstatus->color;
							//echo $permisson;

						   						    

							if($permisson == 'Yes'){
								if($role_id==1){

								    if($original_status == 'Rejected'){
								    	
		 								$button_display='<button type="submit" name="submit" id="update_btn" class="btn btn-primary">Update<i class="icon-paperplane ml-2"></i></button>';
	 								}else if($original_status == 'Completed'){
				                		//$Display_status = 'Request has been uploaded to '.$display_label_name.'';
				                		$Display_status = 'Request Completed';
				                		$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_status.'</b></span>';
				                	}else if($original_status == 'Closed'){
									//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
									$Display_status = 'Request Closed';
									$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_status.'</b></span>';
									}else{
				                		$Display_status = 'Request Pending at '.$get_form_label_name;
				                		$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_status.'</b></span>';
				                	}
								}
								else if($role_id==8 || $role_id==7){
									//echo $get_gsm_permission=get_gsm_permission($original_form_id,$sup_id);
									if($role_id==8){
										
										if(($current_user_name<>'GSM Category 1') && ($current_user_name<>'GSM Category 2')){
											
											$get_gsm_permission=get_gsm_permission($category_value,$user_id,'category');
											if($get_gsm_permission==0){
												if($original_status == 'Rejected'){
													$Display_label_status = 'Request has been rejected';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												}else if($original_status == 'Completed'){
													//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
													$Display_label_status = 'Request Completed';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												}else if($original_status == 'Closed'){
													//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
													$Display_label_status = 'Request Closed';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												}else{
													//$Display_label_status = 'Request sent for '.$display_label_name.' upload';
													$Display_label_status = 'Request Pending at '.$get_form_label_name;
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												}
											}else{
												if($original_status == 'Rejected'){
												// if($role_id==1){
												// 	$button_display='<button type="submit" name="submit" id="update_btn" class="btn btn-primary">Update<i class="icon-paperplane ml-2"></i></button>';
												// }else{
													$Display_label_status = 'Request has been rejected';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												//}
													}else if($original_status == 'Completed'){
														//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
														$Display_label_status = 'Request Completed';
														$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
													}else if($original_status == 'Closed'){
														//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
														$Display_label_status = 'Request Closed';
														$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
													}else{
														$check_permission_approve=check_permission_approve($sup_id,$original_status,$original_form_id);
														$check_for_flag=0;
														if($check_permission_approve['is_complete']==1){
															
															$button_display.='<button type="button" name="Approve" id="approve" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Request Uploaded to ERP</button><button type="button" name="" id="" class="btn btn-danger btn-sm d-none" onclick="close_window();return false;"><i class="icon-cross3"></i>Close Window</button>';
															$check_for_flag=1;
														}
														if($check_permission_approve['is_approve']==1){
															
															$button_display.='<button type="button" name="Approve" id="update_gsm_finance" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Approve Request for Upload</button>';
															$check_for_flag=1;
														}
														if($check_permission_approve['is_reject']==1){
															
															$button_display.='<button type="button" name="Rejected" id="reject" class="btn btn-danger btn-sm"><i class="icon-cross3"></i> Reject Request </button>';
															$check_for_flag=1;
														}
														if($check_for_flag==1){
															$button_display.='&nbsp;&nbsp;&nbsp;<button type="button" name="add_flag" id="add_flag" class="btn btn-info btn-sm"><i class="icon-flag3"></i> Update Status</button>';
														}
													}
											}
											
										}else{
											if($original_status == 'Rejected'){
													$Display_label_status = 'Request has been rejected';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
											}else if($original_status == 'Completed'){
												//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
												$Display_label_status = 'Request Completed';
												$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
											}else if($original_status == 'Closed'){
												//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
												$Display_label_status = 'Request Closed';
												$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
											}else{
												
												$check_permission_approve=check_permission_approve($sup_id,$original_status,$original_form_id);
												$check_for_flag=0;
												if($check_permission_approve['is_complete']==1){
													$button_display.='<button type="button" name="Approve" id="approve" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Request Uploaded to ERP</button><button type="button" name="" id="" class="btn btn-danger btn-sm d-none" onclick="close_window();return false;"><i class="icon-cross3"></i>Close Window</button>';
													$check_for_flag=1;
												}
												if($check_permission_approve['is_approve']==1){
													
													$button_display.='<button type="button" name="Approve" id="update_gsm_finance" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Approve Request for Upload</button>';
													$check_for_flag=1;
												}
												if($check_permission_approve['is_reject']==1){
													
													$button_display.='<button type="button" name="Rejected" id="reject" class="btn btn-danger btn-sm"><i class="icon-cross3"></i> Reject Request </button>';
													$check_for_flag=1;
												}
												if($check_for_flag==1){
													$button_display.='&nbsp;&nbsp;&nbsp;<button type="button" name="add_flag" id="add_flag" class="btn btn-info btn-sm"><i class="icon-flag3"></i> Update Status</button>';
												}
											}
										}
										
									}else{
									
									//division
										if(($current_user_name<>'GSM Division 1') && ($current_user_name<>'GSM Division 2')){
										
											$get_gsm_permission=get_gsm_permission($division_value,$user_id,'division');
											if($get_gsm_permission==0){
												if($original_status == 'Rejected'){
													$Display_label_status = 'Request has been rejected';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												}else if($original_status == 'Completed'){
													//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
													$Display_label_status = 'Request Completed';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												}else if($original_status == 'Closed'){
													//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
													$Display_label_status = 'Request Closed';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												}else{
													//$Display_label_status = 'Request sent for '.$display_label_name.' upload';
													$Display_label_status = 'Request Pending at '.$get_form_label_name;
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												}
											}else{
												if($original_status == 'Rejected'){
												// if($role_id==1){
												// 	$button_display='<button type="submit" name="submit" id="update_btn" class="btn btn-primary">Update<i class="icon-paperplane ml-2"></i></button>';
												// }else{
													$Display_label_status = 'Request has been rejected';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												//}
													}else if($original_status == 'Completed'){
														//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
														$Display_label_status = 'Request Completed';
														$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
													}else if($original_status == 'Closed'){
													//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
													$Display_label_status = 'Request Closed';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
													}else{
														$check_permission_approve=check_permission_approve($sup_id,$original_status,$original_form_id);
														$check_for_flag=0;
														if($check_permission_approve['is_complete']==1){
															$button_display.='<button type="button" name="Approve" id="approve" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Request Uploaded to ERP</button><button type="button" name="" id="" class="btn btn-danger btn-sm d-none" onclick="close_window();return false;"><i class="icon-cross3"></i>Close Window</button>';
															$check_for_flag=1;
														}
														if($check_permission_approve['is_approve']==1){
															
															$button_display.='<button type="button" name="Approve" id="update_gsm_finance" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Approve Request for Upload</button>';
															$check_for_flag=1;
														}
														if($check_permission_approve['is_reject']==1){
															
															$button_display.='<button type="button" name="Rejected" id="reject" class="btn btn-danger btn-sm"><i class="icon-cross3"></i> Reject Request </button>';
															$check_for_flag=1;
														}
														if($check_for_flag==1){
															$button_display.='&nbsp;&nbsp;&nbsp;<button type="button" name="add_flag" id="add_flag" class="btn btn-info btn-sm"><i class="icon-flag3"></i> Update Status</button>';
														}
													}
											}
											
										}else{
										
											if($original_status == 'Rejected'){
												// if($role_id==1){
												// 	$button_display='<button type="submit" name="submit" id="update_btn" class="btn btn-primary">Update<i class="icon-paperplane ml-2"></i></button>';
												// }else{
													$Display_label_status = 'Request has been rejected';
													$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
												//}
											}else if($original_status == 'Completed'){
												//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
												$Display_label_status = 'Request Completed';
												$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
											}else if($original_status == 'Closed'){
													//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
													$Display_label_status = 'Request Closed';
													$label_button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$button_display.'</b></span>';
											}else{
												$check_permission_approve=check_permission_approve($sup_id,$original_status,$original_form_id);
												$check_for_flag=0;
												if($check_permission_approve['is_complete']==1){
													$button_display.='<button type="button" name="Approve" id="approve" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Request Uploaded to ERP</button><button type="button" name="" id="" class="btn btn-danger btn-sm d-none" onclick="close_window();return false;"><i class="icon-cross3"></i>Close Window</button>';
													$check_for_flag=1;
												}
												if($check_permission_approve['is_approve']==1){
													
													$button_display.='<button type="button" name="Approve" id="update_gsm_finance" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Approve Request for Upload</button>';
													$check_for_flag=1;
												}
												if($check_permission_approve['is_reject']==1){
													
													$button_display.='<button type="button" name="Rejected" id="reject" class="btn btn-danger btn-sm"><i class="icon-cross3"></i> Reject Request </button>';
													$check_for_flag=1;
												}
												if($check_for_flag==1){
													$button_display.='&nbsp;&nbsp;&nbsp;<button type="button" name="add_flag" id="add_flag" class="btn btn-info btn-sm"><i class="icon-flag3"></i> Update Status</button>';
												}
											}
										}
									}
								}else{
									if($original_status == 'Rejected'){
										// if($role_id==1){
										// 	$button_display='<button type="submit" name="submit" id="update_btn" class="btn btn-primary">Update<i class="icon-paperplane ml-2"></i></button>';
										// }else{
								    		$Display_label_status = 'Request has been rejected';
		 									$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
		 								//}
	 								}else if($original_status == 'Completed'){
				                		//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
				                		$Display_label_status = 'Request Completed';
				                		$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
				                	}else if($original_status == 'Closed'){
										//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
										$Display_label_status = 'Request Closed';
										$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
									}else{
				                		$check_permission_approve=check_permission_approve($sup_id,$original_status,$original_form_id);
										$check_for_flag=0;
										if($check_permission_approve['is_complete']==1){
											
											if($role_id==9){
												$btn_name_change="Request Uploaded to Tradeshift";	
											}else{
												$btn_name_change="Request Uploaded to ERP";
											}
											
											$button_display.='<button type="button" name="Approve" id="approve" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i>'.$btn_name_change.'</button><button type="button" name="" id="" class="btn btn-danger btn-sm d-none" onclick="close_window();return false;"><i class="icon-cross3"></i>Close Window</button>';
											$check_for_flag=1;
										}
										if($check_permission_approve['is_approve']==1){
											
											$button_display.='<button type="button" name="Approve" id="update_gsm_finance" class="btn btn-success btn-sm mr-2"><i class="icon-checkmark2"></i> Approve Request for Upload</button>';
											$check_for_flag=1;
										}
										if($check_permission_approve['is_reject']==1){
											
											$button_display.='<button type="button" name="Rejected" id="reject" class="btn btn-danger btn-sm"><i class="icon-cross3"></i> Reject Request </button>';
											$check_for_flag=1;
										}
										if($check_for_flag==1){
											$button_display.='&nbsp;&nbsp;&nbsp;<button type="button" name="add_flag" id="add_flag" class="btn btn-info btn-sm"><i class="icon-flag3"></i> Update Status</button>';
										}
									}

								}
							}
							else{
							    if($original_status == 'Rejected'){
							    	$Display_label_status = 'Request has been rejected';
	 								$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
 								}else if($original_status == 'Completed'){
			                		//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
			                		$Display_label_status = 'Request Completed';
			                		$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
			                	}else if($original_status == 'Closed'){
									//$Display_label_status = 'Request has been uploaded to '.$display_label_name.'';
									$Display_label_status = 'Request Closed';
									$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
								}else{
			                		//$Display_label_status = 'Request sent for '.$display_label_name.' upload';
									$Display_label_status = 'Request Pending at '.$get_form_label_name;
			                		$button_display='<span class="badge bg-'.$label_color.'-400"><b class="font-size-lg">'.$Display_label_status.'</b></span>';
			                	}
								
							}	
							echo $button_display;
							?>
						</div>
					</form>
				</div>
			</div>
			<!-- comments section -->
			<?php
			$display_comments = '';
			if(logged_in_role_id() != 10){
				if (count($supplier_comments)>0){
			?>
			<div class="card mt-3">
				<div class="card-header header-elements-inline">
					<div class="form_group_text_comments card-title">User Comments</div>
					<div class="header-elements">
						<!--ul class="list-inline list-inline-dotted text-muted mb-0">
							<li class="list-inline-item">42 comments</li>
							<li class="list-inline-item">75 pending review</li>
						</ul-->
                	</div>
				</div>
				<div class="card-body">
					<ul class="media-list">
							
					<?php
						$display_comments = '';
               			$doc_upload_path = base_url().'assets/uploads/payterm_file';								
						
						foreach ($supplier_comments as $key => $value) {
								$sup_id=$value['sup_id'];
								$role_id=$value['requestor_role_id'];
								$process_seq=$value['process_seq'];
								$receiver_user_id=$value['receiver_user_id'];
								if($receiver_user_id<>0){
									$receiver_user=$receiver_user_id;
								}else{
									$receiver_user=$value['requestor_user_id'];
								}
								$requestor_username=get_user_name($receiver_user);
								$req_user_name=$requestor_username->name;
								$rolemodified = get_role_name($role_id);
               					$modified_role_name = strtoupper($rolemodified->name);
               					$item_status=$value['item_status'];
               					if($item_status=="Rejected"){
               						$text_class="text-danger";
               					}else{
									$text_class="";
               					}

               					if($key>0){
									$display_comments .= '<hr class="mt-2">';
               					}
								$display_comments .= '<li class="media flex-column flex-md-row">
										<div class="mr-md-3 mb-2 mb-md-0">
											 <a href="#" target="_blank" class="btn bg-warning-400 rounded-round btn-icon btn-sm">
	                                            <span class="letter-icon">'.strtoupper(substr($req_user_name, 0,1)).'</span>
	                                        </a>
										</div>

										<div class="media-body">
											<div class="media-title">
												<span class="badge badge-dark" style="border-radius: 1.125rem !important;"><b class="font-size-8">'.$modified_role_name.'</b></span>
												<div class="font-weight-semibold font-size-lg text-primary">'.$req_user_name.'&nbsp;&nbsp;&nbsp;<span class="text-default font-size-xs font-weight-light"><i class="icon-calendar3" style="font-size:12px;"></i> '.$value['requested_on'].'</span></div><div class="font-weight-semibold font-size-lg text-primary"><span class="text-default font-size-xs font-weight-light">';
													$approvers_attachments=get_approvers_upload_list($sup_id,$process_seq,$role_id);
													if($approvers_attachments <>''){
														foreach ($approvers_attachments as $uploads_key => $uploads_value) {
															 $file_name_modified=$uploads_value['file_name_modified'];
															 $file_name_original=$uploads_value['file_name_original'];
															 
															$display_comments .= '<i class="icon-attachment text-secondary" style="font-size:15px;"></i>';		
															// $display_comments .= '<a href="'.$upload_path.'payterm_file/'.$file_name_modified.'" target="_blank"><span class="text-success" style="font-size:14px;"><b>&nbsp;'.$file_name_original.'</b>&nbsp;&nbsp;&nbsp;</span></a>';	
															$display_comments .= '<a href="'.$doc_upload_path.'/'.$file_name_modified.'" target="_blank"><span class="text-success" style="font-size:14px;"><b>&nbsp;'.$file_name_original.'</b>&nbsp;&nbsp;&nbsp;</span></a>';		

														}
													}

											$display_comments .='</div></div>
											
											
											<p class="'.$text_class.' font-size-lg">'.strtoupper($value['comment']).'</p>

											<ul class="list-inline list-inline-dotted font-size-sm d-none">
												<li class="list-inline-item text-muted">'.$value['requested_on'].'<!--a href="#"><i class="icon-arrow-up22 text-success"></i></a><a href="#"><i class="icon-arrow-down22 text-danger"></i></a></li-->
												<!--li class="list-inline-item"><a href="#">Reply</a></li>
												<li class="list-inline-item"><a href="#">Edit</a></li-->
											</ul>
										</div>
									</li>';


						}
						echo $display_comments;
					?>
				</ul>
				</div>
			</div>
			<?php
				}
			}
			?>
			<!-- comments section -->
		</div>
	</div>
</div>
<div class="d-none display_comments" id="display_comments">
	 <?php echo $display_comments;?>
</div>
<br>
<!--- Modal box -->
<div id="modal_theme_primary" class="modal fade" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title">Request Form</h6>
				<button type="button" class="close" data-dismiss="modal" onclick="rest_modal();">&times;</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-md-2 d-none" style="padding-top:10px;">
						<input type="radio" name="get_supplier_values" id="get_supplier_values1" value="SDM"  onchange="searchSupplier(1);">&nbsp;&nbsp;<label class="font-weight-semibold">Supplier - SDM</label>
					</div>
					<div class="col-md-3" style="padding-top:10px;">
						<input type="radio" name="get_supplier_values" id="get_supplier_values2" value="ALEI" checked="checked" onchange="searchSupplier(1);">&nbsp;&nbsp;<label class="font-weight-semibold">Supplier - Corning ALEI</label>
					</div>
					<div class="col-md-2 d-none" style="padding-top:10px;">
						<input type="radio" name="get_supplier_values" id="get_supplier_values3" value="NEW" onchange="add_as_new_supplier();">&nbsp;&nbsp;&nbsp;<label class="font-weight-semibold">New Supplier</label>
					</div>
					<div class="col-md-4" style="padding-top:10px;">
					</div>
					<div class="col-md-5" id="col_adjust">
						<input type="text" class="form-control" name="search_supplier" id="search_supplier" style="margin-bottom:10px;" placeholder="Search Supplier">
					</div>
					<div class="col-md-1" id="add_new_sup">
					</div>
				</div>
				<div class="table-responsive" id="supplier_result">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="th_bg">#</th>
								<th class="th_bg">ALEI</th>
								<th class="th_bg">Supplier Name</th>
								<th class="th_bg">City</th>
								<th class="th_bg">State</th>
								<th class="th_bg">Country</th>
							</tr>
						</thead>
						<tbody id="appendDatas_supplier">
							<?php
								// if(count($suppliers)>0){
								// foreach($suppliers as $suppliers_key => $suppliers_value){
								// echo "<tr>
								// <td><input type='radio'></td>	
								// <td>".strtoupper($suppliers_value['alei'])."</td>	
								// <td>".strtoupper($suppliers_value['sup_legal_name'])."</td>	
								// <td>".strtoupper($suppliers_value['city'])."</td>	
								// <td>".strtoupper($suppliers_value['state'])."</td>	
								// <td>".strtoupper($suppliers_value['country'])."</td>	
								// </tr>";
								// }
								// }else{
								// echo "<tr><td colspan='6'>No Records Found</td></tr>";
								// }
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer"> 
				<span class="text-muted d-none">Total No of records available: <b class="text-danger" id="totalCount_supplier">0</b></span> 
				<span id="pagination_supplier">
					<nav aria-label="Page navigation example" id="pagination_supplier">
					</nav>
				</span>
			</div>
		</div>
	</div>
</div>
<!--- Modal box -->
+<div id="modal_theme_danger" class="modal fade" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title">Clone Supplier information</h6>
				<button type="button" class="close" data-dismiss="modal" onclick="rest_modal();">&times;</button>
			</div>
			
			<div class="modal-body">		
				
					<div class="" id="appendDatas_supplier_clone_ids" style="max-height: 600px;overflow:auto;">						
					</div>
			
			</div>	
		</div>
	</div>
</div>
<!--- Modal box -->
<?php 
	$this->session->unset_userdata('exist_supplier_data');	
?>
<!--script src="<?php echo VENDOR_URL;?>js/validate.min.js"></script>
<script src="<?php echo VENDOR_URL;?>js/formJS.js"></script-->
<script type="text/javascript">
function validate_approver_attachments() {
	var app_file_count = $('#app_file_count').val();
    var approver_files = $('#approver_attachments_'+app_file_count)[0].files;
    var container = $('#approver_attachments_container');
    var file_div = $('#approver_upload_div');
    var maxFiles = 3;
    var allowedExtensions = ['.doc','.docx','.pdf','.xlsx','.xls','.ppt','.pptx','.jpeg','.jpg','.png'];
    var maxFileSizeMB = 2;
    var attachmentCounter = 0; // Counter for generating unique IDs
    var files_name_div = $('.attachment_name_display');
    var file_input_id=files_name_div.length;
    if (approver_files.length > 0) { 
        container.css('display', 'block');

        for (var i = 0; i < approver_files.length; i++) {
            var fileName = approver_files[i].name;
            var fileExtension = '.' + fileName.split('.').pop().toLowerCase();
            var fileSizeMB = approver_files[i].size / (1024 * 1024);
            if (!allowedExtensions.includes(fileExtension)) {
                $.alert({
                    title: 'Alert!',
                    content: 'Allowed File types are doc, docx, pdf, xlsx, xls, ppt, pptx, jpeg, jpg and png',
                }); 
                $('#approver_attachments_'+app_file_count).val('');               
                return false;
            }

            if (fileSizeMB > maxFileSizeMB) {
                $.alert({
                    title: 'Alert!',
                    content: 'Maximum file size allowed is ' + maxFileSizeMB + ' MB.',
                });               
                $('#approver_attachments_'+app_file_count).val('');               
                return false;
            }
          
            if (container.children('p').length >= maxFiles) {
                $.alert({
                    title: 'Alert!',
                    content: 'Maximum of ' + maxFiles + ' files allowed.',
                });               
                $('#approver_attachments_'+app_file_count).val('');               
                return false;
            }
            
            var attachmentId = 'attachment_' + attachmentCounter++;
           	$('#approver_attachments_'+app_file_count).hide();                      	
         
            container.append('<p class="attachment_name_display" id="attachment_name_display_'+app_file_count+'">' + fileName + ' (' + fileSizeMB.toFixed(2) + ' MB)  <a href="#" class="remove-link" onclick="removeAttachment(\'' + app_file_count + '\')"><i class="icon-trash mr-2 text-danger"></i></a></p>');

            var new_file_input_id=parseInt(app_file_count)+1;
             $('#app_file_count').val(new_file_input_id);
             file_div.append('<input type="file" id="approver_attachments_'+new_file_input_id+'" name="approver_attachments[]" class="" onchange="validate_approver_attachments()">');
        }
    } else {
        container.css('display', 'none');
    }
}

function removeAttachment(attachmentId) {
    $('#attachment_name_display_'+attachmentId).remove();
    $('#approver_attachments_'+attachmentId).remove();
}

$(function() {
	$('.js-example-basic-single').select2();
	   $('.row_hide_other').addClass('d-none'); 
	   $('.row_hide_other').removeClass('display_flex'); 
	    $('.other_select').change(function(){
	    	var id = $(this).attr('id');
	    	var selectedTextVal = $('#'+id+' option:selected').text();
				selectedTextVal = selectedTextVal.toUpperCase();
					if($('#'+id).val() == 'Other' || selectedTextVal=='OTHER') {
	            $('#row_hide_other_'+id).removeClass('d-none'); 
	            $('#row_hide_other_'+id).prop('required',true);
	            $('#'+id+"_other").prop('required',true);
	        } else {
	            $('#row_hide_other_'+id).addClass('d-none'); 
	            $('#'+id+'_other').val('');
	            $('#row_hide_other_'+id).prop('required',false);
	            $('#'+id+"_other").prop('required',false);
	        } 
	    });
	    $('#quick_update select').each(
		    function(index){  
		        var input = $(this);
		        // alert('Type: ' + input.attr('type') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());
		        /*console.log(input.attr('id'));*/
		        var id = input.attr('id');
		        var other_value = input.attr('data-other-value');
		        /*console.log(input.attr('data-other-value'));*/
		        var selectedTextVal = $('#'+id+' option:selected').text();
						selectedTextVal = selectedTextVal.toUpperCase();
						if($('#'+id).val() == 'Other' || selectedTextVal=='OTHER') {
		            $('#row_hide_other_'+id).removeClass('d-none'); 
		            $('#'+id+'_other').val(other_value);
		            $('#row_hide_other_'+id).prop('required',true);
		            $('#'+id+"_other").prop('required',true);
		        } else {
		            $('#row_hide_other_'+id).addClass('d-none'); 
		            $('#'+id+'_other').val('');
		            $('#row_hide_other_'+id).prop('required',false);
		            $('#'+id+"_other").prop('required',false);
		        }
		    }
		);
	});

$(document).ready(function(){


	$('#row_hide_other_91').hide();
	//$('.row_hide_other').addClass('d-none'); 
// 	$.validator.addMethod("nowhitespace", function(value, element) {
//     return this.optional(element) || /^\S+$/i.test(value);
// }, "No white space please");
//alert('test');
	// _componentValidation();
   // $('.js-example-basic-single').select2();
	$('input[type="submit"]').on('click', function(){
	      $('#quick_update').data('button', this.name);
	});
$('#58').removeAttr("required");
	var classHide = [ 48,51,52,53,57 ];
		jQuery.each( classHide, function( i, val ) {
			$('#'+val).removeAttr("required");
			//$('.'+val).addClass('d-none');
			 $('.'+val).addClass('d-none'); 
		});
	// var selectedValuesArray = [];
	// 	selectedValuesArray = $('#50').val();
	/*var classHide = [ 48,51,52,53,57 ];
	jQuery.each( classHide, function( i, val ) {
		$('.'+val).addClass('d-none');
	});*/
	
	/*var editable = '<?php echo $Editable; ?>';
	if(editable === 'js-example-basic-single'){
		
	}
	else{
		$('.select_onchange').trigger("change");
	}*/
	var selections = [];
	var main_field_id_selections = [];
	$('.select_onchange').each(function () {
		var id = $(this).attr('id');
		var main_field_id = $(this).attr('main_field_id');
		/*console.log("start_"+id+"_stop");*/

		if( typeof id === 'undefined' || id === null ){
		    var id = $(this).attr('newid');
		}
		if( typeof main_field_id === 'undefined' || main_field_id === null ){
		    var main_field_id = $(this).attr('main_field_id');
		}
		/*console.log("start_"+id+"_end");*/
		if(id == 47 || main_field_id == 47){
			// alert(id);
			var spanvalue = $(this).attr('spanvalue');
			// alert(spanvalue);
			if(spanvalue !='' && spanvalue !=undefined){
				/*console.log(spanvalue+"<br>");		*/
				selections.push(spanvalue);
			}
			else{
				$('#'+id+' :selected').each(function(i, sel){ 
					var selectedVal = $(sel).val();
					selections.push(selectedVal);
				});
			}
			/*console.log("hari");		*/
			/*console.log(selections);	*/
			// var classValue1 = [ 48 ];
			var classValue1 = [ 48,51 ];
			jQuery.each( classValue1, function( i, val ) {
				/*console.log("hari1_"+val);*/
				/*console.log("hari1_"+selections);*/
				if(jQuery.inArray("PeopleSoft v9.x", selections) != -1) {
				    /*console.log("is in array");*/
				    /*console.log("krish_"+val+"_");*/
					$('.'+val).removeClass('d-none'); 
					$('.'+val).prop('required',true);
					/*if(val == 51){*/
						$('#'+val).attr('required',true);
					/*}*/
					// $('#'+val).attr("class","badge badge-secondary select_onchange");
				} else {
				    /*console.log("is NOT in array");*/
				    $('.'+val).addClass('d-none'); 
				    $("[name='"+val+"[]']").prop('checked',false);	
				   // var values = $("."+val).find("span").attr("class","sol-quick-delete").click();
					$('.'+val).prop('required',false);
					/*if(val == 51){*/
						$('#'+val).removeAttr("required");
					/*}*/
					// $('#'+val).val('');
				}
			});
			var classValue2 = [ 52,53 ];
			jQuery.each( classValue2, function( i, val ) {
				if(jQuery.inArray("OC SAP ECC", selections) != -1 || jQuery.inArray("S4-HANA public", selections) != -1 || jQuery.inArray("S4 HANA private", selections) != -1) {
				    /*console.log("is in array");*/
					$('.'+val).removeClass('d-none'); 
					$('.'+val).prop('required',true);
					// $('#'+val).attr("class","badge badge-secondary select_onchange");
				} else {
				    /*console.log("is NOT in array");*/
				    $('.'+val).addClass('d-none'); 
				    $("[name='"+val+"[]']").prop('checked',false);
				   // var values = $('.'+val).find("span").attr("class","sol-quick-delete").click();
					$('.'+val).prop('required',false);
					$('#'+val).val('');
				} 
			});
		}
		// if(main_field_id == 47){
		// 	// alert(id);
		// 	var spanvalue = $(this).attr('spanvalue');
		// 	// alert(spanvalue);
		// 	if(spanvalue !='' && spanvalue !=undefined){
		// 		console.log(spanvalue+"<br>");		
		// 		main_field_id_selections.push(spanvalue);
		// 	}
		// 	else{
		// 		$('#'+id+' :selected').each(function(i, sel){ 
		// 			var selectedVal = $(sel).val();
		// 			main_field_id_selections.push(selectedVal);
		// 		});
		// 	}
		// 	// console.log("hari");		
		// 	// console.log(main_field_id_selections);	
		// 	var classValue1 = [ 48,51 ];
		// 	jQuery.each( classValue1, function( i, val ) {
		// 		if(jQuery.inArray("PeopleSoft v9.x", main_field_id_selections) != -1) {
		// 		    /*console.log("is in array");*/
		// 			$('.'+val).removeClass('d-none'); 
		// 			$('.'+val).prop('required',true);
		// 			// $('#'+val).attr("class","badge badge-secondary select_onchange");
		// 		} else {
		// 		    /*console.log("is NOT in array");*/
		// 		    $('.'+val).addClass('d-none'); 
		// 		    $("[name='"+val+"[]']").prop('checked',false);	
		// 		   // var values = $("."+val).find("span").attr("class","sol-quick-delete").click();
		// 			$('.'+val).prop('required',false);
		// 			$('#'+val).val('');
		// 		}
		// 	});
		// 	var classValue2 = [ 52,53 ];
		// 	jQuery.each( classValue2, function( i, val ) {
		// 		if(jQuery.inArray("OC SAP ECC", main_field_id_selections) != -1 || jQuery.inArray("S4-HANA public", main_field_id_selections) != -1 || jQuery.inArray("S4 HANA private", main_field_id_selections) != -1) {
		// 		    /*console.log("is in array");*/
		// 			$('.'+val).removeClass('d-none'); 
		// 			$('.'+val).prop('required',true);
		// 			// $('#'+val).attr("class","badge badge-secondary select_onchange");
		// 		} else {
		// 		    /*console.log("is NOT in array");*/
		// 		    $('.'+val).addClass('d-none'); 
		// 		    $("[name='"+val+"[]']").prop('checked',false);
		// 		   // var values = $('.'+val).find("span").attr("class","sol-quick-delete").click();
		// 			$('.'+val).prop('required',false);
		// 			$('#'+val).val('');
		// 		} 
		// 	});
		// }
	});

	$('.other_select').each(function () {
		var id = $(this).attr('id');
		var selections = [];
		$('#'+id+' :selected').each(function(i, sel){ 
			var selectedVal = $(sel).val();
			selections.push(selectedVal);
		});
		// alert(selections);
		console.log("hari_"+id);
		console.log(selections);
		if(id == 54){
			var classValue3 = [ 57 ];
			//alert(classValue3);
			jQuery.each( classValue3, function( i, val ) {
				/*if(jQuery.inArray("Shorten", selections) != -1) {*/
				if(jQuery.inArray("97", selections) != -1) {
				    /*console.log("is in array");*/
					$('.'+val).removeClass('d-none'); 
					$('.'+val).prop('required',true);
					var oldvalue = $('#'+val+'_oldfile').val();
					console.log("old_value"+oldvalue);
					if(oldvalue==''){
						$('#'+val).attr('required','required');
					}
					else{
						$('#'+val).removeAttr("required");
					}
				} else {
				    /*console.log("is NOT in array");*/
				    $('.'+val).addClass('d-none'); 
					$('.'+val).prop('required',false);
					$('#'+val).removeAttr("required");
					$('#'+val).val('');
				}
			});	
		}
		/*if(id == 23){
			var classValue4 = [ 63 ];
			jQuery.each( classValue4, function( i, val ) {
				//if(selections != 150 && selections != '') {
					//alert(val);
					$('.'+val).removeClass('d-none'); 
					$('#'+val).attr('required','required');
					//} else {
				//	$('.'+val).addClass('d-none'); 
					//$('#'+val).removeAttr("required");
					//$('#'+val).val('');
				//f}
			});	
		}*/
	});
	var valueListarray = [];
		$("#47 option").each(function()
		{
		   valueListarray.push($(this).val());
		});

		// supplier_indicate();
		$("#47").change(function() {	
			 supplier_indicate();
		});
		$(function() {
			var editable = '<?php echo $Editable; ?>';		
			if(editable!=''){
				supplier_indicate();
			}		
		});

		function supplier_indicate(){
			$('#50_remove').addClass('d-none'); 
			selectedValuesArray = [];
			$('#47 :selected').each(function(i, sel){ 
				var selectedValues = $(sel).val();				
				
				if(selectedValues.indexOf(', ') != -1){
				  selectedValues = selectedValues.replace(', ', '__');
				}
				selectedValuesArray.push(selectedValues);				
			});

			if(selectedValuesArray.length==0){
				$('#50_remove').removeClass('d-none'); 
			}

			$(valueListarray).each(function(index, element){
				var charsReplace = {' ':'__','(':'__',')':'__','.':'__'};
				var selectedValuesReplace = element.replace(/[ ().]/g, m => charsReplace[m]);		
				selectedValuesReplace = selectedValuesReplace.replace(",", "__");		

				if(element.indexOf(', ') != -1){
				  element = element.replace(', ', '__');
				}					

				if (jQuery.inArray(element, selectedValuesArray) !== -1) {
					
					$('#'+selectedValuesReplace).removeClass('d-none'); 
					$('#50_'+selectedValuesReplace).addClass('checksupplierlength'); 
					$('#50_'+selectedValuesReplace).addClass('dynamic_text_box'); 
					$('#50_'+selectedValuesReplace).prop('required',true);
				}
				else{
					$('#50_'+selectedValuesReplace).removeClass('checksupplierlength'); 
					$('#50_'+selectedValuesReplace).removeClass('dynamic_text_box'); 
					$('#'+selectedValuesReplace).addClass('d-none'); 
					$('#50_'+selectedValuesReplace).val(''); 
					$('#50_'+selectedValuesReplace).prop('required',false);
				}
			});

			var sup_id = $("#sup_id").val();
			var user_id = $("#userid").val();
			var finalVal = '';
			$(".dynamic_text_box").each(function() {
				var prefix = $(this).attr('data-id');
				var val = $(this).val().trim();

				// if(val!=''){
					var userValJoin = prefix+':'+val;

					if(finalVal==''){
						finalVal += userValJoin;					
					}
					else{
						finalVal += '||'+userValJoin;	
					}
				// }

			});			
			
			$.ajax({ 
				url:"<?php echo base_url();?>smartform/update_temp_forms_edit", 
				method:"POST", 
				data:{user_id:user_id, sup_id:sup_id, field_id:50, field_value:finalVal ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'}, 
				dataType:"text", 
				success:function(data) 
				{ 
					
				} 
			});
		}

	
	var request;	
		$("#search_supplier").keyup(function() {
			request && request.abort(); // always abort the previous request, if there was one
			
			// if (this.value.trim().length > 3) {
			var pageNo = 1;
			var from_value =  $("[name='get_supplier_values']:checked").val();
			var search_keyword = $.trim($('#search_supplier').val());
			//if(search_keyword!=''){
			var records_perpage = 10;
			if(records_perpage==''){
				var recordsPerpage = '<?php echo $this->config->item('admin_per_page');?>';
			}
			else{
				var recordsPerpage = records_perpage;
			}
			request = $.ajax({
				type: 'POST',
				url: '<?php echo base_url();?>smartform/get_alei/'+pageNo,
				data:'pageNo='+pageNo+'&search_keyword='+search_keyword+'&recordsPerpage='+recordsPerpage+'&from_value='+from_value+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
				dataType:'JSON',
				beforeSend: function () {
					$('#appendDatas_supplier').html('<tr><td colspan="6"><center><b>Loading...</b></center></td></tr>');
					$('#pagination_supplier').html('');
					$('#totalCount_supplier').html('');
					// $('#totalItems').html('');
					// $('#approved').html('');
					// $('#pending').html('');
					// $('#rejected').html('');
					// $('#tickets-status').html('');
				},
				success: function (responseData) {
					ajaxindicatorstop();
					var rowData = responseData['rows'];
					var tr='';  
					var result_length=responseData['rows_tr'].length;
					if(result_length>0){
					$.each(responseData['rows_tr'], function(i, item) {
					var address='';
					if(item.address2!=''){
						address=item.address1+','+item.address2;
					}else{
						address=item.address1;
					}
					var validated_status='';
					if(item.validated==''){
						validated_status='<span class="text-danger"><b>***</b> </span>';
					}
					
						tr+='<tr>';
						tr+='<td><input type="radio" name="add_supplier" id="add_supplier'+i+'" onchange="select_supplier('+i+')"><input type="hidden" id="alei_id_'+i+'" value="'+item.id+'"><input type="hidden" id="sup_address_'+i+'" value="'+item.address+'"></td>'; 
						tr+='<td>'+validated_status+item.alei+'<input type="hidden" id="sup_alei_'+i+'" value="'+item.alei+'"><input type="hidden" id="sup_address_'+i+'" value="'+address+'"></td>'; 
						tr+='<td>'+item.sup_legal_name+'<input type="hidden" id="sup_name_'+i+'" value="'+item.sup_legal_name+'"></td>'; 
						tr+='<td>'+item.city+'<input type="hidden" id="sup_city_'+i+'" value="'+item.city+'"></td>'; 
						tr+='<td>'+item.state+'<input type="hidden" id="sup_state_'+i+'" value="'+item.state+'"></td>';
						tr+='<td>'+item.country+'<input type="hidden" id="sup_country_'+i+'" value="'+item.country+'"><input type="hidden" id="sup_pincode_'+i+'" value="'+item.pincode+'"></td>';
						tr+='</tr>';
					});
					}else{
					tr+='<tr><td class="text-danger" colspan="7" align="center"><b>No result found</b></td></tr>';
					}
//alert(responseData['rows_tr']);					
					$('#appendDatas_supplier').html(tr);
					$('#pagination_supplier').html(responseData['pagination']);
					$('#totalCount_supplier').html(responseData['total_rows']);
				}
			});
			// }
			//}
			
		});
		$('#pagination_supplier').on('click','a',function(e){
			if(!$(this).hasClass("current")){
				e.preventDefault(); 
				var pageNo = $(this).attr('data-ci-pagination-page');
				// alert(pageNo);
				// return false;
				searchSupplier(pageNo);
			}
		});
		
});

$('.select_onchange').change(function(){
	var id = $(this).attr('id');
	// alert(id);
	var selections = [];
	$('#'+id+' :selected').each(function(i, sel){ 
		var selectedVal = $(sel).val();
		selections.push(selectedVal);
	});
	// alert(selections);
	if(id == 47){
		var classValue1 = [ 48,51 ];
		jQuery.each( classValue1, function( i, val ) {
			if(jQuery.inArray("PeopleSoft v9.x", selections) != -1) {
			    /*console.log("is in array");*/
				$('.'+val).removeClass('d-none'); 
				$('.'+val).prop('required',true);
				/*if(val == 51){*/
					$('#'+val).attr('required',true);
				/*}*/
			} else {
			    /*console.log("is NOT in array");*/
			    $('.'+val).addClass('d-none'); 
			    $("[name='"+val+"[]']").prop('checked',false);
			   // var values = $("."+val).find("span").attr("class","sol-quick-delete").click();
				$('.'+val).prop('required',false);
				/*if(val == 51){*/
					$('#'+val).removeAttr("required");
				/*}*/
				$('#'+val).val('');
			}
		});
		var classValue2 = [ 52,53 ];
		jQuery.each( classValue2, function( i, val ) {
			var select_val = $('#'+val);
			if(jQuery.inArray("OC SAP ECC", selections) != -1 || jQuery.inArray("S4-HANA public", selections) != -1 || jQuery.inArray("S4 HANA private", selections) != -1) {
			    /*console.log("is in array");*/
				$('.'+val).removeClass('d-none'); 
				$('.'+val).prop('required',true);
				select_val.attr('required', true);
			} else {
			    /*console.log("is NOT in array");*/
			    $('.'+val).addClass('d-none'); 
			    // alert(val);
			    $("[name='"+val+"[]']").prop('checked',false);
			    // var values52 = $('.'+val).find("span").attr("class","sol-quick-delete").click();
			    // var values52_1 = $('.'+val).find("span").attr("class","sol-quick-delete").click();
			    // var values52_2 = $('.'+val).find("span").attr("class","sol-selected-display-item-text").click();
			    // var values52 = $('.'+val).find("div").attr("class","sol-selected-display-item").empty();
			    // var values52 = $('.'+val).find("div").attr("class","sol-current-selection").empty();
				$('.'+val).prop('required',false);
				$('#'+val).val('');
				select_val.attr('required', false);
			} 
		});
	}
	if(id==52){
		var option_all = $("select#"+id+" option:selected").map(function () {
			return $(this).text();
		}).get().join(',');
		// alert(option_all);
		if(option_all!=''){
			$('.'+id).prop('required',false);
			$('#'+id).prop('required',false);
			}else{
			$('.'+id).prop('required',true);
			$('#'+id).prop('required',true);
		}
	}
	if(id==53){
		var option_all = $("select#"+id+" option:selected").map(function () {
			return $(this).text();
		}).get().join(',');
		// alert(option_all);
		if(option_all!=''){
			$('.'+id).prop('required',false);
			$('#'+id).prop('required',false);
			}else{
			$('.'+id).prop('required',true);
			$('#'+id).prop('required',true);
		}
	}
});
$('.other_select').change(function(){
	var id = $(this).attr('id');
	// alert(id);
	var selections = [];
	$('#'+id+' :selected').each(function(i, sel){ 
		var selectedVal = $(sel).val();
		selections.push(selectedVal);
	});
	// alert(selections);
	console.log("krishna_"+id);
		console.log(selections);
	if(id == 54){
		var classValue3 = [ 57 ];
		jQuery.each( classValue3, function( i, val ) {
			if(jQuery.inArray("97", selections) != -1) {
			    /*console.log("is in array");*/
				$('.'+val).removeClass('d-none'); 
				$('.'+val).prop('required',true);
				var oldvalue = $('#'+val+'_oldfile').val();
				console.log("old_value"+oldvalue);
				if(oldvalue==''){
					$('#'+val).attr('required','required');
				}
				else{
					$('#'+val).removeAttr("required");
				}
			} else {
			    /*console.log("is NOT in array");*/
			    $('.'+val).addClass('d-none'); 
				$('.'+val).prop('required',false);
				$('#'+val).val('');
				$('#'+val).removeAttr("required");
			}
		});	
	}
	/*if(id == 23){
			// alert(selections);
			var classValue4 = [ 63 ];
			jQuery.each( classValue4, function( i, val ) {
				if(selections != 150 && selections != '') {
				    /*console.log("is in array");
					$('.'+val).removeClass('d-none'); 
					$('.'+val).prop('required',true);
					//$('.'+val).prop('required',true);
				} else {
				    /*console.log("is NOT in array");
				    $('.'+val).addClass('d-none'); 
					$('.'+val).prop('required',false);
					$('#'+val).val('');
					$('#select2-'+val+'-container').text('SELECT');
					$('#select2-'+val+'-container').removeAttr('title');

				}
			});	
		}*/
});
Array.prototype.containsSubString = function( text ){
	    for ( var i = 0; i < this.length; ++i )
	    {
	        if ( this[i].toString().indexOf( text ) != -1 )
	            return i;
	    }
	    return -1;
	}

	var _validFileExtensions = [".docx", ".doc", ".pdf"];    
	function ValidateSingleInput(oInput) {
	  if (oInput.type == "file") {
	    var sFileName = oInput.value;
	    if (sFileName.length > 0) {
	      var blnValid = false;
	      for (var j = 0; j < _validFileExtensions.length; j++) {
	        var sCurExtension = _validFileExtensions[j];
	        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
	          blnValid = true;
	          break;
	        }
	      }        
	      if (!blnValid) {
	        alert("<?php echo "Invalid format, Please insert *.doc, *.docx, *.pdf file only"; ?>");
	        oInput.value = "";
	        return false;
	      }
	    }
	  }
	  return true;
	}

$("select#34").change(function(){
		var selected_option = $("#34 option:selected").val();
		var supplier_email = $("#15").val();
		// var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		var testEmail = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/i;
		if(selected_option!=''){
			var email_split=supplier_email.split('@');
			if(supplier_email.trim()!=''){
				if (testEmail.test(supplier_email)){
					if(selected_option==632){
						if(email_split[1]=='corning.com'){
							$.alert({
								title: 'Alert!',
								content: "Please enter Supplier Contact Email Other then corning email address",
							});
							//$( "#15" ).focus();
						}
					}else{
						if(email_split[1]!='corning.com'){
							$.alert({
								title: 'Alert!',
								content: "Please enter Corning email address in Supplier Contact Email",
							});
							//$( "#15" ).focus();
						}
					}
					
				}else{
					$.alert({
						title: 'Alert!',
						content: "Please enter Valid Supplier Contact Email",
					});
				}
			}
		}
	
	});
	// $("#15").blur(function() {
	// 	var selected_option = $("#34 option:selected").val();
	// 	var supplier_email = $("#15").val();
	// 	// var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	// 	var testEmail = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/i;
	// 	if(selected_option!=''){
	// 		var email_split=supplier_email.split('@');
	// 		if(supplier_email.trim()!=''){
	// 			if (testEmail.test(supplier_email)){
	// 				if(selected_option==632){
	// 					if(email_split[1]=='corning.com'){
	// 						$.alert({
	// 							title: 'Alert!',
	// 							content: "Please enter Supplier Contact Email Other then corning email address",
	// 						});
	// 					}
	// 				}else{
	// 					if(email_split[1]!='corning.com'){
	// 						$.alert({
	// 							title: 'Alert!',
	// 							content: "Please enter Corning email address in Supplier Contact Email",
	// 						});
	// 					}
	// 				}
					
	// 			}else{
	// 				/* $.alert({
	// 					title: 'Alert!',
	// 					content: "Please enter Valid Supplier Contact Email",
	// 				}); */
	// 			}
	// 		}
	// 	}
	// });
function close_window() {
    window.close();
}
$("#approve").on('click',(function(e) {
	// alert('return');
	// return false;
	var role_id = <?php echo logged_in_role_id();?>;
	var formdata=$("#quick_update");
	var form_id=$("#form_id").val();
	// if(form_id == '6'){
	// 	var alert_content = 'ERP';
	// }
	// else if(form_id == '7' || form_id == '8'){
	// 	var alert_content = 'TS';
	// }
	// else{
	// 	var alert_content = 'Ariba';
	// }
	var alert_content = '<?php echo $display_label_name;?>';
	$.confirm({
		title: 'Upload Confirmation',
		theme: 'light',
		// content: "Kindly confirm that the supplier has been uploaded to "+alert_content+" before clicking the 'CONFIRM' button",
		content: 'Kindly confirm that the supplier has been uploaded to '+alert_content+' before clicking the \'CONFIRM\' button' +
		    '<form action="" class="formName">' +
		    '<div class="form-group">' +
		    '<label><b>Approve comments</b></label>' +
		    '<textarea class="approve_comment form-control text-uppercase" name="approve_comment" id="approve_comment" rows="5" cols="40" required></textarea></br>' +
			'<label><b>Approve Attachment</b></label>' +						    
			'<input type="file" id="approver_attachments_0" name="approver_attachments[]" class="" onchange="validate_approver_attachments()"> <input type="hidden" name="app_file_count" id="app_file_count" value="0"><div id="approver_upload_div"></div>' +
			'<div id="approver_attachments_container" style="display: none;" class="mt-2 font-weight-bold alert alert-info"></div>' +
		    '<div class="form-text text-secondary"> Maximum File limit: 3</div></div>' +
		    '</form>',
		buttons : {
			formSubmit: {
	            text: 'CONFIRM',
	            btnClass: 'btn-blue',
	            action: function () {
	                var approve_comment = this.$content.find('.approve_comment').val();
					ajaxindicatorstart('Loading please wait.');
					// var formdata=$("#quick_update"),approve_comment;
					var form = $("#quick_update");
					var formData = new FormData(form[0]);    

					var elements = document.getElementsByName('approver_attachments[]');

					for (var i = 0; i < elements.length; i++) {
					    var files = elements[i].files;                                  
					    for (var x = 0; x < files.length; x++) {                                     
					        formData.append("approver_files[]", files[x]);
					    }
					}
					var check_file_length=elements.length;
					check_file_length--;

					if (check_file_length > 0 && approve_comment == "") {
						$.alert({
							title: 'Alert!',
							content: 'Kindly provide Approve Comment',
						});							    
					    ajaxindicatorstop();							    
					    return false;
					}							

					formData.append("approve_comment", approve_comment);
					formData.append("role_id", role_id);
					formData.append('<?php echo $this->security->get_csrf_token_name();?>','<?php echo $this->security->get_csrf_hash();?>');

					$.ajax({
						url: '<?php echo base_url();?>smartform/quick_approve',
						type: "POST",
						// data:formdata.serialize()+"&approve_comment="+approve_comment+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
						data: formData,
						processData: false,
						contentType: false,
						dataType: 'json',
						success: function(data)
						{
							console.log(data);
							if(data.error){
								
							}
							else{
								if(role_id == 10){
									window.location.href = '<?php echo base_url(); ?>supplierportal';
								}
								else{
									window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
								}
							}
							ajaxindicatorstop();
						}
					});
							
	            }
	        },
	        cancel: function () {
	            //close
	        },
		}
	});
}));

$("#reject").on('click',(function(e) {
	var role_id = <?php echo logged_in_role_id();?>;
	var sup_id=$("#sup_id").val();
	var form_id=$("#form_id").val();
	var display_comments=$("#display_comments").html();
	// alert(role_id);
	// $(".jconfirm-box").css("width","800px");
	$.confirm({
			title: 'Reject the Request!',
			theme: 'light',
			columnClass: 'col-md-8',
			/*content: 'Is record needed to be Rejected?',*/
			content: display_comments +
					    '<form action="" class="formName">' +
					    '<div class="form-group">' +
					    '<label>Rejected comments</label>' +
					    '<textarea class="reject_comment form-control text-uppercase" name="reject_comment" id="reject_comment" rows="5" cols="40" style="text-transform:uppercase;" required></textarea>' +
					    '</div>' +
					    '</form>',
			buttons : {
				formSubmit: {
		            text: 'Submit',
		            btnClass: 'btn-blue',
		            action: function () {
		                var reject_comment = this.$content.find('.reject_comment').val().trim();
		                if(!reject_comment){
		                    $.alert('Please give reject comments');
		                    $("#reject_comment").val("");
		                    $("#reject_comment").focus();
		                    return false;
		                }
							
						ajaxindicatorstart('Loading please wait.');
						var formdata=$("#quick_update");
						$.ajax({
							url: '<?php echo base_url();?>smartform/quick_reject',
							type: "POST",
							// data:{ sup_id:sup_id,reject_comment:reject_comment,form_id:form_id},
							data:formdata.serialize()+"&reject_comment="+reject_comment+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
							dataType: 'json',
							success: function(data)
							{
								console.log(data);
								// return false;
								ajaxindicatorstop();
								if(data.error){
									
								}
								else{
									if(role_id == 10){
										window.location.href = '<?php echo base_url(); ?>supplierportal';
									}
									else{
										window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
									}
								}
								
							}
						});
								
		            }
		        },
		        cancel: function () {
		            //close
		        },
					
			}
		});
}));

$("#update_gsm_finance").on('click',(function(e) {
	var role_id = <?php echo logged_in_role_id();?>;
	// return false;
	/*NOTE: NO UPDATE*/
	// $('#quick_update').validate();
	if ($('#quick_update').valid()) // check if form is valid
    {    	
    	if(role_id!=10){
			var file_fields=[];				
	        var input_file_fields=$('.check_input_files').length;			
			jQuery('.check_input_files').each(function() {
				var field_value_input=$(this).val();
				var field_name=$(this).attr('id');
				var field_name_id=field_name.substr(0,field_name.indexOf('_'));									
				if(field_value_input!=''){
					if(!$("."+field_name_id).hasClass('d-none')){
						file_fields.push(field_name_id);
					}								
				}

			});
			var file_fields_length=file_fields.length;
			if(file_fields_length>0){
				var sup_id=$("#sup_id").val();
				ajaxindicatorstart('Loading please wait.');
				$.ajax({
					url: '<?php echo base_url();?>smartform/check_pyshical_file_exists',
					type: "POST",
					data: {sup_id:sup_id,fields:file_fields,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
					success: function(data)
					{
						ajaxindicatorstop();
						if(data!=''){
							$.alert({
								title: 'Alert!',
								content: data,
							});
						}else{
							if(role_id == 6){
				    	 		$.confirm({
						 		title: 'Approve Request',
						 		theme: 'light',
								content: 'Kindly confirm the request has been approved for upload?' +
						 				'<br>' +
									    '<form action="" class="formName">' +
									    '<div class="form-group">' +
								    '<br>' +
									    '<label>Enter ERP ID</label>' +
						 			    '<input type="text" class="ERP_ID_mdm form-control text-uppercase" name="ERP_ID_mdm" id="ERP_ID_mdm" required>' +
									    '<br>' +
									    '<label><b>Approve comments</b></label>' +
						 			    '<textarea class="approve_comment form-control text-uppercase" name="approve_comment" id="approve_comment" rows="5" cols="40" required></textarea></br>' +
										'<label><b>Approve Attachment</b></label>' +						    
										'<input type="file" id="approver_attachments_0" name="approver_attachments[]" class="" onchange="validate_approver_attachments()"> <input type="hidden" name="app_file_count" id="app_file_count" value="0"><div id="approver_upload_div"></div>' +
										'<div id="approver_attachments_container" style="display: none;" class="mt-2 font-weight-bold alert alert-info"></div>' +
						 			    '<div class="form-text text-secondary"> Maximum File limit: 3</div></div>' +
						 			    '</form>',

							 		buttons : {
						 			formSubmit: {
						 	            text: 'Submit',
						 	            btnClass: 'btn-blue',
						 	            action: function () {
								            	var ERP_ID_mdm = this.$content.find('.ERP_ID_mdm').val().trim();
							 	                var approve_comment = this.$content.find('.approve_comment').val();
							 	                var approve_comment_ERP = 'ERP ID: '+ERP_ID_mdm + '\n' +'Approve Comment: ' +approve_comment;
							 	                if(!ERP_ID_mdm){			                	
								                    // $.alert('Please provied <b>ERP ID</b> for this request');
							 	                    $.alert({
							 						    title: 'Alert!',
							 						    content: 'Please provied <b>ERP ID</b> for this request',
						 						});
							 	                    $("#ERP_ID_mdm").val("");
							 	                    $("#ERP_ID_mdm").focus();
							 	                    return false;
							 	                }
												if (approve_comment.indexOf('&') > -1) { 
													$.alert("Please replace the special character '&' (ampersand) with the word 'and' to avoid truncation in the comments");
													return false;
												}else{
							 						ajaxindicatorstart('Loading please wait.');
							 						// var formdata=$("#quick_update"),approve_comment;
							 						var form = $("#quick_update");
													var formData = new FormData(form[0]);   

													var elements = document.getElementsByName('approver_attachments[]');


													for (var i = 0; i < elements.length; i++) {
													    var files = elements[i].files;                                  
													    for (var x = 0; x < files.length; x++) {                                     
													        formData.append("approver_files[]", files[x]);
													    }
													}
													var check_file_length=elements.length;
													check_file_length--;

													if (check_file_length > 0 && approve_comment == "") {
														$.alert({
															title: 'Alert!',
															content: 'Kindly provide Approve Comment',
														});							    
													    ajaxindicatorstop();							    
													    return false;
													}							

													formData.append("ERP_ID_mdm", ERP_ID_mdm);
													formData.append("approve_comment", approve_comment_ERP);
													formData.append("role_id", role_id);
													formData.append('<?php echo $this->security->get_csrf_token_name();?>','<?php echo $this->security->get_csrf_hash();?>');

							 						$.ajax({
						 							url: '<?php echo base_url();?>smartform/quick_update',
							 						type: "POST",
														// data:formdata.serialize()+"&ERP_ID_mdm="+ERP_ID_mdm+"&approve_comment="+approve_comment_ERP+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
													data: formData,
													processData: false,
													contentType: false,
						 							dataType: 'json',
							 							success: function(data)
														{
							 								console.log(data);
							 								if(data.error){
																
														}
							 								else{
																if(role_id == 10){
															window.location.href = '<?php echo base_url(); ?>supplierportal';
							 									}
																else{
																	window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
							 									}
							 								}
							 								ajaxindicatorstop();
														}
													});
												}
														
								            }
								        },
								        cancel: function () {
						 	            //close
							 	        },
							 		}
							 	});
				    	 	}
							else{
								$.confirm({
									title: 'Approve Request',
									theme: 'light',
									content: 'Kindly confirm the request has been approved for upload?' +
												'<form action="" class="formName">' +
												'<div class="form-group">' +
												'<label><b>Approve comments</b></label>' +
												'<textarea class="approve_comment form-control text-uppercase" name="approve_comment" id="approve_comment" rows="5" cols="40" required></textarea></br>' +
												'<label><b>Approve Attachment</b></label>' +						    
												'<input type="file" id="approver_attachments_0" name="approver_attachments[]" class="" onchange="validate_approver_attachments()"> <input type="hidden" name="app_file_count" id="app_file_count" value="0"><div id="approver_upload_div"></div>' +
												'<div id="approver_attachments_container" style="display: none;" class="mt-2 font-weight-bold alert alert-info"></div>' +
												'<div class="form-text text-secondary"> Maximum File limit: 3</div></div>' +
												'</form>',

									buttons : {
										formSubmit: {
											text: 'Submit',
											btnClass: 'btn-blue',
											action: function () {
												var approve_comment = this.$content.find('.approve_comment').val();
												if (approve_comment.indexOf('&') > -1) { 
													$.alert("Please replace the special character '&' (ampersand) with the word 'and' to avoid truncation in the comments");
													return false;
												}else{
													ajaxindicatorstart('Loading please wait.');
													// var formdata=$("#quick_update"),approve_comment;
													var form = $("#quick_update");
													var formData = new FormData(form[0]);  

													var elements = document.getElementsByName('approver_attachments[]');

													for (var i = 0; i < elements.length; i++) {
													    var files = elements[i].files;                                  
													    for (var x = 0; x < files.length; x++) {                                     
													        formData.append("approver_files[]", files[x]);
													    }
													}
													var check_file_length=elements.length;
													check_file_length--;

													if (check_file_length > 0 && approve_comment == "") {
														$.alert({
															title: 'Alert!',
															content: 'Kindly provide Approve Comment',
														});							    
													    ajaxindicatorstop();							    
													    return false;
													}							

													formData.append("approve_comment", approve_comment);
													formData.append("role_id", role_id);
													formData.append('<?php echo $this->security->get_csrf_token_name();?>','<?php echo $this->security->get_csrf_hash();?>');
													$.ajax({
														url: '<?php echo base_url();?>smartform/quick_update',
														type: "POST",
														// data:formdata.serialize()+"&approve_comment="+approve_comment+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
														data: formData,
														processData: false,
														contentType: false,
														dataType: 'json',
														success: function(data)
														{
															console.log(data);
															if(data.error){
																
															}
															else{
																if(role_id == 10){
																	window.location.href = '<?php echo base_url(); ?>supplierportal';
																}
																else{
																	window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																}
															}
															ajaxindicatorstop();
														}
													});
												}
											}
										},
										cancel: function () {
											//close
										},
									}
								});
							}
						}
					}
				});
			}else{
				if(role_id == 6){
	    	 		$.confirm({
			 		title: 'Approve Request',
			 		theme: 'light',
					content: 'Kindly confirm the request has been approved for upload?' +
			 				'<br>' +
						    '<form action="" class="formName">' +
						    '<div class="form-group">' +
					    '<br>' +
						    '<label>Enter ERP ID</label>' +
			 			    '<input type="text" class="ERP_ID_mdm form-control text-uppercase" name="ERP_ID_mdm" id="ERP_ID_mdm" required>' +
						    '<br>' +
						    '<label><b>Approve comments</b></label>' +
			 			    '<textarea class="approve_comment form-control text-uppercase" name="approve_comment" id="approve_comment" rows="5" cols="40" required></textarea></br>' +
							'<label><b>Approve Attachment</b></label>' +						    
							'<input type="file" id="approver_attachments_0" name="approver_attachments[]" class="" onchange="validate_approver_attachments()"> <input type="hidden" name="app_file_count" id="app_file_count" value="0"><div id="approver_upload_div"></div>' +
							'<div id="approver_attachments_container" style="display: none;" class="mt-2 font-weight-bold alert alert-info"></div>' +
			 			    '<div class="form-text text-secondary"> Maximum File limit: 3</div></div>' +
			 			    '</form>',

				 		buttons : {
			 			formSubmit: {
			 	            text: 'Submit',
			 	            btnClass: 'btn-blue',
			 	            action: function () {
					            	var ERP_ID_mdm = this.$content.find('.ERP_ID_mdm').val().trim();
				 	                var approve_comment = this.$content.find('.approve_comment').val();
				 	                var approve_comment_ERP = 'ERP ID: '+ERP_ID_mdm + '\n' +'Approve Comment: ' +approve_comment;
				 	                if(!ERP_ID_mdm){			                	
					                    // $.alert('Please provied <b>ERP ID</b> for this request');
				 	                    $.alert({
				 						    title: 'Alert!',
				 						    content: 'Please provied <b>ERP ID</b> for this request',
			 						});
				 	                    $("#ERP_ID_mdm").val("");
				 	                    $("#ERP_ID_mdm").focus();
				 	                    return false;
				 	                }
									if (approve_comment.indexOf('&') > -1) { 
										$.alert("Please replace the special character '&' (ampersand) with the word 'and' to avoid truncation in the comments");
										return false;
									}else{
				 						ajaxindicatorstart('Loading please wait.');
				 						// var formdata=$("#quick_update"),approve_comment;
				 						var form = $("#quick_update");
										var formData = new FormData(form[0]); 

										var elements = document.getElementsByName('approver_attachments[]');

										for (var i = 0; i < elements.length; i++) {
										    var files = elements[i].files;                                  
										    for (var x = 0; x < files.length; x++) {                                     
										        formData.append("approver_files[]", files[x]);
										    }
										}
										var check_file_length=elements.length;
										check_file_length--;

										if (check_file_length > 0 && approve_comment == "") {
											$.alert({
												title: 'Alert!',
												content: 'Kindly provide Approve Comment',
											});							    
										    ajaxindicatorstop();							    
										    return false;
										}							

										formData.append("ERP_ID_mdm", ERP_ID_mdm);
										formData.append("approve_comment", approve_comment_ERP);
										formData.append("role_id", role_id);
										formData.append('<?php echo $this->security->get_csrf_token_name();?>','<?php echo $this->security->get_csrf_hash();?>');
				 						$.ajax({
			 							url: '<?php echo base_url();?>smartform/quick_update',
			 							type: "POST",
											// data:formdata.serialize()+"&ERP_ID_mdm="+ERP_ID_mdm+"&approve_comment="+approve_comment_ERP+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
										data: formData,
										processData: false,
										contentType: false,
			 							dataType: 'json',
				 							success: function(data)
											{
				 								console.log(data);
				 								if(data.error){
													
											}
				 								else{
													if(role_id == 10){
												window.location.href = '<?php echo base_url(); ?>supplierportal';
				 									}
													else{
														window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
				 									}
				 								}
				 								ajaxindicatorstop();
											}
										});
									}
											
					            }
					        },
					        cancel: function () {
			 	            //close
				 	        },
				 		}
				 	});
	    	 	}
				else{
					$.confirm({
						title: 'Approve Request',
						theme: 'light',
						content: 'Kindly confirm the request has been approved for upload?' +
									'<form action="" class="formName">' +
									'<div class="form-group">' +
									'<label><b>Approve comments</b></label>' +
									'<textarea class="approve_comment form-control text-uppercase" name="approve_comment" id="approve_comment" rows="5" cols="40" required></textarea></br>' +
									'<label><b>Approve Attachment</b></label>' +						    
									'<input type="file" id="approver_attachments_0" name="approver_attachments[]" class="" onchange="validate_approver_attachments()"> <input type="hidden" name="app_file_count" id="app_file_count" value="0"><div id="approver_upload_div"></div>' +
									'<div id="approver_attachments_container" style="display: none;" class="mt-2 font-weight-bold alert alert-info"></div>' +
									'<div class="form-text text-secondary"> Maximum File limit: 3</div></div>' +
									'</form>',

						buttons : {
							formSubmit: {
								text: 'Submit',
								btnClass: 'btn-blue',
								action: function () {
									var approve_comment = this.$content.find('.approve_comment').val();
									if (approve_comment.indexOf('&') > -1) { 
										$.alert("Please replace the special character '&' (ampersand) with the word 'and' to avoid truncation in the comments");
										return false;
									}else{
										ajaxindicatorstart('Loading please wait.');
										// var formdata=$("#quick_update"),approve_comment;
										var form = $("#quick_update");
										var formData = new FormData(form[0]); 

										var elements = document.getElementsByName('approver_attachments[]');

										for (var i = 0; i < elements.length; i++) {
										    var files = elements[i].files;                                  
										    for (var x = 0; x < files.length; x++) {                                     
										        formData.append("approver_files[]", files[x]);
										    }
										}
										var check_file_length=elements.length;
										check_file_length--;

										if (check_file_length > 0 && approve_comment == "") {
											$.alert({
												title: 'Alert!',
												content: 'Kindly provide Approve Comment',
											});							    
										    ajaxindicatorstop();							    
										    return false;
										}							

										formData.append("approve_comment", approve_comment);
										formData.append("role_id", role_id);
										formData.append('<?php echo $this->security->get_csrf_token_name();?>','<?php echo $this->security->get_csrf_hash();?>');
										$.ajax({
											url: '<?php echo base_url();?>smartform/quick_update',
											type: "POST",
											// data:formdata.serialize()+"&approve_comment="+approve_comment+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
											data: formData,
											processData: false,
											contentType: false,
											dataType: 'json',
											success: function(data)
											{
												console.log(data);
												if(data.error){
													
												}
												else{
													if(role_id == 10){
														window.location.href = '<?php echo base_url(); ?>supplierportal';
													}
													else{
														window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
													}
												}
												ajaxindicatorstop();
											}
										});
									}
								}
							},
							cancel: function () {
								//close
							},
						}
					});
				}
			// 	$.confirm({
			// 	title: 'Approve Request',
			// 	theme: 'light',
			// 	content: 'Kindly confirm the request has been approved for upload?' +
			// 				'<form action="" class="formName">' +
			// 				'<div class="form-group">' +
			// 				'<label>Approve comments</label>' +
			// 				'<textarea class="approve_comment form-control text-uppercase" name="approve_comment" id="approve_comment" rows="5" cols="40" required></textarea>' +
			// 				'</div>' +
			// 				'</form>',

			// 	buttons : {
			// 		formSubmit: {
			// 			text: 'Submit',
			// 			btnClass: 'btn-blue',
			// 			action: function () {
			// 				var approve_comment = this.$content.find('.approve_comment').val();
			// 				if (approve_comment.indexOf('&') > -1) { 
			// 					$.alert("Please replace the special character '&' (ampersand) with the word 'and' to avoid truncation in the comments");
			// 					return false;
			// 				}else{
			// 					ajaxindicatorstart('Loading please wait.');
			// 					var formdata=$("#quick_update"),approve_comment;
			// 					$.ajax({
			// 						url: '<?php echo base_url();?>smartform/quick_update',
			// 						type: "POST",
			// 						data:formdata.serialize()+"&approve_comment="+approve_comment+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
			// 						dataType: 'json',
			// 						success: function(data)
			// 						{
			// 							console.log(data);
			// 							if(data.error){
											
			// 							}
			// 							else{
			// 								if(role_id == 10){
			// 									window.location.href = '<?php echo base_url(); ?>supplierportal';
			// 								}
			// 								else{
			// 									window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
			// 								}
			// 							}
			// 							ajaxindicatorstop();
			// 						}
			// 					});
			// 				}
			// 			}
			// 		},
			// 		cancel: function () {
			// 			//close
			// 		},
			// 	}
			// });
			}
	    }else{
			if(role_id == 6){
    	 		$.confirm({
		 		title: 'Approve Request',
		 		theme: 'light',
				content: 'Kindly confirm the request has been approved for upload?' +
		 				'<br>' +
					    '<form action="" class="formName">' +
					    '<div class="form-group">' +
				    '<br>' +
					    '<label>Enter ERP ID</label>' +
		 			    '<input type="text" class="ERP_ID_mdm form-control text-uppercase" name="ERP_ID_mdm" id="ERP_ID_mdm" required>' +
					    '<br>' +
					    '<label><b>Approve comments</b></label>' +
		 			    '<textarea class="approve_comment form-control text-uppercase" name="approve_comment" id="approve_comment" rows="5" cols="40" required></textarea></br>' +
						'<label><b>Approve Attachment</b></label>' +						    
						'<input type="file" id="approver_attachments_0" name="approver_attachments[]" class="" onchange="validate_approver_attachments()"> <input type="hidden" name="app_file_count" id="app_file_count" value="0"><div id="approver_upload_div"></div>' +
						'<div id="approver_attachments_container" style="display: none;" class="mt-2 font-weight-bold alert alert-info"></div>' +
		 			    '<div class="form-text text-secondary"> Maximum File limit: 3</div></div>' +
		 			    '</form>',

			 		buttons : {
		 			formSubmit: {
		 	            text: 'Submit',
		 	            btnClass: 'btn-blue',
		 	            action: function () {
				            	var ERP_ID_mdm = this.$content.find('.ERP_ID_mdm').val().trim();
			 	                var approve_comment = this.$content.find('.approve_comment').val();
			 	                var approve_comment_ERP = 'ERP ID: '+ERP_ID_mdm + '\n' +'Approve Comment: ' +approve_comment;
			 	                if(!ERP_ID_mdm){			                	
				                    // $.alert('Please provied <b>ERP ID</b> for this request');
			 	                    $.alert({
			 						    title: 'Alert!',
			 						    content: 'Please provied <b>ERP ID</b> for this request',
		 						});
			 	                    $("#ERP_ID_mdm").val("");
			 	                    $("#ERP_ID_mdm").focus();
			 	                    return false;
			 	                }
								if (approve_comment.indexOf('&') > -1) { 
									$.alert("Please replace the special character '&' (ampersand) with the word 'and' to avoid truncation in the comments");
									return false;
								}else{
			 						ajaxindicatorstart('Loading please wait.');
			 						// var formdata=$("#quick_update"),approve_comment;
			 						var form = $("#quick_update");
									var formData = new FormData(form[0]);    

									var elements = document.getElementsByName('approver_attachments[]');

									for (var i = 0; i < elements.length; i++) {
									    var files = elements[i].files;                                  
									    for (var x = 0; x < files.length; x++) {                                     
									        formData.append("approver_files[]", files[x]);
									    }
									}
									var check_file_length=elements.length;
									check_file_length--;

									if (check_file_length > 0 && approve_comment == "") {
										$.alert({
											title: 'Alert!',
											content: 'Kindly provide Approve Comment',
										});							    
									    ajaxindicatorstop();							    
									    return false;
									}							

									formData.append("ERP_ID_mdm", ERP_ID_mdm);
									formData.append("approve_comment", approve_comment_ERP);
									formData.append("role_id", role_id);
									formData.append('<?php echo $this->security->get_csrf_token_name();?>','<?php echo $this->security->get_csrf_hash();?>');
									
			 						$.ajax({
		 							url: '<?php echo base_url();?>smartform/quick_update',
			 						type: "POST",
										// data:formdata.serialize()+"&ERP_ID_mdm="+ERP_ID_mdm+"&approve_comment="+approve_comment_ERP+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
		 							data: formData,
									processData: false,
									contentType: false,
		 							dataType: 'json',
			 							success: function(data)
										{
			 								console.log(data);
			 								if(data.error){
												
										}
			 								else{
												if(role_id == 10){
											window.location.href = '<?php echo base_url(); ?>supplierportal';
			 									}
												else{
													window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
			 									}
			 								}
			 								ajaxindicatorstop();
										}
									});
								}
										
				            }
				        },
				        cancel: function () {
		 	            //close
			 	        },
			 		}
			 	});
    	 	}
			else{
				$.confirm({
					title: 'Approve Request',
					theme: 'light',
					content: 'Kindly confirm the request has been approved for upload?' +
								'<form action="" class="formName">' +
								'<div class="form-group">' +
								'<label><b>Approve comments</b></label>' +
								'<textarea class="approve_comment form-control text-uppercase" name="approve_comment" id="approve_comment" rows="5" cols="40" required></textarea></br>' +
								'<label><b>Approve Attachment</b></label>' +						    
								'<input type="file" id="approver_attachments_0" name="approver_attachments[]" class="" onchange="validate_approver_attachments()"> <input type="hidden" name="app_file_count" id="app_file_count" value="0"><div id="approver_upload_div"></div>' +
								'<div id="approver_attachments_container" style="display: none;" class="mt-2 font-weight-bold alert alert-info"></div>' +
								'<div class="form-text text-secondary"> Maximum File limit: 3</div></div>' +
								'</form>',

					buttons : {
						formSubmit: {
							text: 'Submit',
							btnClass: 'btn-blue',
							action: function () {
								var approve_comment = this.$content.find('.approve_comment').val();
								if (approve_comment.indexOf('&') > -1) { 
									$.alert("Please replace the special character '&' (ampersand) with the word 'and' to avoid truncation in the comments");
									return false;
								}else{
									ajaxindicatorstart('Loading please wait.');
									// var formdata=$("#quick_update"),approve_comment;
									var form = $("#quick_update");
									var formData = new FormData(form[0]); 
									
									var elements = document.getElementsByName('approver_attachments[]');

									for (var i = 0; i < elements.length; i++) {
									    var files = elements[i].files;                                  
									    for (var x = 0; x < files.length; x++) {                                     
									        formData.append("approver_files[]", files[x]);
									    }
									}
									var check_file_length=elements.length;
									check_file_length--;

									if (check_file_length > 0 && approve_comment == "") {
										$.alert({
											title: 'Alert!',
											content: 'Kindly provide Approve Comment',
										});							    
									    ajaxindicatorstop();							    
									    return false;
									}							

									formData.append("approve_comment", approve_comment);
									formData.append("role_id", role_id);
									formData.append('<?php echo $this->security->get_csrf_token_name();?>','<?php echo $this->security->get_csrf_hash();?>');
									$.ajax({
										url: '<?php echo base_url();?>smartform/quick_update',
										type: "POST",
										// data:formdata.serialize()+"&approve_comment="+approve_comment+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
										data: formData,
										processData: false,
										contentType: false,
										dataType: 'json',
										success: function(data)
										{
											console.log(data);
											if(data.error){
												
											}
											else{
												if(role_id == 10){
													window.location.href = '<?php echo base_url(); ?>supplierportal';
												}
												else{
													window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
												}
											}
											ajaxindicatorstop();
										}
									});
								}
							}
						},
						cancel: function () {
							//close
						},
					}
				});
			}

    	}
    }
    else 
    {
  //       $.alert({
		// 	    title: 'Alert!',
		// 	    content: 'Please fill all Mandatory fields',
		// });
    }
	
}));

// $("#update_btn").on('click',(function(e) {
// 	// alert("new");

// 	// return false;
// 	/*NOTE: NO UPDATE*/
// 	$.confirm({
// 		title: 'Request Confirmation',
// 		theme: 'light',
// 		content: 'Kindly confirm the request to upload?',
// 		buttons : {
// 			yes : {
// 				text: 'Confirm',
// 				btnClass: 'btn-blue',
// 				action: function(){
// 				ajaxindicatorstart('Loading please wait.');
// 				var form=$("#quick_update");
// 				var formdata = new FormData(form[0]);
// 				$.ajax({
// 						url: '<?php echo base_url();?>userhome/quick_update',
// 						type: "POST",

// 						data:formdata ? formdata : form.serialize(),
// 						cache       : false,
// 				        contentType : false,
// 				        processData : false,
// 						dataType: 'json',
// 						success: function(data)
// 						{
// 							console.log(data);
// 							// return false;
// 							ajaxindicatorstop();
// 							if(data.error){
								
// 							}
// 							else{
// 								window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
// 							}
// 						}
// 				});	
// 			}
// 			},
// 			no : {
// 			text: 'Cancel',
// 			btnClass: 'btn-red',
// 			action : function(){
						
// 			}
// 			}
// 		}
// 	});
// }));

$("select#5").change(function(){
    var selectedCountry = $("#5 option:selected").val();
    var state_name_ajax = '';
    var city_name_ajax = '';
    if(selectedCountry==''){
        $('#4').html('<option value="">SELECT</option>');
        $('#1').html('<option value="">SELECT</option>');
        // $('#city_name').html('<option value="">--Select country first--</option>');
    }
    else{
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>smartform/get_state_or_city',
            data: { countryName : selectedCountry,type : 'state' ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
            dataType  : "json", 
            beforeSend: function () {
                    ajaxindicatorstart();
                },
                success   : function(data) {
                     /*console.log(data);  */
                     // return false;

                            state_name_ajax += '<select name="4" id="4" class="form-control form-control-sm">';
                            state_name_ajax += '<option value="">SELECT</option>';
                            data.forEach(function(value, index) {
                            // console.log(value.state_name);
                            var stateName = value.state_name.toUpperCase();
                            state_name_ajax += '<option value="'+value.state_name+'">'+stateName+'</option>';
                            });
                            state_name_ajax += '<option value="Other">OTHER</option>';
                            $('#4').html(state_name_ajax);  
                            $('#1').html('<option value="">SELECT</option>');
                            ///////////////////////////////////////
                            // city_name_ajax += '<select name="1" id="1" class="form-control form-control-sm">';
                            // city_name_ajax += '<option value="">Select State before City</option>';
                            // $('#1').html(city_name_ajax);  
                            ///////////////////////////////////////////
                            ajaxindicatorstop();
                }
        });
    }
    var otherHide = [ 4,1 ];
	jQuery.each( otherHide, function( i, val ) {
		$('#row_hide_other_'+val).addClass('d-none'); 
		$('#'+val+'_other').val('');
		$('#row_hide_other_'+val).prop('required',false);
	});
});

$("select#4").change(function(){
    var selectedState = $("#4 option:selected").val();
    var state_name_ajax = '';
    var city_name_ajax = '';
    if(selectedState==''){
        $('#1').html('<option value="">SELECT</option>');
        // $('#city_name').html('<option value="">--Select country first--</option>');
    }
    else if(selectedState == 'Other'){
        	// alert(selectedState);
        	city_name_ajax = '<option value="">SELECT</option>';
        	city_name_ajax += '<option value="Other">OTHER</option>';
            $('#1').html(city_name_ajax);
        }
    else{
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>smartform/get_state_or_city',
            data: { stateName : selectedState,type : 'city' ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
            dataType  : "json", 
            beforeSend: function () {
                    ajaxindicatorstart();
                },
                success   : function(data) {
                     /*console.log(data);  */
                     // return false;

                            city_name_ajax += '<select name="1" id="1" class="form-control form-control-sm">';
                            city_name_ajax += '<option value="">SELECT</option>';
                            data.forEach(function(value, index) {
                            // console.log(value.state_name);
                            var cityName = value.city_name.toUpperCase();
                            city_name_ajax += '<option value="'+value.city_name+'">'+cityName+'</option>';
                            });
                            city_name_ajax += '<option value="Other">OTHER</option>';
                            $('#1').html(city_name_ajax);  
                            ///////////////////////////////////////
                            ajaxindicatorstop();
                }
        });
    }
    var otherHide = [ 1 ];
	jQuery.each( otherHide, function( i, val ) {
		$('#row_hide_other_'+val).addClass('d-none'); 
		$('#'+val+'_other').val('');
		$('#row_hide_other_'+val).prop('required',false);
	});
});

$("select#203").change(function(){
    var selectedCountry = $("#203 option:selected").val();
    var state_name_ajax = '';
    var city_name_ajax = '';
    if(selectedCountry==''){
        $('#105').html('<option value="">SELECT</option>');
        $('#104').html('<option value="">SELECT</option>');
        // $('#city_name').html('<option value="">--Select country first--</option>');
    }
    else{
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>smartform/get_state_or_city',
            data: { countryName : selectedCountry,type : 'state',['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>' },
            dataType  : "json", 
            beforeSend: function () {
                    ajaxindicatorstart();
                },
                success   : function(data) {
                     /*console.log(data);  */
                     // return false;

                            state_name_ajax += '<select name="105" id="105" class="form-control form-control-sm">';
                            state_name_ajax += '<option value="">SELECT</option>';
                            data.forEach(function(value, index) {
                            // console.log(value.state_name);
                            var stateName = value.state_name.toUpperCase();
                            state_name_ajax += '<option value="'+value.state_name+'">'+stateName+'</option>';
                            });
                            state_name_ajax += '<option value="Other">OTHER</option>';
                            $('#105').html(state_name_ajax);  
                            $('#104').html('<option value="">SELECT</option>');
                            ///////////////////////////////////////
                            // city_name_ajax += '<select name="1" id="1" class="form-control form-control-sm">';
                            // city_name_ajax += '<option value="">Select State before City</option>';
                            // $('#1').html(city_name_ajax);  
                            ///////////////////////////////////////////
                            ajaxindicatorstop();
                }
        });
    }
    var otherHide = [ 105,104 ];
	jQuery.each( otherHide, function( i, val ) {
		$('#row_hide_other_'+val).addClass('d-none'); 
		$('#'+val+'_other').val('');
		$('#row_hide_other_'+val).prop('required',false);
	});
});

$("select#105").change(function(){
    var selectedState = $("#105 option:selected").val();
    var state_name_ajax = '';
    var city_name_ajax = '';
    if(selectedState==''){
        $('#104').html('<option value="">SELECT</option>');
        // $('#city_name').html('<option value="">--Select country first--</option>');
    }
    else if(selectedState == 'Other'){
        	// alert(selectedState);
        	city_name_ajax = '<option value="">SELECT</option>';
        	city_name_ajax += '<option value="Other">OTHER</option>';
            $('#104').html(city_name_ajax);
        }
    else{
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>smartform/get_state_or_city',
            data: { stateName : selectedState,type : 'city',['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>' },
            dataType  : "json", 
            beforeSend: function () {
                    ajaxindicatorstart();
                },
                success   : function(data) {
                     /*console.log(data);  */
                     // return false;

                            city_name_ajax += '<select name="104" id="104" class="form-control form-control-sm">';
                            city_name_ajax += '<option value="">SELECT</option>';
                            data.forEach(function(value, index) {
                            // console.log(value.state_name);
                            var cityName = value.city_name.toUpperCase();
                            city_name_ajax += '<option value="'+value.city_name+'">'+cityName+'</option>';
                            });
                            city_name_ajax += '<option value="Other">OTHER</option>';
                            $('#104').html(city_name_ajax);  
                            ///////////////////////////////////////
                            ajaxindicatorstop();
                }
        });
    }
    var otherHide = [ 104 ];
	jQuery.each( otherHide, function( i, val ) {
		$('#row_hide_other_'+val).addClass('d-none'); 
		$('#'+val+'_other').val('');
		$('#row_hide_other_'+val).prop('required',false);
	});
});	
$("select#202").change(function(){
    var selectedCountry = $("#202 option:selected").val();
    var state_name_ajax = '';
    var city_name_ajax = '';
    if(selectedCountry==''){
        $('#99').html('<option value="">SELECT</option>');
        $('#98').html('<option value="">SELECT</option>');
        // $('#city_name').html('<option value="">--Select country first--</option>');
    }
    else{
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>smartform/get_state_or_city',
            data: { countryName : selectedCountry,type : 'state',['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>' },
            dataType  : "json", 
            beforeSend: function () {
                    ajaxindicatorstart();
                },
                success   : function(data) {
                     /*console.log(data);  */
                     // return false;

                            state_name_ajax += '<select name="99" id="99" class="form-control form-control-sm">';
                            state_name_ajax += '<option value="">SELECT</option>';
                            data.forEach(function(value, index) {
                            // console.log(value.state_name);
                            var stateName = value.state_name.toUpperCase();
                            state_name_ajax += '<option value="'+value.state_name+'">'+stateName+'</option>';
                            });
                            state_name_ajax += '<option value="Other">OTHER</option>';
                            $('#99').html(state_name_ajax);  
                            $('#98').html('<option value="">SELECT</option>');
                            ///////////////////////////////////////
                            // city_name_ajax += '<select name="1" id="1" class="form-control form-control-sm">';
                            // city_name_ajax += '<option value="">Select State before City</option>';
                            // $('#1').html(city_name_ajax);  
                            ///////////////////////////////////////////
                            ajaxindicatorstop();
                }
        });
    }
    var otherHide = [ 99,98 ];
	jQuery.each( otherHide, function( i, val ) {
		$('#row_hide_other_'+val).addClass('d-none'); 
		$('#'+val+'_other').val('');
		$('#row_hide_other_'+val).prop('required',false);
	});
});

$("select#99").change(function(){
    var selectedState = $("#99 option:selected").val();
    var state_name_ajax = '';
    var city_name_ajax = '';
    if(selectedState==''){
        $('#98').html('<option value="">SELECT</option>');
        // $('#city_name').html('<option value="">--Select country first--</option>');
    }
    else if(selectedState == 'Other'){
        	// alert(selectedState);
        	city_name_ajax = '<option value="">SELECT</option>';
        	city_name_ajax += '<option value="Other">OTHER</option>';
            $('#98').html(city_name_ajax);
        }
    else{
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>smartform/get_state_or_city',
            data: { stateName : selectedState,type : 'city' ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
            dataType  : "json", 
            beforeSend: function () {
                    ajaxindicatorstart();
                },
                success   : function(data) {
                     /*console.log(data);  */
                     // return false;

                            city_name_ajax += '<select name="98" id="98" class="form-control form-control-sm">';
                            city_name_ajax += '<option value="">SELECT</option>';
                            data.forEach(function(value, index) {
                            // console.log(value.state_name);
                            var cityName = value.city_name.toUpperCase();
                            city_name_ajax += '<option value="'+value.city_name+'">'+cityName+'</option>';
                            });
                            city_name_ajax += '<option value="Other">OTHER</option>';
                            $('#98').html(city_name_ajax);  
                            ///////////////////////////////////////
                            ajaxindicatorstop();
                }
        });
    }
    var otherHide = [ 98 ];
	jQuery.each( otherHide, function( i, val ) {
		$('#row_hide_other_'+val).addClass('d-none'); 
		$('#'+val+'_other').val('');
		$('#row_hide_other_'+val).prop('required',false);
	});
});		
	
// var selectedValuesArray = [];
// $("select#47").change(function(){
// 	var selectedValues=$(this).val();
// 	var value_length=selectedValues.length;
// 	value_length=value_length-1;
// 	var unselected = $(this).find('option:not(:selected)');
	
// 	$.each(unselected, function(index, value){
// 		if(jQuery.inArray($(this).val(), selectedValuesArray) !== -1){
// 			selectedValuesArray.splice($.inArray($(this).val(), selectedValuesArray),1);
// 		}
// 		console.log(selectedValuesArray);
// 	});
	
// 	$.each( selectedValues, function( key, value ) {
// 		if(jQuery.inArray(value, selectedValuesArray) == -1){
// 			selectedValuesArray.push(value);
// 		}
// 	});	

// 	$('#additional_text_50').html('');	
// 	$.each( selectedValuesArray, function( key, value ) {
// 		var char_len=value.length+1;
// 		if(key==0){
// 			$('#50').val(value+':');
// 			$('#50').attr("data-len", char_len);
// 			$('.dnb').on('keypress, keydown', function(event) {
// 				var readOnlyLengthdnb = $(this).attr('data-len');
// 				 if ((event.which != 37 && (event.which != 39)) && ((this.selectionStart < readOnlyLengthdnb) || ((this.selectionStart == readOnlyLengthdnb) && (event.which == 8)))) {
// 				   return false; 
// 				 }
// 			});
// 		}else{
// 			 $('#additional_text_50').append('<div class="form-group row"><div class="col-md-6">&nbsp;</div><div class="col-md-6"><input type="text" class="form-control form-control-sm dnb" name="50[]" value="'+value+':"  onselectstart="return false" onpaste="return false;" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" style="text-transform:uppercase;" autocomplete="off" data-len="'+char_len+'"/></div></div>');

// 			 $('.dnb').on('keypress, keydown', function(event) {
// 				var readOnlyLengthdnb = $(this).attr('data-len');
// 				 if ((event.which != 37 && (event.which != 39)) && ((this.selectionStart < readOnlyLengthdnb) || ((this.selectionStart == readOnlyLengthdnb) && (event.which == 8)))) {
// 				   return false; 
// 				 }
// 			});
// 		}
// 	}); 
// });
 /* var selectedValuesArray = [];
    $("select#47").change(function(){
    	var selectedValues=$(this).val();
    	var value_length=selectedValues.length;
    	value_length=value_length-1;
    	var unselected = $(this).find('option:not(:selected)');
    // 	var texts=$(".dnb").map(function() {
				//    return $(this).val();
				// }).get();
    // 	    console.log(texts);
    var arr=[];
   	 $( ".dnb" ).each(function( index ) {
		 key=$( this ).prop('id');
		 value=$(this).val();

		    arr[key]=value; 
		});

    	$('#additional_text_50').html('');
    	$.each(unselected, function(index, value){
    		if(jQuery.inArray($(this).val(), selectedValuesArray) !== -1){
    			selectedValuesArray.splice($.inArray($(this).val(), selectedValuesArray),1);
    			arr.splice(arr[$(this).val()],1);
    		}
    		//console.log(selectedValuesArray);
    	});
    	
	    	$.each( selectedValues, function( key, value ) {
	    		//if(key==value_length){
	    		if(jQuery.inArray(value, selectedValuesArray) == -1){
	    			selectedValuesArray.push(value);
	    		}

	    		//}
	    	});	
		var selectedValuesArrayLength=selectedValuesArray.length;
		if(selectedValuesArrayLength==0){
			$('#50').val('');
		}
		
		//console.log(selectedValuesArray);
	
    	$.each( selectedValuesArray, function( key, value ) {
    		
			var char_len=value.length+1;
			var display_value;
			

		console.log(arr);
			//console.log(getKeyByValue(arr, value));


    		if(key==0){
    			if(typeof arr["50"] === "undefined" || arr["50"]==""){
    				if(typeof arr[value] !== "undefined" && arr[value]!=''){
    					display_value=arr[value];
    				}else{
    					display_value=value+':';
    				}
				}else{
					display_value=arr["50"];
				}
    			$('#50').val(display_value);
    			$('#50').attr("data-len", char_len);
    			$('.dnb').on('keypress, keydown', function(event) {
					var readOnlyLengthdnb = $(this).attr('data-len');
					 if ((event.which != 37 && (event.which != 39)) && ((this.selectionStart < readOnlyLengthdnb) || ((this.selectionStart == readOnlyLengthdnb) && (event.which == 8)))) {
					   return false; 
					 }
				});
    		}else{

    // 			var newvalue=arr[value];
    // 			if((newvalue!= '') || (typeof newvalue === "undefined")){
				// 	display_value=newvalue;
				// 	//display_value="found";
				// }else{
				// 	display_value=value+':';
				// }
				// console.log(arr);
				// console.log(arr[value]);
				// if(jQuery.inArray(arr[value], arr) !== -1){
				// 	display_value=arr[value];
				// }else{
				// 	display_value=value+':';
				// }
				if(typeof arr[value] === "undefined"){
					display_value=value+':';
				}else{
					display_value=arr[value];
				}

    			 $('#additional_text_50').append('<div class="form-group row"><div class="col-md-6">&nbsp;</div><div class="col-md-6"><input type="text" class="form-control form-control-sm dnb" name="50[]" value="'+display_value+'" id="'+value+'"  onselectstart="return false" onpaste="return false;" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" style="text-transform:uppercase;" autocomplete="off" data-len="'+char_len+'"/></div></div>');

    			 $('.dnb').on('keypress, keydown', function(event) {
					var readOnlyLengthdnb = $(this).attr('data-len');
					 if ((event.which != 37 && (event.which != 39)) && ((this.selectionStart < readOnlyLengthdnb) || ((this.selectionStart == readOnlyLengthdnb) && (event.which == 8)))) {
					   return false; 
					 }
				});
    		}
    		
		}); 
		
  //   	var value_length=selectedValues.length;
		// //selectedValuesArray.push(selectedValues[value_length]);
		// alert(value_length);
		// alert(selectedValues[value_length]);
    });*/

    
</script>

<script type="text/javascript">

/*$("#reject2").on('click',(function(e) {
	// return false;
	var sup_id=$("#sup_id").val();
	var reject_comment='';
	var element =  document.getElementById('24');
	if (typeof(element) != 'undefined' && element != null)
	{
		reject_comment=$("#24").val();
	}
	if(reject_comment == ''){
		$.confirm({
			title: 'Reject comments needed to be filled',
			theme: 'light',
			content: '',
			buttons : {
				no : {
				text: 'OK',
				btnClass: 'btn-red',
				action : function(){
					$("#24").focus();					
				}
				}
			}
		});
		$("#24").focus();	
	}
	else{
		$.confirm({
			title: 'Reject the Request!',
			theme: 'light',
			content: 'Is record needed to be Rejected?',
			buttons : {
				yes : {
					text: 'Yes',
					btnClass: 'btn-blue',
					action: function(){
						ajaxindicatorstart('Loading please wait.');
						$.ajax({
							url: '<?php echo base_url();?>userhome/quick_reject',
							type: "POST",
							data:{ sup_id:sup_id,reject_comment:reject_comment},
							dataType: 'json',
							success: function(data)
							{
								console.log(data);
								ajaxindicatorstop();
								if(data.error){
									
								}
								else{
									window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
								}
								
							}
						});
					}
				},
				no : {
				text: 'No',
				btnClass: 'btn-red',
				action : function(){
							
				}
				}
			}
		});
	}
}));*/

/*$.confirm({
	title: 'Reject the Request!',
	theme: 'light',
	// content: 'Is record needed to be Rejected?',
	content: '' +
	    '<form action="" class="formName">' +
	    '<div class="form-group">' +
	    '<label>Enter your rejection comments</label>' +
	    '<textarea class="reject_comment form-control" name="reject_comment" id="reject_comment" rows="5" cols="40" required></textarea>' +
	    '</div>' +
	    '</form>',
	buttons : {
		formSubmit: {
            text: 'Reject',
            btnClass: 'btn-blue',
            action: function () {
                var reject_comment = this.$content.find('.reject_comment').val();
                if(!reject_comment){
                    $.alert('Please enter the Rejection Comments');
                    return false;
                }
                $.ajax({
					url: '<?php echo base_url();?>userhome/quick_reject',
					type: "POST",
					data:{ sup_id:sup_id,reject_comment:reject_comment},
					dataType: 'json',
					success: function(data)
					{
						console.log(data);
						ajaxindicatorstop();
						if(data.error){
							
						}
						else{
							window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
						}
						
					}
				});
            }
        },
        cancel: function () {
            //close
        },
		}
});*/

/*$("#reject3").on('click',(function(e) {
	var sup_id=$("#sup_id").val();
	$.confirm({
		icon: 'glyphicon glyphicon-warning-sign',
		title: 'Supplier Status',
		theme: 'light',
		// content: 'Is record needed to be Rejected?',
		content: '' +
		    '<form action="" class="formName">' +
		    '<div class="form-group">' +
		    '<label>Rejected comments</label>' +
		    '<textarea class="reject_comment form-control" name="reject_comment" id="reject_comment" rows="5" cols="40" required></textarea>' +
		    '</div>' +
		    '</form>',
		buttons : {
			formSubmit: {
	            text: 'Submit',
	            btnClass: 'btn-blue',
	            action: function () {
	                var reject_comment = this.$content.find('.reject_comment').val();
	                if(!reject_comment){
	                    $.alert('Please give reject comments');
	                    return false;
	                }
	                $.confirm({
						icon: 'glyphicon glyphicon-warning-sign',
						title: 'Reject the Request!',
						theme: 'light',
						content: 'Is record needed to be Rejected?',
						buttons : {
							yes : {
								text: 'Yes',
								btnClass: 'btn-blue',
								action: function(){
									ajaxindicatorstart('Loading please wait.');
									$.ajax({
										url: '<?php echo base_url();?>userhome/quick_reject',
										type: "POST",
										data:{ sup_id:sup_id,reject_comment:reject_comment},
										dataType: 'json',
										success: function(data)
										{
											console.log(data);
											ajaxindicatorstop();
											if(data.error){
												
											}
											else{
												window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
											}
											
										}
									});
								}
							},
							no : {
							text: 'No',
							btnClass: 'btn-red',
							action : function(){
										
							}
							}
						}
					});
	            }
	        },
	        cancel: function () {
	            //close
	        },
			}
	});
}));*/


	/*var formdata=$("#quick_add");
    $.ajax({
        url: '<?php echo base_url();?>userhome/quick_add_ajax',
        type: "POST",
        data:formdata.serialize(),
        dataType: 'json',
        success: function(data)
        {
        	console.log(data);
        	if(data.error){
				if(data.originator != '')
				{
					$('#originator_error').html(data.originator);
				}
				else
				{
					$('#originator_error').html('');
				}
				if(data.data_requirement != '')
				{
					$('#data_requirement_error').html(data.data_requirement);
				}
				else
				{
					$('#data_requirement_error').html('');
				}
				if(data.data_validation != '')
				{
					$('#data_validation_error ').html(data.data_validation);
				}
				else
				{
					$('#data_validation_error').html('');
				}
				if(data.send_request_to != '')
				{
					$('#send_request_to_error').html(data.send_request_to);
				}
				else
				{
					$('#send_request_to_error').html('');
				}
				if(data.priority != '')
				{
					$('#priority_error').html(data.priority);
				}
				else
				{
					$('#priority_error').html('');
				}
				if(data.reject_to != '')
				{
					$('#reject_to_error').html(data.reject_to);
				}
				else
				{
					$('#reject_to_error').html('');
				}
			}
			else{
				window.location.href = '<?php echo base_url(); ?>userhome/quick_add';
			}
        }
	});*/
//}));


// var validator ="";
// 	var _componentValidation = function() {
// 	    if (!$().validate) {
// 	        console.warn('Warning - validate.min.js is not loaded.');
// 	        return;
// 	    }

// 	    // Initialize
// 	     validator = $('.form-validate-jquery').validate({
// 	        ignore: 'input[type=hidden], .select2-search__field,:hidden:not("#19"), .58', // ignore hidden fields
// 	        errorClass: 'validation-invalid-label',
// 	        successClass: 'validation-valid-label',
// 	        validClass: 'validation-valid-label',
// 	        highlight: function(element, errorClass) {
// 	            $(element).removeClass(errorClass);
// 	        },
// 	        unhighlight: function(element, errorClass) {
// 	            $(element).removeClass(errorClass);
// 	        },
// 	        // success: function(label) {
// 	        //     label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
// 	        // },

// 	        // Different components require proper error label placement
// 	        errorPlacement: function(error, element) {

// 	            // Unstyled checkboxes, radios
// 	            if (element.parents().hasClass('form-check')) {
// 	                error.appendTo( element.parents('.form-check').parent() );
// 	            }

// 	            // Input with icons and Select2
// 	            else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
// 	                error.appendTo( element.parent() );
// 	            }

// 	            // Input group, styled file input
// 	            else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
// 	                error.appendTo( element.parent().parent() );
// 	            }

// 	            // Other elements
// 	            else {
// 	               error.insertAfter(element);
// 	            }
// 	        },
// 	        submitHandler: function() { 
// 	        	// alert('new');
// 	        	var formSubmit=0;
// 	        	var form_id =  $('#form_id').val();
//         		var emailID = 58;
// 	        	var element =  document.getElementById(emailID);
// 	        	// alert('new');
// 	        	// return false;
// 	        	// console.log("new");
// 				if (typeof(element) != 'undefined' && element != null)
// 				{
// 				  var multiple_email=$('#'+emailID).val();
// 				  if(multiple_email != ''){
// 				  	// alert(multiple_email);
// 					  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
// 					  // var reg = /^((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
// 					  var emails = multiple_email.split(",");
					  
// 					  for(var i = 0; i < emails.length; i++)
// 						{
// 							console.log(reg.test(emails[i]));
// 						  if (reg.test(emails[i]) == false) {
// 							  	formSubmit+=1;
							  	
// 							}
// 							else
// 						  {
						  	
// 							  formSubmit+=0;
// 						  }
// 						}
// 					}
// 				}
		
// 				if(formSubmit==0){
// 					// $("#update_btn").on('click',(function(e) {
// 					 // alert("new");
// 					 // return false;

// 					// 	// return false;
// 					// 	/*NOTE: NO UPDATE*/
// 						$.confirm({
// 							title: 'Request Confirmation',
// 							theme: 'light',
// 							content: 'Kindly confirm the request to upload?',
// 							buttons : {
// 								yes : {
// 									text: 'Confirm',
// 									btnClass: 'btn-blue',
// 									action: function(){
// 									ajaxindicatorstart('Loading please wait.');
// 									var form=$("#quick_update");
// 									var formdata = new FormData(form[0]);
// 									$.ajax({
// 											url: '<?php echo base_url();?>smartform/quick_update',
// 											type: "POST",

// 											data:formdata ? formdata : form.serialize(),
// 											cache       : false,
// 									        contentType : false,
// 									        processData : false,
// 											dataType: 'json',
// 											success: function(data)
// 											{
// 												console.log(data);
// 												// return false;
// 												ajaxindicatorstop();
// 												if(data.error){
													
// 												}
// 												else{
// 													window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
// 												}
// 											}
// 									});	
// 								}
// 								},
// 								no : {
// 								text: 'Cancel',
// 								btnClass: 'btn-red',
// 								action : function(){
											
// 								}
// 								}
// 							}
// 						});
// 					//}));
// 	            }else{
// 	            	<?php
// 	            	// $arrayEmailCheck = array();
// 	            	// foreach ($validation_array as $key => $value) {
// 	            	// 	if ($key==58) {

// 	            	// 		$arrayName[$key] = array("maxlength"=>$value['maxlength'],"email"=>'true');
// 	            	// 	}
// 	            	// 	else{
// 	            	// 		$arrayEmailCheck[$key] = $value;
// 	            	// 	}	            	
// 	            	// }
// 	            	// $validate_array_json = json_encode($arrayEmailCheck);
// 	            	?>
// 	            	$('#'+emailID).focus()

// 	            	//alert('Please enter valid Additional email address');
// 	            	$.alert({
// 					    title: 'Alert!',
// 					    content: 'Please enter valid Additional email address',
// 					});
// 	            }
// 	        },
// 	        rules: 
// 	          <?php echo  $validate_array_json;?>
// 	          ,
// 	        messages: {
	           	
// 	        }
// 	    });

// 	    // Reset form
// 	    // $('#reset').on('click', function() {
// 	    //     validator.resetForm();
// 	    // }); 
// 	};	

	$(document).ready(function(e) {
	var current_role_id = '<?php echo logged_in_role_id();?>';
		$("select").on("select2:close", function (e) {  
	        $(this).valid(); 
	    });
		$("#quick_update").on('submit', function(event) {
			if ($(this).valid())
		    {
		    	/*alert("test");*/
		    	/*var selections_47 = [];
		    	$('#47 :selected').each(function(i, sel){ 
					var selectedVal = $(sel).val();
					selections_47.push(selectedVal);
				});*/

				/*alert(selections3);
				return false;*/
		    	/*NOTE: CORNING MAIL CHECK START*/
		    	var formMailSubmit = 1;
				var current_role_id = '<?php echo logged_in_role_id();?>';
		    	var is_live = <?php echo IS_LIVE;?> ;
		    	var is_corning = '<?php echo IS_CORNING;?>' ;
				////var BOUNCE_CHECK = '<?php echo BOUNCE_CHECK;?>' ;
				var BOUNCE_CHECK = '1' ;
		    	console.log(is_corning);
		    	if(is_live == 1){
		    		var supplier_mail =  $('#15').val().toLowerCase();
					/* if (supplier_mail.indexOf('@') === -1) {
						$('#15').focus()
						$.alert({
							title: 'Alert!',
							content: "Invalid Supplier Contact Email",
						});
						return false;
					} */
					if ($('#15').length > 0){
						var supplier_mail =  $('#15').val().toLowerCase();						
						var emailPattern =   /^[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9]@[a-zA-Z0-9.-]+[a-zA-Z]{2,}$/;
					    if (!emailPattern.test(supplier_mail) || supplier_mail.indexOf('@') === -1) {
					        $('#15').focus();
					        $.alert({
					            title: 'Alert!',
					            content: "Please enter valid Supplier Contact Email",
					        });
					        return false;
					    }
					}
					var selected_option = $("#34 option:selected").val();
					var supplier_email = $("#15").val();
					var email_split=supplier_email.split('@');
					if(selected_option==632){
						if(email_split[1]=='corning.com'){
							$.alert({
								title: 'Alert!',
								content: "Please enter Supplier Contact Email Other then corning email address",
							});
							return false;
							//$( "#15" ).focus();
						}
					}else{
						if(email_split[1]!='corning.com'){
							$.alert({
								title: 'Alert!',
								content: "Please enter Corning email address in Supplier Contact Email",
							});
							//$( "#15" ).focus();
							return false;
						}
					} 
					var mailIdArray = [ 26,27 ];
					jQuery.each( mailIdArray, function( i, val ) {
						if($('#'+val).length){
							var mail_value =  $('#'+val).val().toLowerCase();
							var checkRequired = $('#'+val).attr('required');
							/*alert(testnew);
							alert(mail_value);
							alert(val);*/
							if(val==26){
								var alert_message = 'Please enter valid corning email address (which includes @corning.com) or "DID NOT CONTACT GSM"';
								}else if(val==27){
								var alert_message = 'Please enter valid corning email address (which includes @corning.com)';

							}
							if(mail_value != ''){
							
								if(mail_value == 'did not contact gsm' && val ==26){
									formMailSubmit = 1;
								}
								else{
									/*var n = mail_value.includes("@eccma.org");*/
									var n_split = mail_value.split("@");
									// var lastEleven = '';
									var corning_check = '';
									if (typeof n_split[1] != "undefined") {
										var corning_check = n_split[1];
										/*var is_corning_length = is_corning.length;
										lastEleven = corning_check.substr(corning_check.length -is_corning_length);
										console.log(lastEleven+"_mail length");*/
									}else{
										/*lastEleven = '';*/
									}

									/*if((lastEleven != is_corning) || (lastEleven == '')){*/
									if((corning_check != is_corning) || (corning_check == '')){
										formMailSubmit = 0;
										$('#'+val).focus()
										$.alert({
											title: 'Alert!',
											content: alert_message,
										});
										return false;
									}
									else{
										formMailSubmit = 1;
									}
								}
								
							}
							else{
								if(typeof(checkRequired) != 'undefined' && checkRequired != null && checkRequired != ''){
									formMailSubmit = 0;
									$('#'+val).focus()
									$.alert({
										title: 'Alert!',
										content: alert_message,
									});
									return false;
								}
							}
							
						}
					});
				}
				if(BOUNCE_CHECK==1){
					ajaxindicatorstart();
					$.ajax({
						url: '<?php echo base_url();?>smartform/validate_email_address',
						type: "POST",
						data: { supplier_mail : supplier_mail,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>' },
						dataType: 'json',
						success: function(data)
						{
							ajaxindicatorstop();
							if(data.status=='invalid'){
								$.alert({
									title: 'Alert!',
									content: 'Supplier Contact Email is Invalid. Please enter Valid supplier email address to proceed further.',
								});
								return false;
							}else if(data.status=='spamtrap'){
								$.alert({
									title: 'Alert!',
									content: 'Supplier Contact Email is found as a	Spamtrap. Please enter Valid supplier email address to proceed further.',
								}); 
								return false;
							}else if(data.status=='abuse'){
								$.alert({
									title: 'Alert!',
									content: 'Supplier Contact Email is found as a Abuser. Please enter Valid supplier email address to proceed further.',
								});
								return false;
							}else if(data.status=='do_not_mail'){
								$.alert({
									title: 'Alert!',
									content: 'Supplier Contact Email is found as a Do  not email. Please enter Valid supplier email address to proceed further.',
								});
								return false;
							}else{
								//
								if(formMailSubmit == 1){
					
			    		var formSubmit=0;
									var form_id =  $('#form_id').val();
									var emailID = 58;
									var element =  document.getElementById(emailID);
									// alert('new');
									// return false;
									// console.log("new");
									if (typeof(element) != 'undefined' && element != null)
									{
									  var multiple_email=$('#'+emailID).val();
									  if(multiple_email != ''){
										// alert(multiple_email);
										 var reg = /^([A-Za-z0-9_&\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
										  // var reg = /^((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
										  var emails = multiple_email.split(",");
										  
										  for(var i = 0; i < emails.length; i++)
											{
												console.log(reg.test(emails[i]));
											  if (reg.test(emails[i]) == false) {
													formSubmit+=1;
													
												}
												else
											  {
												
												  formSubmit+=0;
											  }
											}
										}
									}
							
									if(formSubmit==0){
										// $("#update_btn").on('click',(function(e) {
										 // alert("new");
										 // return false;

										// 	// return false;
										// 	/*NOTE: NO UPDATE*/
										//var tempMultipleIdArray = [48,47,52,53,62];
										var tempMultipleIdArray = [48,47,52,53,62];
										var check_hidden_multiselect_value=0;
										jQuery.each( tempMultipleIdArray, function( i, val ) {
											/*if($('#'+val).length){
											}*/
											var multiCheck = $('#'+val).attr('multiple');
											var multiReq = $('#'+val).attr('required');
											var multiVal = $('#'+val).val();
											if (typeof(multiCheck) != 'undefined' && multiCheck == 'multiple'){
												if(typeof(multiReq) != 'undefined' && multiReq == 'required'){
													if(typeof(multiVal) == 'undefined' || multiVal == null || multiVal == ''){
														check_hidden_multiselect_value++;
													}
												}
											}
											console.log("val_"+val);
											console.log("multi_"+multiCheck);
											console.log("req_"+multiReq);
											console.log("val_"+multiVal);
										});
										console.log("hidden_multiselect_"+check_hidden_multiselect_value);
										// return false;

										if(check_hidden_multiselect_value > 0){
											$.alert({
											title: 'Alert!',
											content: 'Please fill Mandatory fields',
											});
											return false;
										}else{
											if(current_role_id==1){
												var sup_clone_access_permission;
												var check_sup;
												var submit_check=$("#submit_check").val(); 
												var clone_request_id_supplier_info =  $('#clone_request_id_supplier_info').val();
												var verified_sts =  $('#verified_sts').val();
												var associated_requests_ids =  $('#associated_requests_ids').val();	

												var supplier_email = document.getElementById('15').value.trim().toLowerCase();;
												var supplier_legal_name = document.getElementById('42').value.trim().toLowerCase();;	
												var selected_supplier_email =  $('#selected_supplier_email').val().toLowerCase();
												var selected_legal_name=$("#selected_supplier_legalname").val().toLowerCase(); 

												var supplier_completed_status =  $('#supplier_completed_status').val();

												if(supplier_completed_status == 0){
													sup_clone_access_permission=1;
													$("#sup_clone_access_permission").val('yes'); 
													$("#submit_check").val('yes'); 	

												}else{
													sup_clone_access_permission=0;
													$("#sup_clone_access_permission").val('no'); 	
													$("#submit_check").val('no'); 

												}
												
												// if(sup_clone_access_permission == 1){
													// if(selected_legal_name==supplier_legal_name && selected_supplier_email == supplier_email){
													// 	check_sup= "Yes";
														// $("#submit_check").val('yes'); 	
													// }else{
													// 	check_sup= "No";
													// 	$("#submit_check").val('no'); 
													// }
												// }else{
												// 	check_sup= "No";
												// 	$("#submit_check").val('no'); 
												// }												
												checkBeforeSubmit();
												
												
										
												
												
											}else{
											$.confirm({
												title: 'Request Confirmation',
												theme: 'light',
												content: 'Kindly confirm the request to upload?',
												buttons : {
													yes : {
														text: 'Confirm',
														btnClass: 'btn-blue',
														action: function(){
														ajaxindicatorstart('Loading please wait.');
														var form=$("#quick_update");
														var formdata = new FormData(form[0]);
														$.ajax({
																url: '<?php echo base_url();?>smartform/quick_update',
																type: "POST",

																data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
																cache       : false,
																contentType : false,
																processData : false,
																dataType: 'json',
																success: function(data)
																{
																	console.log(data);
																	// return false;
																	ajaxindicatorstop();
																	if(data.error){
																		
																	}
																	else{
																		window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																	}
																}
														});	
													}
													},
													no : {
													text: 'Cancel',
													btnClass: 'btn-red',
													action : function(){
																
													}
													}
												}
											});
											}
										}

										//}));
									}else{
										<?php
										// $arrayEmailCheck = array();
										// foreach ($validation_array as $key => $value) {
										// 	if ($key==58) {

										// 		$arrayName[$key] = array("maxlength"=>$value['maxlength'],"email"=>'true');
										// 	}
										// 	else{
										// 		$arrayEmailCheck[$key] = $value;
										// 	}	            	
										// }
										// $validate_array_json = json_encode($arrayEmailCheck);
										?>
										$('#'+emailID).focus()

										//alert('Please enter valid Additional email address');
										$.alert({
											title: 'Alert!',
											content: 'Please enter valid Additional email address',
										});
									}
								}
							}
							
						}
					});
					
				}else{
				/*NOTE: CORNING MAIL CHECK END*/
				if(formMailSubmit == 1){
					
			    	var formSubmit=0;
		        	var form_id =  $('#form_id').val();
	        		var emailID = 58;
		        	var element =  document.getElementById(emailID);
		        	// alert('new');
		        	// return false;
		        	// console.log("new");
					if (typeof(element) != 'undefined' && element != null)
					{
					  var multiple_email=$('#'+emailID).val();
					  if(multiple_email != ''){
					  	// alert(multiple_email);
						 var reg = /^([A-Za-z0-9_&\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
						  // var reg = /^((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
						  var emails = multiple_email.split(",");
						  
						  for(var i = 0; i < emails.length; i++)
							{
								console.log(reg.test(emails[i]));
							  if (reg.test(emails[i]) == false) {
								  	formSubmit+=1;
								  	
								}
								else
							  {
							  	
								  formSubmit+=0;
							  }
							}
						}
					}

					var focusID = '';
					var focusIDVal = '';
					$(".dynamic_text_box").each(function() {

					    if ($(this).val().trim() == "") {
					    	var prefix = $(this).attr('data-id');
					    	var charsReplace = {' ':'__','(':'__',')':'__','.':'__'};
							var selectedValuesReplace = prefix.replace(/[ ().]/g, m => charsReplace[m]);		
							selectedValuesReplace = selectedValuesReplace.replace(",", "__");	
							if(focusID==''){
								focusID = selectedValuesReplace;
							}
					        formSubmit = 2;
					    }
					    else if($(this).val().trim() != ""){
					    	userValue = $(this).val().trim().length;
					    	if(userValue<2 || userValue>255){
					    		var prefix = $(this).attr('data-id');
						    	var charsReplace = {' ':'__','(':'__',')':'__','.':'__'};
								var selectedValuesReplace = prefix.replace(/[ ().]/g, m => charsReplace[m]);		
								selectedValuesReplace = selectedValuesReplace.replace(",", "__");	
								if(focusIDVal==''){
									focusIDVal = selectedValuesReplace;
								}
						        formSubmit = 3;
					    	}
					    }
					});

					if(formSubmit==2){
						$( "#50_"+focusID ).focus();
						$( "#50_"+focusID ).val('');
						$.alert({
							title: 'Alert!',
							content: 'Please enter values to the Field “Indicate the supplier ID to be updated (if multiple values are provided, separate them by a comma)".',
						});
						return false;
					}
					if(formSubmit==3){
						$( "#50_"+focusIDVal ).focus();
						$.alert({
							title: 'Alert!',
							content: 'Charcters should be between 2 to 255 to the Field "Indicate the supplier ID to be updated (if multiple values are provided, separate them by a comma)"',
						});
						return false;
					}
			
					if(formSubmit==0){
						// $("#update_btn").on('click',(function(e) {
						 // alert("new");
						 // return false;

						// 	// return false;
						// 	/*NOTE: NO UPDATE*/
						//var tempMultipleIdArray = [48,47,52,53,62];
						var tempMultipleIdArray = [48,47,52,53,62];
						var check_hidden_multiselect_value=0;
						jQuery.each( tempMultipleIdArray, function( i, val ) {
							/*if($('#'+val).length){
							}*/
							var multiCheck = $('#'+val).attr('multiple');
							var multiReq = $('#'+val).attr('required');
							var multiVal = $('#'+val).val();
							if (typeof(multiCheck) != 'undefined' && multiCheck == 'multiple'){
								if(typeof(multiReq) != 'undefined' && multiReq == 'required'){
									if(typeof(multiVal) == 'undefined' || multiVal == null || multiVal == ''){
										check_hidden_multiselect_value++;
									}
								}
							}
							console.log("val_"+val);
							console.log("multi_"+multiCheck);
							console.log("req_"+multiReq);
							console.log("val_"+multiVal);
						});
						console.log("hidden_multiselect_"+check_hidden_multiselect_value);
						// return false;

						if(check_hidden_multiselect_value > 0){
							$.alert({
							title: 'Alert!',
							content: 'Please fill Mandatory fields',
						 	});
						 	return false;
						}else{
							if(current_role_id==1){
								$.confirm({
									title: 'Request Confirmation',
									theme: 'light',
									content: 'Kindly confirm the request to upload?',
									buttons : {
										yes : {
											text: 'Confirm',
											btnClass: 'btn-blue',
											action: function(){
											ajaxindicatorstart('Loading please wait.');
											var form=$("#quick_update");
											var formdata = new FormData(form[0]);
											$.ajax({
													url: '<?php echo base_url();?>smartform/quick_check_flow',
													type: "POST",

													data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
													cache       : false,
													contentType : false,
													processData : false,
													dataType: 'json',
													success: function(data)
													{
														console.log(data);
														// return false;
														//ajaxindicatorstop();
														
														if(data.success==0){
															 var form=$("#quick_update");
																var formdata = new FormData(form[0]);
																$.ajax({
																		url: '<?php echo base_url();?>smartform/quick_update',
																		type: "POST",

																		data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
																		cache       : false,
																		contentType : false,
																		processData : false,
																		dataType: 'json',
																		success: function(data)
																		{
																			console.log(data);
																			// return false;
																			ajaxindicatorstop();
																			if(data.error){
																				
																			}
																			else{
																				window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																			}
																		}
																});	 
														}
														else{
															//window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
															
															/* console.log(data);
															return false; */
															$.confirm({
																title: 'Choose next level to Process',
																theme: 'light',
																columnClass: 'col-md-offset-4 col-md-4',
																/*content: 'Is record needed to be Rejected?',*/
																content:'<form action="" class="formName">' +
																			'<div class="form-group">' +data.info+'<label class="font-weight-semibold d-none">Approve comments</label><textarea class="approve_comment1 form-control text-uppercase d-none" name="approve_comment1" id="approve_comment1" rows="5" cols="40" required></textarea></div></form>',
																buttons : {
																	formSubmit: {
																		text: 'Submit',
																		btnClass: 'btn-blue',
																		action: function () {
																			var radioValue = $("input[name='process_flow']:checked").val();
																			var process_skip_type=$("#process_skip_type").val();
																			
																				
																			ajaxindicatorstart('Loading please wait.');
																			var formdata=$("#quick_update");
																			if(radioValue!=''){
																			$.ajax({
																				url: '<?php echo base_url();?>smartform/quick_update_flow_skip',
																				type: "POST",
																				// data:{ sup_id:sup_id,reject_comment:reject_comment,form_id:form_id},
																				data:formdata.serialize()+"&skipflow="+radioValue+"&process_skip_type="+process_skip_type+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
																				dataType: 'json',
																				success: function(data)
																				{
																					console.log(data);
																					// return false;
																					
																					if(data.error){
																						
																					}else if(data.success==0){
																						var form=$("#quick_update");
																							var formdata = new FormData(form[0]);
																							$.ajax({
																									url: '<?php echo base_url();?>smartform/quick_update',
																									type: "POST",

																									data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
																									cache       : false,
																									contentType : false,
																									processData : false,
																									dataType: 'json',
																									success: function(data)
																									{
																										console.log(data);
																										// return false;
																										ajaxindicatorstop();
																										if(data.error){
																											
																										}
																										else{
																											window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																										}
																									}
																							});	 
																					}
																					else{
																						ajaxindicatorstop();
																						window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																					}
																					
																				}
																			});
																			}else{ 
																				var form=$("#quick_update");
																				var formdata = new FormData(form[0]);
																				$.ajax({
																						url: '<?php echo base_url();?>smartform/quick_update',
																						type: "POST",

																						data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
																						cache       : false,
																						contentType : false,
																						processData : false,
																						dataType: 'json',
																						success: function(data)
																						{
																							console.log(data);
																							// return false;
																							ajaxindicatorstop();
																							if(data.error){
																								
																							}
																							else{
																								window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																							}
																						}
																				});	 	
																			}
																					
																		}
																	},
																	cancel: function () {
																		//close
																		ajaxindicatorstop();
																	},
																		
																}
															});
														}
													}														
											});	 
										}
										},
										no : {
										text: 'Cancel',
										btnClass: 'btn-red',
										action : function(){
													
										}
										}
									}
								});
								
							}else{
							$.confirm({
								title: 'Request Confirmation',
								theme: 'light',
								content: 'Kindly confirm the request to upload?',
								buttons : {
									yes : {
										text: 'Confirm',
										btnClass: 'btn-blue',
										action: function(){
										ajaxindicatorstart('Loading please wait.');
										var form=$("#quick_update");
										var formdata = new FormData(form[0]);
										$.ajax({
												url: '<?php echo base_url();?>smartform/quick_update',
												type: "POST",

												data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
												cache       : false,
										        contentType : false,
										        processData : false,
												dataType: 'json',
												success: function(data)
												{
													console.log(data);
													// return false;
													ajaxindicatorstop();
													if(data.error){
														
													}
													else{
														window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
													}
												}
										});	
									}
									},
									no : {
									text: 'Cancel',
									btnClass: 'btn-red',
									action : function(){
												
									}
									}
								}
							});
							}
						}

						//}));
		            }else{
		            	<?php
		            	// $arrayEmailCheck = array();
		            	// foreach ($validation_array as $key => $value) {
		            	// 	if ($key==58) {

		            	// 		$arrayName[$key] = array("maxlength"=>$value['maxlength'],"email"=>'true');
		            	// 	}
		            	// 	else{
		            	// 		$arrayEmailCheck[$key] = $value;
		            	// 	}	            	
		            	// }
		            	// $validate_array_json = json_encode($arrayEmailCheck);
		            	?>
		            	$('#'+emailID).focus()

		            	//alert('Please enter valid Additional email address');
		            	$.alert({
						    title: 'Alert!',
						    content: 'Please enter valid Additional email address',
						});
		            }
				}
				
				}

	        }

		    event.preventDefault(); // stop form from redirecting to java servlet page
		});
	});

	// $(function() {
	    // $('.on_select_change').change(function(){

			// var form_id = <?php echo $original_form_id; ?>;
			// if ((typeof($(this).attr("data-id")) != 'undefined') && ($(this).attr("data-id") != null)){
				// var id = $(this).attr("data-id");
				// var id_array=id.split(",");
				// var res_array='';
				// $.each(id_array, function(index, value) {
					// var te=$('#'+value).val();
					// te=value+'||'+te;
					// if(res_array==""){
						// res_array=te;
					// }else{
						// res_array+='*'+te;
					// }
				// });
		        // $.ajax({
	                // type: "POST",
	                // url: '<?php echo base_url();?>smartform/get_populated_condition',
	                // data: { form_id : form_id,field_value : res_array },
	                // dataType  : "json", 
	                // success   : function(data) {
	                	// $.each(data, function(index, value) {                		
	                		// if (value=='hide') {
	                			// $('#'+index).val('');
	                			// $('.'+index).addClass('d-none');
	                			// $('.'+index).removeClass('display_flex');
	                		// }
	                		// else if(value=='show'){
	                			// $('.'+index).removeClass('d-none');
	                			// $('.'+index).addClass('display_flex');
	                		// }
	                	// });
	                // }
	            // });
			// }
	    // });
	// });
	function checkBeforeSubmit(){
		// alert('checkBeforeSubmit');
		ajaxindicatorstart();
		var sup_clone_access_permission=$('#sup_clone_access_permission').val();	
		var submit_check=$('#submit_check').val();

	
		if($('#remove_sup_info_cloned_edit').length >0 || sup_clone_access_permission !='yes'){
			submit_check='no';	
			ajaxindicatorstop();				   
			submitForm();
		}
		


		if(sup_clone_access_permission=='yes' && submit_check=='yes' ){
			
			var form_id =  $('#form_id').val();
			var supplier_mail =  $('#15').val().toLowerCase();
			var supplier_legal_name = document.getElementById('42').value;
			var supplier_request_id = document.getElementById('sup_id').value.trim();
			var submit_check=$("#submit_check").val(); 
			// alert(supplier_mail);
			// alert(supplier_legal_name);						
			$.ajax({	
				type: "POST",	
				url: '<?php echo base_url();?>smartform/get_supplier_contact_email_auto_complete_blur',	
				data: { search_keyword: supplier_mail,supplier_legal_name:supplier_legal_name,supplier_request_id:supplier_request_id,['<?php echo $this->security->get_csrf_token_name();?>']: '<?php echo $this->security->get_csrf_hash();?>'},
				dataType  : "json", 
				success : function(responseData) {	
					ajaxindicatorstop();
					if(responseData !='' && responseData !=null){
						$.confirm({
							title: 'Alert',
							theme: 'light',
							content: 'Would you like to display and copy the information filled by the supplier email address '+supplier_mail+' within a year? Please note that if you change the supplier email address to some other after copying the information, all the supplier information will be removed from the request.',
							buttons : {
								yes : {
									text: 'Yes',
									btnClass: 'btn-blue',
									action: function(){
										console.log(responseData);
										$('#appendDatas_supplier_clone_ids').html('');
										$('#appendDatas_supplier_clone_ids').append(responseData);
										$('.child_rows').hide();
										$('.up_arrow').hide();
										//functest();
										/* jk++;
										if(jk==1){
											suppliercloneid(responseData);
										} */
										//$('#supplier_clone_modal').trigger('click');
										$('#modal_theme_danger').modal('toggle');
										
									}
									},no : {
									text: 'No',
									btnClass: 'btn-red',
									action : function(){
										$("#clone_request_id_supplier_info").val(''); 
										$("#submit_check").val('no'); 
										// if(clone_another_count != 2){
											submitForm();
										// }
									}
								}
							}
						});
					}else{
						ajaxindicatorstop();
						// $("#associated_requests_ids").val('');
		                $("#submit_check").val('no');
		                // $("#selected_supplier_email").val('');
		                submitForm();
					}
				}	
			});
			
		}		
		
	}

	function submitForm(){	
		// alert('submitForm');

		var remove_existing_sup_info='';
		var legal_name_Intrack=$('#legal_name_Intrack').val();
		var sup_email_Intrack=$('#sup_email_Intrack').val();
		var legal_name_current=$('#42').val();
		var sup_email_current=$('#15').val();
		var temp_request_id = '<?php echo $sup_id;?>';
		var form_id =  $('#form_id').val();

		
		// alert(legal_name_current);
		// alert(sup_email_Intrack);
		// alert(sup_email_current);

		if($('#remove_sup_info_cloned_edit').length >0){			
			if(legal_name_Intrack == legal_name_current && sup_email_Intrack == sup_email_current){		    	
		    	var alert_title = 'Send Request';
				var alert_content = 'Are you sure want to send request?';
		    }else{
				remove_existing_sup_info =1;			    		    	
		    	var alert_title = 'Send Request';
				var alert_content = 'Supplier Legal Name or Email ID is changed, so the copied information will be removed from the system.</br></br>Are you sure want proceed?';
		    }
		}else{
			var alert_title = 'Send Request';
			var alert_content = 'Are you sure want to send request?';
		}
		// return false;


		$.confirm({
			title: alert_title,
			theme: 'light',
			content: alert_content,
			buttons : {
				yes : {
					text: 'Confirm',
					btnClass: 'btn-blue',
					action: function(){
						ajaxindicatorstart('Loading please wait.');
						if(remove_existing_sup_info == 1){
							var temp_request_id = '<?php echo $sup_id;?>';
							// var cloned_sup_req_id= $("#clone_request_id_supplier_info_val").val();	
							$.ajax({	
								type: "POST",	
								url: '<?php echo base_url();?>smartform/remove_existing_sup_cloned_info_edit',	
								data: { current_request_id:temp_request_id,form_id:form_id,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
								success   : function(data) {	
									ajaxindicatorstop();	
									//reset_clone_modal();	
									if(data=="1"){	
										// window.location.href = '<?php echo base_url(); ?>smartform/form_edit_as/'+sup_id;	
										$.alert({	
											title: 'Alert!',	
											content: 'Copied supplier information are removed successfully.',	
											 onAction: function () {
											 	// $("#submit_check").val('yes');
												window.location.reload();	
											 }	
										});				  									
									}
								}	
							});	
						}
						else{
						var form=$("#quick_update");
						var formdata = new FormData(form[0]);
						$.ajax({
								url: '<?php echo base_url();?>smartform/quick_check_flow',
								type: "POST",

								data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
								cache       : false,
								contentType : false,
								processData : false,
								dataType: 'json',
								success: function(data)
								{
									console.log(data);
									// return false;
									//ajaxindicatorstop();
									
									if(data.success==0){
										 var form=$("#quick_update");
											var formdata = new FormData(form[0]);
											$.ajax({
													url: '<?php echo base_url();?>smartform/quick_update',
													type: "POST",

													data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
													cache       : false,
													contentType : false,
													processData : false,
													dataType: 'json',
													success: function(data)
													{
														console.log(data);
														// return false;
														ajaxindicatorstop();
														if(data.error){
															
														}
														else{
															window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
														}
													}
											});	 
									}
									else{
										//window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
										
										/* console.log(data);
										return false; */
										$.confirm({
											title: 'Choose next level to Process',
											theme: 'light',
											columnClass: 'col-md-offset-4 col-md-4',
											/*content: 'Is record needed to be Rejected?',*/
											content:'<form action="" class="formName">' +
														'<div class="form-group">' +data.info+'<label class="font-weight-semibold d-none">Approve comments</label><textarea class="approve_comment1 form-control text-uppercase d-none" name="approve_comment1" id="approve_comment1" rows="5" cols="40" required></textarea></div></form>',
											buttons : {
												formSubmit: {
													text: 'Submit',
													btnClass: 'btn-blue',
													action: function () {
														var radioValue = $("input[name='process_flow']:checked").val();
														var process_skip_type=$("#process_skip_type").val();
														
															
														ajaxindicatorstart('Loading please wait.');
														var formdata=$("#quick_update");
														if(radioValue!=''){
														$.ajax({
															url: '<?php echo base_url();?>smartform/quick_update_flow_skip',
															type: "POST",
															// data:{ sup_id:sup_id,reject_comment:reject_comment,form_id:form_id},
															data:formdata.serialize()+"&skipflow="+radioValue+"&process_skip_type="+process_skip_type+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
															dataType: 'json',
															success: function(data)
															{
																console.log(data);
																// return false;
																
																if(data.error){
																	
																}else if(data.success==0){
																	var form=$("#quick_update");
																		var formdata = new FormData(form[0]);
																		$.ajax({
																				url: '<?php echo base_url();?>smartform/quick_update',
																				type: "POST",

																				data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
																				cache       : false,
																				contentType : false,
																				processData : false,
																				dataType: 'json',
																				success: function(data)
																				{
																					console.log(data);
																					// return false;
																					ajaxindicatorstop();
																					if(data.error){
																						
																					}
																					else{
																						window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																					}
																				}
																		});	 
																}
																else{
																	ajaxindicatorstop();
																	window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																}
																
															}
														});
														}else{ 
															var form=$("#quick_update");
															var formdata = new FormData(form[0]);
															$.ajax({
																	url: '<?php echo base_url();?>smartform/quick_update',
																	type: "POST",

																	data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
																	cache       : false,
																	contentType : false,
																	processData : false,
																	dataType: 'json',
																	success: function(data)
																	{
																		console.log(data);
																		// return false;
																		ajaxindicatorstop();
																		if(data.error){
																			
																		}
																		else{
																			window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																		}
																	}
															});	 	
														}
																
													}
												},
												cancel: function () {
													//close
													ajaxindicatorstop();
												},
													
											}
										});
									}
								}														
						});	 
					}
					}
				},
				no : {
				text: 'Cancel',
				btnClass: 'btn-red',
				action : function(){
							
				}
				}
			}
		});

	}
	function searchSupplier(pageNo){
		//$("#col_adjust").removeClass('col-md-4').addClass('col-md-5');
		pageNo = pageNo ? pageNo : 1;
		var from_value =  $("[name='get_supplier_values']:checked").val();
		var search_keyword = $.trim($('#search_supplier').val());
		//var form_name = $('#form_name').val();
		var form_name = '<?php echo $this_form_id;?>';
		$("#add_new_sup").html('');
		if(form_name!=''){
			var records_perpage = 10;
			if(records_perpage==''){
				var recordsPerpage = '<?php echo $this->config->item('admin_per_page');?>';
			}
			else{
				var recordsPerpage = records_perpage;
			}
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url();?>smartform/get_alei/'+pageNo,
				data:'pageNo='+pageNo+'&search_keyword='+search_keyword+'&recordsPerpage='+recordsPerpage+'&from_value='+from_value+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
				dataType:'JSON',
				beforeSend: function () {
					ajaxindicatorstart();
					$('#appendDatas_supplier').html('');
					$('#pagination_supplier').html('');
					$('#totalCount_supplier').html('');
					// $('#totalItems').html('');
					// $('#approved').html('');
					// $('#pending').html('');
					// $('#rejected').html('');
					// $('#tickets-status').html('');
				},
				success: function (responseData) {
					ajaxindicatorstop();
					var rowData = responseData['rows'];
					var tr='';  
					var result_length=responseData['rows_tr'].length;
					if(result_length>0){
					$.each(responseData['rows_tr'], function(i, item) {
					var address='';
					if(item.address2!=''){
						address=item.address1+','+item.address2;
					}else{
						address=item.address1;
					}
					var validated_status='';
					if(item.validated==''){
						validated_status='<span class="text-danger"><b>***</b> </span>';
					}
					
						tr+='<tr>';
						tr+='<td><input type="radio" name="add_supplier" id="add_supplier'+i+'" onchange="select_supplier('+i+')"><input type="hidden" id="alei_id_'+i+'" value="'+item.id+'"><input type="hidden" id="sup_address_'+i+'" value="'+item.address+'"></td>'; 
						tr+='<td>'+validated_status+item.alei+'<input type="hidden" id="sup_alei_'+i+'" value="'+item.alei+'"><input type="hidden" id="sup_address_'+i+'" value="'+address+'"></td>'; 
						tr+='<td>'+item.sup_legal_name+'<input type="hidden" id="sup_name_'+i+'" value="'+item.sup_legal_name+'"></td>'; 
						tr+='<td>'+item.city+'<input type="hidden" id="sup_city_'+i+'" value="'+item.city+'"></td>'; 
						tr+='<td>'+item.state+'<input type="hidden" id="sup_state_'+i+'" value="'+item.state+'"></td>';
						tr+='<td>'+item.country+'<input type="hidden" id="sup_country_'+i+'" value="'+item.country+'"><input type="hidden" id="sup_pincode_'+i+'" value="'+item.pincode+'"></td>';
						tr+='</tr>';
					});
					}else{
					tr+='<tr><td class="text-danger" colspan="7" align="center"><b>No result found</b></td></tr>';
					}
//alert(responseData['rows_tr']);					
					$('#appendDatas_supplier').html(tr);
					$('#pagination_supplier').html(responseData['pagination']);
					$('#totalCount_supplier').html(responseData['total_rows']);
				}
			});
			}else{
			// $.alert({
			// title: 'Alert!',
			// content: 'Please choose a form',
			// });
			return false;
		}
		
		
	}
	function select_supplier(id){
		//var form_name=$('#form_name').val();
		var form_name='<?php echo $this_form_id;?>';
		var sup_id='<?php echo $sup_id;?>';
		var sup_alei=$("#sup_alei_"+id).val();
		var sup_name=$("#sup_name_"+id).val();
		var sup_city=$("#sup_city_"+id).val();
		var sup_state=$("#sup_state_"+id).val();
		var sup_country=$("#sup_country_"+id).val();
		var sup_address=$("#sup_address_"+id).val();
		var sup_pincode=$("#sup_pincode_"+id).val();
		var region=$("#18").val();
		var op_unit=$("#19").val();
		var alei_id=$("#alei_id_"+id).val();
		//alert(sup_name);return false;
		var type='browse';
		$.ajax({
			type: "POST",
			url: '<?php echo base_url();?>smartform/get_supplier_pre_populated_values',
			data: { form_id : form_name,supplier_name : sup_name,supplier_alei:sup_alei,supplier_city:sup_city,supplier_state:sup_state,supplier_country:sup_country,supplier_address :sup_address,supplier_pincode:sup_pincode,type:type,region:region,op_unit:op_unit,alei_id:alei_id,temp_data : 'temp_data',sup_id : sup_id ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
			success   : function(data) {
				if(data.error){
					
				}
				else{
					window.location.href = '<?php echo base_url(); ?>smartform/form_edit/'+sup_id;
				}
			}
		});
	}
	function select_supplier_autocomplete(supname){
		//var form_name=$('#form_name').val();
		var form_name='<?php echo $this_form_id;?>';
		var type='autocomplete';
		var sup_id='<?php echo $sup_id;?>';
		var region=$("#18").val();
		var op_unit=$("#19").val();
		// var sup_alei=$("#sup_alei_"+id).val();
		// var sup_name=$("#sup_name_"+id).val();
		// var sup_city=$("#sup_city_"+id).val();
		// var sup_state=$("#sup_state_"+id).val();
		// var sup_country=$("#sup_country_"+id).val();
		// var sup_address=$("#sup_address_"+id).val();
		// var sup_pincode=$("#sup_pincode_"+id).val();
		ajaxindicatorstart();
		$.ajax({
			type: "POST",
			url: '<?php echo base_url();?>smartform/get_supplier_pre_populated_values',
			data: { form_id : form_name,supplier_name : supname,type:type,region:region,op_unit:op_unit ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
			success   : function(data) {
				ajaxindicatorstop();
				if(data.error){
					
				}
				else{
					window.location.href = '<?php echo base_url(); ?>smartform/form_edit/'+sup_id;
				}
			}
		});
	}
	function rest_modal(){
		//$("#col_adjust").removeClass('col-md-5').addClass('col-md-6');
		//$("#get_supplier_values1").attr('checked', 'checked');
		$('#search_supplier').val('');
		$('#appendDatas_supplier').html('');
        $('#pagination_supplier').html('');
		$('#totalCount_supplier').html('');
		//$('#form_name').val('');
		//$("#add_new_sup").html('');
	}
	$(".fa-lightbulb-o").click(function(){
	    $('.fa-lightbulb-o.text-danger').not(this).removeClass('text-danger');
	    $(this).toggleClass('text-danger');
 	})	
	
	$(function() {
		$('.on_select_change').change(function(){
	var field_id = $(this).attr('id');
	//if(field_id!=47){
		 ajaxindicatorstart();
			var form_id = <?php echo $this_form_id; ?>;
			if ((typeof($(this).attr("data-id")) != 'undefined') && ($(this).attr("data-id") != null)){
				var id = $(this).attr("data-id");
				/*alert(id);
					console.log(id.split(","));
				console.log("test");*/
				var id_array=id.split(",");
				var res_array='';
				$.each(id_array, function(index, value) {
					var te=$('#'+value).val();
					te=value+'|'+te;
					if(res_array==""){
						res_array=te;
						}else{
						res_array+='*'+te;
					}
				});
				$.ajax({
					type: "POST",
					url: '<?php echo base_url();?>smartform/get_populated_condition',
					data: { form_id : form_id,field_value : res_array ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
					dataType  : "json",  
					success   : function(data) {
						$.each(data, function(index, value) {                		
							if (value=='hide') {
								$('#'+index).addClass('d-none');
								$('#'+index).removeClass('display_flex');
								$('#'+index).val('');
								$('.select2-container').css('width','100%');
								if(index=='2687'){
									$("input[name=51]").val('<?php echo $people_soft_value;?>');
								}
							}
							else if(value=='show'){
								$('#'+index).removeClass('d-none');
								$('#'+index).addClass('display_flex');
								$('.select2-container').css('width','100%');
								if(index==907){
									///var field_id=$('#'+index).attr('data-field-id');
									var def_field_val=$('#212').val();
									if(def_field_val!=''){
										$('#'+index).removeClass('d-none');
										$('#'+index).addClass('display_flex');
									}else{
										$('#'+index).addClass('d-none');
										$('#'+index).removeClass('display_flex');
										$('#212').prop('required',false);
									}
								}
								if(index=='2687'){
									$("input[name=51]").val('<?php echo $people_soft_value;?>');								
								}

								if(index=='660'){									
									var field_194 =$("#194").val();
									if(field_194==""){
										$('#660').addClass('d-none');
										$('#660').removeClass('display_flex');
										$('.194 ').addClass('d-none');
										$('.194 ').removeClass('display_flex');
										$('#194 ').prop('required',false);
									} 
									//alert('test');
								}

								var obj = {
								    "620":"101",
									"621":"102",
									"622":"103",
									"623":"104",
									"624":"105",
									"625":"106",
									"626":"203",
									"630":"107",
									"631":"207",
									"632":"108",
									"633":"109",
									"634":"208",
									"635":"110",
									"652":"126",
									"659":"132",
									"661":"133",
									"662":"134",
									"663":"135",
									"664":"201",
									"665":"136",
									"666":"137",
									"667":"138",
									"668":"139",
									"669":"140",
									"670":"141",
									"671":"142",
									"672":"143",
									"674":"212",
									"683":"150",
									"714":"177",
									"715":"178",
									"716":"179",
									"717":"215",
									"718":"216",
									"719":"217",
									"720":"218",
									"721":"219",
									"722":"220",
									"723":"221",
									"724":"180",
									"725":"181",
									"726":"182",
									"727":"222",
									"728":"183",
									"729":"184",
									"730":"185",
									"731":"186",
									"732":"223",
									"733":"224",
									"734":"187",
									"735":"188",
									"736":"189",
									"889":"150",
									"907":"212",
									"911":"143",
									"913":"142",
									"915":"141",
									"917":"140",
									"919":"139",
									"921":"138",
									"923":"137",
									"925":"136",
									"927":"201",
									"929":"135",
									"931":"134",
									"933":"133",
									"937":"132",
									"947":"126",
									"981":"110",
									"983":"208",
									"985":"109",
									"987":"108",
									"989":"207",
									"991":"107",
									"999":"203",
									"1001":"106",
									"1003":"105",
									"1005":"104",
									"1007":"103",
									"1009":"102",
									"1011":"101",
									"1169":"177",
									"1171":"178",
									"1173":"179",
									"1175":"215",
									"1177":"216",
									"1179":"217",
									"1181":"218",
									"1183":"219",
									"1185":"220",
									"1187":"221",
									"1189":"180",
									"1191":"181",
									"1193":"182",
									"1195":"222",
									"1197":"183",
									"1199":"184",
									"1201":"185",
									"1203":"186",
									"1205":"223",
									"1207":"224",
									"1209":"187",
									"1211":"188",
									"1213":"189",
									"1279":"150",
									"1297":"212",
									"1301":"143",
									"1303":"142",
									"1305":"141",
									"1307":"140",
									"1309":"139",
									"1311":"138",
									"1313":"137",
									"1315":"136",
									"1317":"201",
									"1319":"135",
									"1321":"134",
									"1323":"133",
									"1327":"132",
									"1337":"126",
									"1371":"110",
									"1373":"208",
									"1375":"109",
									"1377":"108",
									"1379":"207",
									"1381":"107",
									"1389":"203",
									"1391":"106",
									"1393":"105",
									"1395":"104",
									"1397":"103",
									"1399":"102",
									"1401":"101",
									"1559":"177",
									"1561":"178",
									"1563":"179",
									"1565":"215",
									"1567":"216",
									"1569":"217",
									"1571":"218",
									"1573":"219",
									"1575":"220",
									"1577":"221",
									"1579":"180",
									"1581":"181",
									"1583":"182",
									"1585":"222",
									"1587":"183",
									"1589":"184",
									"1591":"185",
									"1593":"186",
									"1595":"223",
									"1597":"224",
									"1599":"187",
									"1601":"188",
									"1603":"189"
								};									
								if(index in obj){
									var def_field_val=$('#'+obj[index]).val();
									if(def_field_val!=''){
										$('#'+index).removeClass('d-none');
										$('#'+index).addClass('display_flex');
									}else{
										$('#'+index).addClass('d-none');
										$('#'+index).removeClass('display_flex');
										$('#'+index).prop('required',false);
									}
								} 
							}
						});
						ajaxindicatorstop();
					}
				});
			}
			else{
				/*alert("no data id");*/
			}
			//}
		});
	});
	
	function ValidateMultipleInput(id) {
		var field_id=id;
		var value = document.getElementById(id).value;
	    var file = value.toLowerCase();
	    var extension = file.substring(file.lastIndexOf('.') + 1);
		var ins = document.getElementById(id).files.length;
		if(ins>0){
			ajaxindicatorstart();
			var blnValid = false;
			var _validMultiFileExtensions = <?php echo FILE_EXTENSION_UPLOAD_SERIAL; ?>;   

			for (var j = 0; j < _validMultiFileExtensions.length; j++) {
				var sCurMultiFileExtension = _validMultiFileExtensions[j];
				if(sCurMultiFileExtension == extension){
					blnValid = true;
					break;
					ajaxindicatorstop();
				}
			}        
			if (!blnValid) {
				$.alert({
						title: 'Alert!',
						content: '<?php echo FILE_EXTENSION_UPLOAD_ALERT;?>',
					});
				document.getElementById(id).value = "";
				ajaxindicatorstop();
				return false;				
			}else{
				var form_data = new FormData();
				var sup_id=$('#sup_id').val();
				var ins = document.getElementById(id).files.length;
				for (var x = 0; x < ins; x++) {
					form_data.append("files[]", document.getElementById(id).files[x]);
				}
				 form_data.append("sup_id",sup_id);
				 form_data.append("field_id",id);
				 form_data.append(['<?php echo $this->security->get_csrf_token_name();?>'],'<?php echo $this->security->get_csrf_hash();?>');
				$.ajax({
					url: '<?php echo base_url();?>smartform/requestor_direct_upload_files/',
					dataType: 'json', // what to expect back from the server
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'POST',
					success: function (response) {
						ajaxindicatorstop();
						var resinfo = response.info;
						var resresult = response.result;
						var result_length=resresult.length;
						/*console.log("test1"+result_length);
						console.log(resresult);
						console.log(resinfo);*/
						// return false;
						if(result_length>0){
							var preview='';
							ajaxindicatorstop();
							$.each(resresult, function(i, item) {
								var delFilename="'"+item.file_name+"'";
								
								preview+='<span class="field_id_'+field_id+'" id= "file_'+item.id+'"><b>'+item.display_name+'</b>&nbsp;&nbsp;&nbsp;<i class="icon-trash mr-2 text-danger" style="cursor:pointer;" onclick="removeUploadedFile('+item.id+','+delFilename+','+id+')"></i></span></br>';
							});
							
						}
						if(resinfo=='failed'){
							$.alert({
								title: 'Alert!',
								content: '<?php echo FILE_EXTENSION_UPLOAD_ALERT;?>',
							});
							document.getElementById(id).value = "";
							ajaxindicatorstop();
						}
						/*$delFilename="'".$fileValue."'";
						echo '<span id="'.$fileKey.'"><b>'.$fileValue.'</b>&nbsp;&nbsp;&nbsp;<i class="icon-trash mr-2 text-danger" style="cursor:pointer;" onclick="removeFile('.$fileKey.','.$master_id.','.$delFilename.')"></i></span></br>';*/
						//$('#preview_1459').html('<span class="mt-2 font-weight-bold alert alert-info">'+preview+'</span>');
						$('#preview_'+id).addClass("mt-2 font-weight-bold alert alert-info");
						$('#preview_'+id).html(preview);
					},
					error: function (response) {
						$('#msg').html(resresult); // display error response from the server
						ajaxindicatorstop();						
					}
				});
			}
		}
	}
	
	function removeUploadedFile(file_id,file_name,field_id){
		var field_id=field_id;
		$.confirm({
			title: 'Remove File',
			theme: 'light',
			content: "Are you sure want to completely remove this file from this request?",
			buttons : {
				yes : {
					text: 'Confirm',
					btnClass: 'btn-blue',
					action: function(){
						ajaxindicatorstart();
						$.ajax({
							type: "POST",
							url: '<?php echo base_url();?>smartform/removeUploadedFile',
							data: { file_id:file_id,file_name:file_name ,field_id:field_id,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
							success   : function(data) {
								ajaxindicatorstop();
								if(data=="suc"){
								   $("#file_"+file_id).remove();
								     if(field_id==57){
										var file_count_57 = $('.field_id_57').length;
										if(file_count_57 <= 0){
											$('#'+57).attr('required','required');
											document.getElementById(field_id).value = "";
										}
										else{
											$('#'+57).removeAttr("required");
										}
								   }
								   if(field_id==1459){
											var file_count_1459 = $('.field_id_1459').length;
											if(file_count_1459 <= 0){
												$("#1459").val(null);
											}		
										}
								}
								
							}
						});	
					}
					},no : {
					text: 'Cancel',
					btnClass: 'btn-red',
					action : function(){  
						
					}
				}
			}
		});
		
	}
	function UpdateTempForms() {
		//alert('test');
		$(".form-control").each(function() {
			var tid = $(this).attr('id');
			//alert('sd'.+tid);
			if(!$(this).hasClass("50_user_input")){
			  	$('#'+tid).change(function(){ 
					
				  	var tvalue = $(this).val();
				  	var user_id = $("#userid").val();
				  	var sup_id = $("#sup_id").val();
					var arr_temp_value = [];
					
					if (tid==57 || tid==194 || tid==195 || tid==198 || tid==199 || tid==200 || tid==213 || tid==233 || tid==246 || tid==255 || tid==257 || tid==262 || tid==265 || tid==267 || tid==273 || tid==279 || tid==282 || tid==284 || tid==286 || tid==289 || tid==291 || tid==295 || tid==298 || tid==330 || tid==1459) {
						var form_data = new FormData();
						var sup_id='<?php echo $sup_id;?>';
						var files = $('#57')[0].files[0];
	    				form_data.append('files',files);
	    				form_data.append("sup_id",sup_id);
	    				form_data.append("field_id",57);
	    				form_data.append(['<?php echo $this->security->get_csrf_token_name();?>'],'<?php echo $this->security->get_csrf_hash();?>');
						$.ajax({
							url: '<?php echo base_url();?>smartform/update_temp_forms_edit',
							dataType: 'json', // what to expect back from the server
							cache: false,
							contentType: false,
							processData: false,
							data: form_data,
							type: 'POST',
							success: function (response) {
								
							},
							error: function (response) {
								// $('#msg').html(response); // display error response from the server
							}
						});
					}
					else if(tid!=1459 && tvalue!='Other'){
						//alert('test14855');
				  		if(tid.indexOf('additional_') != -1 || tid==50){
									
							var prefixvalue = $('#50_firstrow').text();
							tvalue = $('#50').val();
							first_temp_value = prefixvalue+tvalue;
							
							if (tvalue!='') {
								arr_temp_value.push(first_temp_value);
							}

						    $(".checkdynamicname").each(function() {
					    		var temp_val = $(this).val();
					    		var prefixvalue = $(this).attr('prefixvalue');
				    			tvalue = prefixvalue+temp_val;
				    			if (temp_val!='') {
					    			arr_temp_value.push(tvalue);
				    			}
						    });

						    if (arr_temp_value.length>0) {
						    	tvalue = arr_temp_value.join('||');
						    	tid = 50;
						    }
						}					
				  		$.ajax({  
							url:"<?php echo base_url();?>smartform/update_temp_forms_edit",  
							method:"POST",  
							data:{user_id:user_id, sup_id:sup_id, field_id:tid, field_value:tvalue ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},  
							dataType:"text",  
							success:function(data)  
							{  
								// if(data != '')  
								// {  
								// 	$('#post_id').val(data);  
								// }  
								// 	$('#autoSave').text("Post save as draft");  
								// setInterval(function(){  
								// 	$('#autoSave').text('');  
								// }, 5000);  
								if ($('#'+tid).attr('data-required-check') !== undefined) {
    // Attribute exists
										var check_req=$('#'+tid).attr('data-required-check');
										if(check_req=='check_required'){
											change_required_condition(tid);
										}else{

										}
									} else {
										
									}
							}  
						}); 
				  	}
				  	
			  	}); 
		  	}
		});		
	}
	$("#79").on("change", function (e) { 
		var tvalue = $(this).val();
		//console.log(tvalue);
		var tvalue = $(this).val();
		var user_id = $("#userid").val();
		var sup_id = $("#sup_id").val();
		$.ajax({  
				url:"<?php echo base_url();?>smartform/update_temp_forms_edit",  
				method:"POST",  
				data:{user_id:user_id, sup_id:sup_id, field_id:'79', field_value:tvalue ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},  
				dataType:"text",  
				success:function(data)  
				{  
					// if(data != '')  
					// {  
					// 	$('#post_id').val(data);  
					// }  
					// 	$('#autoSave').text("Post save as draft");  
					// setInterval(function(){  
					// 	$('#autoSave').text('');  
					// }, 5000);  
					console.log(tvalue);
				}  
		}); 
		//console.log(tvalue);
	});
	$("#add_flag").on('click',(function(e) {
	var role_id = <?php echo logged_in_role_id();?>;
	var sup_id=$("#sup_id").val();
	var form_id=$("#form_id"). val();
	$.confirm({
			title: 'Add Flag!',
			theme: 'light',
			columnClass: 'col-md-6',	
			content:	'<form action="" class="formName">' +
					    '<div class="form-group">' +
					    '<label>Please enter your comment:</label>' +
					    '<textarea class="flag_comment form-control text-uppercase" name="flag_comment" id="flag_comment" rows="5" cols="40" maxlength="255" style="text-transform:uppercase;" required></textarea>' +
					    '</div>' +
					    '</form>',
			buttons : {
				formSubmit: {
		            text: 'Submit',
		            btnClass: 'btn-blue',
		            action: function () {
		                var flag_comment = this.$content.find('.flag_comment').val().trim();
		                // var flag_length=flag_comment.length;
		                if(!flag_comment){
		                    $.alert('Please enter your comments');
		                    $.alert(flag_comment.length);

		                    $("#flag_comment").val("");
		                    $("#flag_comment").focus();
		                    return false;
		                }
		            
						ajaxindicatorstart('Loading please wait.');
						$.ajax({
							url: '<?php echo base_url();?>smartform/add_flag_commets',
							type: "POST",
							data:{ sup_id:sup_id,role_id:role_id,flag_comment:flag_comment,'<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>'},
							//data:formdata.serialize()+"&flag_comment="+flag_comment+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
							dataType: 'json',
							success: function(data)
							{
								console.log(data);
								// return false;
								ajaxindicatorstop();
								if(data.error){
									
								}
								else{
									if(role_id == 10){
										window.location.href = '<?php echo base_url(); ?>supplierportal';
									}
									else{
										window.location.reload();
									}
								}
								
							}
						});
								
		            }
		        },
		        cancel: function () {
		            //close
		        },
					
			}
		});
}));
</script>
<?php
if ($original_status=='Rejected') {
?>
<script>
var current_role_id='<?php echo logged_in_role_id();?>';
	UpdateTempForms();
	if(current_role_id==1){
		check_supplier_email_id();
		$("#15").blur(function(){
			//check_supplier_email_id();
		});
		function check_supplier_email_id(){
			var supplier_email_id=$('#15').val();
			supplier_email_id=$.trim(supplier_email_id);
			if(supplier_email_id!=''){
				var testEmail = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,20}$/i;
				if (testEmail.test(supplier_email_id)){
					$.ajax({  
						url:"<?php echo base_url();?>smartform/check_supplier_subscription",  
						method:"POST",  
						data:{supplier_email:supplier_email_id,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},  
						dataType:"text",  
						success:function(data)  
						{  
							if(data==1){
								$.alert({
									icon:'fa fa-warning',
									title: 'Alert!',
									content: 'The supplier email id that you have entered in the field "Supplier Contact Email - For portal maintenance" has unsubcribed to notification emails from the SDM supplier portal. Please send the subscription link to the supplier and ask him to subscribe to receive notification emails from the SDM supplier portal. ',
								}); 
							}
							//return false;
						}  
					}); 
					
				}else{
					$.alert({
						title: 'Alert!',
						content: 'Please enter valid email address',
					});
					return false;
				}
			}
		}
	}
	function show_supplier(sup_id){		
		$('#supplier_info_'+sup_id).html('<center>Loading..</center>');	
		$('.child_rows').hide();
		$('.up_arrow').hide();
		$('.down_arrow').show();
		$('#child_'+sup_id).show();
		$('#up_arrow_'+sup_id).show();
		$('#down_arrow_'+sup_id).hide();
		var sup_id = sup_id;		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url();?>smartform/get_supplier_form_details',
			data: { sup_id : sup_id,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>' },
			success   : function(data) {
				$('#supplier_info_'+sup_id).html(data);
				// $('#appendDatas_supplier_clone_ids').append(data);
				
			}
		});

	}
function close_toggle_supplier(sup_id){	
	$('.child_rows').hide();
	$('.up_arrow').hide();				
	$('#up_arrow_'+sup_id).hide();
	$('#down_arrow_'+sup_id).show();

}
function clone_supplier_info(supId){	
	var selected_request_id = supId;	
	var temp_request_id = '<?php echo $sup_id;?>';	
	var form_id = '<?php echo $original_form_id;?>';
	var supplier_email_id=$('#15').val();	
	var supplier_legalname=$('#42').val();	
	//alert(selected_request_id+' - '+temp_request_id);	
	$.confirm({	
		title: 'Alert',	
		theme: 'light',	
		content: "Are you sure want to copy the supplier information of the selected request?",	
		buttons : {	
			yes : {	
				text: 'Confirm',	
				btnClass: 'btn-blue',	
				action: function(){	
					ajaxindicatorstart();	
					$.ajax({	
						type: "POST",	
						url: '<?php echo base_url();?>smartform/clone_supplier_info_edit',	
						data: { selected_request_id:selected_request_id,current_request_id:temp_request_id,current_form_id:form_id ,form_edit_process:'1',supplier_email_id:supplier_email_id,supplier_legalname:supplier_legalname,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
						success   : function(data) {	
							ajaxindicatorstop();	
							//reset_clone_modal();	
							if(data=="1"){	
							   $.alert({	
									title: 'Alert!',	
									content: 'Copied successfully.',	
									 onAction: function () {	
										window.location.reload();	
									 }	
								});										
							}else{	
								$.alert({	
									title: 'Alert!',	
									content: 'Failed to clone.',	
									onAction: function () {	
										window.location.reload();	
									}	
								});	
									
							}	
								
						}	
					});		
				}	
				},no : {	
				text: 'Cancel',	
				btnClass: 'btn-red',	
				action : function(){ 
					$( ".clone_class" ).prop( "checked", false );							
				}	
			}	
		}	
	});	
}
	$(document).ready(function(e) {
		$(function() {
			$("#15").autocomplete({
				source: function(request, response) {
			var search_keyword = document.getElementById('15').value.trim();
			var supplier_legal_name = document.getElementById('42').value.trim();
			var supplier_request_id = document.getElementById('sup_id').value.trim();
			//Fetch data
			if (search_keyword != '') {
				if (search_keyword.length >= 3) {
					$.ajax({
						url: '<?php echo base_url();?>smartform/get_supplier_contact_email_auto_complete',
						type: 'post',
						dataType: "json",
						async: false,
						data: {
							search_keyword: search_keyword,supplier_legal_name:supplier_legal_name,supplier_request_id:supplier_request_id,
							['<?php echo $this->security->get_csrf_token_name();?>']: '<?php echo $this->security->get_csrf_hash();?>'
						},
						success: function(data) {
							response(data);
							response($.map(data, function(item ,value) {
								return {
									label: value,
									value: item
								};
							}));
							return data;
						}
					});
					return false;
				}
			} else {
				$("#15").val('');
				// alert('Space not allowed!');
				$.alert({
					title: 'Alert!',
					content: 'Space not allowed!',
				});
				return false;
			}

		},
		select: function(event, ui) {
			//Set selection
			$('#15').val(ui.item.label); // display the selected text
			event.preventDefault();
			$(this).val(ui.item.label);
			var keywords = ui.item.sup_legal_name;
			$("#keywords").val(keywords);
			var existing_email =$("#15").val().toLowerCase();
			var clone_request_id_supplier_info =$("#clone_request_id_supplier_info").val().toLowerCase();
			if(clone_request_id_supplier_info!='yes'){
				if(existing_email == ui.item.label){
					$("#clone_request_id_supplier_info").val('No');
				}else{
					$("#clone_request_id_supplier_info").val('yes');
				}
			}
			$("#associated_requests_ids").val(ui.item.value);
			$("#submit_check").val('yes'); 
			$("#selected_supplier_email").val(ui.item.label); 
			
			//$('#select_supplier_info').show();
			//get_associated_request(ui.item.label);
			return false;
		}			
		});
			
		});
			
	});

	function change_required_condition(tid){
		var form_id = '<?php echo $original_form_id;?>';
		var tvalue=$('#'+tid).val();
		var sup_id = $("#sup_id").val();
		ajaxindicatorstart();
		$.ajax({  
			url:"<?php echo base_url();?>smartform/change_required_condition", 
			method:"POST",  
			data:{form_id:form_id,field_id:tid, field_value:tvalue,pagename:'temp',sup_id:sup_id,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'}, 
			dataType  : "json", 
			success   : function(data) {
				ajaxindicatorstop();
				$.each(data, function(index, value) {   
					console.log(index+ ' - '+value);
					var val_split= value.split('|');
					if ($('#'+index).length) {
						if(val_split[0]==1){
							var form_layout_id=val_split[2];
							if ($('#'+form_layout_id).hasClass('d-none')) {
							}else{
								$('#'+index).attr('required','required');
								$('#'+index).addClass(val_split[1]);
								$('#star_'+index).text('*');
							}
							
						}else if(val_split[0]==0){
							$('#'+index).removeAttr('required');
							$('#'+index).removeClass(val_split[1]);
							$('#star_'+index).text('');
							if ($('#'+index+'-error').text().trim() === 'This field is required.'){
								$('#'+index+'-error').text('');
							}
						}
					} else {

					}
					
				});
					

			}
		});
	}
	function field_required_check_ajax(tid){
		var form_layout_id = tid;
		var sup_id = $("#sup_id").val();
		var page='temp';
		ajaxindicatorstart();
		$.ajax({  
			url:"<?php echo base_url();?>smartform/field_required_check_ajax", 
			method:"POST",  
			data:{sup_id:sup_id,form_layout_id:form_layout_id,page:'temp',['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'}, 
			dataType  : "json", 
			success   : function(data) {
				ajaxindicatorstop();
				$.each(data, function(index, value) {   
					console.log(index+ ' - '+value);
					var val_split= value.split('|');
					if ($('#'+index).length) {
						if(val_split[0]==1){
							var form_layout_id=val_split[2];
							if ($('#'+form_layout_id).hasClass('d-none')) {
							}else{
								$('#'+index).attr('required','required');
								$('#'+index).addClass(val_split[1]);
								$('#star_'+index).text('*');
							}
							
						}else if(val_split[0]==0){
							$('#'+index).removeAttr('required');
							$('#'+index).removeClass(val_split[1]);
							$('#star_'+index).text('');
							if ($('#'+index+'-error').text().trim() === 'This field is required.'){
								$('#'+index+'-error').text('');
							}
						}
					} else {

					}
					
				});
					

			}
		});
	}

	function checkForExitsingSupplier(){	
		var search_keyword = document.getElementById('15').value.trim();
		var supplier_legal_name = document.getElementById('42').value.trim();
		var supplier_request_id = document.getElementById('sup_id').value.trim();
		// var associated_requests_ids = document.getElementById('associated_requests_ids').value.trim();
		var selected_supplier_legal_name = document.getElementById('selected_supplier_legalname').value.trim();
		var selected_supplier_email = document.getElementById('selected_supplier_email').value.trim();
		// alert(search_keyword);
		// alert(supplier_legal_name);
		// alert(selected_supplier_email);
		// alert(search_keyword);
		// return false
		if(search_keyword!='' && supplier_legal_name!=''){
			if(selected_supplier_email!=search_keyword){
		// alert("testa");return false

			$.ajax({	
				type: "POST",	
				url: '<?php echo base_url();?>smartform/get_supplier_contact_email_auto_complete_blur',	
				data: { search_keyword: search_keyword,supplier_legal_name:supplier_legal_name,supplier_request_id:supplier_request_id,['<?php echo $this->security->get_csrf_token_name();?>']: '<?php echo $this->security->get_csrf_hash();?>'},
				dataType  : "json", 
				success : function(data) {	
					ajaxindicatorstop();
					if(data !=''){
						$.each(data, function(index, value) {   
							console.log(index+ ' - '+value);
							var result = value.split('|');
							var associated_sup_id_res=result[0];
							var supplier_email_address_res=result[1];
							// insert_supplier_temp_data(associated_sup_id_res,supplier_email_address_res,supplier_request_id);
							$("#associated_requests_ids").val(associated_sup_id_res);
							$("#submit_check").val('yes'); 
							$("#selected_supplier_email").val(supplier_email_address_res); 						
						});
					}else{
						$("#associated_requests_ids").val('');
	                    $("#submit_check").val('no');
	                    $("#selected_supplier_email").val('');
					}
				}	
			});
			}
		}
	}

	function remove_sup_cloned_info_edit(){		
		var temp_request_id = '<?php echo $sup_id;?>';
		var form_id= $("#form_id").val();	

		$.confirm({	
			title: 'Alert',	
			theme: 'light',	
			content: "Are you sure want to remove the cloned supplier information of the selected request?",	
			buttons : {	
				yes : {	
					text: 'Remove',	
					btnClass: 'btn-blue',	
					action: function(){	
						ajaxindicatorstart();	
						$.ajax({	
							type: "POST",	
							url: '<?php echo base_url();?>smartform/remove_sup_cloned_info_edit',	
							data: { current_request_id:temp_request_id,form_id:form_id,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
							success   : function(data) {	
								ajaxindicatorstop();	
								//reset_clone_modal();	
								if(data=="1"){	
								   $.alert({	
										title: 'Alert!',	
										content: 'Copied supplier information removed successfully.',	
										 onAction: function () {
										 	// $("#submit_check").val('yes');
											window.location.reload();	
										 }	
									});										
								}else{	
									$.alert({	
										title: 'Alert!',	
										content: 'Failed to removed Copied supplier information.',	
										onAction: function () {	
											window.location.reload();	
										}	
									});	
										
								}	
									
							}	
						});		
					}	
					},no : {	
					text: 'Cancel',	
					btnClass: 'btn-red',	
					action : function(){  	
							
					}	
				}	
			}	
		});

	}


</script>

<?php
}
?>