<?php 
    class User{
        private $email;
        private $password;
        private $passwordConfirmation;
        private $id;

        // setters
        public function setEmail($email){
            $this->email = $email;
            return $this;
        }

        public function setPassword($password){
            $this->password = $password;
            return $this;
        }

        public function setPasswordConfirmation($passwordConfirmation){
            $this->passwordConfirmation = $passwordConfirmation;
            return $this;
        }

        // getters
        public function getEmail(){
            return $this->email;
        }
 
        public function getPassword(){
                return $this->password;
        }

        public function getPasswordConfirmation(){
                return $this->passwordConfirmation;
        }

        public function canLogin(){
            $error = "test";
           
                try{
                    $conn = new PDO("mysql:host=localhost;dbname=InspirationHunter", "root", "root");
                    $statement = $conn->prepare("SELECT password FROM users WHERE email= :email;");
                    $statement->bindParam(":email", $this->email);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);

                    $error = "WORKS";
                    $_SESSION['id'] = $this->email;
                    header("location: index.php");
                    
                }
                catch(Throwable $t ){
                    return $t;
                } 
        }

    }



