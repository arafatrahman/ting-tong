<?php
    session_start();
    include_once "config.php";
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $fname = escape_string($post['fname']);
    $lname = escape_string($post['lname']);
    $email = escape_string($post['email']);
    $hash = md5( rand(0,1000) );
    $password = escape_string($post['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = "SELECT * FROM users WHERE email = '{$email}'";
            $res = db_query_execute($sql);
            if(mysqli_num_rows($res) > 0){
                echo "$email - This email already exist!";
            }else{
                if(isset($_FILES['image'])){
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];
                    
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);
    
                    $extensions = ["jpeg", "png", "jpg"];
                    if(in_array($img_ext, $extensions) === true){
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time();
                            $new_img_name = $time.$img_name;
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){
                                $ran_id = rand(time(), 100000000);
                                $status = "Active now";
                                $encrypt_pass = md5($password);
                                $insert_query = "INSERT INTO users (unique_id, fname, lname, email, password, img, status,id-hash)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}', '{$hash}')";
                                $res_insert_query = db_query_execute($insert_query);
                               
                                if($res_insert_query){
                                    
                                    $sql2 = "SELECT * FROM users WHERE email = '{$email}'";
                                    $select_sql2 = db_query_execute($sql2);
                                    if(db_query_numrow($select_sql2) > 0){
                                        $result = fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    }else{
                                        echo "This email address not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>