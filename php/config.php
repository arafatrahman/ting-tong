<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chatapp";

  define("DB_HOST", "localhost");
  define("DB_USER", "root");
  define("DB_PASSWORD", "");
  define("DB_DATABASE", "chatapp");

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }

  function get_db_connect(){
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    return $con;
  }

  function escape_string($val){
    $value = mysqli_real_escape_string(get_db_connect(), $val);
    return $value;
  }

  function db_query_execute($query){
    $result = mysqli_query(get_db_connect(),$query);
    return $result;
  }

  function db_query_numrow($query_data){
    $query_rows = mysqli_num_rows($query_data);
    return $query_rows;
  }
  function fetch_assoc($query_data){
    $query_rows = mysqli_fetch_assoc($query_data);
    return $query_rows;
  }

?>
