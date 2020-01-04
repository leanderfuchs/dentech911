<div class="visual-form-builder-container">
 	<form id="order" enctype="multipart/form-data" class="visual-form-builder" method="post" action="?page=order_detail">
 			<fieldset class="fieldset  commandexfset">
 			<ul class="section section-1">
 				<li class="item item-text left-half" id="patient">
 					<label for="patient" class="desc">N° de suivi ou Nom/Prénom du patient <span>*</span></label><input type="text" name="patient" id="patient" class="text large" value="<?php if(!empty($_POST['patient'])){ echo $_POST['patient']; }?>">
 					<?php echo $missing_patient ?><!--  Error message  -->
 				</li>

 				<li class="item item-text right-half" id="teeth_nbr">
 					<label for="teeth_nbr" class="desc">N° des dents</label>
					 <input type="text" name="teeth_nbr" id="teeth_nbr" class="text large" value="<?php if(!empty($_POST['teeth_nbr'])){ echo $_POST['teeth_nbr']; }?>">
 				</li>
 				
 				<li class="item item-select left-half">
 					<label for="product">Nom du matériau <span>*</span></label>
					<input type="text" name="product" id="product" class="text large" value="<?php if(!empty($_POST['product'])){ echo $_POST['product']; }?>">
 					 <?php echo $missing_product ?><!--  Error message  -->
 				</li>

				<li class="item item-text right-half">
 					<label for="email-order-to" class="desc" onclick="show_address_book()">Email du destinataire <span>*</span>
					 <i class="fas fa-address-book" id="address-book"></i></label>

					 <div id="addresses" style="display:none" class="float-left position-absolute floating-window"></div>
					 
					  <input type="email" name="email-order-to" id="email-order-to" class="text large" value="
					 <?php if(!empty($_GET['email-order-to'])){ echo $_GET['email-order-to']; };
						if(!empty($_POST['email-order-to'])){ echo $_POST['email-order-to']; }?>">
					<? if(isset($missinemail)) echo $missinemail; ?>
				</li>
				 
 				<li class="item item-select left-half" id="vita_body2">
 					<label for="vita_body" class="desc">Teinte Vita</label>
 					<select name="vita_body" id="vita_body" class="select medium">
 						<option value="<?php if(!empty($_POST['vita_body'])){ echo $_POST['vita_body']; }?>"><?php if(!empty($_POST['vita_body'])){ echo $_POST['vita_body']; }?>
 						</option>
 						<option value="A1">
 							A1
 						</option>
 						<option value="A2">
 							A2
 						</option>
 						<option value="A3">
 							A3
 						</option>
 						<option value="A3.5">
 							A3.5
 						</option>
 						<option value="A4">
 							A4
 						</option>
 						<option value="B1">
 							B1
 						</option>
 						<option value="B2">
 							B2
 						</option>
 						<option value="B3">
 							B3
 						</option>
 						<option value="B4">
 							B4
 						</option>
 						<option value="C1">
 							C1
 						</option>
 						<option value="C2">
 							C2
 						</option>
  						<option value="C3">
 							C3
 						</option>
 						<option value="C4">
 							C4
 						</option>
 						<option value="D2">
 							D2
 						</option>
 						<option value="D3">
 							D3
 						</option>
 						<option value="D4">
 							D4
 						</option>
 					</select>
 				</li>

 				<li class="item item-select right-half" id="vita3d_body2">
 					<label for="vita3d_body" class="desc">Vita 3D Master</label><select name="vita3d_body" id="vita3d_body3" class="select medium">
 					<option value="<?php if(!empty($_POST['vita3d_body'])){ echo $_POST['vita3d_body']; }?>"><?php if(!empty($_POST['vita3d_body'])){ echo $_POST['vita3d_body']; }?>
 					</option>
 					<option value="1M1">
 						1M1
 					</option>
 					<option value="1M2">
 						1M2
 					</option>
 					<option value="2L1.5">
 						2L1.5
 					</option>
 					<option value="2L2.5">
 						2L2.5
 					</option>
 					<option value="2M1">
 						2M1
 					</option>
 					<option value="2M2">
 						2M2
 					</option>
 					<option value="2M3">
 						2M3
 					</option>
 					<option value="2R1.5">
 						2R1.5
 					</option>
 					<option value="2R2.5">
 						2R2.5
 					</option>
 					<option value="3L1.5">
 						3L1.5
 					</option>
 					<option value="3L2.5">
 						3L2.5
 					</option>
 					<option value="3M1">
 						3M1
 					</option>
 					<option value="3M2">
 						3M2
 					</option>
 					<option value="3M3">
 						3M3
 					</option>
 					<option value="3R1.5">
 						3R1.5
 					</option>
 					<option value="3R2.5">
 						3R2.5
 					</option>
 					<option value="4L1.5">
 						4L1.5
 					</option>
 					<option value="4L2.5">
 						4L2.5
 					</option>
 					<option value="4M1">
 						4M1
 					</option>
 					<option value="4M2">
 						4M2
 					</option>
 					<option value="4M3">
 						4M3
 					</option>
 					<option value="4R1.5">
 						4R1.5
 					</option>
 					<option value="4R2.5">
 						4R2.5
 					</option>
 					<option value="5M1">
 						5M1
 					</option>
 					<option value="5M2">
 						5M2
 					</option>
 					<option value="5M3">
 						5M3
 					</option>
 				</select>
 			</li>

		<li class="item item-select left-half" id="implant_name">
			<label for="implant_name" class="desc">Type de pilier implantaire </label>
			<input type="text" name="implant_name" id="implant_name" class="text medium" value="<?php if(!empty($_POST['implant_name'])){ echo $_POST['implant_name']; }?>">
 		</li>

 		<li class="item item-text right-half" id="implant_diam">
 			<label for="implant_diam" class="desc">Diamètre des piliers </label>
 			<input type="text" name="implant_diam" id="implant_diam" value="<?php if(!empty($_POST['implant_diam'])){ echo $_POST['implant_diam']; }?>" class="text medium required">
 		</li>

 		<li class="item item-textarea" id="item-vfb-596-596">
			 <label for="comment" class="desc">Commentaire</label>
 			<textarea name="comment" id="comment" class="textarea small"><?php if(!empty($_POST['comment'])){ echo $_POST['comment']; }?></textarea>
		 </li>

 		<li class="item item-file-upload left-third" id="file1">
 			<input type="file" size="35" name="file1" id="file12" accept=".zip,.zipx.tar.gz,.tgz,.tar.Z,.tar.bz2,
.tbz2,.tar.lzma,.tlz..tar.xz,.txz,.rar,.7z,.rar,.bz2,.gz,.tar,.doc,.docx,.pdf,.stl,.jpeg,.jpg,.png,.ply,.obj,image/*,video/*" class="text small">
		 </li>
		 <li class="item item-file-upload middle-third" id="file2">
 			<input type="file" size="35" name="file2" id="file22" accept=".zip,.zipx.tar.gz,.tgz,.tar.Z,.tar.bz2,
.tbz2,.tar.lzma,.tlz..tar.xz,.txz,.rar,.7z,.rar,.bz2,.gz,.tar,.doc,.docx,.pdf,.stl,.jpeg,.jpg,.png,.ply,.obj,image/*,video/*" class="text small">
		 </li>
 		<li class="item item-file-upload right-third" id="file3">
 			<input type="file" size="35" name="file3" id="file32" accept=".zip,.zipx.tar.gz,.tgz,.tar.Z,.tar.bz2,
.tbz2,.tar.lzma,.tlz..tar.xz,.txz,.rar,.7z,.rar,.bz2,.gz,.tar,.doc,.docx,.pdf,.stl,.jpeg,.jpg,.png,.ply,.obj,image/*,video/*" class="text small">
 		</li>
 		<li class="item item-file-upload left-third" id="file4">
 			<input type="file" size="35" name="file4" id="file42" accept=".zip,.zipx.tar.gz,.tgz,.tar.Z,.tar.bz2,
.tbz2,.tar.lzma,.tlz..tar.xz,.txz,.rar,.7z,.rar,.bz2,.gz,.tar,.doc,.docx,.pdf,.stl,.jpeg,.jpg,.png,.ply,.obj,image/*,video/*" class="text small">
 		</li>
 		<li class="item item-file-upload middle-third" id="file5">
 			<input type="file" size="35" name="file5" id="file52" accept=".zip,.zipx.tar.gz,.tgz,.tar.Z,.tar.bz2,
.tbz2,.tar.lzma,.tlz..tar.xz,.txz,.rar,.7z,.rar,.bz2,.gz,.tar,.doc,.docx,.pdf,.stl,.jpeg,.jpg,.png,.ply,.obj,image/*,video/*,image/*,video/*" class="text small">
 		</li>
 		<li class="item item-file-upload right-third" id="file6">
 			<input type="file" size="35" name="file6" id="file62" accept=".zip,.zipx.tar.gz,.tgz,.tar.Z,.tar.bz2,
.tbz2,.tar.lzma,.tlz..tar.xz,.txz,.rar,.7z,.rar,.bz2,.gz,.tar,.doc,.docx,.pdf,.stl,.jpeg,.jpg,.png,.ply,.obj,image/*,video/*" class="text small">
 		</li>

 		<div class="center">
 			<li class="item item-text ">
 				<label for="datepicker" class="desc">Date de retour</label>
 				<input type="hidden" name"format" id="format" value="Y-m-d">
 				<input type="text" name="datepicker" id="datepicker" value="<?php if(!empty($_POST['datepicker'])){ echo $_POST['datepicker']; }?>" class="text small ">
 			</li>
 		</div>

 		<li class="item item-submit">
 			<input type="submit" name="order" value="Commander" class="submit">
 		</li>
 	</ul><br>
 </fieldset>
</form>
</div>

<input type="hidden" id="user-id" value="<? echo $_SESSION['user_id']; ?>"/>

<script type='text/javascript'>

function show_address_book() {
	var user_id = document.getElementById("user-id").value;
	var url = "views/js/address_book.php/?user_id=" + user_id;
	
	// Open an ajax request : type, url, async
	var request = new XMLHttpRequest();
	request.open('POST', url, false);
	request.send();
	
	document.getElementById("addresses").innerHTML = request.responseText;

	// TOGGLE HIDE SHOW ADDRESS BOOK
	var addressbook = document.getElementById("addresses");
	if (addressbook.style.display === "none") {
    	addressbook.style.display = "block";
  	} else {
    	addressbook.style.display = "none";
  	}

}

function get_email(email) {
	var email_address = email.innerText || email.textContent;
	//console.log(email_address);
	document.getElementById("email-order-to").value = email_address;

	var addressbook = document.getElementById("addresses");
	addressbook.style.display = "none";
}

</script>