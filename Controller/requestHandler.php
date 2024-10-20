<?php
    include_once "Controller.class.php";
    include_once "Database.php";
    
    if(isset($_POST['post_product']) || isset($_POST['edit_product']))
    {
        $dbClass = new Database();
        $db = $dbClass->connect();
        $ctrl = new Controller($db);
        $title = $_POST['title'];
        $location = $_POST['location'];
        $date = $_POST['date'];
        $topic = $_POST['topic'];
        $banner = $_FILES;
        // print_r($_POST);

        $fields = [
            'title'=>$title,
            'location'=>$location,
            'date_time'=>$date,
            'topic'=>$topic,
        ];
        // foreach ($fields as $key => $value) 
        // {
        //     if(isset($_POST[$key]) && empty($_POST[$key]))
        //     {
        //         $ctrl->error[] = "All feilds are required";
        //     break;
        //     }
        // }
        if(isset($_POST['edit_product']) && !empty($_FILES)){
            $ctrl->setFile($_FILES);
            $ctrl->update_image();
        }
        if(isset($_POST['post_product'])){
            $ctrl->setFile($_FILES);
            $ctrl->upload_image();
        }
        
        if(isset($_POST['post_product'])){
            $ctrl->setData($fields);
            $ctrl->add_event();
        }
        if(isset($_POST['edit_product'])){
            $fields['photo'] = $_POST['photo'];
            $ctrl->setData($fields);
            $ctrl->update($_POST['id'], "products");
        }
            
        
    }

    if(isset($_POST['submit_donation']) || isset($_POST['edit_donation']))
    {
        $dbClass = new Database();
        $db = $dbClass->connect();
        $ctrl = new Controller($db);
        $target = $_POST['target'];
        $reason = $_POST['reason'];

        $fields = [
            'target_amount'=>$target,
            'reason'=>$reason,
            'realized_amount'=> 0
        ];
        foreach ($fields as $key => $value) 
        {
            if(isset($_POST[$key]) && empty($_POST[$key]))
            {
                $ctrl->error[] = "All feilds are required";
            break;
            }
        }
        if(isset($_POST['submit']) && empty($_FILES)){
            $ctrl->error[] = "upload image";
        }else{
            if(isset($_POST['edit']) && !empty($_FILES)){
                $ctrl->setFile($_FILES);
                $ctrl->update_image();
            }
            if(isset($_POST['submit'])){
                $ctrl->setFile($_FILES);
                $ctrl->upload_image();
            }
        }
        if(!empty($ctrl->error))
        {
            echo $ctrl->display_errors();
        }else{
            if(isset($_POST['submit_donation'])){
                $ctrl->setData($fields);
                $ctrl->add_donation();
            }
            if(isset($_POST['edit_donation'])){
                
                $ctrl->setData($fields);
                $ctrl->update($_POST['id'], "donation");
            }
            
        }
    }

    if(isset($_POST['delete'])){
        $dbClass = new Database();
        $db = $dbClass->connect();
        $ctrl = new Controller($db);
        $table = $_POST['table'];

        $id = $_POST['id'];
        $ctrl->delete_this($id, $table);
    }

    if(isset($_POST['getEdit'])){
        $dbClass = new Database();
        $db = $dbClass->connect();
        $ctrl = new Controller($db);
        $table = $_POST['table'];
        $id = $_POST['id'];
        $data = $ctrl->select_this($id, $table);
        echo $data;
    }

    if(isset($_POST['signup'])){
        $dbh = new Database;
        $db = $dbh->connect();
        $ctrl = new Controller($db);
	
        $userName = $_POST['username'];
        $email = $_POST['email'];
        $pword = $_POST['password'];
        $rPword = $_POST['rePassword'];
        //$obj = new Controller;
        
        if($pword != $rPword)
        {
           $response = [
             "status" => "500",
             "text" => "password does not match"
           ];

           echo json_encode($response);
           return;
        }
        $fields = [
            'username'=>$userName,
            'email'=>$email,
            'password'=>password_hash($pword,PASSWORD_DEFAULT)
        ];
        $ctrl->setData($fields);
        $ctrl->addUser();
    
    }


	if(isset($_POST['login']))
    {
        $dbh = new Database;
        $db = $dbh->connect();
        $ctrl = new Controller($db);
        $email = $_POST['email'];
        $pword = $_POST['password'];
        if($email == " " || $pword == " "){
            $ctrl->error[] = "All feilds are required";
            // $ctrl->display_error();
        }
        $ctrl->setData([
			'email'=>$email,
			'password'=>$pword
		]);
        $ctrl->login();

    }

    if(isset($_POST['getMail'])){
        $dbh = new Database;
        $db = $dbh->connect();
        $ctrl = new Controller($db);
        $ctrl->select_this($_POST['id'], "inbox");
    }

    if(isset($_POST['read'])){
        $dbh = new Database;
        $db = $dbh->connect();
        $ctrl = new Controller($db);
        $fields = [
            "sender_name" => $_POST['sender_name'],
            "sender_email" => $_POST['sender_email'],
            "message" => $_POST['message'],
            "is_read" => 1,
            "deleted" => 0,
        ];
        $ctrl->setData($fields);
        $ctrl->update($_POST['id'], "inbox");
    }

    if(isset($_POST['sendmail'])){
        $dbh = new Database;
        $db = $dbh->connect();
        $ctrl = new Controller($db);
        $fields = [
            "recipient_name" => $_POST['name'],
            "recipient_email" => $_POST['email'],
            "message" => $_POST['message'],
        ];
        $ctrl->setData($fields);
        $ctrl->sendMail($fields);
    }