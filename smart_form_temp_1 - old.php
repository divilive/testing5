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
if($this->session->userdata('exist_supplier_data')) {
	$suppliers_info = $this->session->userdata['exist_supplier_data'];
}else{
	$suppliers_info = '';
}

$user_id = logged_in_user_id();
$current_user_name=get_user_name($user_id);
$current_user_name=$current_user_name->name; 

$consolidate_id='';

$card_title = ""; 
$role_id = logged_in_role_id();
$userid = logged_in_user_id();
					
$Editable = 'js-example-basic-single';
$tempEditable = 'js-example-basic-single';
if($Editable !=''){
	$comment_field = '';	
}
$form_details=get_form_details($original_form_id);
$card_title=$form_details->form_name;
$button_title=$form_details->button_name;

$parallel=$form_details->is_parallel;
$this_form_id=$original_form_id;

$corning_alei='';
$consolidate_id='';

if(isset($suppliers_info['alei'])<>''){
	$corning_alei=$suppliers_info['alei'];
}else{
	$corning_alei=$edit_quick_list[0]['alei'];
}
if(isset($suppliers_info['consolidate_id'])<>''){
	$consolidate_id=$suppliers_info['consolidate_id'];
}

if(isset($suppliers_info['master_id'])<>''){
	$master_id=$suppliers_info['master_id'];
}
else{
	$master_id=date("YmdHis");
} 
$get_supplier_master_details=get_suplier_master_temp($sup_id);	
$get_request_status	= $get_supplier_master_details->status;		
$get_request_legal_name	= $get_supplier_master_details->legal_name;			
					
?>
<div class="page-content container">
	<div class="content-wrapper">
		<div class="content">
			<div class="card" style="background: #fafafb;border: 3px solid #c79238;margin-bottom: 0px !important;">
				<div class="card-header header-elements-sm-inline	">
					<h5 class="card-title"><strong><i class="icon-reading icon-2x"></i><?php echo " $card_title";?></strong></h5>
					<div class="header-elements">							
	                	<?php
	                	$temp_status=$get_supplier_master_details->status;
	                	$clone_request_id_supplier_info_val=$get_supplier_master_details->clone_request_id_supplier_info;
	                	$associated_request_ids=$get_supplier_master_details->associated_request_ids;
						$submit_check=$get_supplier_master_details->submit_check;
						$verified=$get_supplier_master_details->verified;
						$clone_removed=$get_supplier_master_details->clone_removed;
						$info_copied_email_id=$get_supplier_master_details->info_copied_email_id;
						$request_clone_id	= $get_supplier_master_details->clone_request_id;
						$get_request_legal_name	= $get_supplier_master_details->legal_name;
						if($request_clone_id<>'' && $info_copied_email_id<>'' && $associated_request_ids<>''){
							$display_cloned_request='';
						}else{
							if($request_clone_id<>''){
								$display_cloned_request="Clone";
							}else{
								$display_cloned_request="";
							}
							

						}
					
								if($temp_status=="Closed"){
									$temp_close_label='<span class="badge badge-secondary"><b class="font-size-lg">Request Closed</b></span>';
								}else{
									$temp_close_label='';
								}
                			echo '<div class="pr-1 text-center pb-1"><span class="badge bg-info-400"><b class="font-size-lg">Request ID :TEMP'.$sup_id.'</b></span>'.$temp_close_label.'<br></div>';
                		?>
                	</div>
				</div>
				<div class="card-body">					
					<?php //echo form_open(base_url().'smartform/quick_update', array('name' => 'quick_update', 'id' => 'quick_update', 'class' => 'form-validate-jquery'), ''); ?>		
					<form name= 'smart_form' id= 'smart_form' class= 'form-validate-jquery' method='post' enctype='multipart/form-data'>				
						<fieldset class="mb-3">		

							<div class="row">				
								<?php
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
														        }
														        if($value['is_not_visible'] != 1 || $value['is_show_once_filled'] == 1){ 
														        	// echo $value['is_show_once_filled'];
														            $tempEditable = $Editable;
														            $Editable = '';
														            $readonly = 'readonly';
														            $pointer_events="pointer-events:none;cursor: not-allowed;";
														        } 
														        // echo "tempEditable=".$tempEditable;
														        // echo "editable=".$Editable;
														        /*NOTE:HK END*/
																if($value['id']==$group_order_value_array){

																	$is_required = '';

																	$star = '';

																	$CI =& get_instance(); 
																	$CI->load->model('Smartform_Model');
																	$field_required_check=$CI->Smartform_Model->field_required_check($sup_id,$value['form_layout_id'],'temp');
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
																	/*if ($value['id']=='1.1.11') {*/
																	$default_values = $value['default_values'];
																	
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
																		$CI =& get_instance();
																		$CI->load->model('Smartform_Model');
																		$field_visible=$CI->Smartform_Model->check_field_visible_temp($original_form_id,$sup_id,$form_layout_id);
																		/*if($original_value<>''){
																			$def_view_lclass = '';
																		}else{
																			// $def_view_class = 'd-none';
																			$def_view_class = '';
																			$is_required='';
																		}*/
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
																	}else{
																		$default_values = "";
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
																	/*echo $value['is_show_once_filled']."showonce<br>";
																	echo $default_values."defaultvalue";
*/																	if($value['is_show_once_filled']==1 && $default_values==''){
																		$def_view_class='d-none';
																	}
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
																					echo '<input type="text" name="50[]" id="50_remove" class="form-control form-control-sm text-uppercase" >
																					';
																			}
																			else{
																				echo '<input type="text" name="50[]" id="50_remove" class="form-control form-control-sm text-uppercase d-none" >
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
																			
																			if(isset($suppliers_info[$value['id']])){
																				$default_values=$suppliers_info[$value['id']];
																			}
																			if($readonly<>''){
																				$btn_disable="disabled";
																			}else{
																				$btn_disable="";
																			}
																			$consolidate_id=get_consolidate_id($default_values);
																			echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'">
																			'.$field_label.'
																			<div class="col-md-4">
																			<input type="text"  name="'.$value['id'].''.$valueArray.'" id="'.$value['id'].'"class="form-control form-control-sm '.$styl.' '.$validation_class.' " placeholder="'.$value['place_holder'].'" '.$is_required.' value="'.htmlspecialchars($default_values).'" '.$autofill.' '.$max_len.' '.$readonly.'>';
																			$suppliers_validated=check_for_validated_alei($default_values);
																			if(isset($suppliers_info['validated'])){ 
																				if($suppliers_info['validated']==''){
																				echo "<span class='text-danger'><b>*** -  ALEI not validated</b></span>";
																				}
																			}
																			
																			echo '</div><div class="col-md-2"><input type="button" name="borwse_supplier" id="borwse_supplier" class="btn btn-sm btn-warning" value="Browse" data-toggle="modal" data-target="#modal_theme_primary" onclick="searchSupplier(1)" '.$btn_disable.'>&nbsp;&nbsp;<button type="button" name="borwse_supplier_clone" id="borwse_supplier_clone" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_theme_secondary" title="Clone existing request" '.$btn_disable.'><i class="icon-copy3"></i> Clone</button></div></div>';
																		}else if($value['id']==51){
																			if(isset($suppliers_info[$value['id']])){
																				$default_values=$suppliers_info[$value['id']];
																			}

																			if($value['id']==51){
																				if($default_values==""){
																					$default_values='Default MDM SOP'; 
																				}
																				//echo "test";
																				
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
																			/* if($value['id']==51){
																				$default_values='Default MDM SOP';
																				//echo "test";
																				
																			} */	
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
																			$original_list_id=array();
																		if (strpos($value['default_values'], 'table_') !== false) {
																			if(isset($suppliers_info[$value['id']])){
																				$default_values=$suppliers_info[$value['id']];
																			}
																		    $options = explode('_', $value['default_values'],2);
																			$original_list_id = explode('_', strtolower($default_values));
																			//pre($original_list_id);
																			//pre($suppliers_info);
																		    // $country_name= '';
																		    // $state_name= '';
																		    // $city_name= '';
																		    $CI =& get_instance();
																			$CI->load->model('Userhome_Model');
																			if($options[1] == 'countries'){
																				$list_country = $CI->Userhome_Model->get_list($options[1],null,null,null,null,'country_name','ASC');
																				if(isset($original_list_id[0]) && $original_list_id[0] !='table'){
																					$country_name = $original_list_id[0];
																				}else{
																					$country_name ="";
																				}
																				/*echo $country_name;*/
																			}
																			else if($options[1] == 'states'){
																				// echo $options[1];
																				$list_state =  get_state($country_name);
																				if(isset($original_list_id[0]) && $original_list_id[0] !='table'){
																					$state_name = strtolower($original_list_id[0]);
																				}else{
																					$state_name="";
																				}
																				/*pre($list_state );*/
																				/*echo $state_name;*/
																			}
																			else if($options[1] == 'cities'){
																				$list_city = get_city($state_name);
																				if(isset($original_list_id[0]) && $original_list_id[0] !='table'){
																					$city_name = strtolower($original_list_id[0]);
																				}else{
																					$city_name="";
																				}
																				/*echo $city_name;*/
																			}
																			
																			
																			// echo $original_list_id[0];
																			if($options[1] == 'countries'){
																				echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																						'.$field_label.'
																					<div class="col-md-'.$value['field_size'].'">
																					<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
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
																				//pre($list_state);
																				//pre($state_name);
																				if($value['is_view'] == 1){

																					if(!empty($listDummy) && $state_name!=''){
																						  /*echo 'Not FOUND!';*/
																						if (array_search($state_name, $listDummy) === FALSE){
																						  $other_value = $state_name;
																						  $state_name = 'Other';
																						  $selectOther = 'selected';
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
																			if(isset($original_list_id[0]) && $original_list_id[0] !='table'){
																				$other_value=$default_values;
																			}else{
																				$other_value=$original_list_id[0];
																			}
																			/*if(array_search('Other', array_column($options, 'field_value')) !== false) {*/
																		    echo '<div class="form-group row row_hide_other" id="row_hide_other_'.$value['id'].'">
																					<div class="col-md-6">&nbsp;</div>	
																					<div class="col-md-'.$value['field_size'].'">
																					<input type="text" class="form-control  checkother form-control-sm  '.$styl.'" name="'.$value['id'].'_other" id="'.$value['id'].'_other" value="'.$other_value.'" placeholder="If other please specify" '.$readonly.'>
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
																								//$optionDisabled="disabled";
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
																				if($value['id']==72){
																					if($default_values=="Other" || $default_values==""){
																						$default_values=234;
																					}
																				}
																				echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																							'.$field_label.'
																						<div class="col-md-'.$value['field_size'].'">
																						<select name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm  '.$validation_class.' '.$Editable.' other_select '.$pop_field_class.'" '.$is_required.' style="'.$pointer_events.'" data-other-value="'.$other_value.'" '.$data_id.' data-required-check="'.$data_attr_required.'">';
																							echo '<option value="">SELECT</option>';

																							foreach ($options as $options_key => $options_value) {
																								if($options_value['id'] == $default_values  || $options_value['field_value'] == $default_values)
																									{ $selected = "selected"; }
																								else { $selected = ""; }
																							
																								echo '<option value="'.$options_value['id'].'" '.$selected.'>'.strtoupper((isset($extra_value) && $extra_value!='' && $options_value['display_value']!='Other') ? $options_value['field_value'].' - '.$options_value['display_value'] : $options_value['display_value']).'</option>';
																							}		
																							// echo '<option value="Other" '.$selectOther.'>OTHER</option>';
																					echo'</select>
																					</div>
																				</div>';
																			}
																			
																			if(array_search('Other', array_column($options, 'field_value')) !== false) {
																			    echo '<div class="form-group row row_hide_other" id="row_hide_other_'.$value['id'].'">
																						<div class="col-md-6">&nbsp;</div>	
																						<div class="col-md-'.$value['field_size'].'">
																						<input type="text" class="form-control checkother form-control-sm  '.$styl.' " name="'.$value['id'].'_other" id="'.$value['id'].'_other" placeholder="If other please specify" '.$readonly.' value="'.$other_value.'">
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
																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																					'.$field_label.'
																				<div class="col-md-'.$value['field_size'].'">';
																				if($value['id']==47){
																				if($Editable != ''){
																				
																					echo '<select name="'.$value['id'].'[]" id="'.$value['id'].'" class="form-control form-control-sm select_onchange checkdynamic_selectbox '.$validation_class.' '.$pop_field_class.' multiselect-display-values" '.$is_required.'  multiple="multiple" data-fouc '.$data_id.'>'; 
															
																						foreach ($options as $options_key => $options_value) {
																						/* 	if(in_array($options_value['display_value'],$default_values_array))
																									//if($options_value->po_bu_code == $default_values)
																										{ $selected = "selected"; }
																									else { $selected = ""; } */
																									
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
																				
																					}
																				else{																					
																					$multiselect_value = '';
																					foreach ($options as $options_key => $options_value) {
																							if(in_array($options_value['display_value'],$default_values_array))
																								{ 
																									if($multiselect_value==''){
																										$multiselect_value .= '<span class="select_onchange" main_field_id="'.$value['id'].'"  newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span>'; 
																									}else{
																										$multiselect_value .= ', <span class="select_onchange" main_field_id="'.$value['id'].'"  newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span>'; 
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
																					}
																				else{									
																					$multiselect_value = '';
																					foreach ($options as $options_key => $options_value) {
																					
																							if(in_array($options_value['display_value'],$default_values_array))
																								{ 
																									if($multiselect_value==''){
																										$multiselect_value = '<span class="select_onchange" main_field_id="'.$value['id'].'"  newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span>'; 
																									}else{
																									$multiselect_value .= ', <span class="select_onchange" main_field_id="'.$value['id'].'"  newid="'.$options_value['display_value'].'" spanvalue="'.$options_value['field_value'].'">'.strtoupper($options_value['display_value']).'</span> &nbsp;&nbsp;'; 
																									}
																								
																								}
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
																						

																					}
																					else{
																							
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

																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'">
																			'.$field_label.'
																		<div class="col-md-'.$value['field_size'].'">
																			<textarea name="'.$value['id'].'" id="'.$value['id'].'" class="form-control form-control-sm '.$validation_class.' '.$styl.' " placeholder="'.$value['place_holder'].'" '.$is_required.' col="30" row="3" '.$autofill.'  '.$comment_field.'>'.$default_values.'</textarea>
																		</div>
																	</div>';
																	}
																	// File Upload
																	else if ($value['field_type']=='8') {
																		// echo $default_values;

																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'">
																		'.$field_label.'
																			<div class="col-md-'.$value['field_size'].'">';
																				if($value['id']==1459){
																					if($Editable !=''){
																						echo '<input type="file" accept="'.FILE_EXTENSION_UPLOAD_INPUT.'"   class="form-control h-auto '.$validation_class.' " name="'.$value['id'].'" id="'.$value['id'].'" mutliple onchange="ValidateMultipleInput('.$value['id'].');">';
																					}
																					$CI =& get_instance();
																					$CI->load->model('Smartform_Model');
																					$supplier_upload_file=$CI->Smartform_Model->check_supplier_upload_file_temp($sup_id,$value['id']);
																					if(count($supplier_upload_file)>0){
																					if ($value['id'] == 194 || $value['id'] == 195 || $value['id'] == 198 || $value['id'] == 199 || $value['id'] == 213 || $value['id'] == 233 || $value['id'] == 246 || $value['id'] == 255 || $value['id'] == 257 || $value['id'] == 262 || $value['id'] == 265 || $value['id'] == 267 || $value['id'] == 273 || $value['id'] == 279 || $value['id'] == 282 || $value['id'] == 284 || $value['id'] == 286 || $value['id'] == 289 || $value['id'] == 291 || $value['id'] == 295 || $value['id'] == 298) {
																							$upload_path = SUPPLIER_UPLOAD_PATH;
																						}
																						else{
																							$upload_path = UPLOAD_PATH;
																						}
																						echo '<div id="preview_1459" class="preview_1459 mt-2 font-weight-bold alert alert-info">';
																						foreach($supplier_upload_file as $fileKey => $fileValue){
																							$delFilename="'".$fileValue['file_name']."'";
																							if($Editable !=''){
																							echo '<span id="file_'.$fileValue['id'].'"><a href="'.$upload_path.'payterm_file/'.$fileValue['file_name'].'" download target="_blank"><b>'.$fileValue['display_name'].'</b></a>&nbsp;&nbsp;&nbsp;<i class="icon-trash mr-2 text-danger" style="cursor:pointer;" onclick="removeUploadedFileTemp('.$fileValue['id'].','.$delFilename.','.$value['id'].')"></i></span></br>';
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
																						echo '<input type="file" accept=".doc,.docx,.pdf.xlsx,.xls,.ppt, .pptx"  class="form-control h-auto '.$validation_class.' " name="'.$value['id'].'" id="'.$value['id'].'" onchange="ValidateSingleInput(this);">';
																					}
																					if($default_values == ''){
																						echo '<br><span class="badge badge-secondary" style="/*font-size:14px;*/">NO FILES FOUND</span>';
																					}
																					else{
																						if ($value['id'] == 194 || $value['id'] == 195 || $value['id'] == 198 || $value['id'] == 199 || $value['id'] == 213 || $value['id'] == 233 || $value['id'] == 246 || $value['id'] == 255 || $value['id'] == 257 || $value['id'] == 262 || $value['id'] == 265 || $value['id'] == 267 || $value['id'] == 273 || $value['id'] == 279 || $value['id'] == 282 || $value['id'] == 284 || $value['id'] == 286 || $value['id'] == 289 || $value['id'] == 291 || $value['id'] == 295 || $value['id'] == 298) {
																							$upload_path = SUPPLIER_UPLOAD_PATH;
																						}
																						else{
																							$upload_path = UPLOAD_PATH;
																						}
																						echo '<br><a href="'.$upload_path.'payterm_file/'.$default_values.'"  download target="_blank"><span class="badge badge-secondary" style="font-size:14px;">Click here to view the loaded file</span></a>';
																					}
																				}
																				
																		echo '</div>
																		</div>';
																	}
																	// Date field
																	else if ($value['field_type']=='9') {
																		if($default_values!="all" && $default_values!="past" && $default_values !="future"){
																			$visible_default_value_date=$default_values;
																		}else{
																			$visible_default_value_date='';
																		}
																		echo '<div class="'.$def_view_class.' form-group row '.$value['id'].'" id="'.$form_layout_id.'" data-field-id="'.$value['id'].'">
																		'.$field_label.'
																			<div class="col-md-'.$value['field_size'].'">';
																				$date_style='';
																				if($readonly<>''){
																					$date_style='style="pointer-events:none;cursor: not-allowed;"';
																				}
																				echo'<input type="text" class="form-control h-auto '.$validation_class.'" name="'.$value['id'].'" id="'.$value['id'].'" value="'.$visible_default_value_date.'" '.$date_style.' '.$is_required.' >
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
							<input type="hidden" value="Pending" id="status" name="status">
							<input type="hidden" value="<?php echo $this_form_id;?>" id="form_id" name="form_id">
							<input type="hidden" value="<?php echo $corning_alei;?>" id="alei" name="alei">
							<input type="hidden" value="<?php echo $consolidate_id;?>" id="consolidate_id" name="consolidate_id">
							<input type="hidden" value="<?php echo $master_id;?>" id="master_id" name="master_id">
							<input type="hidden" value="<?php echo $sup_id;?>" id="sup_id" name="sup_id">
							<input type="hidden" value="<?php echo $userid;?>" id="userid" name="userid">

							<input type="hidden" name="clone_request_id_supplier_info" id="clone_request_id_supplier_info" value="<?php echo $verified; ?>" > 
							<input type="hidden" name="clone_request_id_supplier_info" id="clone_request_id_supplier_info_val" value="<?php echo $clone_request_id_supplier_info_val; ?>" > 
							<input type="hidden" name="verified_sts" id="f" value="<?php echo $verified; ?>" > 
							<input type="hidden" name="associated_requests_ids" id="associated_requests_ids" value="<?php echo $associated_request_ids; ?>" > 
							<input type="hidden" name="submit_check" id="submit_check" value="<?php echo $submit_check; ?>" > 
							<input type="hidden" name="clone_another_count" id="clone_another_count" value="1" > 
							<input type="hidden" name="cloned_and_removed_val" id="cloned_and_removed_val" value=" <?php echo $clone_removed; ?>"> 
							<input type="hidden" name="selected_supplier_email" id="selected_supplier_email" value="<?php echo $info_copied_email_id; ?>" > 
							<input type="hidden" name="clone_request_id" id="clone_request_id" value="<?php echo $display_cloned_request; ?>" > 
							<input type="hidden" name="selected_supplier_email" id="selected_supplier_email" value="<?php echo $info_copied_email_id; ?>" > 
							<input type="text" name="selected_supplier_legal_name" id="selected_supplier_legal_name" value="<?php echo $get_request_legal_name; ?>" > 
							<input type="hidden" value="<?php if($this_form_id<>5){ echo "0";}else{echo "0";}?>" id="checkdynamic_selectbox_value" name="checkdynamic_selectbox_value">

							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" > 
							<?php
								$temp_status=$get_supplier_master_details->status;
								if($temp_status=="Closed"){
								?>
								<span class="badge badge-secondary"><b class="font-size-lg">Request Closed</b></span>
							<?php }else{ 

									if($clone_request_id_supplier_info_val != "" && $submit_check=='no'){ ?>
										<button type="button" class="btn btn-danger " name="remove_sup_info_cloned" id="remove_sup_info_cloned" onclick='remove_sup_cloned_info()'>Remove cloned Supplier Info <i class="icon-user-cancel ml-2"></i></button> &nbsp; &nbsp;
										<!-- <button type="button" class="btn btn-primary" name="clone_another_sup_info" id="clone_another_sup_info">Cloned Supplier Info <i class="icon-user-plus ml-2"></i></button>&nbsp; &nbsp; -->

								<?php }else if($clone_request_id_supplier_info_val == "" && $submit_check=='no'){ ?>
										<button type="button" class="btn btn-primary " name="clone_another_sup_info" id="clone_another_sup_info" onclick="resend_clone_request()">Clone Supplier Info <i class="icon-user-plus ml-2"></i></button>&nbsp;&nbsp;

								<?php } ?>								
								
								<button type="submit" class="btn btn-success" name="submit" id="submit"><?php echo $button_title;?> <i class="icon-paperplane ml-2"></i></button> 
							<?php } ?>								
						</div>
					</form>
				</div>
			</div>			
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
<!--- Modal box -->
<div id="modal_theme_secondary" class="modal fade" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title">Search Request</h6>
				<button type="button" id="reset_clone_modal" class="close" data-dismiss="modal" onclick="reset_clone_modal();">&times;</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-md-5" id="col_adjust">
					<span style="color:red;font-size:11px;font-weight:bold;">Note: Fields that are dependent or have dependent fields will not populate the values from the original request.</span>
					</div>					
					<?php
						$form_options="";
						$get_form_list_array = get_form_list();
						foreach ($get_form_list_array as $list_key => $list_value_array) {
							$form_id=$list_value_array['id'];
							$form_name=$list_value_array['form_name'];
							$form_options.='<option value="'.$form_id.'">'.$form_name.'</option>';	
						}
					?>
					<div class="col-md-3" id="col_adjust">					
						<form action="" class="formName">
							<div class="form-group">
								<select name="form_name" id="form_name_clone" class="form-control"><option value="">Select Form</option><?php echo $form_options;?></select>
							</div>
						</form>
					</div>
					<div class="col-md-4" id="col_adjust">
						<input type="text" class="form-control-sm" name="search_supplier_clone" id="search_supplier_clone" style="margin-bottom:10px;display: block;width: 100%;height: calc(1.5385em + 0.875rem + 2px);padding: 0.4375rem 0.875rem;font-size: .8125rem;font-weight: 400;line-height: 1.5385;color: #333;background-color: #fff;background-clip: padding-box;border: 1px solid #ddd;border-radius: 0.1875rem;box-shadow: 0 0 0 0 transparent;transition: border-color .15s" placeholder="Search Supplier Name/Request ID#"> 
					</div>
				</div>
				<div class="table-responsive" id="supplier_result">
					<table class="table table-bordered" style="font-size:12px">
						<thead>
							<tr>
								<th class="th_bg_clone"></th>
								<th class="th_bg_clone">Request ID</th>
								<th class="th_bg_clone">Form Type</th>
								<th class="th_bg_clone">Supplier Name</th>
								<th class="th_bg_clone">Legal Address</th>
								<th class="th_bg_clone">ERP ID#</th>
								<th class="th_bg_clone">Supplier Contact Info.</th>
								<th class="th_bg_clone">Status</th>
							</tr>
						</thead>
						<tbody id="appendDatas_supplier_clone">
							<tr>
								<td colspan="7"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer"> 
				<div style="float:left;"><span class="text-muted">Total No of records available: <b class="text-danger" id="totalCount_supplier_clone">0</b></span></div>
				<span id="pagination_supplier">
					<nav aria-label="Page navigation example" id="pagination_supplier_clone">
					</nav>
				</span>
			</div>
		</div>
	</div>
</div>
<!--- Modal box -->
<div id="modal_theme_danger" class="modal fade" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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

<script type="text/javascript">
	$(function() {
		$('.row_hide_other').addClass('d-none'); 
		$('.other_select').change(function(){
			var id = $(this).attr('id');
			var selectedTextVal = $('#'+id+' option:selected').text();
				selectedTextVal = selectedTextVal.toUpperCase();
					if($('#'+id).val() == 'Other' || selectedTextVal=='OTHER') {
		        $('#row_hide_other_'+id).removeClass('d-none'); 
		        $('#row_hide_other_'+id).prop('required',true);
		        $('#'+id+"_other").prop('required',true);
		    } 
		    else {
		        $('#row_hide_other_'+id).addClass('d-none'); 
		        $('#'+id+'_other').val('');
		        $('#row_hide_other_'+id).prop('required',false);
		        $('#'+id+"_other").prop('required',false);
		    } 
		});

		$('#quick_update select').each(
		    function(index){  
		        var input = $(this);		       
		        var id = input.attr('id');
		        var other_value = input.attr('data-other-value');
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
		function keyPressed(){
		var key = event.keyCode || event.charCode || event.which ;
		return key;
		}
	$(document).ready(function(){

		$('#row_hide_other_91').addClass('d-none').removeClass('display_flex');
		$('#91_other').prop('required',false);
		$('.other_select').each(function(){
		var id = $(this).attr('id');
		
		var selectedTextVal = $('#'+id+' option:selected').text();
			selectedTextVal = selectedTextVal.toUpperCase();
			console.log(id+' - '+selectedTextVal);
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

		$('.js-example-basic-single').select2();
		$('input[type="submit"]').on('click', function(){
			$('#quick_update').data('button', this.name);
		});

		$(".multiselect-display-values").on("change", function (e) {  
			var selid=$(this).attr('id');
			$('#values-area-'+selid).addClass('alert alert-info').text($('#'+selid).val().join(', '));
			if($('#'+selid).val()!=''){
				$('#'+selid).addClass('valid').removeClass('error'); 
			 	$(this).valid(); 
			}
			else{
				$('#values-area-'+selid).removeClass('alert alert-info');			
			}
			if($(this).val()==""){
				$(this).multiselect('refresh');
			}
		});

		$('#58').removeAttr("required");

		var classHide = [ 48,51,52,53,57 ];
		jQuery.each( classHide, function( i, val ) {
			$('#'+val).removeAttr("required");
			$('.'+val).addClass('d-none'); 
		});
		
		var selections = [];
		var main_field_id_selections = [];
		$('.select_onchange').each(function () {
			var id = $(this).attr('id');
			var main_field_id = $(this).attr('main_field_id');

			if( typeof id === 'undefined' || id === null ){
			    var id = $(this).attr('newid');
			}
			if( typeof main_field_id === 'undefined' || main_field_id === null ){
			    var main_field_id = $(this).attr('main_field_id');
			}

			if(id == 47 || main_field_id == 47){

				var spanvalue = $(this).attr('spanvalue');
				if(spanvalue !='' && spanvalue !=undefined){
					selections.push(spanvalue);
				}
				else{
					$('#'+id+' :selected').each(function(i, sel){ 
						var selectedVal = $(sel).val();
						selections.push(selectedVal);
					});
				}
				
				var classValue1 = [ 48,51 ];
				jQuery.each( classValue1, function( i, val ) {
					if(jQuery.inArray("PeopleSoft v9.x", selections) != -1) {
						$('.'+val).removeClass('d-none'); 
						$('.'+val).prop('required',true);
						$('#'+val).attr('required',true);
					} 
					else {
					    $('.'+val).addClass('d-none'); 
					    $("[name='"+val+"[]']").prop('checked',false);	
						$('.'+val).prop('required',false);
						$('#'+val).removeAttr("required");
					}
				});

				var classValue2 = [ 52,53 ];
				jQuery.each( classValue2, function( i, val ) {
					if(jQuery.inArray("OC SAP ECC", selections) != -1 || jQuery.inArray("S4-HANA public", selections) != -1 || jQuery.inArray("S4 HANA private", selections) != -1) {
						$('.'+val).removeClass('d-none'); 
						$('.'+val).prop('required',true);
					} 
					else {
					    $('.'+val).addClass('d-none'); 
					    $("[name='"+val+"[]']").prop('checked',false);
						$('.'+val).prop('required',false);
						$('#'+val).val('');
					} 
				});
			}
		});

		$('.other_select').each(function () {
			var id = $(this).attr('id');
			var selections = [];
			$('#'+id+' :selected').each(function(i, sel){ 
				var selectedVal = $(sel).val();
				selections.push(selectedVal);
			});

			if(id == 54){
				var classValue3 = [ 57 ];
				jQuery.each( classValue3, function( i, val ) {

					if(jQuery.inArray("97", selections) != -1) {

						$('.'+val).removeClass('d-none'); 
						$('.'+val).prop('required',true);
						var oldvalue = $('#'+val+'_oldfile').val();
						if(oldvalue==''){
							$('#'+val).attr('required','required');
						}
						else{
							$('#'+val).removeAttr("required");
						}
					} else {
					    $('.'+val).addClass('d-none'); 
						$('.'+val).prop('required',false);
						$('#'+val).removeAttr("required");
						$('#'+val).val('');
					}
				});	
			}		
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
				url:"<?php echo base_url();?>smartform/update_temp_forms", 
				method:"POST", 
				data:{user_id:user_id, sup_id:sup_id, field_id:50, field_value:finalVal ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'}, 
				dataType:"text", 
				success:function(data) 
				{ 
					
				} 
			});
		}

		$(".50_user_input").on("keyup", function(e) {
			var sup_id = $("#sup_id").val();
			var user_id = $("#userid").val();
			var finalVal = '';
			$(".dynamic_text_box").each(function() {
				var prefix = $(this).attr('data-id');
				var val = $(this).val();

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
			// alert(finalVal);
			$.ajax({ 
				url:"<?php echo base_url();?>smartform/update_temp_forms", 
				method:"POST", 
				data:{user_id:user_id, sup_id:sup_id, field_id:50, field_value:finalVal ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'}, 
				dataType:"text", 
				success:function(data) 
				{ 
					
				} 
			}); 
		})

		var request;	
		$("#search_supplier").keyup(function() {
			request && request.abort(); 
				
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
					$('#appendDatas_supplier').html(tr);
					$('#pagination_supplier').html(responseData['pagination']);
					$('#totalCount_supplier').html(responseData['total_rows']);
				}
			});
		});
		$('#pagination_supplier').on('click','a',function(e){
			if(!$(this).hasClass("current")){
				e.preventDefault(); 
				var pageNo = $(this).attr('data-ci-pagination-page');			
				searchSupplier(pageNo);
			}
		});


		$("#15").on("blur", function(event) {

	    });
	});


	$('.select_onchange').change(function(){
		var id = $(this).attr('id');
		var selections = [];
		$('#'+id+' :selected').each(function(i, sel){ 
			var selectedVal = $(sel).val();
			selections.push(selectedVal);
		});
		if(id == 47){
			var classValue1 = [ 48,51 ];
			jQuery.each( classValue1, function( i, val ) {
				if(jQuery.inArray("PeopleSoft v9.x", selections) != -1) {
					$('.'+val).removeClass('d-none'); 
					$('.'+val).prop('required',true);
					$('#'+val).attr('required',true);
				} 
				else {
					$('.'+val).addClass('d-none'); 
					$("[name='"+val+"[]']").prop('checked',false);
					$('.'+val).prop('required',false);
					$('#'+val).removeAttr("required");
					$('#'+val).val('');
				}
			});
			var classValue2 = [ 52,53 ];
			jQuery.each( classValue2, function( i, val ) {
				var select_val = $('#'+val);
				if(jQuery.inArray("OC SAP ECC", selections) != -1 || jQuery.inArray("S4-HANA public", selections) != -1 || jQuery.inArray("S4 HANA private", selections) != -1) {
					$('.'+val).removeClass('d-none'); 
					$('.'+val).prop('required',true);
					select_val.attr('required', true);
				} 
				else {
				    $('.'+val).addClass('d-none'); 
				    $("[name='"+val+"[]']").prop('checked',false);
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
		var selections = [];
		$('#'+id+' :selected').each(function(i, sel){ 
			var selectedVal = $(sel).val();
			selections.push(selectedVal);
		});
		console.log("krishna_"+id);
			console.log(selections);
		if(id == 54){
			var classValue3 = [ 57 ];
			jQuery.each( classValue3, function( i, val ) {
				if(jQuery.inArray("97", selections) != -1) {			    
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
				} 
				else {
				    $('.'+val).addClass('d-none'); 
					$('.'+val).prop('required',false);
					$('#'+val).val('');
					$('#'+val).removeAttr("required");
				}
			});	
		}
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


	function close_window() {
	    window.close();
	}

	

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
	            data: { stateName : selectedState,type : 'city',['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>' },
	            dataType  : "json", 
	            beforeSend: function () {
	                    ajaxindicatorstart();
                },
                success   : function(data) {
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
                    state_name_ajax += '<select name="105" id="105" class="form-control form-control-sm">';
                    state_name_ajax += '<option value="">SELECT</option>';
                    data.forEach(function(value, index) {
                        var stateName = value.state_name.toUpperCase();
                        state_name_ajax += '<option value="'+value.state_name+'">'+stateName+'</option>';
                    });
                    state_name_ajax += '<option value="Other">OTHER</option>';
                    $('#105').html(state_name_ajax);  
                    $('#104').html('<option value="">SELECT</option>');	                           
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
	            data: { countryName : selectedCountry,type : 'state' ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
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
	$("select#34").change(function(){
		var selected_option = $("#34 option:selected").val();
		var supplier_email = $("#15").val().toLowerCase();
		// var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		var testEmail = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/i;
		if(selected_option!=''){
			var email_split=supplier_email.split('@');
			if(supplier_email.trim()!=''){
				if (testEmail.test(supplier_email)){
					if(selected_option==632){
						if(email_split[1].toUpperCase()=='CORNING.COM'){
							$.alert({
								title: 'Alert!',
								content: "Please enter Supplier Contact Email Other then corning email address",
							});
							//$( "#15" ).focus();
						}
					}else{
						if(email_split[1].toUpperCase()!='CORNING.COM'){
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
	$("#15").blur(function() {
		
		var selected_option = $("#34 option:selected").val();
		var supplier_email = $("#15").val().toLowerCase();
		// var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		var testEmail = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/i;
		if(selected_option!=''){
			var email_split=supplier_email.split('@');
			if(supplier_email.trim()!=''){
				if (testEmail.test(supplier_email)){
					if(selected_option==632){
						if(email_split[1].toUpperCase()=='CORNING.COM'){
							$.alert({
								title: 'Alert!',
								content: "Please enter Supplier Contact Email Other then corning email address",
							});
						}
					}else{
						if(email_split[1].toUpperCase()!='CORNING.COM'){
							$.alert({
								title: 'Alert!',
								content: "Please enter Corning email address in Supplier Contact Email",
							});
						}
					}
					
				}else{
					 $.alert({
						title: 'Alert!',
						content: "Please enter Valid Supplier Contact Email",
					}); 
				}
			}
			checkForExitsingSupplier();
		}
	});
</script>

<script type="text/javascript">
	$(document).ready(function(e) {

		$("select").on("select2:close", function (e) {  
	        $(this).valid(); 
	    });

	    $('.multiselect-display-values').each(function () {
	        var selid=$(this).attr('id');
	        $('#values-area-'+selid).addClass('alert alert-info').text($('#'+selid).val().join(', '));	  
	        if($('#'+selid).val()!=''){
				$(this).valid(); 
			}
			else{
				$('#values-area-'+selid).removeClass('alert alert-info');
				$('#'+selid).addClass('error').removeClass('valid'); 
			}      
	    });

		$("#smart_form").on('submit', function(event) {
			
			if ($(this).valid())
			{
				var formMailSubmit = 1;
				var is_live = <?php echo IS_LIVE;?> ;
				var is_corning = '<?php echo IS_CORNING;?>' ;
				var BOUNCE_CHECK = '<?php echo BOUNCE_CHECK;?>' ;
				var supplier_mail =  $('#15').val().toLowerCase();
				var supplier_legal_name = document.getElementById('42').value;
				var clone_request_id_supplier_info =  $('#clone_request_id_supplier_info').val();
				var clone_another_count =  $('#clone_another_count').val();
				var cloned_and_removed_val =  $('#cloned_and_removed_val').val();
				var clone_request_id_supplier_info_val =  $('#clone_request_id_supplier_info_val').val();
				var verified_sts =  $('#verified_sts').val();
				var associated_requests_ids =  $('#associated_requests_ids').val();
				var submit_check =  $('#submit_check').val();
				var selected_supplier_email =  $('#selected_supplier_email').val().toLowerCase();
				if(is_live == 1){
					
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
					var supplier_email = $("#15").val().toLowerCase();
					var email_split=supplier_email.split('@');
					if(selected_option==632){
						if(email_split[1].toUpperCase()=='CORNING.COM'){
							$.alert({
								title: 'Alert!',
								content: "Please enter Supplier Contact Email Other then corning email address",
							});
							return false;
							//$( "#15" ).focus();
						}
					}else{
						if(email_split[1].toUpperCase()!='CORNING.COM'){
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
									var n_split = mail_value.split("@");
									var corning_check = '';
									if (typeof n_split[1] != "undefined") {
										var corning_check = n_split[1];
									}else{
										/*lastEleven = '';*/
									}

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
				if(submit_check=='no'){
				/* alert('1');
				return false; */
					if(formMailSubmit == 1){
						var checkdynamic_selectbox_value=$('#checkdynamic_selectbox_value').val();

						var tempMultipleIdArray = [ 52,53,48];
						var check_hidden_multiselect_value=0;
						jQuery.each( tempMultipleIdArray, function( i, val ) {
							
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
							console.log("multi_"+multiCheck);
							console.log("req_"+multiReq);
							console.log("val_"+multiVal);
						});

						checkdynamic_selectbox_value=0;
						check_hidden_multiselect_value=0;
						if(checkdynamic_selectbox_value==0 && check_hidden_multiselect_value==0){
							var formSubmit=0;
							var form_id =  $('#form_id').val();
							var emailID = 58;
							var element =  document.getElementById(emailID);
							if (typeof(element) != 'undefined' && element != null)
							{
								var multiple_email=$('#'+emailID).val();
								if(multiple_email != ''){
									var reg = /^([A-Za-z0-9_&\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
									var emails = multiple_email.split(",");
									for(var i = 0; i < emails.length; i++)
									{
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
									content: 'Please enter values to the Field “Indicate the supplier ID to be updated (if multiple values are provided, separate them by a comma) or Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request',
								});
								return false;
							}
							if(formSubmit==3){
								$( "#50_"+focusIDVal ).focus();
								$.alert({
									title: 'Alert!',
									content: 'Charcters should be between 2 to 255 to the Field "Indicate the supplier ID to be updated (if multiple values are provided, separate them by a comma) or Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request"',
								});
								return false;
							}
							if(formSubmit==0){
								var form_id =  $('#form_id').val();
								
								if(form_id == 5){
									var alert_title = 'Send Request for Ariba Upload';
									var alert_content = 'Are you sure want to send the request for upload to Ariba?';
								}
								else{
									var alert_title = 'Send Request';
									var alert_content = 'Are you sure want to send request?';
								}
								
								$.confirm({
									title: alert_title,
									theme: 'light',
									content: alert_content,
									buttons : {
										yes : {
											text: 'Confirm',
											btnClass: 'btn-blue',
											action: function(){
												$("#status").val('Pending');
												var form=$("#smart_form");
												var formdata = new FormData(form[0]);
												ajaxindicatorstart('Loading please wait.');
												$.ajax({
													url: '<?php echo base_url();?>smartform/quick_add_ajax',
													type: "POST",
													data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
													cache       : false,
													contentType : false,
													processData : false,
													dataType: 'json',
													success: function(data)
													{
														console.log(data);
														if(data.error){
															
														}
														else{
															window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
														}
														ajaxindicatorstop();
													}
												});	
												
											}
											},no : {
											text: 'Cancel',
											btnClass: 'btn-red',
											action : function(){ 	
												if(clone_request_id_supplier_info_val == '' && submit_check=='no' && cloned_and_removed_val =='yes'){
													$("#submit_check").val('no'); 												
												}else if(clone_request_id_supplier_info_val == '' && submit_check=='yes'){
													$("#submit_check").val('yes'); 
													if(cloned_and_removed_val =='yes'){	
														$("#submit_check").val('no');
													}										
												}else if(clone_request_id_supplier_info_val == '' && submit_check=='no' && cloned_and_removed_val ==' '  ){	$("#submit_check").val('yes'); 
													if(clone_request_id_supplier_info_val == '' && submit_check=='no' && clone_another_count == ""){
														$("#submit_check").val('no'); 
													}													
													if((clone_another_count == 1 || clone_another_count == 2) && cloned_and_removed_val ==''){
														$("#submit_check").val('yes');	
													}
													if(cloned_and_removed_val =='yes' && submit_check=='yes'){
														$("#submit_check").val('no');													
													}										
													
												}else{
													$("#submit_check").val('no');
												}
												
											}
										}
									}
								});
							}
							else{
								$('#'+emailID).focus();
								$.alert({
									title: 'Alert!',
									content: 'Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request"',
								});
							}
							
						}else{
							$.alert({
							title: 'Alert!',
							content: 'Please fill Mandatory fields',
							});
							return false;
						}
					}
				}else if(submit_check=='yes' && associated_requests_ids!=''){
					/* alert('2');
					return false; */
					var check_sup;
					if(selected_supplier_email!=''){
						if(selected_supplier_email == supplier_mail){
							check_sup= "Yes";
						}else{
							check_sup= "No";
						}
					}else{
						check_sup= "Yes";
					}
					if(check_sup=="No"){
						$("#submit_check").val('no'); 
						$("#smart_form").submit();
					}else{
						
						$.ajax({
								type: 'POST',
								url: '<?php echo base_url();?>smartform/check_existing_requests/',
								data: {
									associated_requests_ids: associated_requests_ids,supplier_legal_name:supplier_legal_name,
									['<?php echo $this->security->get_csrf_token_name();?>']: '<?php echo $this->security->get_csrf_hash();?>'
								},
								beforeSend: function () {
									ajaxindicatorstart();
											
								},
								success: function (responseData) {
									ajaxindicatorstop();
									//console.log(responseData);
									if(responseData==0 || responseData==''){
										
									}else{
										$.confirm({
											title: 'Alert',
											theme: 'light',
											content: 'Would you like to display and copy the information filled by the supplier email address '+supplier_email+' within a year? Please note that if you change the supplier email address to some other after copying the information, all the supplier information will be removed from the request.',
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
														if(clone_another_count != 2){
															$("#smart_form").submit();	
														}
													}
												}
											}
										});
									}
									
								}
						});
					}
					
				}else{
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
							}else if(data.status=='Spamtrap'){
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
								if(formMailSubmit == 1){
									var checkdynamic_selectbox_value=$('#checkdynamic_selectbox_value').val();

									var tempMultipleIdArray = [ 52,53,48];
									var check_hidden_multiselect_value=0;
									jQuery.each( tempMultipleIdArray, function( i, val ) {
										
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
										console.log("multi_"+multiCheck);
										console.log("req_"+multiReq);
										console.log("val_"+multiVal);
									});

									checkdynamic_selectbox_value=0;
									check_hidden_multiselect_value=0;
									if(checkdynamic_selectbox_value==0 && check_hidden_multiselect_value==0){
										var formSubmit=0;
										var form_id =  $('#form_id').val();
										var emailID = 58;
										var element =  document.getElementById(emailID);
										if (typeof(element) != 'undefined' && element != null)
										{
											var multiple_email=$('#'+emailID).val();
											if(multiple_email != ''){
												var reg = /^([A-Za-z0-9_&\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
												var emails = multiple_email.split(",");
												for(var i = 0; i < emails.length; i++)
												{
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
												content: 'Please enter values to the Field “Indicate the supplier ID to be updated (if multiple values are provided, separate them by a comma) or Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request',
											});
											return false;
										}
										if(formSubmit==3){
											$( "#50_"+focusIDVal ).focus();
											$.alert({
												title: 'Alert!',
												content: 'Charcters should be between 2 to 255 to the Field "Indicate the supplier ID to be updated (if multiple values are provided, separate them by a comma) or Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request"',
											});
											return false;
										}
										if(formSubmit==0){
											var form_id =  $('#form_id').val();
											
											if(form_id == 5){
												var alert_title = 'Send Request for Ariba Upload';
												var alert_content = 'Are you sure want to send the request for upload to Ariba?';
											}
											else{
												var alert_title = 'Send Request';
												var alert_content = 'Are you sure want to send request?';
											}
											
											$.confirm({
												title: alert_title,
												theme: 'light',
												content: alert_content,
												buttons : {
													yes : {
														text: 'Confirm',
														btnClass: 'btn-blue',
														action: function(){
															$("#status").val('Pending');
															var form=$("#smart_form");
															var formdata = new FormData(form[0]);
															ajaxindicatorstart('Loading please wait.');
															$.ajax({
																url: '<?php echo base_url();?>smartform/quick_add_ajax',
																type: "POST",
																data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
																cache       : false,
																contentType : false,
																processData : false,
																dataType: 'json',
																success: function(data)
																{
																	console.log(data);
																	if(data.error){
																		
																	}
																	else{
																		window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
																	}
																	ajaxindicatorstop();
																}
															});	
															
														}
														},no : {
														text: 'Cancel',
														btnClass: 'btn-red',
														action : function(){  
															if(clone_request_id_supplier_info_val == ''){
																$("#submit_check").val('yes'); 
															}
															
														}
													}
												}
											});
										}
										else{
											$('#'+emailID).focus();
											$.alert({
												title: 'Alert!',
												content: 'Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request"',
											});
										}
										
									}else{
										$.alert({
										title: 'Alert!',
										content: 'Please fill Mandatory fields',
										});
										return false;
									}
								}

							}
						}
							
					});
				}else{
					if(formMailSubmit == 1){
						var checkdynamic_selectbox_value=$('#checkdynamic_selectbox_value').val();

						var tempMultipleIdArray = [ 52,53,48];
						var check_hidden_multiselect_value=0;
						jQuery.each( tempMultipleIdArray, function( i, val ) {
							
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
							console.log("multi_"+multiCheck);
							console.log("req_"+multiReq);
							console.log("val_"+multiVal);
						});

						checkdynamic_selectbox_value=0;
						check_hidden_multiselect_value=0;
						if(checkdynamic_selectbox_value==0 && check_hidden_multiselect_value==0){
							var formSubmit=0;
							var form_id =  $('#form_id').val();
							var emailID = 58;
							var element =  document.getElementById(emailID);
							if (typeof(element) != 'undefined' && element != null)
							{
								var multiple_email=$('#'+emailID).val();
								if(multiple_email != ''){
									var reg = /^([A-Za-z0-9_&\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
									var emails = multiple_email.split(",");
									for(var i = 0; i < emails.length; i++)
									{
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
									content: 'Please enter values to the Field “Indicate the supplier ID to be updated (if multiple values are provided, separate them by a comma) or Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request',
								});
								return false;
							}
							if(formSubmit==3){
								$( "#50_"+focusIDVal ).focus();
								$.alert({
									title: 'Alert!',
									content: 'Charcters should be between 2 to 255 to the Field "Indicate the supplier ID to be updated (if multiple values are provided, separate them by a comma) or Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request"',
								});
								return false;
							}
							if(formSubmit==0){
								var form_id =  $('#form_id').val();
								
								if(form_id == 5){
									var alert_title = 'Send Request for Ariba Upload';
									var alert_content = 'Are you sure want to send the request for upload to Ariba?';
								}
								else{
									var alert_title = 'Send Request';
									var alert_content = 'Are you sure want to send request?';
								}
								
								$.confirm({
									title: alert_title,
									theme: 'light',
									content: alert_content,
									buttons : {
										yes : {
											text: 'Confirm',
											btnClass: 'btn-blue',
											action: function(){
												$("#status").val('Pending');
												var form=$("#smart_form");
												var formdata = new FormData(form[0]);
												ajaxindicatorstart('Loading please wait.');
												$.ajax({
													url: '<?php echo base_url();?>smartform/quick_add_ajax',
													type: "POST",
													data:formdata ? formdata : form.serialize()+'&<?php echo $this->security->get_csrf_token_name();?>='+'<?php echo $this->security->get_csrf_hash();?>',
													cache       : false,
													contentType : false,
													processData : false,
													dataType: 'json',
													success: function(data)
													{
														console.log(data);
														if(data.error){
															
														}
														else{
															window.location.href = '<?php echo base_url(); ?>userhome/quick_add_list';
														}
														ajaxindicatorstop();
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
							else{
								$('#'+emailID).focus();
								$.alert({
									title: 'Alert!',
									content: 'Please enter valid Additional email address in "Additional Corning email address(es) for people who need to be copied on the status of the request"',
								});
							}
							
						}else{
							$.alert({
							title: 'Alert!',
							content: 'Please fill Mandatory fields',
							});
							return false;
						}
					}
				}
				}
			} 
			event.preventDefault(); // stop form from redirecting to java servlet page
		});

	});
	
	function searchSupplier(pageNo){
		pageNo = pageNo ? pageNo : 1;
		var from_value =  $("[name='get_supplier_values']:checked").val();
		var search_keyword = $.trim($('#search_supplier').val());
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
					}
					else{
						tr+='<tr><td class="text-danger" colspan="7" align="center"><b>No result found</b></td></tr>';
					}
					$('#appendDatas_supplier').html(tr);
					$('#pagination_supplier').html(responseData['pagination']);
					$('#totalCount_supplier').html(responseData['total_rows']);
				}
			});
			
		}
		else{			
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
		var master_id=$("#master_id").val();
		//alert(sup_name);return false;
		var type='browse';
		$.ajax({
			type: "POST",
			url: '<?php echo base_url();?>smartform/get_supplier_pre_populated_values',
			data: { form_id : form_name,supplier_name : sup_name,supplier_alei:sup_alei,supplier_city:sup_city,supplier_state:sup_state,supplier_country:sup_country,supplier_address :sup_address,supplier_pincode:sup_pincode,type:type,region:region,op_unit:op_unit,alei_id:alei_id,master_id:master_id,temp_data : 'temp_data',sup_id : sup_id ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},
			success   : function(data) {
				if(data.error){
					
				}
				else{
					window.location.href = '<?php echo base_url(); ?>smartform/form_edit_as/'+sup_id;
				}
			}
		});
	}

	function select_supplier_autocomplete(supname){
		//var form_name=$('#form_name').val();
		var form_name='<?php echo $this_form_id;?>';
		var sup_id='<?php echo $sup_id;?>';
		var type='autocomplete';
		var region=$("#18").val();
		var op_unit=$("#19").val();
		var master_id=$("#master_id").val();
		
		ajaxindicatorstart();
		$.ajax({
			type: "POST",
			url: '<?php echo base_url();?>smartform/get_supplier_pre_populated_values',
			data: { form_id : form_name,supplier_name : supname,type:type,region:region,op_unit:op_unit,master_id:master_id,temp_data : 'temp_data',sup_id : sup_id,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>' },
			success   : function(data) {
				ajaxindicatorstop();
				if(data.error){
					
				}
				else{
					window.location.href = '<?php echo base_url(); ?>smartform/form_edit_as/'+sup_id;
				}
			}
		});
	}


	function rest_modal(){		
		$('#search_supplier').val('');
		$('#appendDatas_supplier').html('');
        $('#pagination_supplier').html('');
		$('#totalCount_supplier').html('');
	}

	$(".fa-lightbulb-o").click(function(){
	    $('.fa-lightbulb-o.text-danger').not(this).removeClass('text-danger');
	    $(this).toggleClass('text-danger');
 	})	
	
	$(function() {
		$('.on_select_change').change(function(){
		var field_id = $(this).attr('id');
		//var peple_soft_id=$("input[name=51]").val();

		//alert(peple_soft_id);
		 ajaxindicatorstart();
			var form_id = <?php echo $this_form_id; ?>;
			if ((typeof($(this).attr("data-id")) != 'undefined') && ($(this).attr("data-id") != null)){
				var id = $(this).attr("data-id");				
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
						//$("input[name=51]").val('DEFAULT MDM SOP');
						$.each(data, function(index, value) { 
							//var peoplesoft_def_val=$('#2687').val();
							if (value=='hide') {								
								$('#'+index).addClass('d-none');
								$('#'+index).removeClass('display_flex');
								// $('#'+index).val('');
								$('.select2-container').css('width','100%');
								if(index=='2687'){
									$("input[name=51]").val('DEFAULT MDM SOP');
									//alert('test');
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
									$("input[name=51]").val('DEFAULT MDM SOP');
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
									if(index=='2687'){
									$("input[name=51]").val('DEFAULT MDM SOP');
									//alert('test');
									}
								} 
							}

							if ($('#'+index).attr('data-field-id') !== undefined) {
								var getfield_id = $('#'+index).attr('data-field-id');
								if ($('#'+getfield_id).attr('data-required-check') !== undefined) {
									var check_req=$('#'+getfield_id).attr('data-required-check');
									if(check_req=='check_required'){
										change_required_condition(getfield_id);
									}else{
										field_required_check_ajax(index);
									}
								} else {
									field_required_check_ajax(index);
								}
							}
						});
						ajaxindicatorstop();
					}
				});
			}
			else{

			}
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
				var sup_id='<?php echo $sup_id;?>';
				var ins = document.getElementById(id).files.length;
				for (var x = 0; x < ins; x++) {
					// alert(document.getElementById('1459').files[x]);
					form_data.append("files[]", document.getElementById(id).files[x]);
				}
				 form_data.append("sup_id",sup_id);
				 form_data.append("field_id",field_id);
				 form_data.append(['<?php echo $this->security->get_csrf_token_name();?>'],'<?php echo $this->security->get_csrf_hash();?>');
				$.ajax({
					url: '<?php echo base_url();?>smartform/requestor_direct_upload_files_temp/',
					dataType: 'json', // what to expect back from the server
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'POST',
					success: function (response) {
						console.log(response);
						console.log("testnew");
						ajaxindicatorstop();						
						var resinfo = response.info;
						var resresult = response.result;
						var result_length=resresult.length;
						if(result_length>0){
							ajaxindicatorstop();
							var preview='';
							$.each(resresult, function(i, item) {
								var delFilename="'"+item.file_name+"'";
								
								preview+='<span class="field_id_'+field_id+'" id="file_'+item.id+'"><b>'+item.display_name+'</b>&nbsp;&nbsp;&nbsp;<i class="icon-trash mr-2 text-danger" style="cursor:pointer;" onclick="removeUploadedFileTemp('+item.id+','+delFilename+','+id+')"></i></span></br>';
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
						
						$('#preview_'+id).addClass("mt-2 font-weight-bold alert alert-info");
						$('#preview_'+id).html(preview);
					},
					error: function (response) {
						var resresult = '';
						$('#msg').html(resresult); // display error response from the server
						ajaxindicatorstop();						
					}
				});
			}

		}
	}

	function removeUploadedFileTemp(file_id,file_name,field_id){
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
							url: '<?php echo base_url();?>smartform/removeUploadedFileTemp',
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

	UpdateTempForms();
	function UpdateTempForms() {
		$(".form-control").each(function() {
			var tid = $(this).attr('id');
		  	$('#'+tid).change(function(){ 
			  	var tvalue = $(this).val();
			  	var user_id = $("#userid").val();
			  	var sup_id = $("#sup_id").val();
				var arr_temp_value = [];
				if(!$(this).hasClass("50_user_input")){
					if (tid==57 || tid==194 || tid==195 || tid==198 || tid==199 || tid==200 || tid==213 || tid==233 || tid==246 || tid==255 || tid==257 || tid==262 || tid==265 || tid==267 || tid==273 || tid==279 || tid==282 || tid==284 || tid==286 || tid==289 || tid==291 || tid==295 || tid==298 || tid==1459) {
						var form_data = new FormData();
						var sup_id='<?php echo $sup_id;?>';
						var files = $('#57')[0].files[0];
	    				form_data.append('files',files);
	    				form_data.append("sup_id",sup_id);
	    				form_data.append("field_id",57);
	    				form_data.append(['<?php echo $this->security->get_csrf_token_name();?>'],'<?php echo $this->security->get_csrf_hash();?>');
						$.ajax({
							url: '<?php echo base_url();?>smartform/update_temp_forms',
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
							url:"<?php echo base_url();?>smartform/update_temp_forms",  
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
			  	}
		  	}); 
		});		
	}
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
	var search_request_result="";		
	$(document).ready(function(e) {	
			
		$('#form_name_clone').on('change',function(e){			
			get_all_request_details(1);	
		});	
		$('#search_supplier_clone').on('keyup',function(e){	
			$('#appendDatas_supplier_clone').html('<tr><td colspan="10" align ="center"><i class="fa fa-spinner fa-spin" style="font-size:44px;color:rgb(75, 183, 245);"></i></td></tr>');	
			var pageNo =  1;	
			var search_by_supplier = $.trim($('#search_supplier_clone').val());	
			
			var search_by_form_name = $('#form_name_clone').val();	
			if(search_request_result!=''){	
				search_request_result.abort();	
			}	
			search_request_result = $.ajax({ 	
				url:"<?php echo base_url();?>smartform/get_all_request_details_ajax/"+pageNo,  	
				method:"POST", 	
				data:{pageNo:pageNo,search_by_supplier:search_by_supplier,form_id:search_by_form_name,recordsPerpage:"10",['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
				dataType:'JSON',	
				success:function(responseData) 	
				{ 	
					var rowData = responseData['rows'];	
					var tr = responseData['rows_tr'];               	
					$('#appendDatas_supplier_clone').html(tr);	
					$('#pagination_supplier_clone').html(responseData['pagination']);	
					//$('#totalCount_supplier_clone').html(responseData['total_rows']);	
					$('#totalCount_supplier_clone').html(responseData['total_rows']);	
				}	
			});	
		});	
			
		$('#pagination_supplier_clone').on('click','a',function(e){	
			if(!$(this).hasClass("current")){	
				e.preventDefault(); 	
				var pageNo = $(this).attr('data-ci-pagination-page');				
				get_all_request_details(pageNo);	
			}	
		});	
	});	
	function get_all_request_details(pageNo){	
			
		var search_by_supplier = $.trim($('#search_supplier_clone').val());	
		$('#appendDatas_supplier_clone').html('<tr><td colspan="10" align ="center"><i class="fa fa-spinner fa-spin" style="font-size:44px;color:rgb(75, 183, 245);"></i></td></tr>');	
		var search_by_form_name = $('#form_name_clone').val();	
		if(search_request_result!=''){	
			search_request_result.abort();	
		}	
		search_request_result = $.ajax({ 	
			url:"<?php echo base_url();?>smartform/get_all_request_details_ajax/"+pageNo,  	
			method:"POST", 	
			data:{pageNo:pageNo,form_id:search_by_form_name,search_by_supplier:search_by_supplier,recordsPerpage:"10",['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
			dataType:'JSON',	
			success:function(responseData) 	
			{ 	
				var rowData = responseData['rows'];	
				var tr = responseData['rows_tr'];               	
				$('#appendDatas_supplier_clone').html(tr);	
				$('#pagination_supplier_clone').html(responseData['pagination']);	
				//$('#totalCount_supplier_clone').html(responseData['total_rows']);	
				$('#totalCount_supplier_clone').html(responseData['total_rows']);	
			}	
		});	
	}	
	function select_request_to_clone(supId){	
		var selected_request_id = supId;	
		var temp_request_id = '<?php echo $sup_id;?>';	
		var form_id = '<?php echo $original_form_id;?>';	
		//alert(selected_request_id+' - '+temp_request_id);	
		$.confirm({	
			title: 'Clone Request',	
			theme: 'light',	
			content: "Are you sure want to clone the selected request?",	
			buttons : {	
				yes : {	
					text: 'Confirm',	
					btnClass: 'btn-blue',	
					action: function(){	
						ajaxindicatorstart();	
						$.ajax({	
							type: "POST",	
							url: '<?php echo base_url();?>smartform/clone_request',	
							data: { selected_request_id:selected_request_id,current_request_id:temp_request_id,current_form_id:form_id ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
							success   : function(data) {	
								ajaxindicatorstop();	
								//reset_clone_modal();	
								if(data=="1"){	
								   $.alert({	
										title: 'Alert!',	
										content: 'Request cloned successfully.',	
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
							
					}	
				}	
			}	
		});	
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
function clone_supplier_info(supId,){	
	var selected_request_id = supId;	
	var temp_request_id = '<?php echo $sup_id;?>';	
	var form_id = '<?php echo $original_form_id;?>';	
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
						url: '<?php echo base_url();?>smartform/clone_supplier_info',	
						data: { selected_request_id:selected_request_id,current_request_id:temp_request_id,current_form_id:form_id ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
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

function remove_sup_cloned_info(){
	var temp_request_id = '<?php echo $sup_id;?>';
	var cloned_sup_req_id= $("#clone_request_id_supplier_info_val").val();	

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
						url: '<?php echo base_url();?>smartform/remove_sup_cloned_info',	
						data: { current_request_id:temp_request_id,cloned_sup_req_id:cloned_sup_req_id ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
						success   : function(data) {	
							ajaxindicatorstop();	
							//reset_clone_modal();	
							if(data=="1"){	
							   $.alert({	
									title: 'Alert!',	
									content: 'Copied supplier information removed successfully.',	
									 onAction: function () {	
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

function resend_clone_request(){
	// alert("test");
	$("#clone_another_count").val('2');	
	$("#submit_check").val('yes');
	$("#smart_form").submit();
}

function insert_supplier_temp_data(req_ids,supp_email,sup_id){
	ajaxindicatorstart();
	var req_id = req_ids.replace(',','|');
	$.ajax({	
		type: "POST",	
		url: '<?php echo base_url();?>smartform/insert_supplier_temp_data',	
		data: { selected_request_id:req_ids,current_request_id:sup_id,supplier_email:supp_email ,['<?php echo $this->security->get_csrf_token_name();?>']:'<?php echo $this->security->get_csrf_hash();?>'},	
		success   : function(data) {	
			ajaxindicatorstop();	
		}	
	});
}

$(document).ready(function(e) {


	var currentRequest = null; 
	$(function() { 
		$("#15").autocomplete({
			minLength: 3,
			delay: 30, // this is in milliseconds
			json: true,			
		source: function(request, response) {
			
			var search_keyword = document.getElementById('15').value.trim();
			var supplier_legal_name = document.getElementById('42').value.trim();
			var supplier_request_id = document.getElementById('sup_id').value.trim();
				currentRequest = $.ajax({
					url: '<?php echo base_url();?>smartform/get_supplier_contact_email_auto_complete',
					type: 'post',
					dataType: "json",
					async: false,
					data: {
						search_keyword: search_keyword,supplier_legal_name:supplier_legal_name,supplier_request_id:supplier_request_id,
						['<?php echo $this->security->get_csrf_token_name();?>']: '<?php echo $this->security->get_csrf_hash();?>'
					},
					beforeSend : function()    {           
						if(currentRequest != null) {
							currentRequest.abort();
						}
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
						
					},
					error:function(e){
					  // Error
					  
					}
				});
			//Fetch data
			/* if (search_keyword != '') {
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
				}
			} else {
				$("#15").val('');
				// alert('Space not allowed!');
				$.alert({
					title: 'Alert!',
					content: 'Space not allowed!',
				});
				return false;
			} */

		},
		select: function(event, ui) {
			//Set selection
			var supplier_request_id = document.getElementById('sup_id').value;
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
			var associate_ids=$("#associated_requests_ids").val();
			insert_supplier_temp_data(associate_ids,ui.item.label,supplier_request_id);
			//$('#select_supplier_info').show();
			//get_associated_request(ui.item.label);
			return false;
		}
		});
	});
});		

function checkForExitsingSupplier(){
	//ajaxindicatorstart();
	var search_keyword = document.getElementById('15').value.trim();
	var supplier_legal_name = document.getElementById('42').value.trim();
	var supplier_request_id = document.getElementById('sup_id').value.trim();
	var associated_requests_ids = document.getElementById('associated_requests_ids').value.trim();
	var selected_supplier_legal_name = document.getElementById('selected_supplier_legal_name').value.trim();
	var selected_supplier_email = document.getElementById('selected_supplier_email').value.trim();
	if(search_keyword!='' && supplier_legal_name!='' && associated_requests_ids!='' && selected_supplier_legal_name!=''){
		if(selected_supplier_legal_name!=supplier_legal_name || search_keyword!=selected_supplier_email){
			alert('etetetete');
		}
		// $.ajax({	
		// 	type: "POST",	
		// 	url: '<?php echo base_url();?>smartform/insert_supplier_temp_data_blur',	
		// 	search_keyword: search_keyword,supplier_legal_name:supplier_legal_name,supplier_request_id:supplier_request_id,['<?php echo $this->security->get_csrf_token_name();?>']: '<?php echo $this->security->get_csrf_hash();?>'
		// 	success   : function(data) {	
				//ajaxindicatorstop();
					
		// 	}	
		// });
	}


}

</script>