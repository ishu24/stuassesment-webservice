<?php

require_once 'dbDetails.php';
 
//Getting the server ip
$server_ip = gethostbyname(gethostname());
 
//creating the upload url
 $upload_url="answersheet/";
//response array
$fields = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['Subjectid']) and isset($_POST['Semestername']) and isset($_POST['Midname']))
    {
        $con = mysqli_connect('localhost','root','','assesmentweb') or die('Unable to Connect...');
		$Subjectid = $_POST['Subjectid'];
		$Semestername = $_POST['Semestername'];
		$Midname = $_POST['Midname'];
		$fileinfo = pathinfo($_FILES['Answersheetpdf']['name']);
 
        //getting the file extension
        $extension = $fileinfo['extension'];
 
               //file url to store in the database
    $file_url = $upload_url. getFileName() . '.' . $extension;
        //file path to upload in the server
        $file_path = getFileName() . '.'. $extension;
        
            //saving the file
       
            move_uploaded_file($_FILES['Answersheetpdf']['tmp_name'],$file_url);
            $sql = "INSERT INTO `answersheet`(`Answersheetpdf`,`Subjectid`,`Semestername`,`Midname`) VALUES ('$file_path','$Subjectid','$Semestername','$Midname');";
 
            //adding the path and name to database
            if(mysqli_query($con,$sql)){
 
                //filling response array with values
                $fields = array( "Subjectid" => $Subjectid,
                                "Semestername"=>$Semestername,
                                "Midname"=>$Midname,
								"Answersheetpdf"=>$file_url
                               );
            }
           
        
    }
				//header('Content-type: application/json');
				echo json_encode(array('status'=>1,'Answersheet_details'=> $fields,'message'=>'Answersheet added successfully.'));
			}

function getFileName(){
    error_reporting(E_ERROR);
    $con = mysqli_connect("localhost","root","","assesmentweb") or die('Unable to Connect...');
    $sql = "SELECT max(Answersheetid) as id FROM answersheet";
    $result = mysqli_fetch_array(mysqli_query($con,$sql));
 
    mysqli_close($con);
    if($result['id']==null)
        return 1;
    else
        return ++$result['id'];
}

				
?>