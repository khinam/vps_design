<?php 

	class config{
		
		public static function connect()
		{
			$host = "localhost";
			$username = "root";
			$password = "";
			$dbname = "japan_system_development_sai";

			try {
				$con = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
				$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
			}
			catch(PDOException $e)
			{
				echo "Connection failed" . $e->getMessage();
			}

			return $con;

		}

	}

	function myPagination() {
		echo "hello";
	}


 ?>