<? 
   mail("j301@byu.edu", "$lesson: $assignment -  $section, $name", $body, "From: $email"); 
   
   echo "<h1>Your Assignment was Submitted Successfully.</h1>";
   echo "<h5><a href='print_assignment.php?name=$name&section=$section&email=$email&body=$body'>View a Printable Version of this page</a></h5>";
 
?>
