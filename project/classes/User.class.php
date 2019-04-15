<?php 

    require_once('Security.class.php'); 

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

        public function register(){
            $password = Security::hash($this->password);
            try {
                $conn = Db::getInstance();
                $statement = $conn->prepare('insert into user (email, password) values (:email, :password);');
                $statement->bindParam(":email", $this->password);
                $statement->bindParam(":password", $password);
                $result = $statement->execute();
                return $result;
            }

            catch (Throwable $t) {
                return false;
            }
        }

        // maybe add some code to slow down bruit force attacks  ? 
        // with sleep ? https://www.php.net/manual/en/function.sleep.php

        public function canLogin(){
            if(SafetyCheck::isValidEmail($this->email)){
                try{
                    $conn = Db::getInstance();
                    $statement = $conn->prepare("SELECT password FROM users WHERE email= :email;");
                    $statement->bindParam(":email", $this->email);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);

                    if($this->password === $result['password']){
                    // NORMAAL met password_verify 
                    // MAAR verify hashes created with other functions like crypt()
                    // kan pas als er een sign in is, met crypt
                    //if(password_verify($this->password, $result['password'])){
                        echo "WORKS check ✅";

                        $this->id = $result['id'];
                        $_SESSION['id'] = $this->email;
                        header("location: index.php");
                    } else{
                        $error = "Something went wrong, your email or password are wrong. Try again.";
                        return $error;
                    }
                }
                catch(Throwable $t ){
                    return $t;
                } 
            }   else {
                $error = "Your email is invalid.";
                        return $error;
            } 
        }

    }



