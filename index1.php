<?

if($mb && $sb && $t1 && $t2 && $t3 && $t4 && $h1 && $f1 && $w1 && $w2 && $e1){

   $mb = $mb - 1;
   $sb = $sb - 1;
   $t1 = $t1 - 1;
   $t2 = $t2 - 1;
   $t3 = $t3 - 1;
   $t4 = $t4 - 1;
   $h1 = $h1 - 1;
   $f1 = $f1 - 1;
   $w1 = $w1 - 1;
   $w2 = $w2 - 1;
   $e1 = $e1 - 1;
                   
   $data=$mb+$sb+$t1+$t2+$t3+$t4+$h1+$f1+$w1+$w2+$e1;
   $data=$data%2;
   if($data!=$p){
      echo "err";
      $time_data=date("Ymd-His");
      $file_pointer = fopen("err.txt", "a");
      $text="$time_data-$REMOTE_ADDR-$mb-$sb-$t1-$t2-$t3-$t4-$h1-$f1-$w1-$w2-$e1-$p(Parity error)#\n";
      fwrite($file_pointer, $text);
      fclose($file_pointer);    
   }  
   else if($data==$p){
      $time_data=date("Ymd-His");
      $file_pointer = fopen("data.txt", "a");
      $text="$time_data-$REMOTE_ADDR-$mb-$sb-$t1-$t2-$t3-$t4-$h1-$f1-$w1-$w2-$e1-$p#\n";
      fwrite($file_pointer, $text);
      fclose($file_pointer);    
      $file = file_get_contents('./control.txt', true);

      $file = split("#",$file);
      $data=$file[0]+$file[1]+$file[2]+$file[3];

      $data=$data%2;
      if($data) $data=1;
      else if(!$data) $data=0;
      $text="@$file[0]$file[1]$file[2]$file[3]$data";  
      echo $text;
      
   }
}
else {
      echo "err";
      $time_data=date("Ymd-His");
      $file_pointer = fopen("err.txt", "a");
      $text="$time_data-$REMOTE_ADDR-$mb-$sb-$t1-$t2-$t3-$t4-$h1-$f1-$w1-$w2-$e1-$p(Data loss)#\n";
      fwrite($file_pointer, $text);
      fclose($file_pointer);    
}
?>
