session_start();

$mysqli = new mysqli("localhost", "user", "password", "customerInfo");

if($mysqli->connect_errno)
	echo"lololol : (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;

if(isset($_POST['submit'])){

	//include_once 'connect.php';



	$first = mysqli_real_excape_string($conn, $_POST['firstname']);
	$last = mysqli_real_excape_string($conn, $_POST['lastname']);
	$email = mysqli_real_excape_string($conn, $_POST['email']);
	$phone = mysqli_real_excape_string($conn, $_POST['phone']);
	$postal = mysqli_real_excape_string($conn, $_POST['postal']);
	$userid = mysqli_real_excape_string($conn, $_POST['userid']);
	$password = mysqli_real_excape_string($conn, $_POST['password']);


//Error handling
//Is it empty?
	if(empty($first) || empty($last) || empty($email) || empty($phone) || empty($postal) || empty($userid) || empty($password)){
			header("Location: /master/register.html");
			exit();
	}else{
//Check for input characters
			if(!preg_match("/^[a-zA-Z]*S/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)){  
			header("Location: /master/register.html");
			exit();
			}else{
//Is email valid?
			if(!filter_var($email, FILER_VALIDATE_EMAIL)){
			header("Location: /master/register.html");
			exit();
			}else{
//Does user already exist?
			$sql = "SELECT * FROM Customer WHERE userid= '$userid'";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			if($resultCheck > 0){
			header("Location: /master/register.html");
			exit();
			}else{
//Hashing Password
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				//Insert user into Customer table
				$sql = "INSERT INTO users(fname, lname, email, phone, postal, userid, password) VALUES ($first, $last, $email, $phone, $postal, $userid, $hashedPassword);";
					mysqli_query($conn, $sql);
				header("Location: /master/login.html");
				exit();
			}
			}
			}
			}
	}else{
		header("Location: /master/targetPage.html");
		exit();
	}