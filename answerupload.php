<?php

require_once 'dbDetails.php';
 
//Getting the server ip
$server_ip = gethostbyname(gethostname());
 
//creating the upload url
 $upload_url="answer/";
//response array
$fields = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['Userid']) and isset($_POST['AssignmentQueid']) and isset($_POST['Dt']))
    {
        $con = mysqli_connect('localhost','root','','assesmentweb') or die('Unable to Connect...');
		$Userid = $_POST['Userid'];
		$AssignmentQueid = $_POST['AssignmentQueid'];
		$Dt = $_POST['Dt'];

		$fileinfo = pathinfo($_FILES['Assignmentanspdf']['name']);
 
        //getting the file extension
        $extension = $fileinfo['extension'];
 
               //file url to store in the database
    $file_url = $upload_url. getFileName() . '.' . $extension;
        //file path to upload in the server
        $file_path = getFileName() . '.'. $extension;
        
            //saving the file
       
            move_uploaded_file($_FILES['Assignmentanspdf']['tmp_name'],$file_url);
            $sql = "INSERT INTO `assignment_ans` (`Userid`,`AssignmentQueid`,`Assignmentanspdf`,`Dt`) VALUES ('$Userid','$AssignmentQueid','$file_path','$Dt');";
 
            //adding the path and name to database
            if(mysqli_query($con,$sql)){
 
                //filling response array with values
                $fields = array( "Userid" => $Userid,
                                "AssignmentQueid"=>$AssignmentQueid,
								"Assignmentanspdf"=>$file_url,
                                "Dt"=>$Dt
                               );
            }
           
        
    }
				//header('Content-type: application/json');
				echo json_encode(array('status'=>1,'Answer_details'=> $fields,'message'=>'Answer added successfully.'));
			}

function getFileName(){
    error_reporting(E_ERROR);
    $con = mysqli_connect("localhost","root","","assesmentweb") or die('Unable to Connect...');
    $sql = "SELECT max(AssignmentAnsid) as id FROM assignment_ans";
    $result = mysqli_fetch_array(mysqli_query($con,$sql));
 
    mysqli_close($con);
    if($result['id']==null)
        return 1;
    else
        return ++$result['id'];
}

				
?>