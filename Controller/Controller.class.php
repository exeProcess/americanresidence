<?php
// Load Composer's autoloader (if using Composer)
require '../vendor/autoload.php';
include_once "config.php";
include_once "Session.php";
include_once "Database.php";

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
   


    class Controller
    {
        private $productTable = PROPERTIES_TABLE;
        // private $donationTable = DONATION_TABLE;
        // private $inboxTable = INBOX_TABLE;
        // private $outboxTable = OUTBOX_TABLE;
        private $connection;
        public $data;
        public $files;
        public $fileNames = "";
        public $error = [];
        public $success = [];

        public function __construct($db)
        {
            $this->connection = $db;
        }

        public function setData($data)
        {
            $this->data = $data;
        }
        public function setFile($file)
        {
            $this->files = $file;
        }
        public function setFileName($name){
            $this->fileNames = $name;
        }
        

        // public function add_category()
        // {
        //     $query_cat = "SELECT 
        //                 * 
        //             FROM "
        //                 .$this->categoryTable." 
        //             WHERE 
        //                 category = :category 
        //             AND 
        //                 parent = 0";
        //     $prep_cat_query = $this->connection->prepare($query_cat);
        //     $prep_cat_query->bindValue(':category',$this->data['category']);
        //     $prep_cat_query->execute();
        //     $parent = $prep_cat_query->fetch();
        //     if($prep_cat_query->rowCount() == 0)
        //     {
        //         $sql = "INSERT INTO "
        //                 .$this->categoryTable."
        //                 (category) 
        //             VALUE
        //                 (:category)";
        //         $prep_cat_query = $this->connection->prepare($sql);
        //         $prep_cat_query->bindValue(':category',$this->data['category']);
        //         $exec = $prep_cat_query->execute();
        //         $query_cat = "SELECT
        //                     * 
        //                 FROM "
        //                     .$this->categoryTable."
        //                 WHERE 
        //                     category = :category 
        //                 AND 
        //                     parent = 0";
        //         $prep_cat_query = $this->connection->prepare($query_cat);
        //         $prep_cat_query->bindValue(':category',$this->data['category']);
        //         $prep_cat_query->execute();
        //         $parent = $prep_cat_query->fetch();
        //     }
        //     $this->data['category'] = $parent['id'];
        //     //////////Insert portfolio
        //     $query_child = "SELECT 
        //                     * 
        //                 FROM "
        //                     .$this->categoryTable."
        //                 WHERE 
        //                     category = ? 
        //                 AND 
        //                     parent = ? ";
        //     $prep_child_query = $this->connection->prepare($query_child);
        //     $prep_child_query->execute([$this->data['portfolio'],$parent['id']]);
        //     $child = $prep_child_query->fetch();
        //     if($prep_child_query->rowCount() == 0)
        //     {
        //         $sql = "INSERT INTO "
        //                 .$this->categoryTable."
        //                 (category,parent) 
        //             VALUES 
        //                 (?,?)";
        //         $stmt = $this->connection->prepare($sql);
        //         $exec = $stmt->execute([$this->data['portfolio'],$parent['id']]);
        //         $query_cat = "SELECT 
        //                     * 
        //                 FROM "
        //                     .$this->categoryTable." 
        //                 WHERE 
        //                     category = ? 
        //                 AND 
        //                     parent = ?";
        //         $prep_child_query = $this->connection->prepare($query_cat);
        //         $prep_child_query->execute([$this->data['portfolio'],$parent['id']]);
        //         $child = $prep_child_query->fetch();
        //     }
        //     $this->data['portfolio'] = $child['id'];
        // }


        public function upload_image()
        {
            $name = $this->files['photo']['name'];
            $size = $this->files['photo']['size'];
            $tmp_name = $this->files['photo']['tmp_name'];
            $type = $this->files['photo']['type'];
            $formats = ['jpg','jpeg','png'];
            $db_path = "";
            // for($i = 0;$i < count($name);$i++)
            // {
                $ext = explode('/',$type);
                $actExt = end($ext);
                if(!in_array($actExt,$formats))
                {
                    $this->error[] = "Image format not allowed";
                }
                if($size > 101010101)
                {
                    $this->error[] = "File too large";
                
                }
                if(empty($this->error))
                {
                    $file_name = sha1(microtime()).'.'.$actExt;
                    $dir = $_SERVER['DOCUMENT_ROOT'].'/resido/Admin/Uploads/'.$file_name;
                    $db_path = '/resido/Admin/Uploads/'.$file_name;
                    move_uploaded_file($tmp_name,$dir);
                }
            //}
            $this->fileNames .= $db_path;
        }
        public function update_image($id,$index)
        {
           $name = $this->files['name'];
           $type = $this->files['type'];
           $size = $this->files['size'];
           $format = ['jpg','jpeg','png'];
           $tmp = $this->files['tmp_name'];
           $ext = explode('.',$name);
           $actExt = strtolower(end($ext));
           $file_name = sha1(microtime()).".".$actExt;
           $upload_name = '/E-shop/View/Admin/Uploads/'.$file_name;
           $dir = $_SERVER['DOCUMENT_ROOT']."/E-shop/View/Admin/Uploads/".$file_name;
           if($size > 101010101)
           {
               $this->error[] = "File too large";
           }
           if(!in_array($actExt,$format))
           {
               $this->error[] = "Image Format not allowed";
           }
           if(empty($this->error))
           {
               move_uploaded_file($tmp,$dir);
               $entry = $this->select_this($id);
               $image = explode(',',$entry['product_img']);
               $image[$index] = $upload_name;
               $sequel = "UPDATE "
                        .$this->productTable."
                    SET 
                        product_img = ? 
                    WHERE 
                        id = ?";
               $stmt = $this->connection->prepare($sequel);
               $stmt->execute([implode(',',$image),$id]);
               echo $upload_name;
            }
        }
        public function delete_image($id,$index)
        {
            $data = $this->select_this($id);
            $photo = explode(',',$data['photo']);
            unset($photo[$index]);
            $sequel = "UPDATE "
                    .$this->productTable." 
                SET 
                   product_img =:photo 
                WHERE 
                    id =:id";
            $stmt = $this->connection->prepare($sequel);
            $stmt->bindValue(':photo',implode(',',$photo));
            $stmt->bindValue(':id',$id);
            $exec = $stmt->execute();
            if($exec){
                echo "removed";
            }else{
                echo "something went wrong";
            }
        }
        public function validate()
        {
            $this->add_brand();
            $this->add_category();
        }
        public function add()
        {
            $this->validate();
            $this->data['photo'] = $this->fileNames;
                $query_keys = implode(',',array_keys($this->data));
                $query_values = implode(', :',array_keys($this->data));
                $query = "INSERT INTO 
                            products($query_keys) 
                        VALUES
                            (:".$query_values.")";
                $prep_stmt = $this->connection->prepare($query);
                foreach($this->data as $key => $value)
                {
                    $prep_stmt->bindValue(":".$key,$value);
                }
                $exec = $prep_stmt->execute();
                if($exec)
                {
                    header('Location: pages/data-tables.php');
                }
        }
        public function selectAll($table)
        {
            $select_query = "SELECT 
                            * 
                        FROM 
                            $table";
            $stmt = $this->connection->query($select_query);
            $data = $stmt->fetchAll();
            return $data;
        }
       
        public function select_this($id, $table)
        {
            $query = "SELECT 
                    * 
                FROM 
                    $table 
                WHERE 
                    id=:id";
            $prep_stmt = $this->connection->prepare($query);
            $prep_stmt->bindValue(':id',$id);
            $prep_stmt->execute();
            $result = $prep_stmt->fetch();
            $result['status'] = 200;
            return $result;
        } 
        public function select($limit){
            $sql = "SELECT * FROM properties
                    ORDER BY id DESC
                    LIMIT $limit";
            $stmt = $this->connection->query($sql);
            $data = $stmt->fetchAll();
            if(sizeof($data)){
                return $data;
            }
            
        } 
        public function update()
        {
            if(!empty($this->fileNames)){
                $this->data['image'] = $this->fileNames;
            }
            $st = "";
            foreach ($this->data  as $key => $value) 
            {
                $st .= "$key = :".$key.", ";
            }
            $table = $this->productTable;
            $sql = "UPDATE ".
                        $table ."
                    SET". 
                        rtrim($st,', ')."
                    WHERE 
                    id=:id"; 
           
            $stmt = $this->connection->prepare($sql);
            foreach ($this->data as $key => $value) 
            {
                # code...
                $stmt->bindValue(":".$key,$value);
            }
            // $stmt->bindValue(":id",$id);
            $exec = $stmt->execute();
            if($exec)
            {
                $response = [
                    "status" => 200,
                    "text" => "Event Updated Successfully"
                ];
                echo json_encode($response);
            }else{
                $response = [
                    "status" => 500,
                    "text" => "Update Error. Retry!"
                ];
                echo json_encode($response);
            }
        }
        public function delete_this($id, $table)
        {
            $sequel = "UPDATE 
                    $table 
                SET 
                    deleted = 1 
                WHERE 
                    id=?";
            $stmt = $this->connection->prepare($sequel);
            $exec = $stmt->execute([$id]);
            if($exec)
            {
                $response = [
                    "status" => 200,
                    "text" => "Data deleted successfully"
                ];
                return json_encode($response);
               
            }
        }
        public function display_error()
        {
            $response = [
                "status" => 500,
                "text" => $this->error
            ];
            echo json_encode($response);
            return;
        }
        public function addUser()
        {
            if(!empty($this->error))
            {
                echo $this->display_errors();
            }
            $keys = implode(',',array_keys($this->data));
            $values = implode(', :',array_keys($this->data));
            $sequel = "SELECT 
                    * 
                FROM 
                    user 
                WHERE 
                    email = ?";
            $stmt = $this->connection->prepare($sequel);
            $stmt->execute([$this->data['email']]);
            if($stmt->rowCount() > 0)
            {
                $response = [
                    "status" => 500,
                    "text" => "User with this email already exist"
                ];
                echo json_encode($response);
                return;
            }else
            {
                $sequel = "INSERT INTO 
                        user ($keys) 
                    VALUES 
                        (:".$values.")";
                $stmt = $this->connection->prepare($sequel);
                foreach ($this->data as $key => $value)
                {
                    # code...
                    $stmt->bindValue(":".$key,$value);
                }
                $exec = $stmt->execute();
                if($exec)
                {
                    // header('Location: ../../../index.php');
                    $response = [
                        "status" => 200,
                        "text" => "success"
                    ];
                    echo json_encode($response);
                }
            }
        }
        public function login()
        {
            $sequel = "SELECT 
                        * 
                    FROM 
                        user 
                    WHERE 
                        email = ?";
            $stmt = $this->connection->prepare($sequel);
            $stmt->execute([$this->data['email']]);
            $result = $stmt->fetch();
            if($stmt->rowCount() == 0)
            {
                $response = [
                    "status" => 500,
                    "text" => "User not found",
                ];
                echo json_encode($response);
                return;
            }
            if(!empty($this->error))
            {
                echo $this->display_errors();    
            }else
            {
                if(!password_verify($this->data['password'],$result['password']))
                {
                    // $this->error[] = "Password does not match our record.Try again";
                    $response = [
                        "status" => 500,
                        "text" => "Password does not match our record.Try again",
                    ];
                    echo json_encode($response);
                    return;
                }
                Session::start();
                Session::set('user',$result);
                $response = [
                    "status" => 200,
                    "text" => "success",
                    "user" => Session::get('user')
                ];
                echo json_encode($response);
            }
        }
        static public function is_logged_in()
        {
            if(isset($_SESSION['user']) && !empty($_SESSION['user']))
            {
                return true;
            }
            return false;
        }
        public static function login_error_redirect($url)
        {
            Session::set('error_flash','You have no permission to this page');
            if(isset($_SESSION['user']))
            {
                unset($_SESSION['error_flash']);
            }
            header('Location: '.$url);
        }
        public static function logOut()
        {
            if(isset($_SESSION['user']))
            {
                Session::destroy();
            }
            header("Location: ../View/index.php");
        }
        public function validate_location(){
            $sequel = "SELECT 
                        * 
                    FROM 
                        properties 
                    WHERE 
                        prop_location = ?";
            $stmt = $this->connection->prepare($sequel);
            $stmt->execute([$this->data['prop_location']]);
            $result = $stmt->fetch();
            if($stmt->rowCount() > 0)
            {
                return true;
            }
        }
        public function add_event(){
            //$cart_data = $this->select_this($id);
            $key = [];
            $value = [];
            $this->data['image'] = $this->fileNames;
            
            if($this->validate_location($this->data['prop_location'])){
                $response = [
                    "status" => 500,
                    "text" => "This property has already been listed, O boy!",
                ];
                echo json_encode($response); 
                return; 
            }else{
                $field = ['name','prop_location','prop_type','transaction_type','asking_price','final_price','space',
                'bedroom','bathroom','description','image'];
                for($i = 0;$i < count($field);$i++){
                    if(in_array($field[$i],array_keys($this->data))){
                        $index = $field[$i];
                        $key[] =  $field[$i];
                        $value[] = $this->data[$index];
                    }
                }
                $keys = implode(',',$key);
                $values = implode(', :',$key);
                $table = $this->productTable;
                $sequel = "INSERT INTO 
                            $table($keys) 
                        VALUES
                            (:".$values.")";
                $stmt = $this->connection->prepare($sequel);
                for($i = 0;$i < count($key);$i++){
                    $stmt->bindValue(':'.$key[$i],$value[$i]);
                }
                $exec = $stmt->execute();
                if($exec){
                    $response = [
                        "status" => 200,
                        "text" => "success"
                    ];
                    echo json_encode($response);
                }else{
                    $response = [
                        "status" => 500,
                        "text" => "Error"
                    ];
                    echo json_encode($response);
                }
            }
            
            
        }

        
        // public function add_donation(){
        //     //$cart_data = $this->select_this($id);
        //     $key = [];
        //     $value = [];
        //     $field = ['reason','target_amount','realized_amount'];
        //     for($i = 0;$i < count($field);$i++){
        //         if(in_array($field[$i],array_keys($this->data))){
        //             $index = $field[$i];
        //             $key[] =  $field[$i];
        //             $value[] = $this->data[$index];
        //         }
        //     }
        //     $keys = implode(',',$key);
        //     $values = implode(', :',$key);
        //     $table = $this->donationTable;
        //     $sequel = "INSERT INTO 
        //                 $table($keys) 
        //             VALUES
        //                 (:".$values.")";
        //     $stmt = $this->connection->prepare($sequel);
        //     for($i = 0;$i < count($key);$i++){
        //         $stmt->bindValue(':'.$key[$i],$value[$i]);
        //     }
        //     $exec = $stmt->execute();
        //     if($exec){
        //         $response = [
        //             "status" => 200,
        //             "text" => "success"
        //         ];
        //         echo json_encode($response);
        //     }
        // }
        public function send_mail(){
            $to = filter_var($this->fields['email'], FILTER_SANITIZE_EMAIL);
            $subject = filter_var($this->fields['subject'], FILTER_SANITIZE_STRING);
            $message = filter_var($this->fields['message'], FILTER_SANITIZE_STRING);
            $name = $this->fields['name'];
            // $card_number = $_POST['message']['cardNumber'];
            // $card_expiration = $_POST['message']['expiration'];
            // $cvc = $_POST['message']['cvc'];


            $email_body = "You have received a new message.\n\n";
            $email_body .= "Card owner: ".$name."\n";
            $email_body .= "Email: ".$to."\n";
            // $email_body .= "Card number: ".$card_number."\n";
            // $email_body .= "Card expiration: ".$card_expiration."\n";
            // $email_body .= "Card CVC: ".$cvc."\n";


            // $html_body = "<h3>You have received a new message.</h3>";
            // $html_body .= "<p><strong>Card owner:</strong> $name</p>";
            // $html_body .= "<p><strong>Email:</strong> $to</p>";
            // $html_body .= "<p><strong>card number:</strong> $card_number</p>";
            // $html_body .= "<p><strong>card expiration:</strong><br>$card_expiration</p>";
            // $html_body .= "<p><strong>cvc:</strong><br>$cvc</p>";
            $mail = new PHPMailer(true);  // Create a new PHPMailer instance

            try {
                //Server settings
                $mail->SMTPDebug = 0;  // Disable verbose debug output
                $mail->isSMTP();  // Set mailer to use SMTP
                $mail->Host       = 'smtp.gmail.com';  // Specify Gmail's SMTP server
                $mail->SMTPAuth   = true;  // Enable SMTP authentication
                $mail->Username   = 'habeebajani9@gmail.com';   // Your Gmail address
                $mail->Password   = 'saql daif rliq iigy';  // Your Gmail password or app-specific password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
                $mail->Port       = 587;  // TCP port to connect to Gmail's SMTP

                //Recipients
                $mail->setFrom($to, $name);  // From email address and name
                $mail->addAddress('habeebajani9@gmail.com');  // Recipient email address

                // Content
                $mail->isHTML(true);  // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $email_body;

                // Send the email
                $mail->send();
                $response = [
                    "status" => 200,
                    "text" => "success"
                ];
                echo json_encode($response);
                
            } catch (Exception $e) {
                $response = [
                    "status" => 500,
                    "text" => "success",
                    "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
                ];
                echo json_encode($response);
            }
        }
    }

?>