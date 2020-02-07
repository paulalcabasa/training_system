<?php

class Dealer {

	private $dealer_group_name,$dealer_group_id,
			$dealer_main_name,$dealer_code,$dealer_main_id,
			$dealer_sattelite_code,$dealer_satellite_name,$dealer_satellite_id,$dealer_abbrev,$dealer_sat_abbrev;

	public function setDealerGroupName($name){
		$this->dealer_group_name = $name;
	}

	public function setDealerGroupId($id){
		$this->dealer_group_id = $id;
	}

	public function setDealerCode($code){
		$this->dealer_code = $code;
	}

	public function setDealerMainName($name){
		$this->dealer_main_name = $name;
	}

	public function setDealerMainId($id){
		$this->dealer_main_id = $id;
	}

	public function setDealerSatelliteCode($code){
		$this->dealer_sattelite_code = $code;
	}

	public function setDealerSatelliteName($name){
		$this->dealer_satellite_name = $name;
	}

	public function setDealerSatelliteId($id){
		$this->dealer_satellite_id = $id;
	}

	public function setDealerAbbrev($abbrev){
		$this->dealer_abbrev = $abbrev;
	}

	public function setDealerSatAbbrev($abbrev){
		$this->dealer_sat_abbrev = $abbrev;
	}

	public function addDealerGroup($dealer_group_name,$user){	
		$db = Database::getInstance();
		$sql = "INSERT INTO dealer_group(dealer_group_name,create_user,date_created) 
				VALUES(:dealer_group_name,:create_user,NOW())";
		$result = $db->query($sql,array(
									":dealer_group_name" => $dealer_group_name,
									":create_user" => $user
								  )
							);
			
	}

	public function getDealerGroup(){
		try {
			$output = "";
			$conn = new Connection();
			$stmt = $conn->prepare("SELECT * FROM dealer_group WHERE delete_user IS NULL");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$id = $row['dealer_group_id'];
				$enc_id = $conn->encryptor("encrypt",$id);
				$dealer_group_name = $row['dealer_group_name'];
				$output .= "<tr>";

					$output .= "<td>
						<span class='d_gname' title='Click to edit'>$dealer_group_name</span>
						<div class='input-group' style='display:none;'>
							<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$dealer_group_name' />
							<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
							<span class='input-group-btn'>
								<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id'>Save</button>	
							</span>
						</div>
						</td>";
					$output .= "<td><div class='btn-group'>
					  <button type='button' class='btn btn-info btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
					    Action <span class='caret'></span>
					  </button>

					  <ul class='dropdown-menu dropdown-menu-right'>
					  	<li><a href='manage_dealers.php?d=$enc_id'>View Dealers</a></a></li>
						<li><a href='#' data-id='$id' data-gname='$dealer_group_name' class='btn_delete'>Delete</a></li>
					  </ul>
					</div></td>";
					
				$output .= "</tr>";

			}
			$conn->closeConnection();
			return $output;	
		} catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function updateDealerGroup($dealer_group_id,$dealer_group_name,$user){
		$db = Database::getInstance();
		$sql = "UPDATE dealer_group SET dealer_group_name = :dealer_group_name, 
										update_user = :update_user
				WHERE dealer_group_id = :dealer_group_id";
		$db->query($sql,array(":dealer_group_name"=>$dealer_group_name,":dealer_group_id"=>$dealer_group_id,":update_user"=>$user));
	}

	public function deleteDealerGroup($dealer_group_id,$user){
		$db = Database::getInstance();

		$sql = "UPDATE dealer_group SET delete_user = :delete_user,
										date_deleted = NOW()
				WHERE dealer_group_id = :id";
		$db->query($sql,array(":delete_user"=>$user,":id"=>$dealer_group_id));
		
		$sql = "UPDATE dealers_master SET dealer_group_id = NULL,
										  update_user = :update_user,
										  date_updated = NOW()
				WHERE dealer_group_id = :id";
		$db->query($sql,array(":update_user"=>$user,":id"=>$dealer_group_id));
	}


	public function getDealerMain($id){
		try {
			$output = "";
			$conn = new Connection();
			$stmt = $conn->prepare("SELECT * FROM dealer_main WHERE dealer_group_id = :id");
			$stmt->bindParam(":id",$id,PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$id = $row['dealer_main_id'];
				$dealer_name = ucfirst($row['dealer_main_name']);
				$dealer_code = ucfirst($row['dealer_code']);
				$dealer_abbr = $row['dealer_abbrev'];
				
				$enc_id = $conn->encryptor("encrypt",$id);
				$enc_dealer_name = $conn->encryptor("encrypt",$dealer_name);
				$output .= "<tr>";
					$output .= "<td>
						<span class='dealer_code' title='Click to edit'>$dealer_code</span>
						<div class='input-group' style='display:none;'>
							<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$dealer_code' />
							<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
							<span class='input-group-btn'>
								<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id' data-action='Dealer Code'><i class='fa fa-save fa-1x'></i></button>	
							</span>
						</div>
						</td>";
					$output .= "<td>
						<span class='dealer_name' title='Click to edit'>$dealer_name</span>
						<div class='input-group' style='display:none;'>
							<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$dealer_name' />
							<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
							<span class='input-group-btn'>
								<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id' data-action='Dealer Name'><i class='fa fa-save fa-1x'></i></button>	
							</span>
						</div>
						</td>";
					$output .= "<td>
						<span class='dealer_abbrev' title='Click to edit'>$dealer_abbr</span>
						<div class='input-group' style='display:none;'>
							<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$dealer_abbr' />
							<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
							<span class='input-group-btn'>
								<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id' data-action='Dealer Abbrev'><i class='fa fa-save fa-1x'></i></button>	
							</span>
						</div>
						</td>";
					$output .= "<td><div class='btn-group'>
					  <button type='button' class='btn btn-info btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
					    Action <span class='caret'></span>
					  </button>

					  <ul class='dropdown-menu dropdown-menu-right'>
						  <li><a href='manage_satellites.php?d=$enc_id&n=$enc_dealer_name'>View Satellites</a></li>
						  <li><a href='#' data-id='$id' class='btn_delete'>Delete</a></li>
					  </ul>
					</div></td>";
					
				$output .= "</tr>";

			}
			$conn->closeConnection();
			return $output;	
		} catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function addDealer($dealer_type_id,$dealer_parent_id,$dealer_group_id,$dealer_code,$dealer_name,$dealer_abbrev,$user){
		$db = Database::getInstance();
		$sql = "INSERT INTO dealers_master(dealer_type_id,dealer_parent_id,dealer_group_id,dealer_code,dealer_name,dealer_abbrev,create_user,date_created)
				VALUES(:dealer_type_id,:dealer_parent_id,:dealer_group_id,:dealer_code,:dealer_name,:dealer_abbrev,:create_user,NOW())";
		$result = $db->query($sql,array(
								  	":dealer_type_id" => $dealer_type_id,
								  	":dealer_parent_id" => $dealer_parent_id,
								  	":dealer_group_id" => $dealer_group_id,
								  	":dealer_code" => $dealer_code,
								  	":dealer_name" => $dealer_name,
								  	":dealer_abbrev" => $dealer_abbrev,
								  	":create_user" =>  $user
								  )
							);
	}

	public function updateDealerMain($user){
		try {
			$conn = new Connection();
			$today = $conn->getDateToday();
			$stmt = $conn->prepare("UPDATE dealer_main SET dealer_code = :dealer_code, dealer_main_name = :dealer_main_name, dealer_abbrev = :abbrev, update_user = :update_user WHERE dealer_main_id = :dealer_main_id");
			$stmt->bindParam(":dealer_main_id",$this->dealer_main_id,PDO::PARAM_INT);
			$stmt->bindParam(":dealer_code",$this->dealer_code,PDO::PARAM_STR);
			$stmt->bindParam(":dealer_main_name",$this->dealer_main_name,PDO::PARAM_STR);
			$stmt->bindParam(":abbrev",$this->dealer_abbrev,PDO::PARAM_STR);
			$stmt->bindParam(":update_user",$user,PDO::PARAM_INT);
			$rows = $stmt->execute();
			$conn->closeConnection();
			return $rows;
		} catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function deleteDealerMain(){
		try {
			$conn = new Connection();
			$get_main = $conn->prepare("SELECT dealer_main_id FROM dealer_main WHERE dealer_main_id = :id");
			$get_main->bindParam(":id",$this->dealer_main_id,PDO::PARAM_INT);
			$get_main->execute();
			while($row = $get_main->fetch(PDO::FETCH_ASSOC)){
				$delete_sat = $conn->prepare("DELETE FROM dealer_satellite WHERE dealer_main_id = :main_id");
				$delete_sat->bindParam(":main_id",$row['dealer_main_id'],PDO::PARAM_INT);
				$delete_sat->execute();
			}
			$delete_main = $conn->prepare("DELETE FROM dealer_main WHERE dealer_main_id = :id");
			$delete_main->bindParam(":id",$this->dealer_main_id,PDO::PARAM_INT);
			$rows = $delete_main->execute();
			$conn->closeConnection();
			return $rows;
		} catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function addSatellite($user){
		try {
			$conn = new Connection();
			$today = $conn->getDateToday();
			$stmt = $conn->prepare("INSERT INTO dealer_satellite(dealer_satellite_name,dealer_code,dealer_main_id,dealer_abbrev,create_user,date_created) VALUES(:name,:dealer_code,:main_id,:abbrev,:create_user,:date_created)");
			$stmt->bindParam(":name",$this->dealer_satellite_name,PDO::PARAM_STR);
			$stmt->bindParam(":dealer_code",$this->dealer_sattelite_code,PDO::PARAM_STR);
			$stmt->bindParam(":abbrev",$this->dealer_sat_abbrev,PDO::PARAM_STR);
			$stmt->bindParam(":main_id",$this->dealer_main_id,PDO::PARAM_STR);
			$stmt->bindParam(":create_user",$user,PDO::PARAM_INT);
			$stmt->bindParam(":date_created",$today,PDO::PARAM_STR);
			$rows = $stmt->execute();
			$conn->closeConnection();
			return $rows;
		} catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function getDealerSatellite($id){
		try {
			$output = "";
			$conn = new Connection();
			$stmt = $conn->prepare("SELECT * FROM dealer_satellite WHERE dealer_main_id = :id");
			$stmt->bindParam(":id",$id,PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$id = $row['dealer_satellite_id'];
				$dealer_name = ucfirst($row['dealer_satellite_name']);
				$dealer_code = ucfirst($row['dealer_code']);
				$dealer_abbrev = $row['dealer_abbrev'];
				$enc_id = $conn->encryptor("encrypt",$id);
				$enc_dealer_name = $conn->encryptor("encrypt",$dealer_name);
				$output .= "<tr>";
					$output .= "<td>
						<span class='dealer_code' title='Click to edit'>$dealer_code</span>
						<div class='input-group' style='display:none;'>
							<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$dealer_code' />
							<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
							<span class='input-group-btn'>
								<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id' data-action='Dealer Code'><i class='fa fa-save fa-1x'></i></button>	
							</span>
						</div>
						</td>";
					$output .= "<td>
						<span class='dealer_name' title='Click to edit'>$dealer_name</span>
						<div class='input-group' style='display:none;'>
							<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$dealer_name' />
							<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
							<span class='input-group-btn'>
								<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id' data-action='Dealer Name'><i class='fa fa-save fa-1x'></i></button>	
							</span>
						</div>
						</td>";
					$output .= "<td>
						<span class='dealer_abbrev' title='Click to edit'>$dealer_abbrev</span>
						<div class='input-group' style='display:none;'>
							<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$dealer_abbrev' />
							<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
							<span class='input-group-btn'>
								<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id' data-action='Dealer Abbrev'><i class='fa fa-save fa-1x'></i></button>	
							</span>
						</div>
						</td>";
					$output .= "<td><button type='button' data-id='$id' class='btn btn-danger btn-sm btn_delete'>Delete</button></td>";
				$output .= "</tr>";

			}
			$conn->closeConnection();
			return $output;	
		} catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function updateDealerSatellite($user){
		try {
			$conn = new Connection();
			$today = $conn->getDateToday();
			$stmt = $conn->prepare("UPDATE dealer_satellite SET dealer_code = :dealer_code, dealer_satellite_name = :dealer_satellite_name, dealer_abbrev = :abbrev, update_user = :update_user WHERE dealer_satellite_id = :dealer_satellite_id");
			$stmt->bindParam(":dealer_satellite_id",$this->dealer_satellite_id,PDO::PARAM_INT);
			$stmt->bindParam(":dealer_code",$this->dealer_sattelite_code,PDO::PARAM_STR);
			$stmt->bindParam(":dealer_satellite_name",$this->dealer_satellite_name,PDO::PARAM_STR);
			$stmt->bindParam(":abbrev",$this->dealer_sat_abbrev,PDO::PARAM_STR);
			$stmt->bindParam(":update_user",$user,PDO::PARAM_INT);
			$rows = $stmt->execute();
			$conn->closeConnection();
			return $rows;
		} catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function deleteSatellite(){
		try {
			$conn = new Connection();
			$delete_satellite = $conn->prepare("DELETE FROM dealer_satellite WHERE dealer_satellite_id = :id");
			$delete_satellite->bindParam(":id",$this->dealer_satellite_id,PDO::PARAM_INT);
			$rows = $delete_satellite->execute();
			$conn->closeConnection();
			return $rows;
		} catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function getDealersByGroup($dealer_group_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   dealer_type_id,
					   dealer_code,
					   dealer_name,
					   dealer_abbrev
				FROM dealers_master 
				WHERE dealer_type_id = 1 AND dealer_group_id = :dealer_group_id
				      and delete_user is null";
		$result = $db->query($sql,array(":dealer_group_id"=>$dealer_group_id));
		return $result;
	}

	public function getSatelliteByDealer($dealer_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   dealer_type_id,
					   dealer_code,
					   dealer_name,
					   dealer_abbrev
				FROM dealers_master 
				WHERE dealer_type_id = 2 AND dealer_parent_id = :dealer_parent_id
					   and delete_user is null";
		$result = $db->query($sql,array(":dealer_parent_id"=>$dealer_id));
		return $result;
	}

	public function getDealerGroupDetails($dealer_group_id){
		$db = Database::getInstance();
		$sql = "SELECT dealer_group_id,
					   dealer_group_name
				FROM dealer_group
				WHERE dealer_group_id = :dealer_group_id";
		$result = $db->query($sql,array(":dealer_group_id"=>$dealer_group_id));
		$data = (object)$result[0];
		return $data;
	}

	public function updateDealer($dealer_id,$dealer_code,$dealer_name,$dealer_abbrev,$user){
		$db = Database::getInstance();
		$sql = "UPDATE dealers_master SET dealer_code = :dealer_code,
										  dealer_name = :dealer_name,
										  dealer_abbrev = :dealer_abbrev,
										  update_user = :update_user,
										  date_updated = NOW()
				WHERE id = :dealer_id";
		$result = $db->query($sql,array(
								  	":dealer_code" => $dealer_code,
								  	":dealer_name" => $dealer_name,
								  	":dealer_abbrev" => $dealer_abbrev,
								  	":update_user" => $user,
								  	":dealer_id" => $dealer_id
								  )
							);
	}

	public function getDealerDetails($dealer_id){
		$db = Database::getInstance();
		$sql = "SELECT a.id,
					   a.dealer_type_id,
					   a.dealer_parent_id,
					   a.dealer_group_id,
					   a.dealer_code,
					   a.dealer_name,
					   a.dealer_abbrev,
					   b.dealer_group_name
				FROM dealers_master a LEFT JOIN dealer_group b ON a.dealer_group_id = b.dealer_group_id
				WHERE id = :dealer_id";
		$result = $db->query($sql,array(":dealer_id"=>$dealer_id));
		return (object)$result[0];
	}

	public function getDealersList(){
		$db = Database::getInstance();
		$sql = "SELECT a.id,
				       b.type,
				       a.dealer_name
				FROM dealers_master a LEFT JOIN dealer_type b 
					ON a.dealer_type_id = b.id
				WHERE a.delete_user IS NULL
				ORDER BY a.dealer_name";
		$result = $db->query($sql,false);
		return $result;
	}

	public function getDealersListWithCountOfTrainees(){
		$db = Database::getInstance();
		$sql = "SELECT a.id,
				       a.dealer_name,
				       (SELECT COUNT(trainee_code) FROM trainees_masterfile WHERE dealer_id = a.id and delete_user is null) trainee_count
				FROM dealers_master a
				WHERE delete_user IS NULL
				ORDER BY a.dealer_name";
		$result = $db->query($sql,false);
		return $result;
	}
}	
?>