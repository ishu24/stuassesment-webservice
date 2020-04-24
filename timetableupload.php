<?php

require_once 'dbDetails.php';
 
//Getting the server ip
$server_ip = gethostbyname(gethostname());
 
//creating the upload url
 $upload_url="timetable/";
//response array
$fields = array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['Userid']) and isset($_POST['Semestername']) and isset($_POST['Midname']))
    {
        $con = mysqli_connect('localhost','root','','assesmentweb') or die('Unable to Connect...');
		$Userid = $_POST['Userid'];
		$Semestername = $_POST['Semestername'];
		$Midname = $_POST['Midname'];
		$fileinfo = pathinfo($_FILES['Timetablepdf']['name']);
 
        //getting the file extension
        $extension = $fileinfo['extension'];
 
               //file url to store in the database
    $file_url = $upload_url. getFileName() . '.' . $extension;
        //file path to upload in the server
        $file_path = getFileName() . '.'. $extension;
        
            //saving the file
       
            move_uploaded_file($_FILES['Timetablepdf']['tmp_name'],$file_url);
            $sql = "INSERT INTO `timetable`(`Timetablepdf`,`Userid`,`Semestername`,`Midname`) VALUES ('$file_path','$Userid','$Semestername','$Midname');";
 
            //adding the path and name to database
            if(mysqli_query($con,$sql)){
 
                //filling response array with values
                $fields = array( "Userid" => $Userid,
                                "Semestername"=>$Semestername,
                                "Midname"=>$Midname,
								"Timetablepdf"=>$file_url
                               );
            }
           
        
    }
				//header('Content-type: application/json');
				echo json_encode(array('status'=>1,'Timetable_details'=> $fields,'message'=>'Timetable added successfully.'));
			}

function getFileName(){
    error_reporting(E_ERROR);
    $con = mysqli_connect("localhost","root","","assesmentweb") or die('Unable to Connect...');
    $sql = "SELECT max(Timetableid) as id FROM timetable";
    $result = mysqli_fetch_array(mysqli_query($con,$sql));
 
    mysqli_close($con);
    if($result['id']==null)
        return 1;
    else
        return ++$result['id'];
}

				
?>