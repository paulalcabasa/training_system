<?php
class Job{
	
	public function addJobCategory($category_name){
		$db = Database::getInstance();
		$sql = "INSERT INTO job_category(category_name) VALUES(:category_name)";
		$result = $db->query($sql,array(":category_name"=>$category_name));
	}

	public function getJobCategory(){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT * FROM job_category");
		$stmt->execute();
		$output = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$category = $row['category_name'];
			$id = $row['category_id'];
			$enc_id = $conn->encryptor("encrypt",$id);
			$enc_name = $conn->encryptor("encrypt",$category);
			$output .= "<tr>";
				$output .= "<td>
					<span class='j_cat' title='Click to edit'>$category</span>
					<div class='input-group' style='display:none;'>
						<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$category' />
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
				  	<li><a href='manage_job_positions.php?d=$enc_id&n=$enc_name'>View Jobs</a></li>
				    <li><a href='#' data-id='$id' class='btn_delete'>Delete</a></li>
				   
				   </ul>
				</div></td>";
			
			$output .= "</tr>";

		}
		$conn->closeConnection();
		return $output;
	}

	public function updateJobCategory($id,$name){
		$db = Database::getInstance();
		$sql = "UPDATE job_category SET category_name = :name WHERE category_id = :id";
		$db->query($sql,array(":name"=>$name,":id"=>$id));
	}

	public function deleteJobCategory($id){
		$db = Database::getInstance();
		
		$sql = "DELETE FROM job_category WHERE category_id = :id";
		$db->query($sql,array(":id"=>$id));

		$sql = "UPDATE job_position SET job_category = NULL WHERE job_category = :id";
		$db->query($sql,array(":id"=>$id));
	}

	public function addJob($job_category,$job_position){
		$db = Database::getInstance();;
		$sql = "INSERT INTO job_position(job_category,job_description) VALUES(:category,:position)";
		$db->query($sql,array(":category"=>$job_category,":position"=>$job_position));
	}

	public function getJobPosition($cat){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT * FROM job_position WHERE job_category = :cat");
		$stmt->bindParam(":cat",$cat,PDO::PARAM_STR);
		$stmt->execute();
		$output = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id = $row['job_id'];
			$job = $row['job_description'];
			$output .= "<tr>";
				$output .= "<td>
					<span class='j_pos' title='Click to edit'>$job</span>
					<div class='input-group' style='display:none;'>
						<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$job' />
						<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
						<span class='input-group-btn'>
							<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id'>Save</button>	
						</span>
					</div>
					</td>";
				$output .= "<td><button type='button' data-id='$id' class='btn btn-danger btn-sm btn_delete'>Delete</button></td>";
			$output .= "</tr>";

		}
		$conn->closeConnection();
		return $output;
	}

	public function updateJobPosition($id,$job){
		$db = Database::getInstance();
		$sql = "UPDATE job_position SET job_description = :job WHERE job_id = :id";
		$db->query($sql,array(":job"=>$job,":id"=>$id));
	}

	public function deleteJob($id){
		$db = Database::getInstance();
		$sql = "DELETE FROM job_position WHERE job_id = :id";
		$db->query($sql,array(":id"=>$id));
	}

	public function getJobPositionOption(){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT * FROM job_category ORDER BY category_name ASC");
		$stmt->execute();
		$output = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$category = $row['category_name'];
			$cat_id = $row['category_id'];
			$output .= "<optgroup label='".$category."'>";
				$get_ops = $conn->prepare("SELECT * FROM job_position WHERE job_category = :cat_id");
				$get_ops->bindParam(":cat_id",$cat_id,PDO::PARAM_INT);
				$get_ops->execute();
				while($ops = $get_ops->fetch(PDO::FETCH_ASSOC)){
					$job_id = $ops['job_id'];
					$job_desc = $ops['job_description'];
					$output .= "<option value='".$job_id."'>" . $job_desc. "</option>";
				}
			$output .= "</optgroup>";
		}
		$conn->closeConnection();
		return $output;
	}
    
    public function getJobDescription($id){
        $output = "";
        $conn = new Connection();
        $stmt = $conn->prepare("SELECT job_description AS job FROM job_position WHERE job_id = :id");
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch();
        $conn->closeConnection();
        return $data['job'];
    }

  
}
?>