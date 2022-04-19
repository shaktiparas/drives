<?php
//echo $graphData[0]['month'];
//echo $graphData[1]['tcount'];

//print_r($graphData);
foreach($graphData as $graph)
{
    $months[$graph['month']]=$graph['tcount'];
}
//print_r($months);
if(!empty($months[0])){ echo "1 =".$months[0] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[1])){ echo "2 =".$months[1] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[2])){ echo "3 =".$months[2] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[3])){ echo "4 =".$months[3] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[4])){ echo "5 =".$months[4] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[5])){ echo "6 =".$months[5] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[6])){ echo "7 =".$months[6] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[7])){ echo "8 =".$months[7] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[8])){ echo "9 =".$months[8] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[9])){ echo "10 =".$months[9] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[10])){ echo "11 =".$months[10] ."<br>"; }else{ echo 0 ."<br>"; }
if(!empty($months[11])){ echo "12 =".$months[11] ."<br>"; }else{ echo 0 ."<br>"; }

/*for($i=0;$i < 12; $i++)
{
    if($montharray[$i] == $i)
    {
        $count['month']=$i;
        $count['count']=$montharray['tcount'];
    }
    else
    {
        $count['month']=$i;
        $count['count']=0; 
    }
    
}*/
die;
?>