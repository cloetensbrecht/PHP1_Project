<?php

    require_once 'bootstrap.php';  // import Classes
    class User
    {
        // variabelen ///////////////////////////////////////////////
        private $email;
        private $password;
        private $passwordConfirmation;
        private $id;
        private $CurrentPassword;

        private $firstName;
        private $lastName;
        private $username;
        private $mobile;
        private $bio;
        private $profilePicture;

        // setters ///////////////////////////////////////////////
        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }

        public function setPassword($password)
        {
            $this->password = $password;

            return $this;
        }

        public function setPasswordConfirmation($passwordConfirmation)
        {
            $this->passwordConfirmation = $passwordConfirmation;

            return $this;
        }

        public function setFirstName($firstName)
        {
            $this->firstName = $firstName;

            return $this;
        }

        public function setLastName($lastName)
        {
            $this->lastName = $lastName;

            return $this;
        }

        public function setUsername($username)
        {
            $this->username = $username;

            return $this;
        }

        public function setMobile($mobile)
        {
            $this->mobile = $mobile;

            return $this;
        }

        public function setBio($bio)
        {
            $this->bio = $bio;

            return $this;
        }

        public function setProfilePicture($profilePicture)
        {
            $this->profilePicture = $profilePicture;

            return $this;
        }

        public function setCurrentPassword($CurrentPassword)
        {
            $this->CurrentPassword = $CurrentPassword;

            return $this;
        }

        // SET ID
        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }

        // getters ///////////////////////////////////////////////
        public function getEmail()
        {
            return $this->email;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function getPasswordConfirmation()
        {
            return $this->passwordConfirmation;
        }

        public function getCurrentPassword()
        {
            return $this->CurrentPassword;
        }

        /*
        public function getFirstName()
        {
            return $this->firstName;
        }

        public function getLastName()
        {
            return $this->lastName;
        }

        public function getUsername()
        {
            return $this->username;
        }

        public function getMobile()
        {
            return $this->mobile;
        }

        public function getBio()
        {
            return $this->bio;
        }

        public function getProfilePicture()
        {
            return $this->profilePicture;
        }*/

        // functions ///////////////////////////////////////////////

        // HOE ID OPHALEN // $id = self::getId();
        public static function getId()
        {
            $conn = Db::getInstance();

            // id ophalen uit db
            $emailCheck = $_SESSION['id'];
            $result = $conn->prepare('SELECT id FROM users WHERE email= :email');
            $result->bindParam(':email', $emailCheck);
            $result->execute();
            $id = $result->fetch(PDO::FETCH_COLUMN);

            return $id;
        }

        public function register()
        {
            $password = Security::hash($this->password);
            try {
                $conn = Db::getInstance();
                $statement = $conn->prepare('INSERT INTO users (email, password) VALUE (:email, :password);');
                $statement->bindParam(':email', $this->email);
                $statement->bindParam(':password', $password);
                $result = $statement->execute();

                return $result;
            } catch (Throwable $t) {
                return $t;
            }
        }

        // maybe add some code to slow down bruit force attacks  ?
        // with sleep ? https://www.php.net/manual/en/function.sleep.php

        public function canLogin()
        {
            if (SafetyCheck::isValidEmail($this->email)) {
                try {
                    $conn = Db::getInstance();
                    $statement = $conn->prepare('SELECT password FROM users WHERE email= :email;');
                    $statement->bindParam(':email', $this->email);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);

                    //if($this->password === $result['password']){
                    // NORMAAL met password_verify
                    // MAAR verify hashes created with other functions like crypt()
                    // kan pas als er een sign in is, met crypt
                    if (password_verify($this->password, $result['password'])) {
                        //echo 'WORKS check ✅';

                        $this->id = $result['id'];
                        $_SESSION['id'] = $this->email; // session aanmaken
                        // ?? // $_SESSION['id'] = $this->id; // session aanmaken met ID ?
                        header('location: index.php');
                    } else {
                        $error = 'Something went wrong, your email or password are wrong. Try again.';

                        return $error;
                    }
                } catch (Throwable $t) {
                    return false;
                }
            } else {
                $error = 'Your email is invalid.';

                return $error;
            }
        }

        public function passwordCorrect()
        {
            $CurrentPassword = $this->CurrentPassword;
            // try {
            $conn = Db::getInstance();
            $id = self::getId();
            $statement = $conn->prepare('SELECT password FROM users WHERE id = :id');
            // TEGEN SQL > bindParam= veiligere manier // waarden koppelen aan inputvelden
            $statement->bindParam(':id', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC)['password'];

            if (password_verify($CurrentPassword, $result)) {
                //echo 'WORKS check ✅';

                return $validPw = true;
            } else {
                //$error = 'Something went wrong, your password are wrong. Try again.';
                return $validPw = false;
            }
            //} catch (Throwable $t) {return $validPw = false;}
        }

        public function getProfileInfo()
        {
            $id = self::getId();
            $conn = Db::getInstance();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM users where id = ?';
            $q = $conn->prepare($sql);

            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);

            return $data;
        }

        public function validFormUpdateData()
        {
            $conn = Db::getInstance();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $conn->prepare('UPDATE users set firstName = ?, lastName = ?, email = ?, mobile =?, bio=? , profilePicture=? , username=? 
            WHERE id = ?');
            $q->execute(array($this->firstName, $this->lastName, $this->email, $this->mobile, $this->bio, $this->profilePicture, $this->username, $this->id));

            //$q->execute(array($firstName, $lastName, $email, $mobile, $bio, $profilePicture, $username, $id));
        }
    }
