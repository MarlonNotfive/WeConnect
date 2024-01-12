<?php
    if(isset($_POST['landing-save'])){
        if(isset($_FILES['img'])){
            $img_name = $_FILES['img']['name'];
            $img_type = $_FILES['img']['type'];
            $temp_name = $_FILES['img']['tmp_name'];

            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);

            $extensions = ['png', 'jpeg', 'jpg'];
            if(in_array($img_ext, $extensions) === true){
                $time = time();

                $new_image_name = $time.$img_name;
                if(move_uploaded_file($temp_name, '../client/assets/image/announcement/'.$new_image_name)){
                    
                }

            } else {
                echo "invalid image -jpg, jpeg, png only";
            }

        } else {
            echo "No image";
        }

    } else {

    }
?>