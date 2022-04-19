<?php

//Chat.php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface 
{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo ' live Server Started';
    }

    public function onOpen(ConnectionInterface $conn) {

        // Store the new connection to send messages to later
        echo 'live Server Started';
       
        require('connection.php');
        $this->clients->attach($conn);

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);
       
        if(isset($queryarray['userID']))
        {
             
                 echo"Pchat";
             $userID=$queryarray['userID'];
             $questionID=$queryarray['questionID'];
            
            $connectionID=$conn->resourceId;
            $Selectquery=mysqli_query($con,"select * from tbl_UserConnectionTb where userID='".$userID."' AND questionID='".$questionID."'");
            $rows=mysqli_num_rows($Selectquery);
            if($rows>0)
            {
                 mysqli_query($con,"update tbl_UserConnectionTb SET connectionID='".$connectionID."',status='1' where userID='".$userID."' AND questionID='".$questionID."'");
                
                
            }
            else
            {
                mysqli_query($con,"insert into tbl_UserConnectionTb(userID,questionID,connectionID,status) values('".$userID."','".$questionID."','".$connectionID."','1')");
               
            }
            
            
            
        }


        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        
       require('connection.php');
       $data = json_decode($msg, true);
        
        
		$userID=$data['userID'];
        $questionID=$data['questionID'];
       
      $GetConnectionIDQuery=mysqli_query($con,"select connectionID from tbl_UserConnectionTb where questionID='".$questionID."' AND status='1' AND userID!='".$userID."'");
       while($datas=mysqli_fetch_assoc($GetConnectionIDQuery))
            {
               $recieverConnectID[]=$datas['connectionID']; 
            }
      
      
        foreach($this->clients as $client)
            {
				
				 if(in_array($client->resourceId,$recieverConnectID))
                { 
               	if($data['type']=='typing')
						{
							$response=array('Response' => 'true', 'message' => 'Data Found','type' => $data['type']);
						  
						  
							$client->send(json_encode($response));
						}
						
						elseif($data['type']=='not_typing')
						{
							$response=array('Response' => 'true', 'message' => 'Data Found','type' => $data['type']);
						   
							$client->send(json_encode($response));
						}
						else
						{
							
						}
					
                }
                 
				}
			
		
        
}
    public function onClose(ConnectionInterface $conn) {
		
          require('connection.php');
        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        if(isset($queryarray['userID']))
        {
            
        		
        			$questionID=$queryarray['questionID'];  // GroupID
                    $userID=$queryarray['userID'];
                    
                    
                    $connectionID=$conn->resourceId;
                    $Selectquery=mysqli_query($con,"select * from tbl_UserConnectionTb  where userID='".$userID."' AND questionID='".$questionID."'");
                    $rows=mysqli_num_rows($Selectquery);
                    if($rows>0)
                    {
                         mysqli_query($con,"update tbl_UserConnectionTb SET connectionID='0',status='0' where userID='".$userID."' AND questionID='".$questionID."'");
                        
                    }
            
        }
           
           
       
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

?>
