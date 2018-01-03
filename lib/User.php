<?php
include_once 'Session.php';
include'Database.php';
class User{
		private $db;
		public function __construct(){
			$this->db= new Database();
		}

		public function userRegistration($data) {

			$name = $data['name'];
			$username = $data['username'];
			$email = $data['email'];
			$password =$data['password'];

			 $chk_email = $this->emailCheck($email);
			
			if ($name == '' || $username == '' || $email == '' || $password == '' ) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>Field must not be Empty</div>";
				return $msg;
			}

			if (strlen($username) < 3) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>Username is too Short!!!</div>";
				return $msg;
			} elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>Username must only contain alphanumerical, dashes and underscores!!!</div>";
				return $msg;
			}

			if (filter_var($email,FILTER_VALIDATE_EMAIL)  === false) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>The email Address is not valid!!!</div>";
				return $msg;
			}

			if ($chk_email == true) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>The email Address already Exist!!!</div>";
				return $msg;
			}
			$password = md5($data['password']);
			$sql ="INSERT INTO lr_user (name, username, email, password) VALUES (:name, :username, :email, :password)";
			$query =$this->db->pdo->prepare($sql);
			$query->bindValue(':name',$name);
			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':password',$password);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class ='alert alert-success'><strong>Success !!</strong>Congratulation! User has been created successfully.</div>";
				return $msg;
			} else {
				$msg = "<div class ='alert alert-danger'><strong>Sorry !!</strong>Server error! Please try again later.</div>";
				return $msg;
			}
		}

		public function  emailCheck($email) {
			$sql = "SELECT email FROM lr_user WHERE email =:email";
			$query =$this->db->pdo->prepare($sql);
			$query->bindValue(':email',$email);
			$query->execute();
			if ($query->rowCount() > 0){
        	return true;
    } else {
    	return false;
    }

		}

		public function getLoginUser($email,$password) {
			$sql = "SELECT * FROM lr_user WHERE email =:email AND password =:password LIMIT 1";
			$query =$this->db->pdo->prepare($sql);
			$query->bindValue(':email',$email);
			$query->bindValue(':password',$password);
			$query->execute();
			$result =$query->fetch(PDO::FETCH_OBJ);
			return $result;
		}
		public function userLogin($data) {
			$email = $data['email'];
			$password = md5($data['password']);
			$chk_email = $this->emailCheck($email);
			
			if ($email == '' || $password == '' ) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>Field must not be Empty</div>";
				return $msg;
			}

			if (filter_var($email,FILTER_VALIDATE_EMAIL)  === false) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>The email Address is not valid!!!</div>";
				return $msg;
			}

			if ($chk_email == false) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>The email Address is Not Exist!!!</div>";
				return $msg;
			}

			$result = $this->getLoginUser($email,$password);
			if ($result) {
				Session::init();
				Session::set("login", true);
				Session::set("id", $result->id);
				Session::set("name", $result->name);
				Session::set("username", $result->username);
				Session::set("loginmsg", "<div class ='alert alert-success'><strong>Successfully !!!! </strong> You are LoggedIn!</div>");
				header("Location: index.php");
			} else {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!! </strong> Password doesn't match.Data not found!</div>";
				return $msg;
			}
		}

		public function getUserData() {
			$sql = "SELECT * FROM lr_user ORDER BY id DESC";
			$query =$this->db->pdo->prepare($sql);
			$query->execute();
			$result =$query->fetchAll();
			return $result;
		}

		public function getUserById($id) {
			$sql = "SELECT * FROM lr_user WHERE id = :id LIMIT 1";
			$query =$this->db->pdo->prepare($sql);
			$query->bindValue(':id',$id);
			$query->execute();
			$result =$query->fetch(PDO::FETCH_OBJ);
			return $result;
		}

		public function updateUserData($id, $data) {
			$name = $data['name'];
			$username = $data['username'];
			$email = $data['email'];
			
			if ($name == '' || $username == '' || $email == '') {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>Field must not be Empty</div>";
				return $msg;
			}

			
			$sql ="UPDATE lr_user 
			set
			name = :name,
			username = :username,
			email = :email
			WHERE id = :id";
			$query =$this->db->pdo->prepare($sql);
			$query->bindValue(':name',$name);
			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':id',$id);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class ='alert alert-success'><strong>Success !! </strong>Congratulation! User data Updated successfully.</div>";
				return $msg;
			} else {
				$msg = "<div class ='alert alert-danger'><strong>Sorry !! </strong>Server error! User data Not Updated successfully.Please try again later.</div>";
				return $msg;
			}
		}

		private function checkPassword($id,$old_pass) {
			$password = md5($old_pass);
			$sql = "SELECT password FROM lr_user WHERE id =:id AND password =:password";
			$query =$this->db->pdo->prepare($sql);
			$query->bindValue(':id',$id);
			$query->bindValue(':password',$password);
			$query->execute();
			if ($query->rowCount() > 0){
        	return true;
    } else {
    	return false;
    }
		}


		public function updatePassword($id, $data) {
			$old_pass = $data['old_password'];
			$new_pass = $data['new_password'];
			$chk_pass = $this->checkPassword($id,$old_pass);

			if ($old_pass == "" || $new_pass == "") {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>Field must not be Empty</div>";
				return $msg;
			}

			if ($chk_pass == false) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!! </strong> Old Password not Exist.</div>";
				return $msg;
			}

			if (strlen($new_pass) < 6) {
				$msg = "<div class ='alert alert-danger'><strong>Error !!!!</strong>Password is too short.</div>";
				return $msg;
			}

			$password = md5($new_pass);
			$sql ="UPDATE lr_user 
			set
			password = :password
			WHERE id = :id";
			$query =$this->db->pdo->prepare($sql);
			$query->bindValue(':password',$password);
			$query->bindValue(':id',$id);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class ='alert alert-success'><strong>Success !! </strong>Congratulation! Password Updated successfully.</div>";
				return $msg;
			} else {
				$msg = "<div class ='alert alert-danger'><strong>Sorry !! </strong>Server error! Password Not Updated successfully.Please try again later.</div>";
				return $msg;
			}
		}

		
	}

?>