<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://unpkg.com/flatpickr"></script>
<link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">

<style type="text/css">
   @import url('http://fonts.googleapis.com/earlyaccess/nanumgothic.css');
   body, table, div, p          { font-family:'Nanum Gothic';    }
   body,div                      { margin : 0;     padding : 0;   }
   select { outline : none;}
   option { text-align : right; background : white;}
   a       { }

   .BOX                          { margin : 0;     padding : 0;     width:100%; height:100%; background : gray; position : relative;}
   .BOX .menu_area                { width : 0;  height : 100%;   background : black;      float : left; display : inline-block; color : white; margin-right : 10px;}
   .BOX .document_area          { width : 2000px; height : 100%;   background : #FFFFFF;   }   
   .BOX .document_area .filterBOX { width : 1700px; height : 30px;   background : #FFFFFF;   }
   .BOX .document_area .filterBOX TABLE             { display : inline-block; margin : 0; padding : 0; }
   .BOX .document_area .filterBOX TABLE tr td         { width : 170px;}
   .BOX .document_area .filterBOX input[type=button] { margin : 0; padding-top : 5px; border : none; background : white; float : right; outline : none;}
   .BOX .document_area .filterBOX select            { border : none; height : 20px;}
   .BOX .document_area .filterBOX #search           { border-bottom : 1px solid #007BE6; width : 120px;}
   .BOX .document_area .filterBOX #search a        { text-decoration : none; color : black;}
   .BOX .document_area .filterBOX #searchText         { outline : none; border : none;}
   
   .BOX .document_area .dataArea .dataTable .table             { width : 1700px; border : 1px solid black;   border-collapse : collapse;   } 
   .BOX .document_area .dataArea .dataTable .table>tr>td        { border : 1px solid black;   display : inline-block;}
   .BOX .document_area .dataArea .dataTable table #titleRow    { width : 100px;   text-align : center; background : #FFFFFF;   }
   .BOX .document_area .dataArea .dataTable table #filter_last>td:first-child  {   text-align : center;}
   .BOX .document_area .dataArea .dataTable table #filter_last             {   text-align : right;   height : 50px; }

   .BOX .document_area .dataArea .dataTable table .c0 { background-color : white;}
   .BOX .document_area .dataArea .dataTable table .c1 { background-color : #DCF2D6;}
   .BOX .document_area .dataArea .dataTable table #rowData       { text-align : right; }
   .BOX .document_area .dataArea .dataTable table #rowData:hover   { background : #E0E6F8; }
   .BOX .document_area .dataArea .dataTable table #rowData td         { text-align : right; min-width:100%;}
   .BOX .document_area .dataArea .dataTable table #rowData .title       { text-align : left; padding-left : 10px; width:315px;}
   .BOX .document_area .dataArea .dataTable table #rowData .coworker   { width : 100px;}
   .BOX .document_area .dataArea .dataTable table #rowData ._m       { text-align : right; }
   .BOX .document_area .dataArea .dataTable table #rowData #false       { background : yellow;}
   .BOX .document_area .dataArea .dataTable table #rowData #true       { background : green; }
   .BOX .document_area .dataArea .dataTable table #rowData td          { text-align : center; }
   .BOX .document_area .dataArea .dataTable table #inputLine td        { margin : 0;  padding:0;   height:27px; text-align:center;}
    .BOX .document_area .dataArea .dataTable table #inputLine .inputTEXT
   {  margin : 0;  padding:0px; padding-bottom:0px; width:100%; height :27px; outline:none; border:none; background:white; text-align:center;}

   .BOX .document_area .dataArea .dataTable table #inputLine .inputTEXT:hover { border-bottom : 1px solid green; width:100%; }
   .BOX .document_area .dataArea .dataTable table #inputLine .inputTEXT:focus { background : yellow; }   

   .BOX .document_area .dataArea .setting .setting_Table             { width : 1700px;   border : 1px solid black;   border-bottom : none;   }
   .BOX .document_area .dataArea .setting .setting_Table tr:first-child{ text-align : center; }

   #sub {
      width : 10px;
      height : 10px;
      background : green;
      border-radius : 40%;
   }
</style>

<script type="text/javascript">
   
   // 자동 완성 기능을 위한 배열 변수
   var autoComplete_text = new Array();

   // Event를 위해서 만들어 놓은 전역 변수
   var elements = null;
   
   // No : countting
   var count = 0;
   
   // column change Color
   var line = 0;

   var am = ""; // all_money 
   var um = ""; // use_money
   var rm = ""; // remain_money
   function autoComplete(){
      
   }

    $(function(){

    //   $(".date").flatpickr({
    //      dateFormat: "y.m.d"
    //   });

      // 누르는 값에 따라 실시간 DB 조회 혹은 등등 function을 위해 남겨 놓은 코드
      elements = document.querySelectorAll('input[class="inputTEXT"]');
      for(var i=0; i<elements.length; i++){
         elements[i].addEventListener('click',action);
      }

      $(".exit").on("click",function(event){
         if(!$(event.target).hasClass("detail_area")){
            $(".del").remove();           
            $(".detail_area").hide(220);
            $(".Tqiwrcmdqiw125qiehawqf4531").hide();
         }
      });

      $(".approb").on("click",function(event){
         if(!$(event.target).hasClass("detail_area")){
            var state = $('.modal_hidden2').attr('value');
            if(state!=50){
            $var = confirm('용역의 상태를 다음으로 진행시키시겠습니까?');
            }else{
                $var = false;
                alert('이미 완료된 용역입니다.');
            }
            if($var){
                var hidden = $('.modal_hidden').attr('value');
                $(".del").remove();           
                $(".detail_area").hide(220);
                $(".Tqiwrcmdqiw125qiehawqf4531").hide();    



                    $.post('../ajax_code_generator/ajax_detail_interface4_1.php?list_num='+hidden,function(data){
                       // table : detail_table tr 밑에 붙여야된다.
                       alert('용역 상태가 변경되었습니다.')
                       state_activity_2(0,hidden,0);
                    });
                 


            }

         }
      });


      $("#sub_add").on("click",sub_add);
   })

   // 실제 action 되는 함수
   function action(event){
      //console.dir(event);
   }

   // 상태 필드를 클릭하면 해당 필드의 상세 정보를 볼 수 있도록 하려고 했으나
   // tr 단위로 클릭하면 볼 수 있게 수정해야 할 것이다.
   function state_activity(obj,n,t){
      $.post('../ajax_code_generator/ajax_detail_interface4.php?list_num='+n,function(data){
         // table : detail_table tr 밑에 붙여야된다.
         $(".detail_table").remove();
         var t = $(".dataTable").offset().top;
         var l = $(".dataTable").offset().left;

         // .offset().top;
         $(".testDIV").css({
            "top" : t,
            "left" : l+30
         })
         
         $(".Tqiwrcmdqiw125qiehawqf4531").css({
            "width" : "200%",
            "height" : "100%",
            "z-index" : "5",
            "background" : "white",
            "position" : "absolute",
            "top" : "0",
            "left" : "0",
            "opacity" : "0.6"
         });

         $(".Tqiwrcmdqiw125qiehawqf4531").show();

         $(".testDIV").css({
            "z-index" : "6"
         });
         $(".detail_table").append(data);
         $(".detail_area").show(220);
      });
   }

   function state_activity_2(obj,n,t){
      $.post('../ajax_code_generator/ajax_detail_interface4_2.php?list_num='+n,function(data){
         // table : detail_table tr 밑에 붙여야된다.
         $(".data").remove();
         var t = $(".dataTable").offset().top;
         var l = $(".dataTable").offset().left;

         // .offset().top;
         $(".testDIV").css({
            "top" : t,
            "left" : l+30
         })
         
         $(".Tqiwrcmdqiw125qiehawqf4531").css({
            "width" : "200%",
            "height" : "600%",
            "z-index" : "5",
            "background" : "white",
            "position" : "absolute",
            "top" : "0",
            "left" : "0",
            "opacity" : "0.6"
         });



         $(".Tqiwrcmdqiw125qiehawqf4531").show();

         $(".testDIV").css({
            "z-index" : "6"
         });
         $(".detail_table").append(data);
         $(".detail_area").show(220);
      });
   }
   
   //특수문자, 날짜 정규화
   function regExp(string){
      var str = string;
      var regExp = /[\{\}\\/?,.;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/gi;
      
      if(regExp.test(str) ){
         alert("특수 문자는 제한 됩니다.");
         return false;
      }
      return true;
   }

   // 추가 버튼 함수
   function insertData(){
      
      // field라는 name을 가지고 있는 모든 element들을 배열 형태로 fields에 담는다.
      var data = [];
      var fields = document.getElementsByName("field");

      for(var i=0; i<fields.length; i++){
         var field = fields[i];
         if(field.value.trim() == "" || field.value.trim() == null ){
            alert("빈 칸이 있습니다.");
            $("#"+field.id).focus();
            return;
         }
      }

      // 특수 문자 유효성을 검증하기 위한 함수입니다.
      for(var i=0; i<fields.length; i++){
         if(!regExp(field.value.trim())){
            $("#"+field.id).focus();
            return;
         }
      }

      var sel = $(".depart");
      for(var i=0; i<sel.length; i++){
         if(sel[i].value==0){
            
         }
      }

      // 그리고 각 element들의 value 값을 배열 data에 담는다.
      for(var i=0; i<fields.length; i++){
         data[i] = fields[i].value;
      }

      // 위 두 단계에 걸쳐 데이터만 존재하는 배열을 ajax 함수 인자에 추가한다.
      $.post('../ajax_code_generator/ajax_detail_interface4.php?data='+data+"&count="+count+"&line="+line,function(data){      
         // append 와 반대로 앞에 추가된다.
         $("#inputLine").before(data);
         
         count++;

         // tr 별로 색상 바꾸기 flag
         if(line==0){ line=1; }else{ line=0;   }
         
         // 입력 필드를 초기화 한다.
         for(var i=0; i<fields.length; i++){
            fields[i].value="";
         }

         // 여러개의 .rowData 중에서 마지막번째 tr 중 클래스 .m을 가진 element들을 배열로 가져온다.
         var _m = $(".rowData:last>._m");
         
         // String Data 이면서 ','가 추가 되어 있기 때문에 ','를 지우고 형변환 후에 전역 변수 am,um,rm에 add한다.      
         am=parseInt(am)+parseInt(_m[0].textContent.replace(",",""));
         um=parseInt(um)+parseInt(_m[1].textContent.replace(",",""));
         rm=parseInt(rm)+parseInt(_m[2].textContent.replace(",",""));
         
         var m_arr = [ am, um, rm] ;
         for(var i=0; i<3; i++){
            // 위 에서 합산된 데이터를 sum 필드에 초기화 하기 전에 ','를 붙여주는 작업을 한다. function numberWithCommas()
            $(".tm").eq(i).html(numberWithCommas(m_arr[i]));
         }
      });
   }
   
   // 화폐 단위 마다 콤마(,)를 찍기 위한 정규식 사용 함수
   function numberWithCommas(x) {
       return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }

   var oldObj = "";
   var state = "";
   var kind = "DESC";

   function order(obj,comm){
   
      if(oldObj!=obj){
         $(oldObj).val("▲");
      }
      oldObj = obj;

      if($(obj).val()=="▲"){
         state = "▼";
         kind = "DESC";
      }else{
         state = "▲";
         kind = "ASC";
      }
      orderBy(kind,comm);
      $(obj).val(state);      
   }

   function orderBy(kind,comm){
      $.post('../ajax_code_generator/ajax_detail_interface4.php?order='+kind+'&col='+comm+"&count="+count+"&line="+line,function(data){      
         $(".rowData").remove();
         $("#inputLine").before(data);
      });
   }

   // 실시간 DB 검색을 통한 자동완성 함수 : 대상 발주처, 발주감독, 영업담당, 담당팀, 당담팀장
   // 미 구현 . 초성 불러오기는 되나 합성 글자 불가
   function real_time_user(obj,str){      
      $.post('../ajax_code_generator/ajax_detail_interface4.php?search='+str,function(data){   
         var test = data.split(' ');
         console.log(data);
         $(obj).autocomplete({
            //source : test
         });
      });
   }
   function sub_add(){
      console.log(1111111);
   }

</script>