<?php
session_start();
require_once('common.php');
class Account{

	function login($domain_userid, $password) {
		/* ハッシュ化 */
		$pass_encrypted = hash_hmac('sha256', $password, PASS_KEY);

		try {
			$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);
			$dstmt = $pdo_account->prepare("SELECT * FROM web_account WHERE `domain` = ? AND `password` = ?");
			$dstmt->execute(array($domain_userid,$pass_encrypted));
			$ddata = $dstmt->fetch(PDO::FETCH_ASSOC);

			//for customer
			$stmt = $pdo_account->prepare("SELECT * FROM customer WHERE `user_id` = ? AND `password` = ?");
			$stmt->execute(array($domain_userid,$pass_encrypted));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			$attemp=1;
			if (count($data['user_id']) ==1) {
				setcookie("admin", $domain_userid);
				setcookie("password", $pass_encrypted);
				header("location: admin");
				unset($_SESSION["locked"]);
        unset($_SESSION["login_attempts"]);
			}else if(count($ddata['domain'])==1){
				setcookie("domain", $domain_userid);
				setcookie("password", $pass_encrypted);
				header("location: share");
				unset($_SESSION["locked"]);
        unset($_SESSION["login_attempts"]);
			}else{
				$_SESSION["login_attempts"] += $attemp;
				return false;
			}


		} catch (PDOException $e) {
			print('Error ' . $e->getMessage());
			$error_message = "データベースへの接続エラーです。";
			// require("views/allerror.php");
			$pdo_account = NULL;
			die();
		}
	}

	function passReset($domain_userid){
		try {
			$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);
			$stmt = $pdo_account->prepare("SELECT * FROM web_account WHERE `domain` = ? AND stopped = 0");
			$stmt->execute(array($domain_userid));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($data > 0) {
				// sendEmail()
				$stmt1 = $pdo_account->prepare("SELECT * FROM customer WHERE `user_id` = ?");
				$stmt1->execute(array($data['customer_id']));
				$data1 = $stmt1->fetch(PDO::FETCH_ASSOC);
				$this->sendEmail($data['token'], $data1['email']);
					$stmt2 = $pdo_account->prepare("UPDATE web_account SET `status` = 0 WHERE `domain` = ?");
					$stmt2->execute(array($domain_userid));
				setcookie("domain_userid", $domain_userid, time() + 3600);
				// setcookie("token", $data1['token'], time() + 3600);
				return true;
				// header('Location: /home.php');
			}else{
				$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);
				$stmt = $pdo_account->prepare("SELECT * FROM customer WHERE `user_id` = ?");
				$stmt->execute(array($domain_userid));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($data > 0) {
					$this->sendEmail($data['token'], $data['email']);
					$stmt1 = $pdo_account->prepare("UPDATE customer SET `status` = 0 WHERE `user_id` = ?");
					$stmt1->execute(array($domain_userid));
					// $stmt = $pdo_account->prepare("REPLACE INTO `current_pass` (`web_id`, `password`) VALUES (?, ?)");
					// $stmt->execute(array($id,$pass_1));
					$pdo_account = NULL;
					setcookie("domain_userid", $domain_userid, time() + 3600);
					setcookie("token", $data['token'], time() + 3600);
					// header('Location: /home.php');
				return true;
				}
			}
			return false;


		} catch (PDOException $e) {
			print('Error ' . $e->getMessage());
			$error_message = "データベースへの接続エラーです。";
			require("views/allerror.php");
			$pdo_account = NULL;
			die();
		}
	}

	function getDatabyToken($token, $domain_userid){

		try {
				$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);
				// for domain
				$dstmt = $pdo_account->prepare("SELECT * FROM web_account WHERE `token` = ? AND domain=? AND status=0");
				$dstmt->execute(array($token,$domain_userid));
				$ddata = $dstmt->fetch(PDO::FETCH_ASSOC);

				// for customer
				$stmt = $pdo_account->prepare("SELECT * FROM customer WHERE `token` = ? AND `user_id` = ?  AND `status` = 0");
				$stmt->execute(array($token,$domain_userid));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				// echo $token.$domain_userid;
				// die();
				if ($ddata > 0) {
					setcookie("domain_userid", $domain_userid, time() + 3600);
					return true;
				}else if ($data > 0) {
					setcookie("domain_userid", $domain_userid, time() + 3600);
					return true;
				}else{
					return false;
				}

			} catch (PDOException $e) {
				print('Error ' . $e->getMessage());
				$error_message = "データベースへの接続エラーです。";
				require("views/allerror.php");
				$pdo_account = NULL;
				die();
			}
	}

	function addMultiDomain($domain, $web_dir, $ftp_user, $password, $token){
		try{
			$common = new Common;
			$exist = array();
			if(strpos($common->alreadyExist("web_account",'domain',$domain), "not available"))
			{
				 $exist[0]=false;
				 $exist[1]="Domain already exist.".$domain;
				 return $exist;
			}
			if(strpos($common->alreadyExist("db_ftp",'ftp_user',$ftp_user), "not available"))
			{
				return $exist=array(false,"Ftp user already exist.");
			}
			// die('no error');
			$plan = 4;
			$pass_encrypted = hash_hmac('sha256', $password, PASS_KEY);

			$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);
			$stmt = $pdo_account->prepare("INSERT INTO web_account (`domain`, `password`, `user`, `plan`, `customer_id`) VALUES (?, ?, ?, ?, ?)");
			$stmt->execute(array($domain, $pass_encrypted, $ftp_user, $plan, $_COOKIE['customer'])) or die("insert error <br />". print_r($pdo_account->errorInfo(), true));
			$stmt1 = $pdo_account->prepare("INSERT INTO db_ftp (`ftp_user`, `password`, `domain`, `permission`) VALUES (?, ?, ?, ?)");
			$stmt1->execute(array($ftp_user, $password, $domain, "F,R,W")) or die("insert error <br />". print_r($pdo_account->errorInfo(), true));
			$pdo_account = NULL;

			$ip=IP;
			echo system('powershell.exe -executionpolicy bypass -NoProfile -File "E:\scripts/test.ps1" '.$domain.' '.$ftp_user.' '.$password.' '.$ip);

			return $exist=array(true,'no error');

		} catch (PDOException $e) {
			print('Error ' . $e->getMessage());
			$error_message = "データベースへの接続エラーです。";
			$pdo_account = NULL;
			die();
		}
	}

	function getMultiDomain($customer_id){
		try {
			$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);

			$dstmt = $pdo_account->prepare("SELECT * FROM web_account WHERE `customer_id` = ?");
			$dstmt->execute(array($customer_id));
			$ddata = $dstmt->fetchAll(PDO::FETCH_ASSOC);
			return $ddata;


		} catch (PDOException $e) {
			print('Error ' . $e->getMessage());
			$pdo_account = NULL;
			die();
		}
	}

		// error pages
	function getErrorPages($domain)
	{
		try {
					$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);

					$epstmt = $pdo_account->prepare("SELECT error_pages FROM web_account WHERE `domain` = ?");
					$epstmt->execute(array($domain));
					$epdata = $epstmt->fetchAll(PDO::FETCH_ASSOC);
					return $epdata;

				} catch (PDOException $e) {
					$pdo_account = NULL;
					die();
				}
	}

	function errorPages($domain, $action,$statuscode,$url_spec)
	{
		// $pass_encrypted = hash_hmac('sha256', $password, PASS_KEY);

		try {
			$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);

			// for domain
			$stmt = $pdo_account->prepare("SELECT * FROM web_account WHERE `domain` = ?");
			$stmt->execute(array($domain));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if(count($data)>0)
				{
					if($action=="new")
					{
						$temp=json_decode($data['error_pages']);
						// $test=$data['error_pages'];
						$error_pages['statuscode'] = $statuscode;
						$error_pages['url'] =  $url_spec;
						$error_pages['stopped'] =  1;
						$temp[]=$error_pages;
					}
					
					$error_pages=json_encode($temp);
					$upstmt = $pdo_account->prepare("UPDATE web_account SET `error_pages` = ? WHERE `domain` = ?");
					echo $upstmt->execute(array($error_pages,$domain));
				}
			} catch (PDOException $e) {
			$pdo_account = NULL;
			die();
		}
	}
	function getErrorData($domain,$ekey)
	{
		$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);

			// for domain
			$stmt = $pdo_account->prepare("SELECT * FROM web_account WHERE `domain` = ?");
			$stmt->execute(array($domain));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			// return count($data);
			
			if(count($data)>0)
				{
						$test=$data['error_pages'];
						foreach (json_decode($test) as $key => $value) {
							if((int)$key==(int)$ekey){
								$temp[$key]['statuscode']=$value->statuscode;
								$temp[$key]['url']=$value->url;
								$temp[$key]['stopped']=$value->stopped;
							}
						}
				}
					return $temp;

	}
	function editErrorPages($domain, $action,$statuscode,$url_spec,$ekey)
	{
		// $pass_encrypted = hash_hmac('sha256', $password, PASS_KEY);

		try {
			$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);

			// for domain
			$stmt = $pdo_account->prepare("SELECT * FROM web_account WHERE `domain` = ?");
			$stmt->execute(array($domain));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if(count($data)>0)
				{
						$test=$data['error_pages'];
						foreach (json_decode($test) as $key => $value) {
							if((int)$key==(int)$ekey){
								$temp[$key]['statuscode']=$statuscode;
								$temp[$key]['url']=$url_spec;
								$temp[$key]['stopped']=$value->stopped;
							}else{
								$temp[$key]['statuscode']=$value->statuscode;
								$temp[$key]['url']=$value->url;
								$temp[$key]['stopped']=$value->stopped;
							}
							
							// echo "string";
						}
					$error_pages=json_encode($temp);
					$upstmt = $pdo_account->prepare("UPDATE web_account SET `error_pages` = ? WHERE `domain` = ?");
					$upstmt->execute(array($error_pages,$domain));
				}
				return true;
			} catch (PDOException $e) {
			$pdo_account = NULL;
			die();
		}
	}

	function onoffErrorPages($domain, $error,$ekey,$status)
	{
		// $pass_encrypted = hash_hmac('sha256', $password, PASS_KEY);

		try {
			$pdo_account = new PDO(DSN, ROOT, ROOT_PASS);

			// for domain
			$stmt = $pdo_account->prepare("SELECT * FROM web_account WHERE `domain` = ?");
			$stmt->execute(array($domain));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if(count($data)>0)
				{
						$test=$data['error_pages'];
						foreach (json_decode($test) as $key => $value) {
							if((int)$key==(int)$ekey){
								$temp[$key]['statuscode']=$value->statuscode;
								$temp[$key]['url']=$value->url;
								if($status==1){
									$temp[$key]['stopped']=1;
									// echo Shell_Exec ("c:/laragon/www/app/error/onoff.cmd ". $data['user']." ". $value->statuscode);
								}else{
									$temp[$key]['stopped']=0;
									// echo Shell_Exec ("c:/laragon/www/app/error.cmd ". $data['user']." ". $value->statuscode." ".$value->url);
								}
							}else{
								$temp[$key]['statuscode']=$value->statuscode;
								$temp[$key]['url']=$value->url;
								$temp[$key]['stopped']=$value->stopped;
							}
						}
					$error_pages=json_encode($temp);
					$upstmt = $pdo_account->prepare("UPDATE web_account SET `error_pages` = ? WHERE `domain` = ?");
					echo $upstmt->execute(array($error_pages,$domain));
				}
			} catch (PDOException $e) {
			$pdo_account = NULL;
			die();
		}
	}

	function sendEmail($token,$tomail){
	
    $transport = (new Swift_SmtpTransport('smtp.googlemail.com', 465, 'ssl'))
      ->setUsername('capital.saiyannaing@gmail.com')
      ->setPassword('saiyannaing123!')
    ;
 
    // Create the Mailer using your created Transport
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $mailer = new Swift_Mailer($transport);
		$body = 'Hello, <p><a href="'.$url.'/new_password?token='.$token.'">password reset link</a></p>';

		$message = (new Swift_Message('Please change your new password.'))
		      ->setFrom(['capital.saiyannaing@gmail.com' => 'Password Reset Link'])
		      ->setTo($tomail)
		      // ->setCc(['RECEPIENT_2_EMAIL_ADDRESS'])
		      // ->setBcc(['RECEPIENT_3_EMAIL_ADDRESS'])
		      ->setBody($body)
		      ->setContentType('text/html')
		    ;
		 
		    // Send the message
		    $mailer->send($message);
	}

}


?>