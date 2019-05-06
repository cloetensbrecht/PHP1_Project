<?php 

    require_once('Security.class.php'); 

    class User{
        private $username;
        private $firstname;
        private $lastname;
        private $email;
        private $password;
        private $passwordConfirmation;

        // setters
        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername($username)
        {
                $this->username = $username;

                return $this;
        }

        /**
         * Get the value of firstname
         */ 
        public function getFirstname()
        {
                return $this->firstname;
        }

        /**
         * Set the value of firstname
         *
         * @return  self
         */ 
        public function setFirstname($firstname)
        {
                $this->firstname = $firstname;

                return $this;
        }

        /**
         * Get the value of lastname
         */ 
        public function getLastname()
        {
                return $this->lastname;
        }

        /**
         * Set the value of lastname
         *
         * @return  self
         */ 
        public function setLastname($lastname)
        {
                $this->lastname = $lastname;

                return $this;
        }



        public function setEmail($email){
            
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format"; 
            }
            
            
            
            
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
                $statement = $conn->prepare('INSERT INTO users (firstname, lastname, username, email, password) VALUE (:firstname, :lastname, :username, :email, :password)');
                $statement->bindParam(":firstname", $this->firstname);
                $statement->bindParam(":lastname", $this->lastname);
                $statement->bindParam(":username", $this->username);
                $statement->bindParam(":email", $this->email);
                $statement->bindParam(":password", $password);
                $result = $statement->execute();
                return $result;
            }

            catch (Throwable $t) {
                return $t;
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

                    //if($this->password === $result['password']){
                    // NORMAAL met password_verify 
                    // MAAR verify hashes created with other functions like crypt()
                    // kan pas als er een sign in is, met crypt
                    if(password_verify($this->password, $result['password'])){
                        echo "WORKS check ✅";

                        $this->id = $result['id'];
                        $_SESSION['id'] = $this->email; // session aanmaken 
                        header("location: index.php");
                    } else{
                        $error = "Something went wrong, your email or password are wrong. Try again.";
                        return $error;
                    }
                }
                catch(Throwable $t ){
                    return false;
                } 
            }   else {
                $error = "Your email is invalid.";
                        return $error;
            } 
        }


        

        

        
    }



