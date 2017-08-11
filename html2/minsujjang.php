<!DOCTYPE html>
<!--
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

		$notice_id = $_GET['notice_id'];

			$task_table_query = "select * from notice_document_header_table u where u.notice_id = $notice_id ;";
			$result_set = mysqli_query($conn,$task_table_query);
			$row = mysqli_fetch_array($result_set)
			

?>

-->
<html>
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script type="text/javascript" src="nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
			
			
			<title>글쓰기</title>
			
			
			<style>
					@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
					body {
						font-family: 'Nanum Gothic', sans-serif;
					}
					
					ul,li{list-style:none;}

					#TopSlider{align:center; margin:0px 0px 0px 630px;width:650px; height:300px; border:1px solid #d2d2d2;}
					#TopSlider div{ width:650px;height:300px; float:left; visibility:hidden; position:absolute;}
					#top_0{background-color:white;}
					#top_1{background-color:white;}
					#top_2{background-color:white;}
					#top_3{background-color:white;}

					#ul_btns{float:left;margin:0px 0px 0px 630px; width:650px; text-align:center; }
					#ul_btns a{float:left; width:130px; border:2px solid #e0e0e0;}
					#ul_btns .on{background-color:ivory;}

					#footer{ margin:200px 0px 0px 0px;}
					#wrapper{ align:center;}


					html,body{
					 
					}
					body{
					  text-align:center;
					}
					body:before{
					  content:'';
					  height:100%;
					  display:inline-block;
					  vertical-align:middle;
					}
					button{
					  background:#1AAB8A;
					  color:#fff;
					  border:none;
					  position:relative;
					  height:60px;
					  font-size:1.6em;
					  padding:0 2em;
					  cursor:pointer;
					  transition:800ms ease all;
					  outline:none;
					}
					button:hover{
					  background:#fff;
					  color:#1AAB8A;
					}
					button:before,button:after{
					  content:'';
					  position:absolute;
					  top:0;
					  right:0;
					  height:2px;
					  width:0;
					  background: #1AAB8A;
					  transition:400ms ease all;
					}
					button:after{
					  right:inherit;
					  top:inherit;
					  left:0;
					  bottom:0;
					}
					button:hover:before,button:hover:after{
					  width:100%;
					  transition:800ms ease all;
					}
			</style>
			
			
			<script   
					src="https://code.jquery.com/jquery-3.0.0.min.js" 
				    integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="   
					crossorigin="anonymous">
			</script>
		
		<script>
 
    var intv;
    var current = 0;
    var sIdx = 0;
    var sCnt =  4;
    
 
    function startTopSlider() {
        intv = setInterval(function () {
            $("#ul_btns").find("a").eq(current++ % sCnt).click();
        }, 3000);
    }
 
    function setBnr(idx, bnr, allTab, addCls) {
        $(bnr).css("visibility", "hidden")
              .eq(idx).css("visibility", "visible");
        $(allTab).removeClass(addCls);
        $(allTab).eq(idx).addClass(addCls);
    }
 
    $(document).ready(function () {
        
        //set init
        $("#top_0").css("visibility", "visible");
        $("#btn_0").addClass("on");
        startTopSlider();
        
        
        $("#ul_btns").find("a").click(function(){
            var idx = $(this).attr("id").split("_")[1];
            setBnr(idx, "#TopSlider > div" , "#ul_btns > a" , "on" );
            
        });
 
        
    });
</script>

	

	</head>


	<body style="background-color:ivory; text-align:center;">

	<div id="wrapper">
	
	<p align="center"><img src="./src/su_rsc_sulogo_a.png" width="200" height="100" title="선운로고"/></p>
		
			<p align="center">공 지 사 항</p>
		    <div id="TopSlider" style="background-color:ivory; ">
			
        <div id="top_0">내용1</div>
        <div id="top_1">내용2</div>
        <div id="top_2">내용3</div>
        <div id="top_3">내용4</div>
    </div>
    <div id="TopSliderBtn" style="background-color:ivory">
        <ul id="ul_btns">
			
            <a href="#" id="btn_0"><li>●</li></a>
            <a href="#" id="btn_1"><li>●</li></a>
            <a href="#" id="btn_2"><li>●</li></a>
            <a href="#" id="btn_3"><li>●</li></a>
        </ul>
    </div>
	<h1 align="center">&nbsp</h1>
	<div align="center">

	<button type="button" onclick="location.href='">업무관리</button>
	<button type="button" onclick="location.href='">결재관리</button>
	<button type="button" onclick="location.href='">공지사항</button>
	<button type="button" onclick="location.href='https://www.naver.com/'"> 설&nbsp&nbsp&nbsp&nbsp 정 </button>

		
	</div>
	<div id="footer">
				<p class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED 연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		</div>


	</body>
</html>