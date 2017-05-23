<?php
  class JS
  {
    public static function print(){
      $printme = addslashes(implode(func_get_args()));
      echo "<script>console.log(\"$printme\");</script>";

    }
  }
?>