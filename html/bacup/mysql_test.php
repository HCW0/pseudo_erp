<table border='1'>
    <tr align='center'>
        <td>
            <p>ID</p>
            </td>
        <td>
            <p>URL</p>
            </td>
        <td>
            <p>DESCRIPTION</p>
            </td>
        <td>
            <p>DELETE/MODIFY</P>
            </td>
    </tr>

<?php

    $conn2 = mysqli_connect('localhost','root','9708258a');
    if(!$conn2){
        die('cannot connect DB :' .mysqli_error($conn2));
    }

    $selDb = mysqli_select_db($conn2,'suproject');
    if(!$selDb){
        echo "DB가 존재하지 않습니다.";
    }

?>
            
        