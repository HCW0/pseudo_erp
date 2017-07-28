<body>
갯수 :<input type="text" name="count[]" class="cal"> 
단가 :<input type="text" name="unitpri[]" class="cal"> 
합계 :<input type="text" name="price[]" class="cal"> 
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 

<script type="text/javascript"> 
jQuery(document).ready(function(){	
jQuery(".cal").change(function() { 

jQuery("input[name=count[]]").each(function(e, data) { 
var count = jQuery("input[name=count[]]").eq(e).val(); 
var unitpri = jQuery("input[name=unitpri[]]").eq(e).val(); 
jQuery("input[name=price[]]").eq(e).val(count * unitpri); 
}); 
}); 
}); 
</script>