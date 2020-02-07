<?php
/*
 * PDO Database class
 *
 * Usage:
 * $db = Database::getInstance();
 * Return array of query results, normal statement: $results = $db->query("SELECT * FROM test WHERE name = 'Bob'");
 * Return array of query results, prepared statement (named params): $results = $db->query("SELECT * FROM test WHERE name = :name", array(":name" => "matthew"));
 * Return int of last insert result row id: $db->lastInsertId()
 * Return int of last query result row count: $db->lastQueryRowCount()
 */
define("DBNAME","sys_training");
define("HOST","localhost");
define("USER","root");
define("PASS","latropcpi");

class Database {
	
	/*
	 * Instance of the database class
	 *
	 * @static Database $instance
	 */
	private static $instance;

	/*
	 * Database connection
	 *
	 * @access private
	 * @var PDO $connection
	 */
	private $db;
	
	/*
	 * Constructor
	 *
	 * @param $dsn The Data Source Name. eg, "mysql:dbname=testdb;host=127.0.0.1;port=3306"
	 * @param $username
	 * @param $password
	 */
	private function __construct() {

		//$config = parse_ini_file("../../../../config/sys_vehicle_monitoring_config.ini",true);
		
		$this->db = new PDO("mysql:dbname=".DBNAME.";host=".HOST.";", 
									USER,
									PASS, 
									array(
                                 		
                                 		PDO::ATTR_PERSISTENT => true
                                 	) 
                                 );
	
		if (empty($this->db)) {
			trigger_error("Error #D001:", E_USER_ERROR);
            return false;
		}
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->exec("set names utf8");
	}
		
	/*
	 * Gets an instance of the Database class
	 *
	 * @static $instance
	 * @return Database An instance of the database singleton class
	 */
	public static function getInstance() {
		if (empty(self::$instance)) {
			try {
				self::$instance = new Database();
			} catch (\PDOException $e) {
				trigger_error("Error #D002: ".$e->getMessage(), E_USER_ERROR);
			}
		}
		return self::$instance;
	}
	
	/*
	 * Runs a query using the current connection to the database
	 *
	 * @param string query
	 * @param array $args An array of arguments for the sanitization such as array(":name" => "foo")
	 * @return array Containing all the remaining rows in the result set.
	 */
	public function query($query, $args = false) {
		$tokens = array_map('trim',explode(" ",trim($query)));
		$query = str_replace(array("\r\n", "\r", "\t"), " ", $query);
        $query = str_replace('    ', ' ', $query);
		try {
			// Prepare results
			$results=false;
	
			// Allow for rollback if query fails
			$this->db->beginTransaction();
			// Prepared statements
			$sth = $this->db->prepare($query);

			// Execute prepared statement, with or without arguments
			if (empty($args)) {
				$sth->execute();
			} else {
				$multiple = false;
				foreach ($args as $arg) {
					if (!is_array($arg)) { continue; }
					$multiple = true;
					break;
				}
				if ($multiple) {
					$i=0;$j=count($args);
					foreach ($args as $arg) {
						foreach ($arg as $k=>$v) {
							if ($v === "NULL") { $arg[$k] = NULL; }
						}
						$sth->execute($arg);
						$i++;
					}
				} else {
					$i=0;$j=count($args);
					foreach ($args as $a=>$arg) {
						if ($arg === "NULL") {$args[$a] = NULL;}
						$i++;
					}
					$sth->execute($args);
				}
			}

			// SELECT: Return array of data or false if 0 rows
			if ($tokens[0] == "SELECT") {
				$sth->setFetchMode(PDO::FETCH_ASSOC);
				$results = $sth->fetchAll();
			}
			// INSERT/UPDATE/REPLACE: Return number of affected rows / array of affected ids ?
			// Note: lastInsertId only works if ID col on table is auto_incremented
			else if ($tokens[0] == "INSERT"
					|| $tokens[0] == "UPDATE"
					|| $tokens[0] == "REPLACE") {
				
				// If sessions table, assume key = return id
				$results = $this->db->lastInsertId();
			}
			// Else: Return number of affected rows
			else {
				$results = $sth->rowCount();
			}
			// Attempt to commit changes, triggers exception if fails
			$this->db->commit();

		// Rollback changes on failure
		} catch (\PDOException $e) {
            $msg = 'query(): ***** Caught Exception! Rolling back changes *****'.PHP_EOL.'<hr />Query:<pre>'.$query.'</pre>'.PHP_EOL.'<hr />Exception Message:<pre>'.$e->getMessage().'</pre><hr />'.PHP_EOL;
			$this->db->rollBack();
			trigger_error($msg, E_USER_ERROR);
			return false;
		}
		
		return $results;
	}
	
	/*
	 * Returns the last insert result row id
	 *
	 * @return int of last insert result row id
	 */
	public function lastInsertId() {
		return $this->db->lastInsertId();
	}
	
	/*
	 * Returns the last query result row count
	 *
	 * @return int of last query result row count
	 */
	public function lastQueryRowCount() {
  		return $this->db->lastQueryRowCount();
	}

	public function disconnect(){
		$this->db = NULL;
	}

	public function __destruct(){
		$this->disconnect();
	}
	
}



 //$results = $db->query("SELECT * FROM employee WHERE name = :name OR age = :age",array(":name" => "pau2l",":age"=>20));
 //print_r($results);
/*  Return array of query results, prepared statement (named params): $results = $db->query("SELECT * FROM test WHERE name = :name", array(":name" => "matthew"));
  Return int of last ert result row id: $db->lastInsertId()
* Return int of last query result row count: $db->lastQueryRowCount()
 */
	
	//$results = $db->query("INSERT INTO employee(name,position,age) VALUES(:name,:position,:age)", array());
?>