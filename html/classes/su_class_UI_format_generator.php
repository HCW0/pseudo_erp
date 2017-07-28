<?php

    class su_class_UI_format_generator{

            function su_function_get_title($logo_name,$myname,$myposi,$mydepart,$home_name){


                //로고
                echo "<div>";
            	echo "<H1 align='center'><font size='6px'><strong />$logo_name</font></H4>";



                       
                            echo "<div style='float:left;'>";
                            
                                echo "현재일 : ";
                                echo date("Y-m-d");
                                $date = date("Y-m-d");
                                echo " / ( ";
                                $parts = explode('-',$date);
                                echo "  ".date("W")." 주차 )";
                                echo "<br />";
                            
                            
                            
                            echo "</div>";

                            echo "<br />";
                            echo "<a href='./su_script_home_key.php?home=$home_name')'><img src='./src/HOME.png'/ width=5% height=5% style='float:right;'></a>";
                            echo "<div style='float:left;'>";
                             
                           

                                                echo "부서명 : $mydepart";
                                                echo "<br />";
                                                echo "직책명 : $myposi";
                                                echo "<br />";
                                                echo "유저명 : $myname";
                                                echo "<br />";                                                       
                            echo "</div>";

                            
                                    echo "<br />";
                                    echo "<br />";
                                    echo "<br />";
                                    echo "<br />";
                                    echo "<br />";

                            
                echo "</div>";
                return;
            }
          

    }

?>