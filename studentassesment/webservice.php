<?php

$file = fopen('php://input','r');
$jsonInput ="";
while(! feof($file))
  {
	$jsonInput .= fgets($file);
  }

fclose($file);

$input_params  = json_decode($jsonInput,true);


	include("include/common_vars.php");
	include("include/common_class.php");
	//include("include/session.php");
	include("include/config.php");
	include("include/function.php");
	include('include/classes/SMTPClass.php');
	include('include/classes/PHPMailer.class.php');
	include('include/classes/SMTP.class.php');
	include("include/postNotification.php");
	
	$logo="http://studentevaluationsystem.000webhostapp.com/studentassesment/logo/";
	$question="http://studentevaluationsystem.000webhostapp.com/studentassesment/question/";
	$answer="http://studentevaluationsystem.000webhostapp.com/studentassesment/answer/";
	$timetable="http://studentevaluationsystem.000webhostapp.com/studentassesment/timetable/";
	$answersheet="http://studentevaluationsystem.000webhostapp.com/studentassesment/answersheet/";
	function checkuserforinactive($Email){
		$checkstatesql = mysql_query("SELECT Email FROM user WHERE Email = '".$Email."'");
		$checkstatefetch = mysql_fetch_assoc($checkstatesql);
		
		if(empty($checkstatefetch)){
			header('Content-Type: application/json');
			echo json_encode(array('status' => 'ERROR', 'message' => 'Requested username is not here'));
			exit;
		}
	}
	
	function checkemail($Email)
	{
		
		$checkInactiveUserSql = mysql_query("select Email from user where Email='".$Email."'");
		$inactive_user=mysql_fetch_assoc($checkInactiveUserSql);
		
		if(empty($inactive_user))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>"ERROR",'message'=>'Your account has been deactivated or deleted by system.'));
			exit;
		}
	}
	function get_User_name($Userid) {
		global $con;
		
		$get_Username = $con->select_query("user","*","where Userid=".$Userid." ");
		$get_Username = mysql_fetch_assoc($get_Username);
		
		return $get_Username['Username'];
	}
	function get_Subject_name($Subjectid) {
		global $con;
		
		$get_Subjectname = $con->select_query("subject","*","where Subjectid=".$Subjectid." ");
		$get_Subjectname = mysql_fetch_assoc($get_Subjectname);
		
		return $get_Subjectname['Subjectname'];
	}
	function get_Subject1_name($AssignmentQueid) {
		global $con;
		
		$get_Subjectname = $con->select_query("assignment_que","*","where AssignmentQueid=".$AssignmentQueid." ");
		$get_Subjectname = mysql_fetch_assoc($get_Subjectname);
		
		return $get_Subjectname['Subjectid'];
	}
		
  //------------------------------------------  user registeration ---------------------------------------//	
	if($input_params['mode'] == 'userregister')
	{
		$Username = $input_params['Username'];
		$Eno_Fid = $input_params['Eno_Fid'];
		$Email = $input_params['Email'];
		$Password = $input_params['Password'];
		$Contact = $input_params['Contact'];
		$College = $input_params['College'];
		$Department = $input_params['Department'];
		$Semester = $input_params['Semester'];
		$Type = $input_params['Type'];
		
	if(empty($Username) ||  empty($Eno_Fid) || empty($Email) || empty($Password) || empty($Contact) || empty($College) || empty($Department) ||empty($Type) )
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
			
			$query_user_detail=$con->select_query("user","*"," Where Email='".$Email."'");
			$rowfetch = mysql_fetch_assoc($query_user_detail);			
			
			if(mysql_num_rows($query_user_detail) > 0){
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Email already exists.'));
				die();
			}
			else{

				$fields = array( "Username" => $Username,
								 "Eno_Fid" => $Eno_Fid,
								 "Email" => $Email,
								 "Password" => $Password,
								 "Contact" => $Contact,
								 "College"=>$College,
								 "Department" => $Department,
								 "Semester" => $Semester,
								 "Type" => $Type	 
							 );
		
				$insert_user=$con->insert_record("user",$fields);
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,'message'=>' Successfull Registration'));	
			}
		}
	}

	//------------------------------------------ user Login  ---------------------------------------//
	else if($input_params['mode']=='userlogin')
	{
		
		$Email = $input_params['Email'];
		$Password = $input_params['Password'];
			
		if(empty($Email) || empty($Password))
		{
			header('Content-type: application/json');
			echo json_encode(array("status"=>0,"message"=>"Please Fill all Required Fields"));	
		}
		else
		{
			$check_login_query = $con->select_query("user","*","where Email='".$Email."' AND Password='".$Password."'");
		
			if(mysql_num_rows($check_login_query)>0)
			{
				$fetchResult = mysql_fetch_assoc($check_login_query);
				$Userid=$fetchResult['Userid'];
				$updateData = array("Status"=>1);

			$update_details1 = $con->update("user",$updateData,"where Userid='".$Userid."'");
				$redit = array(    
				                "Userid"=> intval($fetchResult['Userid']),
				                "Username"=> $fetchResult['Username'],
				                "Eno_Fid"=> $fetchResult['Eno_Fid'],
				                "Email"=> $fetchResult['Email'],
				                "Contact"=> $fetchResult['Contact'],
				                "College"=> $fetchResult['College'],
								"Department"=> $fetchResult['Department'],
								"Semester"=> $fetchResult['Semester'],
								"Type"=>$fetchResult['Type']
								
										);
				header('Content-type: application/json');
				echo json_encode(array("status"=>1,"user_details"=>$redit,"message"=>"You are Successfully Logged in"));
			}
			else
			{
				header('Content-type: application/json');
				echo json_encode(array("status"=>0,"message"=>"Invalid Email and Password"));
			}
		}
	}
	
	//************************************** user edit *****************************************************************************************************//	
	else if($input_params['mode']=='useredit')
	{
	    $Userid = $input_params["Userid"];
		$Username = $input_params['Username'];
		$Eno_Fid = $input_params['Eno_Fid'];
		$Email = $input_params['Email'];
		$Contact = $input_params['Contact'];
		$Semester = $input_params['Semester'];
		
		$College = $input_params['College'];
		$Department = $input_params['Department'];
				
	if(empty($Username) ||  empty($Eno_Fid) || empty($Email) || empty($Contact) || empty($College) || empty($Department))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
		else
		{
		
			$fetch_query = $con->select_query("user","*","where Userid='".$Userid."'");
			$rowFetch = mysql_fetch_assoc($fetch_query);

			$update_details = array(
								"Userid"=>$Userid,
								 "Username" => $Username,
								 "Eno_Fid" => $Eno_Fid,
								 "Email" => $Email,
								 "Contact" => $Contact,
								 "Semester"=>$Semester,
								 "College"=>$College,
								 "Department" => $Department
								 
									);

				$update_details = $con->update("user",$update_details,"where Userid='".$Userid."'");

				$fetch_data = $con->select_query("user","*","where Userid='".$Userid."'","","");
				$fetchResult = mysql_fetch_assoc($fetch_data);

				$redit = array(    
				                "Userid"=> intval($fetchResult['Userid']),
				                "Username"=> $fetchResult['Username'],
				                "Eno_Fid"=> $fetchResult['Eno_Fid'],
				                "Email"=> $fetchResult['Email'],
				                "Contact"=> $fetchResult['Contact'],
				                "Semester"=>$fetchResult['Semester'],
				                "College"=> $fetchResult['College'],
								"Department"=> $fetchResult['Department']
								
										);

				header('Content-type:application/json');
				echo json_encode(array("status"=>1,'user_details'=> $redit,"message"=>"You are successfully updated your detail"));
		}

	}
//--------------------------------user Change Password ----------------------------------------------------------------------------------------------------------//
	else if($input_params['mode']=='changepassword')
	{
		$Email = $input_params['Email'];
		$Password = $input_params['Password'];
		$Newpassword = $input_params["Newpassword"];

		if(empty($Email) || empty($Password))
		{
			header('Content-type: application/json');
			echo json_encode(array("status"=>0,"message"=>"Please Fill all Required Fields"));	
		}
		else
		{
			checkuserforinactive($Email);
			
			$userPQuery = $con->select_query("user","*","where Email='".$Email."' and Password='".$Password."'");
			//print_r($userPQuery);
			$fetchPassword = mysql_fetch_assoc($userPQuery);
			$Userid=$fetchPassword['Userid'];
				$Username=$fetchPassword['Username'];
			if($fetchPassword['Password'] != $Password)
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Invalid current Password'));
				exit;
			}
			else
			{
				$renew_pass = array('Password'=>$Newpassword);
				//print_r($renew_pass);
				$query = $con->update("user",$renew_pass,"where Email='".$Email."' and Password='".$Password."'");
                
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,"Userid"=>$Userid,"Username"=>$Username,'message'=>'Your password has changed Successfully'));
				exit;
			}
		}
	}
	
	
		
	//------------------------------------------------------  user ForgotPasword  -------------------------------------------------------------------------//
	else if($input_params['mode'] == 'forgotpassword')
	{
		$Email = $input_params['Email'];
		if(empty($Email))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
		else
		{
			$query_user_detail=$con->select_query("user","Userid,Email,Password"," where Email='".$Email."' ","","");	
			$row_state=mysql_fetch_assoc($query_user_detail);
			if($con->total_records($query_user_detail)>0)
			{
				if($row_state['Email']!='')
				{
					
					$headers = "MIME-Version: 1.0\r\n";
	                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	                    $message="<p>your login details are as below:<b>Your Email:</b>".$row_state["Email"]."</p><p><b>Your Password:</b>".$row_state["Password"]."</p>";
	                    mail($row_state['Email']," User Forgot Password !!!",$message,$headers);
						header('Content-type: application/json');
						echo json_encode(array('status'=>1,'message'=>'Your password sent to your registered Email-id.')); 
				}
				else
				{
					header('Content-type: application/json');
					echo json_encode(array('status'=>0,'message'=>'Email does not exist.'));
				}
			}
			else
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Email does not exist.'));
			}
		}
	}
	//-----------------------------------------  user Logout ---------------------------------------//
	else if($input_params['mode']=='userlogout')
	{
		$Email =  $input_params["Email"];
		
		if(empty($Email))
		{
			header('Content-type: application/json');
			echo json_encode(array("status"=>0,"message"=>"Please fill all required fields"));	
		}else
		{
			$check_login_query = $con->select_query("user","*","where Email='".$Email."'");
			$fetchResult = mysql_fetch_assoc($check_login_query);
			$Userid=$fetchResult['Userid'];
			$updateData = array("Status"=>0);

			$update_details1 = $con->update("user",$updateData,"where Userid='".$Userid."'");

			header('Content-type: application/json');
			echo json_encode(array("status"=>1,"message"=>"You are Successfully Logout"));
		}
		
	}
	//************************************************************** add subject     *****************************************************************************//      	
    else if($input_params['mode'] == 'addsubject')
	{
		$Semestername =$input_params['Semestername'];
		$Subjectname =$input_params['Subjectname'];
		$Logo = $input_params['Logo'];
		$Userid = $input_params["Userid"];
		$Department = $input_params["Department"];

	if(empty($Semestername) ||  empty($Subjectname) || empty($Department))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
				$fields = array( "Semestername" => $Semestername,
								 "Subjectname" => $Subjectname,
								 "Userid" => $Userid,
								 "Department" => $Department
							 );
				$insert_user=$con->insert_record("subject",$fields);
				$Subjectid=mysql_insert_id();
				if($Logo!= "")
					{
						$binarytoimage = binarytoimage($Logo,$Subjectname,$Subjectid);
						$fields_image =array("Logo"=>$binarytoimage);
						$images_insert=$con->update("subject",$fields_image,"where Subjectid='".$Subjectid."'");
					}

					$userDetailwithImage = array( "Subjectid"=>$Subjectid ,
													"Semestername" => $Semestername,
								 "Subjectname" => $Subjectname,
								 "logo" =>$Logo,
								 "Userid" => $Userid,
								 "Department" => $Department


												);
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,'subject'=> $userDetailwithImage,'message'=>'Subject added successfully.'));		
		}
	}
	//----------------------------------------------------------------- View subject----------------------------------------------------------//
	else if($input_params['mode'] == 'viewsubject') 
	 { 
         	 	
			$Result =$con->select_query("subject","*","","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$subjectlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						$subjectlist[$x]['Subjectid']=intval($row_state['Subjectid']);
						$subjectlist[$x]['Semestername']=$row_state['Semestername'];
						$subjectlist[$x]['Subjectname']=$row_state['Subjectname'];
						if($row_state['Logo']!=""){
							$subjectlist[$x]['Logo']=$logo.$row_state['Logo'];
						}
						
						$subjectlist[$x]['Userid']=get_User_name($row_state['Userid']);
						$subjectlist[$x]['Department']=$row_state['Department'];
						$x++;
				}
	
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1' , 'Message'=>'All subject fetched successfully', 'subjectlist'=>$subjectlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No Subject(s) available'));  
			}
	}
	//--------------------------------view subject by semester ----------------------------------------------------------------------------------------------------------//
	else if($input_params['mode'] == 'viewsubjectbydepartment') 
	 { 
         	 	
		$Department =$input_params['Department'];
		
		if(empty($Department))
		{
			header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'Please Fill all required fields.'));  
		}
		else
		{
			$Result =$con->select_query("subject","*","where Department='".$Department."'","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$subjectlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						$subjectlist[$x]['Subjectid']=intval($row_state['Subjectid']);
						$subjectlist[$x]['Semestername']=$row_state['Semestername'];
						$subjectlist[$x]['Subjectname']=$row_state['Subjectname'];
						$subjectlist[$x]['Logo']=$row_state['Logo'];
						$subjectlist[$x]['Userid']=get_User_name($row_state['Userid']);
						$subjectlist[$x]['Department']=$row_state['Department'];
						$x++;
				}
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1',"Department"=>$Department,'Message'=>'Subject fetched successfully', 'subjectlist'=>$subjectlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'0','Message'=>'No subject(s) available'));  
			}
		}
	 }
	//--------------------------------view subject by semester and department----------------------------------------------------------------------------------------------------------//
	else if($input_params['mode'] == 'viewsubjectbysemanddep') 
	 { 
         	 	
		$Semestername =$input_params['Semestername'];
		$Department =$input_params['Department'];
		
		if(empty($Semestername) || empty($Department))
		{
			header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'Please Fill all required fields.'));  
		}
		else
		{
			$Result =$con->select_query("subject","*","where Semestername='".$Semestername."' and Department='".$Department."'","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$subjectlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						$subjectlist[$x]['Subjectid']=intval($row_state['Subjectid']);
						$subjectlist[$x]['Semestername']=$row_state['Semestername'];
						$subjectlist[$x]['Subjectname']=$row_state['Subjectname'];
						$subjectlist[$x]['Logo']=$row_state['Logo'];
						$subjectlist[$x]['Userid']=get_User_name($row_state['Userid']);
						$subjectlist[$x]['Department']=$row_state['Department'];
						$x++;
				}
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1',"Semestername"=>$Semestername,"Department"=>$Department,'Message'=>'Subject fetched successfully', 'subjectlist'=>$subjectlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No subject(s) available'));  
			}
		}
	 }
	 //************************************************************** add suggestion     *****************************************************************************//      	
	else if($input_params['mode'] == 'addsuggestion')
	{
	    $Userid = $input_params['Userid'];
	    $Suggestiondes = $input_params['Suggestiondes'];
			
	if(empty($Userid) || empty($Suggestiondes))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
				$fields = array("Userid" => $Userid, 
								"Suggestiondes" => $Suggestiondes
				                );
				$insert_user=$con->insert_record("suggestion",$fields);
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,'suggestion_details'=> $fields,'message'=>'suggestion added successfully.'));		
		}
	}	
	//----------------------------------------------------------------- View suggestion----------------------------------------------------------//
	else if($input_params['mode'] == 'viewsuggestion') 
	 { 
         	 	
			$Result =$con->select_query("suggestion","*","","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$suggestionlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						$suggestionlist[$x]['Suggestionid']=intval($row_state['Suggestionid']);
						$suggestionlist[$x]['Userid']=get_User_name($row_state['Userid']);
						$suggestionlist[$x]['Suggestiondes']=$row_state['Suggestiondes'];
						$x++;
				}
	
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1' , 'Message'=>'All suggestion fetched successfully', 'suggestionlist'=>$suggestionlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No suggestion(s) available'));  
			}
		}
		//************************************************************** add feedback     *****************************************************************************//      	
	else if($input_params['mode'] == 'addfeedback')
	{
	    $Userid = $input_params['Userid'];
	    $Feedbackdes = $input_params['Feedbackdes'];
			
	if(empty($Userid) || empty($Feedbackdes))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
				$fields = array("Userid" => $Userid, 
								"Feedbackdes" => $Feedbackdes
				                );
				$insert_user=$con->insert_record("Feedback",$fields);
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,'Feedback_details'=> $fields,'message'=>'feedback added successfully.'));		
		}
	}	
	//----------------------------------------------------------------- View suggestion----------------------------------------------------------//
	else if($input_params['mode'] == 'viewfeedback') 
	 { 
         	 	
			$Result =$con->select_query("feedback","*","","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$feedbacklist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						$feedbacklist[$x]['Feedbackid']=intval($row_state['Feedbackid']);
						$feedbacklist[$x]['Userid']=get_User_name($row_state['Userid']);
						$feedbacklist[$x]['Feedbackdes']=$row_state['Feedbackdes'];
						$x++;
				}
	
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1' , 'Message'=>'All feedback fetched successfully', 'feedbacklist'=>$feedbacklist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No feedback(s) available'));  
			}
		}
	 
	//------------------------------------------  add seating arrangment ---------------------------------------//	
	if($input_params['mode'] == 'addseatingarrangment')
	{
		
		$Midname = $input_params['Midname'];
		$Userid = $input_params['Userid'];
		$SeatNo = $input_params['SeatNo'];
		$Dttime = $input_params['Dttime'];
		$Subjectid = $input_params['Subjectid'];
		$BlockNo = $input_params['BlockNo'];
		$RoomNo = $input_params['RoomNo'];
		$BenchNo = $input_params['BenchNo'];
		
	if( empty($Midname) || empty($Userid) || empty($SeatNo) || empty($Subjectid) || empty($BlockNo) || empty($RoomNo) ||empty($BenchNo) )
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
			
			$query_user_detail=$con->select_query("seatingarrangement","*"," Where SeatNo='".$SeatNo."' and Subjectid='".$Subjectid."'");
			$rowfetch = mysql_fetch_assoc($query_user_detail);			
			
			if(mysql_num_rows($query_user_detail) > 0){
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'SeatNo already exists.'));
				die();
			}
			else{

				$fields = array( "Midname" => $Midname,
								 "Userid" => $Userid,
								 "SeatNo" => $SeatNo,
								 "Dttime" => $Dttime,
								 "Subjectid" => $Subjectid,
								 "BlockNo"=>$BlockNo,
								 "RoomNo" => $RoomNo,
								 "BenchNo" => $BenchNo	 
							 );
		
				$insert_user=$con->insert_record("seatingarrangement",$fields);
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,'arrangement_details'=> $fields,'message'=>' seatingarrangement details successfully added'));	
			}
		}
	}
	//----------------------------------------------------------------- View seating arrangment----------------------------------------------------------//
	else if($input_params['mode'] == 'viewseatingarrangment') 
	 { 
         	 	
			$Result =$con->select_query("seatingarrangement","*","","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$arrangementlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
						$arrangementlist[$x]['Midname']=$row_state['Midname'];
						$arrangementlist[$x]['Userid']=get_User_name($row_state['Userid']);
						$arrangementlist[$x]['SeatNo']=intval($row_state['SeatNo']);
						$arrangementlist[$x]['Dttime']=$row_state['Dttime'];
						$arrangementlist[$x]['Subjectid']=get_Subject_name($row_state['Subjectid']);
						$arrangementlist[$x]['BlockNo']=$row_state['BlockNo'];
						$arrangementlist[$x]['RoomNo']=$row_state['RoomNo'];
						$arrangementlist[$x]['BenchNo']=$row_state['BenchNo'];
						
						$x++;
				}
	
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1' , 'Message'=>'All arrangement fetched successfully', 'arrangementlist'=>$arrangementlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No seating arrangement(s) available'));  
			}
		}
		//----------------------------------------------------------------- View seating arrangment----------------------------------------------------------//
	else if($input_params['mode'] == 'viewseatingarrangmentbyuser') 
	 { 
         	 $Userid =$input_params['Userid'];
		
		if(empty($Userid))
		{
			header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'Please Fill all required fields.'));  
		}
		else
		{
			$Result =$con->select_query("seatingarrangement","*","where Userid='".$Userid."'","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$arrangementlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
						$arrangementlist[$x]['Midname']=$row_state['Midname'];
						$arrangementlist[$x]['Userid']=get_User_name($row_state['Userid']);
						$arrangementlist[$x]['SeatNo']=intval($row_state['SeatNo']);
						$arrangementlist[$x]['Dttime']=$row_state['Dttime'];
						$arrangementlist[$x]['Subjectid']=get_Subject_name($row_state['Subjectid']);
						$arrangementlist[$x]['BlockNo']=$row_state['BlockNo'];
						$arrangementlist[$x]['RoomNo']=$row_state['RoomNo'];
						$arrangementlist[$x]['BenchNo']=$row_state['BenchNo'];
						
						$x++;
				}
	
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1' , 'Message'=>'All arrangement fetched successfully', 'arrangementlist'=>$arrangementlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No arrangement(s) available'));  
			}
		}	
		}
		//------------------------------------------  add marksheet ---------------------------------------//	
	if($input_params['mode'] == 'addmarksheet')
	{
		$Mid1 = $input_params['Mid1'];
		$Mid2 = $input_params['Mid2'];
		$Userid = $input_params['Userid'];
		$Subjectid = $input_params['Subjectid'];
		
	if(empty($Userid)  || empty($Subjectid))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
			
			$query_user_detail=$con->select_query("marksheet","*"," Where Userid='".$Userid."' and Subjectid='".$Subjectid."'");
			$rowfetch = mysql_fetch_assoc($query_user_detail);			
			
			if(mysql_num_rows($query_user_detail) > 0){
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'student marksheet already exists.'));
				die();
			}
			else{

				$fields = array( "Mid1" => $Mid1,
								 "Mid2" => $Mid2,
								 "Userid" => $Userid,
								 "Subjectid" => $Subjectid,
								 "Average"=> (($Mid1 + $Mid2)/2)
							 );
		
				$insert_user=$con->insert_record("marksheet",$fields);
				$studentname=get_User_name($Userid);
				$subjectname=get_Subject_name($Subjectid);
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,"studentname"=>$studentname,"subjectname"=>$subjectname,'marksheet_details'=> $fields,'message'=>' marksheet details successfully added'));	
			}
		}
	}
	//----------------------------------------------------------------- View seating arrangment----------------------------------------------------------//
	else if($input_params['mode'] == 'viewmarksheet') 
	 { 
         	 	
			$Result =$con->select_query("marksheet","*","","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$marksheetlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
						$marksheetlist[$x]['Mid1']=$row_state['Mid1'];
						$marksheetlist[$x]['Mid2']=$row_state['Mid2'];
						$marksheetlist[$x]['Userid']=get_User_name($row_state['Userid']);
						$marksheetlist[$x]['Subjectid']=get_Subject_name($row_state['Subjectid']);
						$marksheetlist[$x]['Average']=$row_state['Average'];
						$x++;
				}
	
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1' , 'Message'=>'All marksheet fetched successfully', 'marksheetlist'=>$marksheetlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No marksheet(s) available'));  
			}
		}
		//--------------------------------view marksheet by student ----------------------------------------------------------------------------------------------------------//
	else if($input_params['mode'] == 'viewmarksheetbystudent') 
	 { 
         	 	
		$Userid =$input_params['Userid'];
		
		if(empty($Userid))
		{
			header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'Please Fill all required fields.'));  
		}
		else
		{
			$Result =$con->select_query("marksheet","*","where Userid='".$Userid."'","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$marksheetlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						$marksheetlist[$x]['Mid1']=$row_state['Mid1'];
						$marksheetlist[$x]['Mid2']=$row_state['Mid2'];
						$marksheetlist[$x]['Subjectid']=get_Subject_name($row_state['Subjectid']);
						$marksheetlist[$x]['Average']=$row_state['Average'];
						$x++;
				}
				$studentname=get_User_name($Userid);
				
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1',"studentname"=>$studentname,'Message'=>'marksheet fetched successfully', 'marksheetlist'=>$marksheetlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No marksheet(s) available'));  
			}
		}
	 }
	//************************************************************** add assigment/practical     *****************************************************************************//      	
	else if($input_params['mode'] == 'addassignpracque')
	{
		$Subjectid = $input_params['Subjectid'];
		$Assignmentimage = $input_params['Assignmentimage'];
		$Assignmentpdf = $input_params['Assignmentpdf'];
		$Type = $input_params['Type'];
		
	if(empty($Subjectid) || empty($Type))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
				$fields = array( 
								 "Subjectid" => $Subjectid,
								 "Assignmentimage" => $Assignmentimage,
								 "Assignmentpdf"=> $Assignmentpdf,
								 "Type" =>$Type
							 );
				$insert_user=$con->insert_record("assignment_que",$fields);
				$AssignmentQueid=mysql_insert_id();
				
				$Subjectname=get_Subject_name($Subjectid);
				if($Assignmentimage!= "")
					{
						$binarytoimage = binarytoimageque($Assignmentimage,$Userid,$Subjectname);
						$fields_image =array("Assignmentimage"=>$binarytoimage);
						$images_insert=$con->update("assignment_que",$fields_image,"where AssignmentQueid='".$AssignmentQueid."'");
					}
					
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,"Subjectname"=>$Subjectname,'message'=>'Assignment_Practical added successfully.'));		
		}
	}
	//----------------------------------------------------------------- View assignments/practical questions by subject----------------------------------------------------------//
	else if($input_params['mode'] == 'viewassignpracquebysubject') 
	 { 
         	$Subjectid =$input_params['Subjectid'];
		
		if(empty($Subjectid))
		{
			header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'Please Fill all required fields.'));  
		}
		else
		{
			$Result =$con->select_query("assignment_que","*","where Subjectid='".$Subjectid."'","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$assignmentlist='';
				$x=0;
				$Subjectname=get_Subject_name($Subjectid);
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						if($row_state['Assignmentimage']!=""){
							$assignmentlist[$x]['Assignmentimage']=$question.$Subjectname."/".$row_state['Assignmentimage'];	
						}
						if($row_state['Assignmentpdf']!=""){
							$assignmentlist[$x]['Assignmentpdf']=$question.$row_state['Assignmentpdf'];
						}
						
						$assignmentlist[$x]['Type']=$row_state['Type'];
						$assignmentlist[$x]['AssignmentQueid']=$row_state['AssignmentQueid'];
						$x++;
				}
				
				
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1',"Subjectname"=>$Subjectname,'Message'=>'assigment fetched successfully', 'assignmentlist'=>$assignmentlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No assigment(s) available'));  
			}
		}
	}
		//************************************************************** add assigment/practical answer    *****************************************************************************//      	
	else if($input_params['mode'] == 'addassignpracans')
	{
		$Studentid = $input_params['Studentid'];
		$AssignmentQueid =$input_params['AssignmentQueid'];
		$Assignmentansimage = $input_params['Assignmentansimage'];
		$Dt = $input_params['Dt'];
		
		
	if(empty($Studentid) ||  empty($AssignmentQueid) || empty($Dt))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
				$fields = array( "Userid" => $Studentid,
								 "AssignmentQueid" => $AssignmentQueid,
								 "Assignmentansimage" => $Assignmentansimage,
								 "Dt"=> $Dt
							 );
				$insert_user=$con->insert_record("assignment_ans",$fields);
				$AssignmentAnsid=mysql_insert_id();
				$userPQuery = $con->select_query("assignment_ans","*","where AssignmentAnsid='".$AssignmentAnsid."'");
			
			$fetchsubject = mysql_fetch_assoc($userPQuery);
			
				$AssignmentQueid=$fetchsubject['AssignmentQueid'];
				$Subjectid=get_Subject1_name($AssignmentQueid);
				$Subjectname=get_Subject_name($Subjectid);
				if($Assignmentansimage!= "")
					{
						$binarytoimage = binarytoimageans($Assignmentansimage,$Userid,$Subjectname);
						$fields_image =array("Assignmentansimage"=>$binarytoimage);
						$images_insert=$con->update("assignment_ans",$fields_image,"where AssignmentAnsid='".$AssignmentAnsid."'");
					}
					$Dt=$fetchsubject['Dt'];
					/*if($Assignmentanspdf!= "")
					{
						$file1=$_FILES["Assignmentanspdf"]["name"];
						$file1tmp=$_FILES["Assignmentanspdf"]["tmp_name"];

						move_uploaded_file($file1tmp,$pdf.$Assignmentanspdf);
						$fields_pdf =array("Assignmentanspdf"=>$file1tmp);
						$pdf_insert=$con->update("assignment_ans",$fields_pdf,"where AssignmentAnsid='".$AssignmentAnsid."'");
					}*/
				$Studentname=get_User_name($Studentid);
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,"Studentname"=>$Studentname,"Subjectname"=>$Subjectname,'message'=>'Assignment_Practical answer added successfully.'));		
		}
	}
		//----------------------------------------------------------------- View assignments/practical answer by subject----------------------------------------------------------//
	else if($input_params['mode'] == 'viewassignpracansbyque') 
	 { 
         	$AssignmentQueid =$input_params['AssignmentQueid'];
		
		if(empty($AssignmentQueid))
		{
			header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'Please Fill all required fields.'));  
		}
		else
		{
			$Result =$con->select_query("assignment_ans","*","where AssignmentQueid='".$AssignmentQueid."'","","" ); 
			
			if($con->total_records($Result) > 0) 
			{
				
				$assignmentlist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
				$Subjectid=get_Subject1_name($AssignmentQueid);
				$Subjectname=get_Subject_name($Subjectid);
						$assignmentlist[$x]['Userid']=get_User_name($row_state['Userid']);
						if($row_state['Assignmentansimage']!="")
						$assignmentlist[$x]['Assignmentansimage']=($answer.$Subjectname."/".$row_state['Assignmentansimage']);
						if($row_state['Assignmentanspdf']!=""){
							$assignmentlist[$x]['Assignmentanspdf']=$answer.$row_state['Assignmentanspdf'];
						}
						$assignmentlist[$x]['AssignmentAnsid']=$row_state['AssignmentAnsid'];
						$assignmentlist[$x]['Dt']=$row_state['Dt'];
						
						$x++;
				}
				
				
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1','Message'=>'assigment answer fetched successfully', 'assignmentlist'=>$assignmentlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No assigment answer(s) available'));  
			}
		}
	}
	//----------------------------------------------------------------- add assignments/practical remark----------------------------------------------------------//
	else if($input_params['mode']=='editassignpracans')
	{
		$AssignmentAnsid = $input_params['AssignmentAnsid'];
	    $Remark = $input_params['Remark'];
				
	if(empty($Remark) ||  empty($AssignmentAnsid))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
		else
		{
		
			$fetch_query = $con->select_query("assignment_ans","*","where AssignmentAnsid='".$AssignmentAnsid."'");
			$rowFetch = mysql_fetch_assoc($fetch_query);

			$update_details = array(
								"AssignmentAnsid"=>$AssignmentAnsid,
								 "Remark" => $Remark
								
									);

				$update_details = $con->update("assignment_ans",$update_details,"where AssignmentAnsid='".$AssignmentAnsid."'");

				$fetch_data = $con->select_query("assignment_ans","*","where AssignmentAnsid='".$AssignmentAnsid."'","","");
				$fetchResult = mysql_fetch_assoc($fetch_data);

				$redit = array(    
				                "AssignmentAnsid"=> intval($fetchResult['AssignmentAnsid']),
				                "Remark"=> $fetchResult['Remark']
				               );

				header('Content-type:application/json');
				echo json_encode(array("status"=>1,'assignment_details'=> $redit,"message"=>"successfully updated assignment remark detail"));
		}

	}
	//************************************************************** add timetable ****************************************************************//      	
	else if($input_params['mode'] == 'addtimetable')
	{
		$Facultyid = $input_params['Facultyid'];
		$Timetableimage = $input_params['Timetableimage'];
		$Timetablepdf = $input_params['Timetablepdf'];
		$Semestername = $input_params['Semestername'];
		$Midname=$input_params['Midname'];
		
	if(empty($Facultyid) || empty($Semestername) || empty($Midname))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
				$fields = array( 
								 "Userid" => $Facultyid,
								 "Timetableimage" => $Timetableimage,
								 "Timetablepdf"=> $Timetablepdf,
								 "Semestername" =>$Semestername,
								 "Midname" => $Midname
							 );
				$insert_user=$con->insert_record("timetable",$fields);
				$Timetableid=mysql_insert_id();
				
				
				if($Timetableimage!= "")
					{
						$binarytoimage = binarytoimagett($Timetableimage,$Midname,$Semestername);
						$fields_image =array("Timetableimage"=>$binarytoimage);
						$images_insert=$con->update("timetable",$fields_image,"where Timetableid='".$Timetableid."'");
					}
					
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,"Semestername"=>$Semestername,"Midname"=>$Midname,'message'=>'Timetable added successfully.'));		
		}
	}
	//----------------------------------------------------------------- View timetable----------------------------------------------------------//
	else if($input_params['mode'] == 'viewtimetable') 
	 { 
         	 	
			$Result =$con->select_query("timetable","*","","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$timetablelist='';
				$x=0;
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						$timetablelist[$x]['Userid']=get_User_name($row_state['Userid']);
						if($row_state['Timetableimage']!=""){
							$timetablelist[$x]['Timetableimage']=$timetable.$row_state['Semestername']."/".$row_state['Timetableimage'];
						}
						if($row_state['Timetablepdf']!=""){
							$timetablelist[$x]['Timetablepdf']=$timetable.$row_state['Timetablepdf'];
						}
						
						$timetablelist[$x]['Semestername']=$row_state['Semestername'];
						$timetablelist[$x]['Midname']=$row_state['Midname'];
						$x++;
				}
	
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1' , 'Message'=>'All timetable fetched successfully', 'timetablelist'=>$timetablelist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No Subject(s) available'));  
			}
	}
	//************************************************************** add answersheet *****************************************************************************//      	
	else if($input_params['mode'] == 'addanswersheet')
	{
		$Subjectid = $input_params['Subjectid'];
		$Answersheetimage = $input_params['Answersheetimage'];
		$Answersheetpdf = $input_params['Answersheetpdf'];
		$Semestername = $input_params['Semestername'];
		$Midname=$input_params['Midname'];
		
	if(empty($Subjectid) || empty($Semestername) || empty($Midname))
		{
			header('Content-type: application/json');
			echo json_encode(array('status'=>0,'message'=>'Please fill all require fields.'));
		}
	else
		{	
				$fields = array( 
								 "Subjectid" => $Subjectid,
								 "Answersheetimage" => $Answersheetimage,
								 "Answersheetpdf"=> $Answersheetpdf,
								 "Semestername" =>$Semestername,
								 "Midname" => $Midname
							 );
				$insert_user=$con->insert_record("answersheet",$fields);
				$Answersheetid=mysql_insert_id();
				
				$Subjectname=get_Subject_name($Subjectid);
				if($Answersheetimage!= "")
					{
						$binarytoimage = binarytoimagesheet($Answersheetimage,$Userid,$Subjectname);
						$fields_image =array("Answersheetimage"=>$binarytoimage);
						$images_insert=$con->update("answersheet",$fields_image,"where Answersheetid='".$Answersheetid."'");
					}
					
				header('Content-type: application/json');
				echo json_encode(array('status'=>1,"Subjectname"=>$Subjectname,'message'=>'answersheet added successfully.'));		
		}
	}
	//----------------------------------------------------------------- View assignments/practical questions by subject----------------------------------------------------------//
	else if($input_params['mode'] == 'viewanswersheetbysubject') 
	 { 
         	$Subjectid =$input_params['Subjectid'];
		
		if(empty($Subjectid))
		{
			header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'Please Fill all required fields.'));  
		}
		else
		{
			$Result =$con->select_query("answersheet","*","where Subjectid='".$Subjectid."'","","" ); 
		
			if($con->total_records($Result) > 0) 
			{
				
				$answersheetlist='';
				$x=0;
				$Subjectname=get_Subject_name($Subjectid);
				while($row_state=mysql_fetch_assoc($Result)) 
				{
					
						if($row_state['Answersheetimage']!=""){
							$answersheetlist[$x]['Answersheetimage']=$answersheet.$Subjectname."/".$row_state['Answersheetimage'];
						}
						if($row_state['Answersheetpdf']!=""){
							$answersheetlist[$x]['Answersheetpdf']=$answersheet.$row_state['Answersheetpdf'];
						}
						
						$answersheetlist[$x]['Subjectid']=get_Subject_name($row_state['Subjectid']);
						$answersheetlist[$x]['Semestername']=$row_state['Semestername'];
						$answersheetlist[$x]['Midname']=$row_state['Midname'];
						$x++;
				}
				
				
				header('Content-type: application/json'); 
				echo json_encode(array('status'=>'1',"Subjectname"=>$Subjectname,'Message'=>'answersheet fetched successfully', 'answersheetlist'=>$answersheetlist));  
			
			}
			else
			{
				header('Content-type: application/json'); 
			echo json_encode(array('status'=>'0','Message'=>'No answersheet(s) available'));  
			}
		}
		}


?>