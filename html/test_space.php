<?php
   session_start();

// 유저 세션 검증
   if(!isset($_SESSION['is_login'])){
      header('Location: ./su_script_logout_support.php');
   };

// include function
     function my_autoloader($class){
         include './classes/'.$class.'.php';
    }
 spl_autoload_register('my_autoloader');

//db 연결 파트
        $conn = mysqli_connect('localhost','root','9708258a');
        if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
           header('Location: ./su_script_login_interface.php');
        }
        $use = mysqli_select_db($conn,"suproject");
        if(!$use) die('cannot open db'.mysqli_error($conn));

//php 객체 생성파트
      $ob2 = new su_class_value_name_convert_with_code();
      $ob_tg = new su_class_db_view_generator();
?>

<!DOCTYPE>
<head> 
<meta charset="utf-8"> 
<title>공정표</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<style type="text/css">
body { margin : 0px; padding : 0px; background : ivory}
ul   { margin : 0px; padding : 0px; list-style-type : none;}



table {
      width: 100%;
      border-top: 1px solid #444444;
      border-collapse: collapse;
}
td,th {
      border-bottom: 1px solid #444444;
      padding: 1px;
      text-align: center;
      vertical-align: middle;
}



.search_Views .subject li input[type=button]{
   font-size : 5px;
   margin : 0;
   padding : 0;
}
.search_Views .data li input[type=button]{
   border : 0;
   outline : 0;
   background : none;
   color : blue;
   float : left;
   font-size :16px;
}

.process_table_Contanier {
   margin : 0px;
   padding : 0px;
}

.issue_Planning_Container {
   width : 100%;
   height : 100%;
}
.issue_Planning_View {
   width : 1100px;
   height : 500px;
   margin : 0 auto;
   background : ivory;
}
.search { clear : both;}
.search>li { float : left; margin-right : 10px;}
.search>li>input[type=radio] {
   margin : 0px;
   padding : 0px;
}
.search_Option {
   width : 1000px;
   padding : 0px;
   margin-bottom : 50px;
}
.search_Views {
   clear : both;
   width : 100%;
   display : block; 
   background : white;
   overflow-x: auto;
   overflow-y: auto; 
}

.search_Views>table {
      width : 6666px;
      height : 100%;
      border-collapse: collapse;
  
}

.search_Views .subject {
   
}
.search_Views .subject>th:first-child{
   border-left : 1px solid black;
}
.search_Views .subject>th{
   float : left;
   width : 145px;
   border : 1px solid black;
   border-left : none;
   text-align : center;
   background-color : gray;
}
.search_Views .data>td{
   float : left;
   width : 145px;
   border : 1px solid gray;
   border-left : none;
   border-top : none;
   text-align : center;
}
.search_Views .data .col:first-child{
   border-left : 1px solid black;
   text-align : right;
}

.search_Views .data .col span {
   padding-right : 3px;
}



</style>

<script type="text/javascript">
   $(function(){
      var data;
      <?php
                 
            $result = $ob_tg->su_function_throw_table_name($conn,'task_document_header_table');   

           
            
            echo "$('.search_Views').append(\"$result\");";
         
      ?>
   });

   // Event function : input tag click [radio]
   function fun_input(obj,data){
      fun_radio_event(obj.id);
   }

   // input[type=radio] tag event function
   // 기준시간 주간/월간/년간 코드(value) 값으로 검색할 수 있다.
   function fun_radio_event(id){
      console.log($("#"+id).val());
   }

   // select onchange 될 때마다 선택한 값을 가져온다.
   function select_event(obj){
      console.log(obj.value);
   }

   // ajax 비동기 통신을 이용한 실시간 데이터 전송 및 데이터 변환
   function planning_Detail_Page(obj,id){
      $.post('',id,function(JsonData){
         
      });
   }
</script>
</head>

<body>
   <!--큰 그림 안에 표현 하려고 하는 것의 공간 DIV  -->
   <div class="issue_Planning_Container">
      <!--   -->
      <div class="issue_Planning_View">
         <div class="search_Option">
            <ul class="search">
               <li>
                  <label>보안 등급</label>
                  <select onchange="select_event(this)">
                     <option>전체</option>
                     <option>특급</option>
                     <option value=1>1급</option>
                     <option value=2>2급</option>
                     <option value=3>3급</option>
                     <option value=4>4급</option>
                     <option value=5>5급</option>
                     <option value=6>6급</option>
                  </select>
               </li>

               <li>
                  <label>주 거래처</label>
                  <select onchange="select_event(this)">
                     <option>전체</option>
                     <option>한국전력공사</option>
                     <option>한국지리공사</option>
                     <option>한국도로교통</option>
                     <option>원자력발전소</option>
                  </select>
               </li>

               <li>
                  <label>발주 금액</label>
                  <select onchange="select_event(this)">
                     <option>전체</option>
                     <option value=1>1백만~1천만</option>
                     <option value=3>1천만~3천만</option>
                     <option value=7>3천만~7천만</option>
                     <option value=10>7천만~10천만</option>
                     <option value=90>10천만~90천만</option>
                  </select>
               </li>
            </ul>

            <ul class="search">
               <li>
                  <label>기준시간</label>
                  <input type="radio" name="cal" id="r1" value="7"  onclick="fun_input(this,this.value);">  <label for="r1">주간</label>
                  <input type="radio" name="cal" id="r2" value="31" onclick="fun_input(this,this.value);">  <label for="r2">월간</label>
                  <input type="radio" name="cal" id="r3" value="365"  onclick="fun_input(this,this.value);">  <label for="r3">년간</label>
               </li>

               <li>
                  <label>달력</label>   
               </li>
            </ul>
         </div>

         <div class="search_Views">
            
         </div>
      </div>
   </div>
</body> 
</html>