<?php
$host = "localhost";
$port = 20205;
set_time_limit(0);

$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket.\n");
$result_result = socket_bind($sock, 3) or die("Could not Bind to socket.\n");

$sock_result = socket_listen($sock, 3) or die("Could no set up socket listener.\n");

echo 'Listening for connections';

class Chat
{
    function readline()
    {
      return rtrim(fgets(STDIN));
    }

}

do
{
  $accept = socket_accept($sock) or die("Could not accept incoming connection.");
  $msg = socket_read($accept, 1024) or die("Could not read input\n");

  $msg = trim($msg);
  echo "Client says:\t".$msg."\n\n";

  $line = new Chat();
  echo "Enter Reply:\t";
  $reply = $line->readline();

  socket_write($accept, $reply, strlen($reply)) or die("Could not write output\n");





}while(true);

socket_close($accept, $sock);


?>
