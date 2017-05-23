<?php
  class JS
  {
    public static function print(){
      $printme = json_encode(implode(func_get_args()));
      echo "<script>console.log($printme);</script>";

    }
  }
?>