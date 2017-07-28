<?php

// include function
     function my_autoloader($class){
         include './classes/'.$class.'.php';
    }

 spl_autoload_register('my_autoloader');



  $ob_test = new test_class();
  $arr = $ob_test->test_method();  

    for($cnt=0;$cnt<count($arr);$cnt++){
                echo $arr[$cnt];
                echo "<br />";
    }

?>


<html>
<head>
    <title><h3> deadman</h3></title>
    </head>
<body>

<p>
    <select id = "dkdk">
        <?php
                $s = array(2,4,5,6,7,8);
        ?>
        <option value = '232' name = 'apple' selected>corn</option>
        <option value = '233' name = 'gag' >dog</option>
        <option value = '234' name = 'longly' >lay</option>
        <option value = '235' name = 'take' >hello</option>
    </select>
</p>
<p id="timezones"></p>
<input type="button" id="execute" value="execute" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    $('#execute').click(function(){
        $.ajax({
            url:'./test_ajax_target.php',
            dataType:'json',
            success:function(data){
                var str = '';
                var cnt = 0;
                for(var name in data){
                    cnt++;
                    str += "<?php
                                 $_SESSION['static_cnt'] = 0;       
                                 echo $arr[$_SESSION['static_cnt']];?>";
                    str += '<li>'+data[name]+'</li>';
                }
                $('#timezones').html('<ul>'+str+'</ul>');
            }
        })
    })
</script>



    <select>

        <option value = '232' name = 'apple' selected>corn</option>
        <option value = '233' name = 'gag' >dog</option>
        <option value = '234' name = 'longly' >lay</option>
        <option value = '235' name = 'take' >hello</option>
        </select>
</body>

</html>