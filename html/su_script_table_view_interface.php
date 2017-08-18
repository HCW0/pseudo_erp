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

	$ob2 = new su_class_value_name_convert_with_code();


    $id = $_GET['id'];
    $type = $_GET['type'];


    switch($type){

        case -1:
        $task_document_button_head = '일일';
        break;

        case 0:
        $task_document_button_head = '주간';	
        break;

        case 1:
        $task_document_button_head = '월간';		
        break;

        case 2:
        $task_document_button_head = '연간';		
        break;

}










?>




<!DOCTYPE html> 
<html lang="ko"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>일일업무보고일지</title>
<style type="text/css">

    @page a4sheet { size:22.0cm 29.7cm}

    table {
        margin :0;
        padding : 0;
    }

   .header {     
        border-collapse:collapse;   
        border-top : 4px double black;
        border-bottom : none;
        border-left : 4px double black;
        border-right : 4px double black;
        margin : 0;
        padding : 0;
        width : 100%;
        height : 110px;
    }

    .header td {
        border : 1px solid black;
    }

    .content {
        width : 100%;
        border-collapse:collapse;   
        border-top : none;
        border-bottom : 4px double black;
        border-left : 4px double black;
        border-right : 4px double black;
        height : 800px;
    }

    .content td {
        border : 1px solid black;
    }


    .title {
        text-align : center;
        font-weight : bold;
    }

    .title_data {
        text-align : center;
    }
    .sub_title {
        font-weight : bold;
    }

    .rec1{
        width : 12%;
        height : 100px;
        border : 1px solid black;
        border-right : none;
        float : right;
        margin-bottom : 10px;
    }

    .rec2 {
        border-right : 1px solid black;
    }

    .rec3 {
        width : 62%;
        height : 100px;
        border : none;
        float : left;
        margin-bottom : 10px;
        letter-spacing:10px;
        text-align : center;
         line-height: 100px;
         font-size: 24pt;
         font-weight: bold;
    }

    h2 {
        float : left;
    }

    .position {
        border-bottom : 1px solid black;
        text-align : center;
    }



</style>

<script>
    var title = "";
    var contents = "";
</script>
 </head> 
 <body> 
    <div>


            <div width=100%>    
                <div class="rec3"><?php echo $task_document_button_head."업무일지"?></div> 
                <div class="rec1 rec2"><div class="position">부서장</div></div>
                <div class="rec1"><div class="position">본부장</div></div>
                <div class="rec1"><div class="position">대표이사</div></div>
            </div>
            <div width=100%>
                <table class="header">


                    <tr class="title">
                        <td>작성일</td>
                        <td>부서명</td>
                        <td>직급</td>
                        <td>성명</td>
                    </tr>
                    <tr class="title_data">
                        <?php
                            echo "<td width='28%'>".$_SESSION['now_date']."</td>";
                            echo "<td width='24%'>".$ob2->su_function_convert_name($conn, "master_department_info_table", "sid_combine_department", $_SESSION['my_department_code'], "master_department_info_name")."</td>";
                            echo "<td width='24%'>".$ob2->su_function_convert_name($conn, "master_position_info_table", "sid_combine_position", $_SESSION['my_position_code'], "master_position_info_name")."</td>";
                            echo "<td width='24%'>".$ob2->su_function_convert_name($conn, 'master_user_info_table', 'SID', $id, 'master_user_info_name')."</td>";
                        ?>
                    </tr>
                    <tr class="sub_title">
                        <td style="text-align:center;"> 프로젝트 </td>
                        <td colspan="3"> 계획 - 분석 - 설계 - 개발 - 완료 </td>
                    </tr>
                </table>

                <table class="content">
                    <tr>
                        <td width="3%" style="padding-left: 23px; padding-right: 25px; text-align:center;">명일업무진행</td>
                        <td width="30%">
                            <?php
                                //task_document_header_table 에 있는 task_orderer 필드 값을 가지고 나의 네임으로 master_user_info_table name으로 조회 후  SID 값을 가진다.
                                // 그 후에는 위 테이블에서 나의 것과 오늘 날짜로 있는 것 중에서 
                                // task_name(제목)과 etcetera(내용) 를 가져와야 한다.
                                $req_myName = $_REQUEST['id'];
                                $today = date("Y-m-d");

                                $title = array();
                                $contents = array();
                                $count = 0;

                                $select = "SELECT DISTINCT  th.task_name, th.etcetera from task_document_header_table th , master_user_info_table mu 
                                        WHERE  th.task_orderer = (select SID from master_user_info_table where master_user_info_name = '$req_myName' ) AND
                                        th.task_birth_date = '$today'";

                                $result = mysqli_query($conn,$select);  
                                while($row=mysqli_fetch_array($result))
                                {
                                    $title[$count] = $row[0];
                                    $contents[$count] = $row[1];
                                    $count++;
                                }       
                                
                                $title_count = 1;
                                for($i=0; $i<count($title); $i++){
                                    echo "
                                        $title_count. $title[$i] <br />\n
                                        </t>- $contents[$i] <br />\n
                                        ";
                                        $title_count++;
                                }
                            
                                
                                //echo json_encode($title,JSON_UNESCAPED_UNICODE);
                            ?>
                        </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                    </tr>

                    <tr>
                        <td width="3%" style="padding-left: 23px; padding-right: 25px; text-align:center;">금일계획</td>
                        <td width="60%">
                            


                        </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                    </tr>

                    <tr height="20%">
                        <td width="10%" style="padding-left: 23px; padding-right: 25px; text-align:center;">비고</td>
                        <td width="60%">
                            <?php
                            ?>
                        </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                    </tr>
                </table>
            </div>
    </div>
 </body> 
 </html>

