<?php

        $sql = "SELECT COUNT(*) as n FROM stats WHERE (page='struttura' OR page='partner') AND idPage='$id'  ";
        $mydb->DoSelect($sql);
        $rtmpu = $mydb->GetRow();
        $visiteTot = $rtmpu['n'];
        
        $sql = "SELECT counter FROM affiliati WHERE  id ='$id'  ";
        $mydb->DoSelect($sql);
        $rtmpu = $mydb->GetRow();
        $visiteTot += $rtmpu['counter'];
        


switch($periodo)
{

    case "mese":
    {

	$giornimese = $nstep= giornimese($mese,$year);

				$datefrom = "$year-$mese-01";
                                
			        $dateto = "$year-$mese-$giornimese";

				$datestart = $datefrom." 00:00:00";
				$stepdata = 86400;
				$a = explode("-", $datefrom);

				$tdstart = $tstart = mktime(0,0,0, $a[1], $a[2], $a[0]);

				$title = mese($mese)." ".$year;

            $sql = "SELECT COUNT(*) as n FROM stats WHERE (page='struttura' OR page='partner')  AND idPage='$id' AND data_ins>= '$datefrom' AND data_ins<='$dateto'  ";
            $mydb->DoSelect($sql);
            $rtmpu = $mydb->GetRow();
            $visitefull = $visitenew  = $rtmpu['n'];

    } break;

    case "multimese":
    {
        
                    $a_da = explode("_",$ymeseda);
                    $a_a  = explode("_",$ymesea);
                    
                    $m_da = $a_da[1];
                    $y_da = $a_da[0];
                    
                    $m_a = $a_a[1];
                    $y_a = $a_a[0];
                    
                    $nstep2 = giornimese($m_a, $y_a);

                        $datefrom = "$y_da-$m_da-01";
                        $dateto = "$y_a-$m_a-$nstep2";
                        
                        $dstart = $datefrom;
                        $dend = $dateto;

				$datestart = $datefrom." 00:00:00";
				$stepdata = 86400;
				$a = explode("-", $datefrom);

				$tdstart = $tstart = mktime(0,0,0, $a[1], $a[2], $a[0]);
                                
                                $continue = true;$i=0;
                                $months=1;
                                $dend_ = "$y_a-".str_pad($m_a,2,"0",0)."-$nstep2";
                                $oldm = $m_da;
                                while($continue)
                                {
                                    $d = Date("Y-m-d",strtotime($dstart." +".$i." day"));
                                    if($d==$dend_ || $i>365)$continue=false;
                                    $i++;
                                    if(substr($d, 5,2)!=$oldm) {
                                        $months++;
                                        $oldm = substr($d, 5,2);
                                    }
                                    //echo $d."<br>";
                                }
                                $nstep=$i;

                                 $rt = floor($nstep/31)+1;

				$title = mese($m_da)." ".$y_da." - ".mese($m_a)." ".$y_a."";


            $sql = "SELECT COUNT(*) as n FROM stats WHERE (page='struttura' OR page='partner')  AND idPage='$id' AND data_ins>= '$datefrom' AND data_ins<='$dateto'";
            $mydb->DoSelect($sql);
            $rtmpu = $mydb->GetRow();
            $visitefull = $visitenew  = $rtmpu['n'];
            



    } break;
    
}


$strDatanew = "";
$strDataFull = "";
$labels = "";
#$strUtenti = "";
#$strUtentiNew = "";
#$strDurata = "";

        
$ia = 0;
if(1)
while($ia<$nstep)
{
    $tdend = $tdstart+$stepdata;



	$dstart = Date("Y-m-d H:i:s", $tdstart);
	$dend   = Date("Y-m-d H:i:s", $tdend);



	$Ystart = Date("Y", $tdstart);
	$mstart = Date("m", $tdstart);


    	$dstart_ = substr($dstart,0,10);
    	$dend_  = substr($dend,0,10);
        
        if($ia>0) {

        $strDataFull .= ",";
    	$strDatanew .= ",";
    	$labels .=  ",";
    	#$strDurata .= ",";
        #$strUtenti .= ",";
        #$strUtentiNew .= ",";
        }

        
        $sql = "SELECT COUNT(*) as n FROM stats WHERE (page='struttura' OR page='partner')  AND idPage='$id' AND  data_ins>= '$dstart_' AND data_ins<'$dend_'  ";
        $mydb->DoSelect($sql);
        $rtmpu = $mydb->GetRow();

        $strDataFull .= $rtmpu['n'];
        
             

        $ii = $ia+1;
        
            if($periodo=="mese") $labels .= "'".Date("d", $tdstart)."'";
             elseif($periodo=="multimese") {
                 ##$rt = floor($nstep/31);
                 if($ii%$rt==0)$labels .= "'".Date("d", $tdstart)."'";
             }    
        
        
    $day = Date("d", $tdstart);    
    $tdstart = $tdend;
    

    if(Date("d", $tdstart)==$day) {
        $tdstart = $tdstart + 3600;
        #$tdend = $tdend + 3600;
    }
	


             
        $ia++;
        echo "<!-- $ia ".Date("d H:i", $tdstart)." $tdstart ($stepdata) -->\n";
}

