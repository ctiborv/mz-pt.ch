<?
  
function zobrazObsahDomu($spojeni)
{
      $idlmenu=$_GET["lmenu"];
      $index=$_GET["index"];
      $iddum=$_GET["id"];
      $idmenu=$_GET["menu"];
      $sql="SELECT nazev from domy where id_dum=$iddum";
      $res = PrSql($spojeni,$sql);
      $zaznam = mysqli_fetch_array($res);
      $nazevdomu = $zaznam["nazev"];      
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
                    <a <?echo $active?> href="dum-<?echo $nazevdomu?>-<?echo $idlmenu?>-<?echo $index?>-<?echo $iddum?>-<?echo $zaznam["id_domy_Menu"]?>.html<? //echo $index?>">
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
                    <img  src="<? echo $zaznam["nahled"]?>" alt="" /> </a>
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
                    <img  src="<? echo $zaznam["nahled"]?>" alt="" /> </a>
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
?>
  
    <!--==============================content================================-->     
    <section id="content">         	
      <div class="container_12">    	
        <!-- <img class="baner" src="images/baner.jpg" /> -->	         	
        <div class="wrapper indent-bot7">                     	
          <div class="grid_12">            	                 	                 	                 	                 	                 	                 	
            <!-- domy -->                 	                   
                              
            <div id="tabs">
              <ul id="left">
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
                 $index=$i; 
                ?>
                <li>
                <a href="#tabs-<?echo $index?>"><?echo $zaznam["nazev"]?></a>
                </li>
                <?

                $sqld="SELECT * FROM domy where id_lDolniMenu=$idm";
                $resd = PrSql($spojeni,$sqld);
                $pocetd = mysqli_num_rows($resd);
                $textd="";
                $textd=$textd."<div id=\"tabs-$index\">";
                if ($pocetd>0) {
                  while ($zaznamd = mysqli_fetch_array($resd)){
                    $iddum = $zaznamd["id_dum"];
                    $obrazek= $zaznamd["obrazek"];
                    
                    $nazev=$zaznamd["nazev"];
                    $textd=$textd."<a class=\"house\" href=\"dum-$nazev-$idm-$index-$iddum-0.html#tabs-$index\">             
                    <img  src=\"$obrazek\" /><p class=\"alter\">$nazev</p></a>";
                   }
                 $textd=$textd."</div>";
                 }
                 $textcel=$textcel.$textd; 
                $i=$i+1;
                
                }
              }
              ?>
              </ul>
              
              <div id="right">
              <?
                echo $textcel;
              
              ?>
                </div>
              </div>
            </div>	                 	                 	                 	                 	                 	
            <!-- domy konec-->                                           <br />  <br />                    
            <div class="wrapper bot-pad2">                                                                                                           
            </div>                                                                                                     
          </div>            
        </div>                                                         
      </div>        
    </section>    	
<?
}

function ZobrazHeader()
{
?>
   <!--==============================header=================================-->    
    <header>    	
      <div class="index-2">	      	
        <div class="container_12">	        	
          <div class="grid_12">	            	
            <div class="header-top">	                	
              <div class="wrapper">	                    	
                <div class="slogon">
                </div>	                    	
                <div class="fleft float-none-sw">				        		<h1>
                    <a href="?">mz chalet</a></h1>	                        
                </div>	                	                    
              </div>	                
            </div>	                
            <nav id="main-menu">	                    
              <div class="menuback"> 
              </div>	                    
              <ul class="menu responsive-menu">	                        
                <li>
                <a class="active" href=""> O nás
                  <span>Úvod
                  </span></a>
                </li>                                            
                <li>
                <a href="">Moderní
                  <span>výstavba
                  </span></a>                                                                                                      
                </li>                   	                        
                <li>
                <a href="">Masivní 
                  <span>dřevostavby
                  </span></a>	                         	                        
                </li>	                        
                <li>
                <a href="">Umělecké 
                  <span>kování
                  </span></a>
                </li>	                        
                <li>
                <a  href="">ESHOP
                  <span>v přípravě
                  </span></a>
                </li>	                        
                <li>
                <a  href="">Galerie
                  <span>novinky
                  </span></a>
                </li>	                        
                <li class="last">
                  <a   href="">Kontakt
                    <span>KDE JSME 
                    </span></a>
                </li>	                    
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
              <a class="footer-logo" href="/">MZ PARTNER TRADING </a> &nbsp;
              <span class="footer-text"> 2015 | 
                <a href="http://www.vconsult.cz">vconsult web studio</a>
              </span>				        
              <div>
                <!-- {%FOOTER_LINK} -->
              </div>	                
            </div>	                
            <ul class="social-buttons">	                	
              <li>SLEDUJTE NÁS:
              </li>	                     	                    
              <li>
              <a class="item-2" href="/"></a>
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