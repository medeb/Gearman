<?php
$worker=new  GearmanWorker();
$worker->addServer();
$worker->addFunction('fetchdata','gearmanquery');
echo "waiting for job...";
print "\n";
while($worker->work());
function gearmanquery($job){
	$input=$job->workload();
	$conn=mysqli_connect("localhost","root","password","TableName"); //give your details
	if($conn->connect_error){
	die("Connection Failed".$conn->connect_error);
	}
	
	$query=" SELECT ownerId from car_table where carNumber='$input' "; //I worked on a car table
	$result=mysqli_query($conn,$query);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			$dId=$row['ownerId'];
			$query2="SELECT registeredNumber,DriverNumber from driver_table where DriverID='$dId'";
			$result2=mysqli_query($conn,$query2);
			if($result2->num_rows>0){
				while($row2=$result2->fetch_assoc()){
				if(!$row2['registeredNumber']){
					$val=explode('/',$row2['DriverNumber']);
					return $val[0].$val[1];
				}else{
					$val=explode('/',$row2['registeredNumber']);
					foreach ($val as $key) {
					return $key;
				}
				}
			}
		}
	}
	}else{
		echo "Nothing here!";
	}
	mysqli_close($conn);
	
	

}
?>
