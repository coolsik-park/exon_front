<?php $this->layout = 'default';  ?>
<style>
.help-block{
	display:none;
	color: #f33;
    padding: 0;
    margin: 2px 0 0 0;
    background-position: 0 0;
    background-repeat: no-repeat;}

div.error {
    color: #f33;
    padding: 0;
    margin: 2px 0 0 0;
    /*font-size: 0.7em;*/
    /*padding-left: 18px;*/
    background-position: 0 0;
    background-repeat: no-repeat;
}

#previews .file-row .delete .dz-preview {
    display: none;
}
</style>
<div id="container">
	<div class="sub-headline">
		<div class="container"></div>
	</div>
	<div class="sub-container">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<nav class="left-aside">
						<h2 class="skip">Mypage</h2>
						<ul class="lnb">
							<li class="active"><a href="/Mypages/company">Company Information</a></li>
							<li><a href="/Mypages/contents">Digital Content</a></li>
							<li><a href="/Mypages/SearchList">Search List</a></li>
							<li><a href="/Mypages/matching">Business Matching</a></li>
							<li><a href="/Mypages/SystemUsage">System Usage</a></li>
						</ul>
					</nav>
				</div>
			<form id="update_form" data-toggle="validator" novalidate="true">
				<input type="hidden" name="company_type_number" id="company_type_number" value="<?php echo $member['company'][0]['company_type']; ?>">
				<div class="col-md-9">
					<div class="contents mypage-edit">
						 <div class="register-cominfo">
	 						<h3 class="h-ty2 fir">Company Information</h3>
	 						<div class="row">
	 							<div class="col-md-3">ID</div>
	 							<div class="col-md-9">
	 								<div class="ln-id">
	 									<input type="text" class="form-control ipt1" value="<?php echo $member['login_id']; ?>" disabled>
	 									<!-- <a href="#" class="btn">Verify</a> -->
	 								</div>
	 							</div>
	 						</div>
					<!-- 		<div class="row">
	 							<div class="col-md-3">Current Password</div>
	 							<div class="col-md-9">
	 								<div class="ln-pw">
	 									<input type="password" name="passwd" id="passwd" class="form-control ipt1">
	 								</div>
	 							</div>
	 						</div> -->
	 						<div class="row">
	 							<div class="col-md-3">New Password</div>
	 							<div class="col-md-9">
	 								<div class="ln-pw">
	 									<input type="password" name="newpasswd" id="newpasswd" class="form-control ipt1" placeholder="8~16 characters in length.">
	 									<!-- <span class="ts">8~16 characters in length.</span> -->
	 								</div>
	 							</div>
	 						</div>
							<div class="row">
	 							<div class="col-md-3">Confirm New Password</div>
	 							<div class="col-md-9">
	 								<div class="ln-pw">
	 									<input type="password" name="renewpasswd" id="renewpasswd" class="form-control ipt1">
	 								</div>
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Ceo Name</div>
	 							<div class="col-md-9">
	 								<input type="text" class="form-control ipt1"  id="ceoname" name="ceoname" value="<?php echo $member['company'][0]['ceo_name']; ?>">
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Country</div>
	 							<div class="col-md-9">
	 								<select class="form-control sel-country" id="country" name="country">
	 								<?php foreach($country as $list): ?>
										<option value="<?php echo $list['id']; ?>" rel="<?php echo $list['code']; ?>" <?php if($list['id'] == $member['company'][0]['country_id']) echo 'selected'; ?>><?php echo $list['name']; ?></option>
									<?php endforeach; ?>
	 								</select>
	 							</div>
	 						</div>

						<?php if($member['company'][0]['country']['code'] == 82): ?>
							<?php $license = explode('-',$member['company'][0]['license_number']); ?>
	 						<div class="row">
	 							<div class="col-md-3">Business License Number</div>
	 							<div class="col-md-9">
	 								<div class="phone-number">
	 									<input type="text" class="form-control ipt-num1" id="license1" name="license1" value="<?php echo $license[0]; ?>">
	 									<span class="bar">-</span>
	 									<input type="text" class="form-control ipt-num1" id="license2" name="license2" value="<?php echo $license[1]; ?>">
	 									<span class="bar">-</span>
	 									<input type="text" class="form-control ipt-num2" id="license3" name="license3" value="<?php echo $license[2]; ?>">
	 								</div>
	 								<div class="biz-img" id="previews">
	 									<img src="<?php echo IMG_SERVER . $member['company'][0]['license_path']; ?>" id="dropzone_license" width="118px" height="118px" alt="">
	 								</div>
	 							</div>
	 						</div>
	 					<?php endif; ?>
	 						<div class="row">
	 							<div class="col-md-3">Company Type</div>
	 							<div class="col-md-9">
	 								<ul class="ctype-list">
	 									<?php foreach($companyType as $list): ?>
											<li><span class="checks"><input type="checkbox" name="company_type" id="ctype<?php echo $list['id']; ?>" rel="<?php echo $list['id']; ?>" <?php if(($member['company'][0]['company_type']&$list['id'])>0) echo "checked"; ?>><label for="ctype<?php echo $list['id']; ?>"><?php echo $list['name']; ?></label></span></li>
										<?php endforeach; ?>
	 								</ul>
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Company Name</div>
	 							<div class="col-md-9">
	 								<input type="text" class="form-control ipt1" name="company_name" id="company_name" value="<?php echo $member['company'][0]['name']; ?>">
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Office Phone Number</div>
								<div class="col-md-9">
	 								<div class="phone-number2"><span class="tx">+<?php echo $member['company'][0]['country']['code']; ?></span><input type="text" class="form-control ipt2" name="company_phone" id="company_phone" value="<?php echo $member['company'][0]['phone']; ?>"></div>
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Office Fax Number</div>
	 							<div class="col-md-9">
	 								<div class="phone-number2"><span class="tx">+<?php echo $member['company'][0]['country']['code']; ?></span><input type="text" class="form-control ipt2" name="company_fax" id="company_fax" value="<?php echo $member['company'][0]['fax']; ?>"></div>
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Oiffcial Web Site</div>
								<div class="col-md-9">
	 								<input type="text" class="form-control ipt1" name="site" id="site" value="<?php echo $member['company'][0]['site']; ?>">
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Foundation Date</div>
	 							<div class="col-md-9">
	 								<input type="number" class="form-control ipt1" name="foundation_date" id="foundation_date"  value="<?php echo $member['company'][0]['foundation_date']; ?>" placeholder="YYYYMMDD">
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Company Logo</div>
	 							<div class="col-md-9">
	 								<span class="c-logo-img"><img src="<?php echo IMG_SERVER . $member['company'][0]['logo_path']; ?>"  id="dropzone_logo" width="118px" height="118px" alt="noimg"></span>
	 								<span class="ts">Image Size 200*200 (jpg, png)</span>
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Company Introduction</div>
	 							<div class="col-md-9">
	 								<textarea rows="8" cols="40" maxlength="1000"  class="textar" id="company_introduction"  name="company_introduction" placeholder="Please enter the content"><?php echo $member['company'][0]['introduction']; ?></textarea>
	 								<div class="file-attach">
	 									<!-- <span class="lf">File Attachment <a href="#" class="ico-file">File Attachment</a></span> -->
	 									<span class="rt"><strong id="counter"><?php echo mb_strlen($member['company'][0]['introduction'],'UTF-8'); ?></strong>/1000</span>
	 								</div>
	 							</div>
	 						</div>
	 					</div>
	 					<div class="register-cominfo">
	 						<h3 class="h-ty2">Management Date</h3>
	 						<div class="row">
	 							<div class="col-md-3">User Name</div>
	 							<div class="col-md-9"><input type="text" class="form-control ipt1" id="member_name" name="member_name" value="<?php echo $member['name']; ?>"></div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Position</div>
	 							<div class="col-md-9"><input type="text" class="form-control ipt1" id="position" name="position" value="<?php echo $member['position']; ?>"></div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">Business Department</div>
	 							<div class="col-md-9"><input type="text" class="form-control ipt1" id="department" name="department" value="<?php echo $member['department']; ?>"></div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">User E-mail</div>
	 							<div class="col-md-9"><span class="info"><?php echo $member['email']; ?></span></div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">User Phone Number (Office)</div>
	 							<div class="col-md-9">
	 								<div class="phone-number2"><span class="tx">+<?php echo $member['company'][0]['country']['code']; ?></span><input type="text" class="form-control ipt2" id="phone" name="phone" value="<?php echo $member['phone']; ?>"></div>
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">User Phone Number (HP)</div>
	 							<div class="col-md-9">
	 								<div class="phone-number2"><span class="tx">+<?php echo $member['company'][0]['country']['code']; ?></span><input type="text" class="form-control ipt2" id="hp" name="hp" value="<?php echo $member['hp']; ?>"></div>
	 							</div>
	 						</div>
	 						<div class="row">
	 							<div class="col-md-3">SNS Account</div>
	 							<div class="col-md-9">
	 								<div class="ln-sns">
	 									<span class="ts">Instagram</span><input type="text" class="form-control ipt2" id="instagram" name="instagram" value="<?php echo($member['company'][0]['instagram']); ?>">
	 								</div>
	 								<div class="ln-sns">
	 									<span class="ts">Facebook</span><input type="text" class="form-control ipt2" id="facebook" name="facebook" value="<?php echo($member['company'][0]['facebook']); ?>">
	 								</div>
	 								<div class="ln-sns">
	 									<span class="ts">Twitter</span><input type="text" class="form-control ipt2" id="twitter" name="twitter" value="<?php echo($member['company'][0]['twitter']); ?>">
	 								</div>
	 							</div>
	 						</div>
	 					</div>
	 					<div class="btn-btms">
	 						<a class="btn" id="go_update">UPDATE</a>
	 					</div>
					</div>
					<!-- //contents -->
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
<?php
    $this->Html->css([
      	'/plugins/select2/select2.min',
      	'/plugins/dropzone/dropzone',
      ],
      ['block' => 'css']);
    $this->Html->script([
    	'/plugins/select2/select2.full.min',
      	'/plugins/dropzone/dropzone',
      ],
      ['block' => 'script']);
?>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">
var id_check=false;
var ready_id = <?php echo $member['member_ready_id']; ?>;
var company_id = <?php echo $member['company'][0]['id']; ?>;
$(document).ready(function(){


	//사업자 등록증
	var dropzone_license = new Dropzone("#dropzone_license", { // Make the whole body a dropzone

            url: "/Uploads/fileUpload//license/" + ready_id, // Set the url
            acceptedFiles: "image/jpeg,image/png,image/gif,image/jpg",
            maxFiles: 1,
            thumbnailWidth: 200,
            thumbnailHeight: 200,
            // autoQueue: false, // Make sure the files aren't queued until manually added
            // clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
            parallelUploads: 1,//병렬로 처리 할 파일 업로드 수
            timeout: 100000,
            resizeWidth: 200,
            resizeQuality: 1.0,
            init: function() {

		      	this.on("addedfile", function (file) {          
		          	if (this.files[1]!=null){ //파일 하나만 업로드 가능
		            	this.removeFile(this.files[0]);
		      		}
		    	});
		    	this.on("success", function(file, response) {
    
			        var jsonObj = JSON.parse(response);

			        if(!jsonObj.data)
			        { 	//오류
			          	alert(jsonObj.msg);
			        }
			        else
			        {
			        	//업로드 성공시 이미지 교체
			        	$('#dropzone_license').attr('src',file.dataURL);

				    }
		        
		   		});
		  	}
    });

    //회사 로고 
	var dropzone_logo = new Dropzone("#dropzone_logo", { // Make the whole body a dropzone

            url: "/Uploads/fileUpload/logo/" + ready_id, // Set the url
            acceptedFiles: "image/jpeg,image/png,image/gif,image/jpg",
            maxFiles: 1,
            // addRemoveLinks: true,
            thumbnailWidth: 200,
            thumbnailHeight: 200,
            // autoQueue: false, // Make sure the files aren't queued until manually added
            // clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
            parallelUploads: 1,//병렬로 처리 할 파일 업로드 수
            timeout: 100000,
            resizeWidth: 200,
            resizeQuality: 1.0,
            init: function() {

		      	this.on("addedfile", function (file) {          
		          	if (this.files[1]!=null){ //파일 하나만 업로드 가능
		            	this.removeFile(this.files[0]);
		      		}
		    	});
		    	this.on("success", function(file, response) {
    
			        var jsonObj = JSON.parse(response);

			        if(!jsonObj.data)
			        { 	//오류
			          	alert(jsonObj.msg);
			        }
			        else
			        {
			        	//업로드 성공시 이미지 교체
			        	$('#dropzone_logo').attr('src',file.dataURL);

				    }
		        
		   		});
		  	}
    });

    //국가 변경시 국가번호 변경
	$('#country').on('change', function(){
	
		var country_code =$('#country option:selected').attr('rel');

		$('.tx').text('+' + country_code);	//국가번호 변경 

		//한국일 경우 사업자 번호 및 사진 등록 폼 노출
		if(country_code == 82 ) $('#license_form').show();
		else $('#license_form').hide();
	})

	//회사 소개 글자수 체크
	$('#company_introduction').keyup(function (e){
      var content = $(this).val();
      $('#counter').html(content.length);
	});

	var validator = $("#update_form").validate({
	    rules: {
	    	// passwd: {
	     //    	required: true,
	     //    	minlength: 6,
	     //    	maxlength:16
	     //    },
	        newpasswd: {
	        	required: true,
	        	minlength: 6,
	        	maxlength:16
	        },
	        renewpasswd: {
	        	required: true,
	        	equalTo: "#newpasswd"
	        },
	        ceoname: {
	        	required: true,
	        	minlength: 3
	        },
	        company_type: {
	        	required: true,
	        	minlength: 2
	        },
	        license1: {
	        	required: true,
	        	minlength:3,
	        	maxlength:3
	        },
	        license2: {
	        	required: true,
	        	minlength:2,
	        	maxlength:2
	        },
	        license3: {
	        	required: true,
	        	minlength:5,
	        	maxlength:5
	        },
	        company_name: {
	        	required: true,
	        	minlength: 2
	        },
	        company_phone: {
	        	required: true,
	        	minlength: 5
	        },
	        company_fax: {
	        	required: true,
	        	minlength: 5
	        },
	        site: {
		      required: true,
		      url: true
		    },
		    foundation_date: {
		      required: true,
		      minlength: 6,
		      maxlength: 8,
		      number: true
		    },
	        company_introduction: {
	        	required: true,
	        	minlength: 5,
		      	maxlength: 1000,
	        },
	        member_name: {
	        	required: true,
	        	minlength: 3
	        },
	        position: {
	        	required: true,
	        	minlength: 3
	        },
	        department: {
	        	required: true,
	        	minlength: 3
	        },
	        phone: {
	        	required: true,
	        	minlength: 5
	        },
	        hp: {
	        	required: true,
	        	minlength: 5
	        },
	        instagram: {
	        	url: true
	        },
	        facebook: {
	        	url: true
	        },
	        twitter: {
	        	url: true
	        }
	     
	    },
	    groups: {
            inputGroup: "license1 license2 license3",
            // checkboxGroup: "check1 check2",            
        },
	    errorPlacement: function (error, element) {
	        if (element.attr('name') == 'license1' || element.attr('name') == 'license2' || element.attr('name') == 'license3')
	            error.insertAfter('#license3');
	        else
	        	 element.after(error); 
	    }

	});

	//업데이트
    $("#go_update").on("click", function(){

    	if(!validator.element("#ceoname")){
			validator.focusInvalid();
			return false;
		}
		else if(company_type_number <=0){
			fnMove('company_type');
			alert('Please check one or more of the company type.')
			return false;
		}
		else if(!validator.element("#license1")){
			validator.focusInvalid();
			return false;
		}
		else if(!validator.element("#license2")){
			validator.focusInvalid();
			return false;
		}
		else if(!validator.element("#license3")){
			validator.focusInvalid();
			return false;
		}
		else if(!validator.element("#company_name")){
			validator.focusInvalid();
			return false;
		}
		else if(!validator.element("#company_phone")){
			validator.focusInvalid();
			return false;
		}
		else if(!validator.element("#company_fax")){
			validator.focusInvalid();
			return false;
		}
		else if(!validator.element("#site")){
			validator.focusInvalid();
			return false;
		}
		else if(!validator.element("#company_introduction")){
			validator.focusInvalid();
			return false;
		}
		else if(!validator.element("#member_name")){
			validator.focusInvalid();
			return false;
		} 
		else if(!validator.element("#position")){
			validator.focusInvalid();
			return false;
		} 
		else if(!validator.element("#department")){
			validator.focusInvalid();
			return false;
		} 
		else if(!validator.element("#phone")){
			validator.focusInvalid();
			return false;
		} 
		else if(!validator.element("#hp")){
			validator.focusInvalid();
			return false;
		}
		else if($('#newpasswd').val().length > 0){	//신규 비밀번호 입력시 체크 


			if(!validator.element("#newpasswd")){
				validator.focusInvalid();
				return false;
			}
			if(!validator.element("#renewpasswd")){					
				validator.focusInvalid();
				return false;
			} 
			
			// if(!validator.element("#passwd")){
			// 	validator.focusInvalid();
			// 	return false;
			// } 
		}

		var company_type_number=0;
		$("input[name=company_type]:checked").each(function() {
			company_type_number += parseInt($(this).attr("rel"));
		});
		$('#company_type_number').val(company_type_number);
		
		
    	//회사 데이터 수정
		var queryString = $("#update_form").serialize();

		$.ajax({
          type: "POST",
          data: queryString+ '&company_type_number=' + $('#company_type_number').val(),
          dataType: 'json',
          url: "/Mypages/updCompany",
          error:function(err){
          
            alert(JSON.stringify(err));

           },
           success: function (data) {
            if(data.data == false)
            { 
                alert(data.msg);    
            }
            else
            {
            	alert(data.msg);
            	return false;
              	
            }
           }

         })
    	
    })	
})
</script>