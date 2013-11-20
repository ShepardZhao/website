<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="masonry.pkgd.min.js"></script>
	<style>
	
	.item { width: 25%; }
	.item.w2 { width: 50%; }
	</style>
</head>
<body>
	<script>
	$(document).ready(function(){
	var container = document.querySelector('#container');
	var msnry = new Masonry( container, {
	  // options
	  columnWidth: 200,
	  itemSelector: '.item'
	});
	
	
	var apiURL='http://b2c.com.au/json/index.php?GetAllCuis=yes';
	function loadData() {
	            $.ajax({
	                url: apiURL,
	                dataType: 'json',
	                success: onLoadData,
	            });
	        };
	        
	function onLoadData(data){
	var html = '';
	
	for (var i=0;i<data.length;i++){
	if(data[i].PicPath!==null){
	  html += '<div class="items">';
	  html += '<img src="'+data[i].PicPath+'">';
	  html += '</div>';
	
	}
	}
		
	$('#container').append(html);
	
		
	}
	      
	     
	     	loadData();
		
	
	
	});
	
	        
	</script>


	<div id="container">
	  
	  
	  
	</div>
	
	
	
</body>
</html>