<?

function zobrazGalerie($spojeni){

$idg=$_GET["idsm"];
$sqlg="SELECT * FROM galerie  order by priorita";  
$resg = PrSql($spojeni,$sqlg);
$pocet = mysqli_num_rows($resg);
$i=1;
$odkaz="mz-galerie";
?>
<section id="content" class="margint">
      <div class="container_12">    	
        <div class="wrapper indent-bot7">                     	
          <div class="grid_12">
                 <div id="obsahovy"> 
        
 <?
 if ($pocet >0 ) {
 ?>
         <nav id="main-menu-karta2">	                         
           <ul class="menu-karta responsive-menu"  id="left2">
  <?
  while ($zaznam = mysqli_fetch_array($resg)) {
  if (($i==1) && (!$idg)) {
    $idg=$zaznam["id_galerie"];
  }
  if ($zaznam["id_galerie"]==$idg) {
    $active="class=\"active\"";
    $popisg=$zaznam["popis"];
  }    
  else {
  $active="";
  }
  setlocale(LC_ALL,'czech'); 
  $input = iconv('UTF-8', 'us-ascii//TRANSLIT', $zaznam["nazev"]);
  $input = preg_replace('/[^a-zA-Z0-9]/', '_', $input);
  $input=strtolower($input);      
  
  ?>
     <li><a <?echo $active?> href="<? echo $odkaz."-".$input."-6-".$zaznam["id_galerie"].".html" ?>"  ><?echo $zaznam["nazev"]?></a></li>
  <?
  $i=$i+1;
  }
            ?>
                              </ul>
              </nav>
              <div id="right2"><?
                $inc=$inc."<div class=\"galerka\"><p>$popisg</p><div class=\"galerie\">";
                $sqlf="SELECT * FROM foto where id_galerie=$idg".$zaznam["id_galerie"];  
                $resf = PrSql($spojeni,$sqlf);
                while ($zaznamf = mysqli_fetch_array($resf)) {
                
                  $popis=substr($zaznamf["popis"],0,30);
                  $inc=$inc."<a class=\"fancybox\" rel=\"group\" title=\"$popis\" href=\"galerie/".$zaznamf["soubor"]."\">";
                  $inc=$inc."<img alt=\"chalet, maison, fer forge\" height=\"60px\" src=\"galerie/".$zaznamf["soubormale"]."\"></a>";
                }
                $inc=$inc."</div></div>\n";
                echo $inc;
                
              ?></div>
          </div>  
          <?}?>                             	                             	                             	                             	                                                
        </div>				            	                  
    </div>
    </div>	                
  <?
}

function zobrazContentMenu($spojeni)
{
  $idhmenu=$_GET["idm"];
  $sql="SELECT nazevvetsi,odkaz,typ from hlavni_Menu where id_hlavni_Menu=$idhmenu";
  $res = PrSql($spojeni,$sql);
  $zaznam = mysqli_fetch_array($res);
  $typ=$zaznam["typ"];
  setlocale(LC_ALL,'czech'); 
  $input = iconv('UTF-8', 'us-ascii//TRANSLIT', $zaznam["nazevvetsi"]);
  $input = preg_replace('/[^a-zA-Z0-9]/', '_', $input);
  $input=strtolower($input); 
  $odkaz="mz-$input";
  $sql="SELECT * from content_Menu  where id_hlavni_Menu=$idhmenu order by poradi";
  $res = PrSql($spojeni,$sql);
  $pocet = mysqli_num_rows($res);
  $idcm=$_GET["idsm"];
  
  $i=1;
  ?>
<section id="content" class="margint">
      <div class="container_12">    	
        <!-- <img class="baner" src="images/baner.jpg" /> -->
        
          	
        <div class="wrapper indent-bot7">                     	
          <div class="grid_12">
                 <div id="obsahovy"> 
        
 <?
 if ($pocet >0 ) {
 ?>
         <nav id="main-menu-karta2">	                         
           <ul class="menu-karta responsive-menu"  id="left2">
  <?
  while ($zaznam = mysqli_fetch_array($res)) {
  if (($i==1) && (!$idcm)) {
    $idcm=$zaznam["id_content_Menu"];
  }
  if ($zaznam["id_content_Menu"]==$idcm) {
    $active="class=\"active\"";
    $text=$zaznam["text"];
  }    
  else {
  $active="";
  }
  $input = iconv('UTF-8', 'us-ascii//TRANSLIT', $zaznam["nazev"]);
  $input = preg_replace('/[^a-zA-Z0-9]/', '_', $input);
  $input=strtolower($input); 
  
  ?>
     <li><a <?echo $active?> href="<? echo $odkaz."-$input-$idhmenu-".$zaznam["id_content_Menu"].".html" ?>"  ><?echo $zaznam["nazev"]?></a></li>
  <?
  $i=$i+1;
  }
            ?>
                              </ul>
              </nav>
              <div id="right2"><?
              if ($typ=='G') {
                $idg=$_GET["idsm"];
                $sqlg="SELECT * FROM galerie where id_content_Menu=".$idcm." order by priorita";  
                $resg = PrSql($spojeni,$sqlg);
                $pocet = mysqli_num_rows($resg);
                $i=1;
                while ($zaznamg = mysqli_fetch_array($resg)) {
                $nazevg=$zaznamg["nazev"];
                $popisg=$zaznamg["popis"];
                $inc="<div class=\"galerka\"><h3>$nazevg</h3><p>$popisg</p><div class=\"galerie\">";
                $sqlf="SELECT * FROM foto where id_galerie=".$zaznamg["id_galerie"]." order by poradi";  
                $resf = PrSql($spojeni,$sqlf);
                while ($zaznamf = mysqli_fetch_array($resf)) {
                
                  $popis=substr($zaznamf["popis"],0,30);
                  $inc=$inc."<a class=\"fancybox\" rel=\"group-".$zaznamg["id_galerie"]."\" title=\"$popis\" href=\"galerie/".$zaznamf["soubor"]."\">";
                  $inc=$inc."<img alt=\"chalet, maison, fer forge\" height=\"60px\" src=\"galerie/".$zaznamf["soubormale"]."\"></a>";
                }
                $inc=$inc."</div></div>\n";
                echo $inc;
                $i++;
                }
                }
              else { echo $text;}
              
              
              ?></div>
          <?}
  ?>
            </div>                               	                             	                             	                             	                                                
                </div>				            	                  
    </div>
    </div>	                
  <?
}

function zobrazTextMenu($spojeni)
{
  $idhmenu=$_GET["idm"];
  $sql="SELECT text from hlavni_Menu where id_hlavni_Menu=$idhmenu";
  $res = PrSql($spojeni,$sql);
  $zaznam = mysqli_fetch_array($res);
  $text=$zaznam["text"];
  ?>
      <div class="container_12">    	
        <!-- <img class="baner" src="images/baner.jpg" /> -->	         	
        <div class="wrapper indent-bot7">                     	
          <div class="grid_12">
            <!-- bežný obsah-->
            
                 <div id="obsahovy"> 
    <div id="rightp" ><?echo $text?>  </div>
                          </div>                               	                             	                             	                             	                                                
                </div>				            	                  
    </div>	                
                </div>
    </div>	            
    </div>	        
        
  <?
}

  
function zobrazObsahDomu($spojeni)
{
      $idlmenu=$_GET["lmenu"];
      $index=$_GET["index"];
      $iddum=$_GET["id"];
      $idmenu=$_GET["menu"];
      if (!$iddum) {
      $sql="SELECT * from domy where id_lDolniMenu=$idlmenu order by poradi asc limit 1";
 
      $res = PrSql($spojeni,$sql);
      $pocet = mysqli_num_rows($res);
      if ($pocet >0) {
        $zaznam = mysqli_fetch_array($res);
        $iddum=$zaznam["id_dum"];}
      else {
        ZobrazUvod();
        return;
      } 
      }
      else {
      $sql="SELECT nazev from domy where id_dum=$iddum";
      $res = PrSql($spojeni,$sql);
      $zaznam = mysqli_fetch_array($res);
      }
      $nazevdomu = $zaznam["nazev"];     
      setlocale(LC_ALL,'czech'); 
      $input = iconv('UTF-8', 'us-ascii//TRANSLIT', $nazevdomu);
      $input = preg_replace('/[^a-zA-Z0-9]/', '_', $input);
      $input=strtolower($input);      
    $sql="SELECT * FROM domy_Menu where id_dum=$iddum order by poradi";
      $res = PrSql($spojeni,$sql);
      $pocet = mysqli_num_rows($res);

?>
               <!-- obsah slideru - karty domu  starrt -->
    <div class="index-1">        	        
      <div class="slider-wrapper">	        	
        <div class="slider-left">	            	
          <div class="slider-right">				        
            <div id="slides">   				                      
              <div id="karta-domu33"> 
              <div class="house-name"><h2><?echo $nazevdomu?></h2></div>                                               
              <div class="menukarta">                                                                                                                                                                                                  
                <nav id="main-menu-karta">	                         
                  <div class="menuback-karta">      
                  </div>	                         
                  <ul class="menu-karta responsive-menu">
                  <?	                               
                  $i=0;
                    while ($zaznam = mysqli_fetch_array($res))
                     {
                     
                      if (((!$idmenu) && ($i==0)) || ($idmenu==$zaznam["id_domy_Menu"]) ) { 
                      $active="class=\"active\"";                      
                      $typmenu=$zaznam["typ"];
                      if (!$idmenu) $idmenu=$zaznam["id_domy_Menu"];
                      }
                      else {$active="";
                      }
                     ?>
                    <li>      
                    <a <?echo $active?> href="maison-<?echo $input?>-<?echo $idlmenu?>-<?echo $index?>-<?echo $iddum?>-<?echo $zaznam["id_domy_Menu"]?>.html<? //echo $index?>">
                      <?echo $zaznam["nazev"];?></a>      
                    </li>
                    <?
                    $i=$i+1;
                    }
                    
                    ?>                                                   
                  </ul>	                     	                   
                </nav>                                                                                                                                                                                                                                          
              </div>
             <?
             switch ($typmenu) {
             
              case "V":
                ?><div class="slides_container"><?                                                              				                
                $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu order by poradi";
                $res = PrSql($spojeni,$sql);
                $pocet = mysqli_num_rows($res);
                $i=1;
                    while ($zaznam = mysqli_fetch_array($res))
                     {
                  ?><div class="slide">                  
                  <a rel="example_group" id="example<?echo $i?>" href="<? echo $zaznam["soubor"]?>" >       	
                    <img  src="<? echo $zaznam["nahled"]?>" alt="chalet, maison, fer forge"/> </a>
                </div>	                             	                             	                             	                             	                               
                   <?
                   $i=$i+1;		
                   }
                  ?>                </div><?
                break;
              case "P":
              ?>    <div id="karta-tabulka"> <?                                                    
                $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu and typ='T' order by poradi";
                $res = PrSql($spojeni,$sql);
                $pocet = mysqli_num_rows($res);
                if ($pocet) {
                  $zaznam = mysqli_fetch_array($res);
                  $text=$zaznam["text"];
                  echo $text;
                }
               ?> </div>  
                <div class="slides_container pudorys"><?                                                              				                
                $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu and typ='O' order by poradi";
                $res = PrSql($spojeni,$sql);
                $pocet = mysqli_num_rows($res);
                $i=1;
                    while ($zaznam = mysqli_fetch_array($res))
                     {
                  ?><div class="slide">                  
                  <a rel="example_group" id="example<?echo $i?>" href="<? echo $zaznam["soubor"]?>" >       	
                    <img  src="<? echo $zaznam["nahled"]?>" alt="chalet, maison, fer forge"  /> </a>
                </div>	                             	                             	                             	                             	                               
                   <?
                   $i=$i+1;		
                   }
                  ?>                </div><?
              break;                             
              case "D":
              ?>    <div id="text-v-karte"><?                                                    
                $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu and typ='T' order by poradi";
                $res = PrSql($spojeni,$sql);
                $pocet = mysqli_num_rows($res);
                if ($pocet) {
                  $zaznam = mysqli_fetch_array($res);
                  $text=$zaznam["text"];
                  echo $text;
                }
                  ?>                </div>
                   <div class="slides_container">                                                               				                                 
                <div class="slide"><img  src="images/white.jpg" alt="chalet, maison, fer forge" /></div>	                             	                             	                             	                             	                                                
                </div>				            	<?
             break;
             case "K":
              ?>    <div id="text-v-karte"><?                                                    
                $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu and typ='T' order by poradi";
                $res = PrSql($spojeni,$sql);
                $pocet = mysqli_num_rows($res);
                if ($pocet) {
                  $zaznam = mysqli_fetch_array($res);
                  $text=$zaznam["text"];
                  echo $text;
                }
                $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu and typ='S' order by poradi";
                $res = PrSql($spojeni,$sql);
                $pocet = mysqli_num_rows($res);
                if ($pocet > 0) {
                  ?><br><ul class="soubory"><?
                    $i=1;
                    while ($zaznam = mysqli_fetch_array($res))
                     {?><li><img alt="chalet, maison, fer forge" src="images/file.png" height="25"/>&nbsp;                  
                  <a target="_new" href="<? echo $zaznam["soubor"]?>" ><? echo $zaznam["text"]?></a>
                  </li>	                             	                             	                             	                             	                               
                   <?
                   $i=$i+1;		
                }
                }
                  ?></ul>
                  </div>
                   <div class="slides_container">                                                               				                                 
                <div class="slide"><img  src="images/white.jpg" alt="" /></div>	                             	                             	                             	                             	                                                
                </div>				            	<?
              break;
             default:
                  ?>                
                   <div class="slides_container">                                                               				                                 
                <div class="slide"><img  src="images/white.jpg" alt="" /></div>	                             	                             	                             	                             	                                                
                </div>				            	<?
            }     
             ?>                  
            </div>	                
                </div>
        </div>	
             
        </div>	        
      </div>        
    </div>    
    
      <!-- obsah slideru karty domu  konec  -->   
<?
}

function zobrazlDolniMenu($spojeni)
{
  $idlmenu=$_GET["lmenu"];
  $sindex=$_GET["index"];

?>
  
    <!--==============================content================================-->
                                                   	
    <section id="content" class="boto">         	
      <div class="container_12">    	
        <!-- <img class="baner" src="images/baner.jpg" /> -->	    
           
 <br />	    
             	
        <div class="wrapper indent-bot7">                     	
          <div class="grid_12">            	                 	                 	                 	                 	                 	                 	
            <!-- domy -->                 	                   
            <div class="border-line">&nbsp; </div>                  
            <div id="tabs2"> 
            
             <nav id="main-menu-karta1">	                         
                  <div class="menuback-karta1">      
                  </div>	  
                  <ul class="menu-karta responsive-menu " id="left" >
              <?
                $sql="SELECT * FROM lDolniMenu order by poradi";
                $res = PrSql($spojeni,$sql);
                $pocet = mysqli_num_rows($res);
                if ($pocet>0) {
                $i=1;
                $textd="";  
                while ($zaznam = mysqli_fetch_array($res))
                 {
                 $poradi=$zaznam["poradi"];
                 $idm=$zaznam["id_lDolniMenu"];
                 $menunazev=$zaznam["nazev"];
                 setlocale(LC_ALL,'czech'); 
                 $input = iconv('UTF-8', 'us-ascii//TRANSLIT', $menunazev);
                 $input = preg_replace('/[^a-zA-Z0-9]/', '-', $input);
                 $input=strtolower($input);      
                 
                 $index=$i; 
                 $active="";
                ?>
                <li <? if ($idm==$idlmenu) {echo "class=\"ui-tabs-active\"";$active="class=\"active\""; }?> >
                <a href="menu-<? echo $input."-".$idm?>.html" <?echo $active?> > <h3> <?echo $menunazev?></h3></a>
                </li>
                <?

                if (($i==1)&& (!$idlmenu)) $idlmenu=$idm;
                if ($idlmenu==$idm) {
                $sqld="SELECT * FROM domy  where id_lDolniMenu=$idlmenu and hidden<>1 order by poradi";
                $resd = PrSql($spojeni,$sqld);
                $pocetd = mysqli_num_rows($resd);
                $textd="";
                $textd=$textd."<div id=\"tabs-$index\">";
                if ($pocetd>0) {
                  while ($zaznamd = mysqli_fetch_array($resd)){
                    $iddum = $zaznamd["id_dum"];
                    $obrazek= $zaznamd["obrazek"];
                    $nazev=$zaznamd["nazev"];
                    $input = iconv('UTF-8', 'us-ascii//TRANSLIT', $nazev);
                    $input = preg_replace('/[^a-zA-Z0-9]/', '-', $input);
                    $input=strtolower($input);      
                    $textd=$textd."<a class=\"house\" href=\"maison-$input-$idm-$index-$iddum-0.html\">             
                    <img alt=\"chalet, maison, fer forge\" src=\"$obrazek\" /><p class=\"alter\">$nazev</p></a>";
                }
                 $textd=$textd."</div>";
                 }
                 $textcel=$textcel.$textd;
                 } 
                $i=$i+1;
                 
                }
              }
              ?>
              </ul>
              </nav>
              
              <div id="right">
              <?
                echo $textcel;
              
              ?>
                </div>
              </div>
            </div>	                 	                 	                 	                 	                 	
            <!-- domy konec-->                                           <br />  <br />                    
                                                                                                                
          </div>            
        </div>                                                         
      </div>        
    </section>
    
  <script type="text/javascript">
    var active = $( ".selector" ).tabs( "option", "active" );
  // Setter
    $( ".selector" ).tabs( "option", "active", 2 );    </script>     
        	
<?
}

function test_input($data)
{
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

function ZobrazKontakt(){
  $mailfirmy="mm@mz-pt.ch";
  
  

/*if ($akce=="odeslatmail"):

   $name=$_POST["name"];
   $email=$_POST["email"];
   $text=$_POST["text"];
   $telefon=$_POST["telefon"];


$headers .= "From: ".$name." <".$email.">" . "\r\n"; 
 $headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
 

 $to="info@vconsult.cz";
 $subject="zprava z webu VOPA.CZ";
 $message="uživatel $name - $email Vam posila nasledujici zpravu:
 
 $text
 $telefon
 ";

                        mail($to, $subject, $message, $headers);
                        
                        
  echo "<div class=\"sent\"><strong>Zpráva odeslána.</strong></div>";                      

endif;*/
      $name =""; // Sender Name
      $email =""; // Sender's email ID
      $telefon =""; // Subject of mail
      $message =""; // Sender's Message
      $nameError ="";
      $emailError ="";
      $telefonError ="";
      $messageError ="";
      $successMessage =""; // On submitting form below function will execute.
      $duvod=$_POST["duvod"];
      if(isset($_POST['akce'])) { // Checking null values in message.
      if (empty($_POST["name"])){
      $nameError = "Name is required";
      }
      else
       {
      $name = test_input($_POST["name"]); // check name only contains letters and whitespace
      }
      if (empty($_POST["email"]))
      {
      $emailError = "Email is required";
      }
      else
       {
      $email = test_input($_POST["email"]);
      } // Checking null values in message.
      
      if (empty($_POST["telefon"]))
      {
      $telefonError = "telefon is required";
      }
      else
      {
      $telefon = test_input($_POST["telefon"]);
      } // Checking null values in message.
      if (empty($_POST["message"]))
      {
      $messageError = "Message is required";
      }
      else
       {
      $message = test_input($_POST["message"]);
      } // Checking null values in the message.
            

      if( !($name=='') && !($email=='') && !($telefon=='') && !($message=='') )
      { // Checking valid email.
      if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
      {
      $header= $name."<". $email .">";
//      $headers .= "From: ".$name." <".$email.">" . "\r\n"; 
//      $headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
      $msg1 = " $name Contacted Us. Here is some information about $name.
      Name: $name
      E-mail: $email
      Purpose: $duvod
      telefon: $telefon
      Message: $message "; /* Send the message using mail() function */
      $headers .= "From: ".$name." <".$email.">" . "\r\n"; 
      $headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
      $to=$mailfirmy;
      $subject="zprava z webu mz-pt.ch";
      
        if (mail($to, $subject, $msg1, $headers)) //      if(mail($email, $header, $msg,$headers ) && mail($mailfirmy, $header, $msg1,$headers ))
      {
      $successMessage = "Votre message a été envoyé avec succès";

      $emailComp = "mm@mz-pt.ch";
      $emailComp = "venusc@seznam.cz";
      $headers = "Content-type: text/html; charset=iso-utf-8 \r\n";
      $headers .= "To: <$email> \r\n";
      $headers .= "From: MZ Partner <$emailComp> \r\n";
      $headers .= "X-Mailer: PHP/" . phpversion();
      
      $odpoved="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
      <html>
      <head>
      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
      <title>MZ Partner Trading</title>
      </head>
      <body bgcolor=\"#FFFFFF\">
      <table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border: 1px solid #282828;\" align=\"left\">
      	<tr>
      		<td width=\"800\" height=\"115\"><img src=\"http://mz-pt.ch/images/top-logo.png\" width=\"800\" height=\"115\" alt=\"\"></td>
      	</tr>
      	<tr>
      		<td width=\"800\" height=\"50\" background=\"http://mz-pt.ch/images/top-text.png\" align=\"center\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; font-style:normal; font-weight:bold; color:#FFFFFF;\">
      			<p>mm@mz-pt.ch | +41 76 652 12 70</p>
      		</td>
      	</tr>
      	<tr>
      		<td width=\"800\" height=\"133\"><img src=\"http://mz-pt.ch/images/top-images.png\" width=\"800\" height=\"133\" alt=\"\"></td>
      	</tr>
      	<tr>
      		<td style=\"padding:20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-style:normal; font-weight: normal;\">
      			<p>Bonjour à vous ! <br />
                                      <br />
      Nous avons pris note de votre visite et nous vous remercions.<br />
      Nos conseillers de construction seront heureux de vous contacter très rapidement.<br />
      <br />
      Dans l’attente  de vous rencontrer veuillez  recevoir nos sincères salutations.<br />
      <br />
      <strong>Team MZ Partner trading</strong>
      </p>
      		</td>
      	</tr>
      	<tr>
      		<td width=\"800\" height=\"62\"><img src=\"http://mz-pt.ch/images/bottom-home.png\" width=\"800\" height=\"62\" alt=\"\"></td>
      	</tr>
      	<tr>
      		<td width=\"800\" height=\"50\" bgcolor=\"#282828\" align=\"center\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; font-style:normal; font-weight:bold; color:#FFFFFF;\">
      			<p>MZ Partner Trading  |  Rte de Corcelles 5  |  Payerne 1530  |  +41 76 652 12 70</p>
      		</td>
      	</tr>
      </table>
      </body>
      </html>
      
      
      ";
      mail($email,'Bonjour à vous !',$odpoved,$headers);      
      }
      }
      else
      { $emailError = "Špatný formát emailu";
       }
       }
      } // Function for filtering input values. function test_input($data)
     
?>

  <section id="content" class="margint">
    	<div class="container_12">
        	<div class="wrapper">
            	<div class="grid_6 indent-sw-1">
                	<h3 class="border-1 bot-pad p4">NOTRE ADRESSE</h3>
					<figure class="map-style img-border3 indent-bot2">

          <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  src="http://maps.google.com/maps?q=Route+de+Corcelles+5,+1530+Payerne&amp;hl=fr&amp;ie=UTF8&amp;ll=46.823835,6.944518&amp;spn=0.010013,0.022724&amp;sll=37.0625,-95.677068&amp;sspn=47.167389,93.076172&amp;hnear=Route+de+Corcelles+5,+1530+Payerne,+Vaud,+%C5%A0v%C3%BDcarsko&amp;t=m&amp;z=16&amp;iwloc=A&amp;spn=0.01628,0.025663&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe> 
         
           
           
  
  
					</figure>
					<dl>
					    <dt class="color-3 indent-bot">MZ Partner Trading<br />Route de Corcelles 5<br />1530 Payerne </dt>
					     <dd>Téléphone: +41 76 652 12 70</dd>
					     <dd>E-mail:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="mailto:mm@mz-pt.ch">mm@mz-pt.ch</a></dd>
					     
					     <dd>
					     Horaire d´ouverture 9:00 - 12:00 et 13:30 - 17:30 sur un rendez-vouz tél. </dd>
					</dl>                                                                 
                </div>
                <div class="grid_6">
                	<h3 class="border-1 bot-pad indent-bot3">ENVOYER UN MESSAGE</h3>
      
          
          
					<form id="contact-form" name="contact-form" action="" method="post">
                        <input type="hidden" name="akce" value="odeslatmail">
                            <fieldset>
                                    <label class="name"><input type="text" name="name" value="Nom" onBlur="if(this.value=='') this.value='Nom'" onFocus="if(this.value =='Nom' ) this.value=''" />&nbsp;<? echo $nameError?></label>
                                    
                                    
                                    <label class="email"><input type="text" name="email" value="Email" onBlur="if(this.value=='') this.value='Email'" onFocus="if(this.value =='Email' ) this.value=''" />&nbsp;<? echo $emailError?></label>
                                    
                                    <label class="telefon"><input type="text" name="telefon" value="Téléphone" onBlur="if(this.value=='') this.value='Téléphone'" onFocus="if(this.value =='Téléphone' ) this.value=''" />&nbsp;<? echo $telefonError?></label>

                                    <label class="purpose"><select name="duvod" > 
                                                           <option value="fer forgé">Fer forgé</option>
                                                           <option value="chalet">Chalet</option>
                                                           <option value="villa">Villa</option>
                                                           <option value="villa">MZ Deco</option>
                                                           <option value="autre question">Autre question</option>
                                                         </select>
                                    </label>
                                    
                                    <label class="message">
                                    <textarea name="message" onBlur="if(this.value=='') this.value='Votre message'" onFocus="if(this.value =='Votre message' ) this.value=''">Votre message</textarea></label>&nbsp;<? echo $messageError?>
                                    
                                    <div class="buttons-wrapper"> 
                           
        
                           
                                          
                               <span class="button-space"><a class="button" href="#" onClick="document.getElementById('contact-form').submit()">envoyer</a></span>
                                          
                                    </div>
                                    	
                            </fieldset>
					                   </form>
					                 <h4><? echo  $successMessage?> </h4>
					  
					
					
                </div>
            </div>
        </div>
    </section>                                          

<?

}

function ZobrazHeader($spojeni)
{
?>
   <!--==============================header=================================-->    
    <header>    	
      <div class="index-2">	      	
        <div class="container_12">	        	
          <div class="grid_12">	            	
            <div class="header-top">	                	
              <div class="wrapper">
              
                 <div class="logofb">
                   <a target="_new" href="https://www.facebook.com/pages/MZ-Partner-Trading/330019133784976?fref=ts"><img src="/images/logofb.png" alt="chalet, maison, fer forge"/></a>
                 </div>
              
              
              	                    	
                <div class="slogon">
                <h1>..constructions en madrier et ossature bois, <br />
                
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
               
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
                
                accessoires en fer forgé..</h1>
                </div>	                    	
                <div class="fleft float-none-sw logo">				        		
                    <a href="/"></a>	                        
                </div>	                	                    
              </div>	                
            </div>	                
            <nav id="main-menu">	                    
              <div class="menuback"> 
              </div>	                    
              <ul class="menu responsive-menu">	      
              <?
                $sql="SELECT * FROM hlavni_Menu order by poradi";
                $res = PrSql($spojeni,$sql);
                $idhm=$_GET["idm"];
                setlocale(LC_ALL,'czech'); 
                
                $pocet = mysqli_num_rows($res);
                $i=1;
                while ($zaznam = mysqli_fetch_array($res)){
                $menunazev=$zaznam["nazevvetsi"];
                $input = iconv('UTF-8', 'us-ascii//TRANSLIT', $menunazev);
                $input = preg_replace('/[^a-zA-Z0-9]/', '-', $input);
                $input=strtolower($input);
                $id=$zaznam["id_hlavni_Menu"];      
                if ($pocet==$i) {
                  $classli="class=\"last\"";
                }
                if ($id==$idhm)  {
                  $active="class=\"active\"";
                }
                else {
                  $active="";
                }
                
              ?>                  
                <li <?echo $classli?>>
                <a <?echo $active?> href="mzpartner-<?echo $input?>-<?echo $zaznam["id_hlavni_Menu"].".html"?>"><?echo $zaznam["nazevvetsi"]?>
                  <span><?echo $zaznam["nazevmensi"]?></span></a>
                </li>                                            
                <?          
                $i=$i+1;      
                }
                ?>
              </ul>	                    
              <div class="clear">
              </div>	                
            </nav>	            
          </div>	        
        </div>        
      </div>      
    </header>  
  <?    
}

function ZobrazFooter(){
?>
    <!--==============================footer=================================-->     
    <footer>    	
      <div class="container_12">        	
        <div class="wrapper">	        	
          <div class="grid_12">	            	
            <div class="fleft up">                    	
              
              <span class="footer-text">MZ PARTNER TRADING <Strong>2015</Strong>  <a target="_new" href="http://vconsult.cz">vconsult web studio </a> 
              </span>				        
              <div>
               
              </div>	                
            </div>	                
            <ul class="social-buttons">	                	
              <li>Suivez-nous
              </li>	                     	                    
              <li>
              <a target="_new" class="item-2" href="https://www.facebook.com/pages/MZ-Partner-Trading/330019133784976?fref=ts"></a>
              </li> 	                     	                    
              <!-- <li><a class="item-5" href="/"></a></li>--> 	                
            </ul>	            
          </div>            
        </div>        
      </div>    
    </footer>    
    <a id="toTop" href="#" style="margin-right: -571px; right: 50%; display: inline;">
      <span id="toTopHover" style="opacity: 0;">
      </span></a>
      

<?
}

function ZobrazUvod($spojeni){
?>
<div class="index-1">       
	        <div class="slider-wrapper">
	        	<div class="slider-left">
	            	<div class="slider-right">
				        <div id="slides">  
				                            <!-- obsah slideru karta domu start -->       
                    <div class="slides_container">
                    
                      
	                            
	                            
	                            
	                            
	                               <div class="slide">
	                          <a rel="example_group" id="example1" href="images/22.jpg" >    	<img src="images/22.jpg" alt="chalet, maison, fer forge" />  </a>
								
	                            </div>
	                            
	                            
	                            
	                     
				           
				           
	               
				           
				            </div>
				                            <!-- obsah slideru karta domu konec -->
				                            
				                            			              
				        </div>
	                </div>
	                    
	            </div>
	            
	      <div class="h2holder" > 
        <?$sql="SELECT * from nastaveni_webu LIMIT 1";
          $res = PrSql($spojeni,$sql);
          $zaznam = mysqli_fetch_array($res);
          $text=$zaznam["uvod_text"];
          echo $text;
         ?>     
  </div>
	        </div>
        </div>
    

<?
}


function VytvorSessId(){
      $token = md5(uniqid(mt_rand()));
      $ip=$_SERVER['REMOTE_ADDR'];
      $_SESSION["id"]=$token;
      $_SESSION["cas"]=time();
      $_SESSION["jmeno"]=null;
      $_SESSION["ip"]=$ip;
    }

function ZmenSessId(){
      $token = md5(uniqid(mt_rand()));
      $_SESSION["id"]=$token;
    }

function InitSession()  {
      session_start();
      
      
      if(!isset($_SESSION["id"])) {
        VytvorSessId();
        return 0;
        }
      else {
       return 1;
       }
}

?>