<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

    td{padding: 0 5px;}

    table{border: 1px solid #000;font-family: "Courier New"}

    h2{margin: 0}

    h3{margin: 10px 0 0 0}

    .jwb td{color: #00f;font-size:10px;padding:0 15px 0 0}
	.deret{ width:15px; text-align:center; color: blue; }
    .readonly{background:#ccc; border:1px solid #666;} div#CountDown {position: relative; left: 430px; margin-bottom: 25px; }
    .timer {text-align:center; width: 120px;background: #34d960; background-image: -webkit-linear-gradient(top, #34d960, #09b523); background-image: -moz-linear-gradient(top, #34d960, #09b523); background-image: -ms-linear-gradient(top, #34d960, #09b523); background-image: -o-linear-gradient(top, #34d960, #09b523); background-image: linear-gradient(to bottom, #34d960, #09b523); -webkit-border-radius: 4; -moz-border-radius: 4; border-radius: 4px; font-family: Arial; color: #ffffff; font-size: 20px; padding: 10px 20px 10px 20px; text-decoration: none; }
    #timer-beep {position: absolute; top: -100000em; }
</style>

</head>

<body>

<?php

$x=(int)$_POST["x"];

$y=(int)$_POST["y"];

?>

<h2>Kraeplin Tes Generator</h2>
<br>
<form action="<?=$PHP_SELF ?>" method="post">

    X <input type="text" name="x" value="<?=$x ?>"><br>

    Y <input type="text" name="y" value="<?=$y ?>"><br>

    <input type="submit" value="create">

</form>
<br><br>
<div class="container">
<div id="CountDown" class="timer" data-deret='1'>
<span class="seconds">5</span> Seconds
</div>
<?php

if($x&&$y){$t=$x*$y; $tt=$t-$x; for($y1=1;$y1<=$y;$y1++){createRandom($x,$y1); } // echo"<h3>Tes</h3>"; show($x,$y,$t,$tt,'soal'); // echo"<h3>Jawaban</h3>"; // show($x,$y,$t,$tt,'jawab'); } function createRandom($x,$y1){$v1=$x*$y1-$x; $data=""; for($x1=1;$x1<=$x;$x1++){$v="v".($v1+$x1); $GLOBALS["$v"]=rand(0,9); } return $data; }
function deretSoalX($x,$y1 $data=""; $xx=$x*$y1-$x; for($x1=1;$x1<=$x;$x1++){$v="v".($xx+$x1); $data.="<td>".$GLOBALS["$v"]."</td><td> </td>"; } return $data; }
function deretJawabX($x,$y1,$p){$data="<td> </td>"; $xx=$x*$y1-$x; $xx1=$x*$y1-$x-$x; for($x1=1;$x1<=$x;$x1++){if($p=='jawab'){$v="v".($xx+$x1); $v1="v".($xx1+$x1); $j=substr($GLOBALS["$v"]+$GLOBALS["$v1"],-1); $data.= "<td>$j</td><td></td>"; } else{$data.= "<td> <input type='text' width='10px' id='deret_".$x1."_".$y1."' class='deret deret_".$x1."' data-y='".$y1."' data-deret='".$x1."' maxlength='1'> </td><td> </td>"; } } return substr($data,0,-15); }
function show($x,$y,$t,$tt,$p){echo "<table>"; for($y1=1;$y1<=$y;$y1++){if($y1>1){echo"<tr class='jwb'>"; echo deretJawabX($x,$y1,$p); echo"</tr>"; } echo"<tr>"; echo deretSoalX($x,$y1); echo"</tr>"; } echo "</table>"; }
?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="timer.js"></script>
<script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
    var deret = $('.deret');
    deret.keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    var length = deret.length; // menghitung total deret 
    for(var x=1;x<=length;x++) {
      if (x > 1) {
        $(".deret_"+x).attr('disabled',true).addClass('readonly'); // disable deret except deret 1
      }
    }

    deret.keypress(function() {
        var y    = $(this).data('y');
        var x    = $(this).data('deret');
         if (y==2) {
            $(".deret_"+(x+1)).attr('disabled',false).removeClass('readonly'); 
            $('#deret_'+(x+1)+'_10').focus(); 
         } else { 
            $('#deret_'+x+'_'+(y-1)).focus(); 
         }
     })


    function TimerForDeret(x,t){
        var sec = t;
        var timer = setInterval(function() { 
           $('#CountDown span').text(sec--);
           if (sec === -1) {
              var xDeret = $('#CountDown').attr('data-deret');
              clearInterval(timer);
              TimerDisableDeret(xDeret);
           }
        }, 1000);
    }

    function TimerDisableDeret(x){
        $('.deret_'+x).each(function() {
            if($(this).val() == '') {
                $(this).attr('disabled',true).addClass('readonly');
                var sumX = eval(x) + eval(1);
                $(".deret_"+sumX).attr('disabled',false).removeClass('readonly'); 
                $('#deret_'+sumX+'_10').focus();
                //console.log(sumX);
            }
        })
        $('CountDown').attr('data-deret',sumX);
        TimerForDeret(sumX,5);
    }

    TimerForDeret (1,5);
    $('#deret_1_10').focus(); // focus deret 1 from bottom

});
</script>
<audio id="timer-beep">
  <source src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/41203/beep.mp3"/>
  <source src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/41203/beep.ogg" />
</audio>

</body>

</html>