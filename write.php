<?php
if($control_data){
    $file_pointer = fopen("control.txt", "w");
    fwrite($file_pointer, $control_data);
    fclose($file_pointer); 
}
include_once "./info.htm";
?>

