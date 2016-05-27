<?php

$client=new GearmanClient();
$client->addServer();
$sms="You car no is WB01J2011";
if(preg_match('/[A-Z]{2}[0-9]{2}[A-Z]{1,2}[0-9]{4}/', $sms,$carno)){
echo "sending job";
print "\n";
$carNumber=$carno[0];//echo $carNumber;

$data[]=$client->doBackground("fetchdata","$carNumber");
foreach ($data as $key) {
	echo $key;
}
print "\n".$client->doNormal("display","$sms");
//print $phoneNumber;	
print "\n";
}else{
	echo "Invalid..\n";
}
?>
