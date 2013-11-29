<?php $this->render('common/header'); ?>

<div id ="center">
			<div class="pic">
				<img  id = "imageBox" src="./apps/mytest/wwwroot/img/f.jpg" height="320px" width="526px" onload='CheckProperty(this)'>
			</div>
			<div style="margin-top:10px;height:31px;">
				<form action="./index.php/data/uploadPic" class="search_form" enctype="multipart/form-data" method="post">
				    <input type="text" class="sinput" placeholder="输入图片URL回车检索">  
				   	<a href="javascript:" class="btn_addPic"><span>上传文件</span>
				   		<input type="file" name="Filedata" id="filesInput" class="filePrew"  >	
				   	</a>
				    <input class="sbtn2" type="submit" value="检索" >
				</form> 
			</div>			
		</div>
	<script type="text/javascript">
		function CheckProperty(obj) {
		    var ImgObj=new Image();
		    ImgObj.src = obj.src;

		    if(ImgObj.readyState!="complete") //如果图像是未加载完成进行循环检测
		    {
		       setTimeout("CheckProperty(FileObj)",500);
		    }
		    //取得图片的宽度
		    ImgWidth=ImgObj.width
		    //取得图片的高度
		    ImgHeight=ImgObj.height;
		    obj.width = ImgWidth*obj.height/ImgHeight;
		}
		/** 裁剪图片 */
		function cut(obj , width , height){
		       obj.width = width*obj.height/height;
		}
	</script>
	<script type="text/javascript">
		function $(id) { return document.getElementById(id);}
		var imageBox = $("imageBox");
		var filesInput = $("filesInput");
		function getFiles(e){
		   		e = e || window.event;
		    	var files = e.target.files;
		    	//console.log(files);
				var reader = new FileReader();
				reader.onload = (function(file) {
					return function(e){						
						imageBox.src = e.target.result;
					}
				})(files[0]);
				reader.readAsDataURL(files[0]);
		}
		if (window.File && window.FileList && window.FileReader && window.Blob) {
		    filesInput.addEventListener("change", getFiles, false);
		}
	</script>
<?php  ?>