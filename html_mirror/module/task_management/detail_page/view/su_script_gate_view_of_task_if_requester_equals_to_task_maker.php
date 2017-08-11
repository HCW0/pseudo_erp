
  <?php
       session_start();


            $level = $_GET['level'];
            $sub_level = $_GET['sub_level'];
            $tid = $_GET['tid'];
            


            echo "검색하려는 업무 코드";
            echo "<br />";
            echo $level;
            echo "<br />";
            echo "검색하려는 업무 서브 코드";
            echo "<br />";
            echo $sub_level;
            echo "<br />";
           

          	
          $_SESSION['current_focused_TID'] = $tid;
                  

            header('location: ./su_script_view_of_task_interface_if_requester_equals_to_task_maker.php?tid='.$tid);

    ?>


