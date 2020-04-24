<?php

require_once 'dbDetails.php';
 
//Getting the server ip
$server_ip = gethostbyname(gethostname());
 
//creating the upload url
 $upload_url="question/";
//response array
$fields = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['Subjectid']) and isset($_POST['Type']))
    {
       $con=mysqli_connect("localhost","id5039311_studentassesment","studentass123","id5039311_studentassesment") or die('Unable to Connect...');
		$Subjectid = $_POST['Subjectid'];
		$Type = $_POST['Type'];
		
		$fileinfo = pathinfo($_FILES['Assignmentpdf']['name']);
 $fileinfo1 = $_FILES['Assignmentpdf']['name'];                                              
        //getting the file extension                                                            
       // $extension = $fileinfo['extension'];                                                    
 
               //file url to store in the database                                              
    $file_url = $upload_url. getFileName().$fileinfo1;                   
        //file path to upload in the server                                                   
        $file_path = getFileName().$fileinfo1; 
        
            //saving the file
       
            move_uploaded_file($_FILES['Assignmentpdf']['tmp_name'],$file_url);
            $sql = "INSERT INTO `assignment_que` (`Subjectid`,`Assignmentpdf`,`Type`) VALUES ('$Subjectid','$file_path','$Type');";
 
            //adding the path and name to database
            if(mysqli_query($con,$sql)){
 
                //filling response array with values
                $fields = array( "Subjectid" => $Subjectid,
								"Assignmentpdf"=>$file_url,
                                "Type"=>$Type
									
								);
            }
           
        
    }
				//header('Content-type: application/json');
				echo json_encode(array('status'=>1,'Question_details'=> $fields,'message'=>'Question added successfully.'));
			}

function getFileName(){
    error_reporting(E_ERROR);
   $con = mysqli_connect("localhost","id5039311_studentassesment","studentass123","id5039311_studentassesment") or die('Unable to Connect...');
    $sql = "SELECT max(AssignmentQueid) as id FROM assignment_que";
    $result = mysqli_fetch_array(mysqli_query($con,$sql));
 
    mysqli_close($con);
    if($result['id']==null)
        return 1;
    else
        return ++$result['id'];
}

				
?>