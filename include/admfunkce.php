<?
  include('class.upload.php');


function ZobrazAdministraci($spojeni){

ZobrazUvod($spojeni,0,0);

?>

  <ul>
    <li><a href="?cmd=zobrazhlavni_Menu">Editace hlavního menu</a></li>
    <li><a href="?cmd=zobrazLDolniMenu">Editace spodní menu</a></li>
    <li><a href="?cmd=zobrazUvodniText">Editace úvodního textu</a></li>
    
  </ul>
  
<?

}

function browser_info($agent=null) {
  // Declare known browsers to look for
  $known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape',
    'konqueror', 'gecko');

  // Clean up agent and build regex that matches phrases for known browsers
  // (e.g. "Firefox/2.0" or "MSIE 6.0" (This only matches the major and minor
  // version numbers.  E.g. "2.0.0.6" is parsed as simply "2.0"
  $agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
  $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
                                        
  // Find all phrases (or return empty array if none found)
  if (!preg_match_all($pattern, $agent, $matches)) return array();

  // Since some UAs have more than one phrase (e.g Firefox has a Gecko phrase,
  // Opera 7,8 have a MSIE phrase), use the last one found (the right-most one
  // in the UA).  That's usually the most correct.
  $i = count($matches['browser'])-1;
  return array($matches['browser'][$i] );
}

function convertTime($dformat,$sformat,$ts) {
    extract(strptime($ts,$sformat));
    return strftime($dformat,mktime(
                                  intval($tm_hour),
                                  intval($tm_min),
                                  intval($tm_sec),
                                  intval($tm_mon)+1,
                                  intval($tm_mday),
                                  intval($tm_year)+1900
                                ));
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

function ZobrazUvod($spojeni,$uroven,$cast)
{
switch ($cast) {
  case "0":
?>
          <div><h2><a href="?">Administrace</a></h2></div><br><hr><br> 
<?
  break;
  case "1":
  $cmd=$_GET["cmd"];
  if ($uroven >0) $idm=$_SESSION["idm"];
  if ($uroven > 1) $iddum=$_SESSION["iddum"];
  
  if ($uroven > 2) $idmenu=$_SESSION["iddomy_Menu"];
  $zpet= "<a href=\"?\">";
?>


          <div><h2><a href="?">Administrace</a> -> <a href="?cmd=zobrazlDolniMenu">Levé spodní menu</a> 
<?
  if ($idm) {
    $sql="SELECT * FROM lDolniMenu where id_lDolniMenu=$idm";
    $res = PrSql($spojeni,$sql);
    $zaznam = mysqli_fetch_array($res);
    $nazevlMenu=$zaznam["nazev"];
      ?>      
           - > <a href="?cmd=editdomy&idm=<?echo $idm?>"><? echo $nazevlMenu ?></a>
      <?
  }
  if ($iddum) {
    $sql="SELECT * FROM domy where id_dum=$iddum";
      $res = PrSql($spojeni,$sql);
      $zaznam = mysqli_fetch_array($res);
      $obrazek=$zaznam["obrazek"];
      $nazevdomu=$zaznam["nazev"];
      ?>
          - > <a href="?cmd=editMenuDomy&iddum=<?echo $iddum?>"><? echo $nazevdomu ?></a>
      <?
     $zpet= "<a href=\"?cmd=editdomy&idm=$idm\">";
  }
  if ($idmenu) {
      $sql="SELECT domy.obrazek, domy.nazev as nazevdomu, domy_Menu.nazev as nazevmenu, domy_Menu.typ FROM domy,domy_Menu where domy.id_dum=$iddum and id_domy_Menu=$idmenu";
      $obrazek=$zaznam["obrazek"];
      $res = PrSql($spojeni,$sql);
      $zaznam = mysqli_fetch_array($res);
      $nazevdomu=$zaznam["nazevdomu"];
      $_SESSION["nazevdomu"]=$nazevdomu;
      $nazevmenu=$zaznam["nazevmenu"];
      $typ=$zaznam["typ"];
      ?>
          - > <? echo $nazevmenu ?></a>  
      <?
     $zpet= "<a href=\"?cmd=editMenuDomy&iddum=$iddum\">";
  }  
  ?></div><div class="zpet"><?echo $zpet?>ZPĚT</A></div><br> <div><? if ($obrazek) { ?><img height="80" src="<? echo $zaznam["obrazek"]?>"> <?}?></div><br>
  <?
  break;
  case "2":
    $zpet= "<a href=\"?\">";
    $idhm=$_SESSION["idhmenu"];
  ?>
            <div><h2><a href="?">Administrace</a> -> <a href="?cmd=zobrazhlavni_Menu">Hlavní menu</a> 
  <?

    if ($uroven>=1) {
        $idhm=$_SESSION["idhmenu"];
         $zpet= "<a href=\"?cmd=zobrazhlavni_Menu\">";
         $sql="SELECT * FROM hlavni_Menu where id_hlavni_Menu=$idhm";
         $res = PrSql($spojeni,$sql);
         $zaznam = mysqli_fetch_array($res);
         $nazevhlMenu=$zaznam["nazevvetsi"]." ".$zaznam["nazevmensi"];
         ?>      
           - > <? echo $nazevhlMenu ?>  </a>
      <?
  }
    if ($uroven>=2) {
        $idcm=$_SESSION["idcmenu"];
        $zpet= "<a href=\"?cmd=zobrazcontent_Menu&idm=$idhm\">";
        $sql="SELECT nazev FROM content_Menu where id_content_Menu=$idcm";
        $res = PrSql($spojeni,$sql);
        $zaznam = mysqli_fetch_array($res);
        $nazevcMenu=$zaznam["nazev"];
         ?>      
           - > <?echo $zpet.$nazevcMenu ?></a>
      <?
  }
  
  ?>
   </div><div class="zpet"><?echo $zpet?>ZPĚT</A></div><br> 
  <?
  break;
  case "3":
    $zpet= "<a href=\"?\">";
    $idhm=$_SESSION["idhmenu"];
  ?>
            <div><h2><a href="?">Administrace</a> -> Editace úvodního textu  
            </div><div class="zpet"><a href="?">ZPĚT</A></div><br> <div><? if ($obrazek) { ?><img height="80" src="<? echo $zaznam["obrazek"]?>"> <?}?></div><br>
  <?

 }
 
  
}


function prDolniMenu($spojeni)

{
  $nahoru=$_POST["nahoru_x"];
  $dolu =$_POST["dolu_x"];
  $prejmenovat =$_POST["prejmenovat_x"];
  $novy=$_POST["novy_x"];
  $smazat = $_POST["smazat_x"]; 
  $id=$_POST["idmenu"];
  $novynazev=$_POST["nazev".$id];
 
  if ($novy) {
  $nazevn=$_POST["nazevn"];
  $poradi=$_POST["poradi"];   
  $sql = "INSERT INTO lDolniMenu (nazev,poradi) VALUES ('$nazevn',$poradi)";
  $res = PrSql($spojeni,$sql);
  }
  
  if ($prejmenovat) {   
  $sql = "UPDATE lDolniMenu SET nazev='$novynazev' where id_lDolniMenu=$id";
  $res = PrSql($spojeni,$sql);
  }
  if ($smazat) {
  $sql = "DELETE from lDolniMenu where id_lDolniMenu=$id";
  $res = PrSql($spojeni,$sql);
  } 
  
  if ($nahoru || $dolu) {
    $poradi=$_POST["poradi"];
    if ($nahoru) {
    $sql = "SELECT * from lDolniMenu where poradi<$poradi order by poradi DESC LIMIT 1";
    }
    else {
    $sql = "SELECT * from lDolniMenu where poradi>$poradi order by poradi ASC LIMIT 1";
    }    
    $res = PrSQL($spojeni,$sql);
    $pocet = mysqli_num_rows($res);
    if ($pocet > 0) {
      $zaznam = mysqli_fetch_array($res);
      $idvrchni = $zaznam["id_lDolniMenu"];
      $porvrchni = $zaznam["poradi"];
      $sql = "UPDATE lDolniMenu SET poradi='$porvrchni' where id_lDolniMenu=$id";
      $res = PrSql($spojeni,$sql);
      $sql = "UPDATE lDolniMenu SET poradi='$poradi' where id_lDolniMenu=$idvrchni";
      $res = PrSql($spojeni,$sql);
    }
  }

  
  zobrazlDolniMenu($spojeni);
  
  
}


function zobrazlDolniMenu($spojeni)
        {  
                    ZobrazUvod($spojeni,0,1);

          $sql="SELECT * FROM lDolniMenu order by poradi";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);  
          ?>
            <table border="0" width="800">
            <tr>
              <th>Název</th>
              <th width="50">Upravit/<br>nový</th>
              <th>Pořadí</th>
              <th>Smazat</th>
              <th>Domy/Přidat nové</th>
            </tr>
          <script language="JavaScript">
            function KontrolaNazvu(id)
                    {
                      var nazevform = "ldolnimenu" + id;
                      var nazevpole = "nazev" + id;
                      var text_jmena = document.forms[nazevform][nazevpole].value;
                      var je_ok = text_jmena != "";
                      if (je_ok == false) alert('Nebyl zadán název menu!');
                      return je_ok; }         
           </script> 
          <? 
          if ($pocet>0) {
          $i=0;
          while ($zaznam = mysqli_fetch_array($res))
           {
           $poradi=$zaznam["poradi"];
            ?>
            <tr>
      	    <form name="ldolnimenu<?echo $zaznam["id_lDolniMenu"]?>" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prldolnimenu" onsubmit="return KontrolaNazvu(<?echo $zaznam["id_lDolniMenu"]?>);">
            <td><input id="idnaz<? echo $zaznam["id_lDolniMenu"]?>" type="text" value="<?echo $zaznam["nazev"];?>" name="nazev<? echo $zaznam["id_lDolniMenu"]?>"><input name="idmenu" type="hidden" value="<?echo $zaznam["id_lDolniMenu"]?>"></td>
            <td><input name="prejmenovat" type ="image" src="images/b_edit.png" value="1" ></td>
            <td><input type="hidden" name="poradi" value="<?echo $zaznam["poradi"]?>">
            <? if ($i>0) {?><input name="nahoru" type ="image" src="images/j_arrow_up.png" value="1"><br><?}
            if ($i<($pocet-1)) {?><input name="dolu" type ="image" src="images/j_arrow_down.png" value="1"><?}?>
            </td>
            <td><input name="smazat" type ="image" src="images/b_drop.png" value="1" onclick="return confirm('Budou tím smazány i veškeré domy s touto položkou související, opravdu smazat tuto položku?')"></td>
            <td><a href="?cmd=editdomy&idm=<?echo $zaznam["id_lDolniMenu"]?>">Editace domů</a></td>            
            </form>
            </tr>
            
            <?
            $i=$i+1;
          }           	
        } // END function ZobrazPrilohy

        ?>
         <tr>
      	    <form name="ldolnimenun" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prldolnimenu" onsubmit="return KontrolaNazvu('n');">
            <td><input type="text" value="" name="nazevn" value=""><input name="poradi" type="hidden" value="<?echo ($poradi+1)?>"></td>
            <td><input name="novy" type ="image" src="images/icon-16-new.png" value="1"></td>
            </form>
        </tr>      
        </table>  
                 
        <?

}      

function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
function prDomy($spojeni)
{
  $nahoru=$_POST["nahoru_x"];
  $dolu =$_POST["dolu_x"];
  $prejmenovat =$_POST["prejmenovat_x"];
  $novy=$_POST["novy_x"];
  $smazat = $_POST["smazat_x"]; 
  $id=$_POST["iddum"];
  $hidden=$_POST["hidden"];
  if (!$hidden) $hidden=0;
  $novynazev=$_POST["nazev".$id];
  $idMenu=$_SESSION["idm"];
  $maxx=X_NAHLED;
  $maxy=Y_NAHLED;

  if ($novy) {
      $nazevn=$_POST["nazevn"];
      $poradi=$_POST["poradi"];   
      $tmp_name = $_FILES["userfile"]["tmp_name"];
      $cesta = "images/nove/";    
      $nazev="$nazevn-nahled";
      if ($tmp_name) {
        $nazevobr=UlozObrazek($cesta,$nazev,"M");
      }        
      $sql = "INSERT INTO domy (id_lDolniMenu,nazev,poradi,obrazek) VALUES ($idMenu,'$nazevn',$poradi,'$cesta$nazevobr')";
      $res = PrSql($spojeni,$sql);
      $idn = mysqli_insert_id($spojeni);
      $sql="INSERT INTO `domy_Menu` (`id_dum`, `nazev`, `poradi`, `odkaz`, `typ`, `zobrazit`) VALUES
($idn, 'Vizualisations', 1, NULL, 'V', 1),
($idn, 'Plans', 2, NULL, 'P', 1),
($idn, 'Recommande', 3, NULL, 'D', 1),
($idn, 'A télécharger', 4, NULL, 'K', 1);";
      $res = PrSql($spojeni,$sql);
  }
  
  if ($prejmenovat) {   
      $tmp_name = $_FILES["userfile"]["tmp_name"];
      $cesta = CESTA_OBRAZKY;    
      $nazev="$iddum-$novynazev-nahled";
      if (!$hidden) $hidden=0;
      if ($tmp_name) {
        $nazevobr=UlozObrazek($cesta,$nazev,$maxx,$maxy);
        $sqlsoubor=",obrazek='$cesta$nazevobr'";
      }        
      $sql = "UPDATE domy SET nazev='$novynazev',hidden=$hidden $sqlsoubor where id_dum=$id";
      $res = PrSql($spojeni,$sql);
  }
  if ($smazat) {
  $sql = "DELETE from domy where id_dum=$id; ";
  $res = PrSql($spojeni,$sql);
  $sql = "DELETE from domy_Menu where id_dum=$id;";
  $res = PrSql($spojeni,$sql);
  $sql = "SELECT * from domy_Data where id_dum=$id;";
  $res = PrSql($spojeni,$sql);
  while ($zaznam = mysqli_fetch_array($res)) {
    if ($zaznam["soubor"]) {
      echo "Mažu soubor : ".$zaznam["soubor"]."<br>";
    unlink ($zaznam["soubor"]);
  }
  }
  $sql = "DELETE from domy_Data where id_dum=$id;";
  $res = PrSql($spojeni,$sql);
  } 
  
  if ($nahoru || $dolu) {
    $poradi=$_POST["poradi"];
    if ($nahoru) {
    $sql = "SELECT * from domy where poradi<$poradi and id_ldolnimenu=$idMenu order by poradi DESC LIMIT 1";
    }
    else {
    $sql = "SELECT * from domy where poradi>$poradi and id_ldolnimenu=$idMenu order by poradi ASC LIMIT 1";
    }    
    $res = PrSQL($spojeni,$sql);
    $pocet = mysqli_num_rows($res);
    if ($pocet > 0) {
      $zaznam = mysqli_fetch_array($res);
      $idvrchni = $zaznam["id_dum"];
      $porvrchni = $zaznam["poradi"];
      $sql = "UPDATE domy SET poradi='$porvrchni' where id_dum=$id";
      $res = PrSql($spojeni,$sql);
      $sql = "UPDATE domy SET poradi='$poradi' where id_dum=$idvrchni";
      $res = PrSql($spojeni,$sql);
    }
  }
  zobrazDomy($spojeni);
 }

function zobrazDomy($spojeni)
        {  
          ZobrazUvod($spojeni,1,1);
          $idm=$_SESSION["idm"];
          $sql="SELECT * FROM domy where id_lDolniMenu=$idm order by poradi";            
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          ?>
            <table border="1" width="500">
            <tr>
              <th>Název</th>
              <th width="50">Upravit/<br>nový</th>
              <th>Pořadí</th>
              <th>Smazat</th>
              <th>Obrázek</th>
              <th>Skrytý</th>
              <th>Editace Dat</th>
            </tr>
          <script language="JavaScript">
            function KontrolaNazvu(id)
                    {
                      var nazevform = "prdomy" + id;
                      var nazevpole = "nazev" + id;
                      var text_jmena = document.forms[nazevform][nazevpole].value;
                      var je_ok = text_jmena != "";
                      if (je_ok == false) alert('Nebyl zadán název menu!');
                      return je_ok; }    

            function KontrolaNove()
                    {
                      var nazevform = "prdomyn";
                      var nazevpole = "nazevn";
                      var obrazek = "userfile";
                      
                      var text_jmena = document.forms[nazevform][nazevpole].value;
                      var obrazek = document.forms[nazevform][obrazek].value;
                      var je_ok = text_jmena != "";
                      if (je_ok == false) alert('Nebyl zadán název domu!');
                      var je_oko = obrazek != "";
                      if (je_oko == false) alert('Nebyl zadán název obrazku!');
                      return je_ok && je_oko; }    
                        
           </script> 
          <? 
          if ($pocet>0) {
          $i=0;
          while ($zaznam = mysqli_fetch_array($res))
           {
           $poradi=$zaznam["poradi"];
           $hidden = $zaznam["hidden"];
           if (!$hidden) $hidden =0;
            ?>
            <tr>
      	    <form name="prdomy<?echo $zaznam["id_dum"]?>" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prDomy" onsubmit="return KontrolaNazvu(<?echo $zaznam["id_lDolniMenu"]?>);">
            <td><input id="idnaz<? echo $zaznam["id_dum"]?>" type="text" value="<?echo $zaznam["nazev"];?>" name="nazev<? echo $zaznam["id_dum"]?>"><input name="iddum" type="hidden" value="<?echo $zaznam["id_dum"]?>"></td>
            <td><input name="prejmenovat" type ="image" src="images/b_edit.png" value="1" ></td>
            <td><input type="hidden" name="poradi" value="<?echo $zaznam["poradi"]?>">
            <? if ($i>0) {?><input name="nahoru" type ="image" src="images/j_arrow_up.png" value="1"><br><?}
            if ($i<($pocet-1)) {?><input name="dolu" type ="image" src="images/j_arrow_down.png" value="1"><?}?>
            </td>
            <td><input name="smazat" type ="image" src="images/b_drop.png" value="1" onclick="return confirm('Budou tím smazány i veškeré data a soubory s tímto domem související, opravdu smazat tuto položku?')"></td>
            <td><img src="<?echo $zaznam["obrazek"]?>"><br><input type="file" name="userfile" ></td>            
            <td><input type="checkbox" name="hidden" <? if ($hidden) echo "checked"; ?> value="1"  > </td>            
            <td><a href="?cmd=editMenuDomy&iddum=<?echo $zaznam["id_dum"]?>">Editovat MENU domu</a></td>            
            </form>
            </tr>
            
            <?
            $i=$i+1;
          }           	
        } // END function ZobrazPrilohy

        ?>
         <tr>
      	    <form name="prdomyn" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prDomy" onsubmit="return KontrolaNove();">
            <td><input type="text" value="" name="nazevn" value=""><input name="poradi" type="hidden" value="<?echo ($poradi+1)?>"></td>
            <td><input name="novy" type ="image" src="images/icon-16-new.png" value="1"></td>
            <td colspan="2"></td><td colspan ="3"><input type="file" name="userfile" ></td>            
            </form>
        </tr>      
        </table>  
       <?         

}      

function prDomy_Menu($spojeni)

{
  $iddum=$_SESSION["iddum"];
  $nahoru=$_POST["nahoru_x"];
  $dolu =$_POST["dolu_x"];
  $prejmenovat =$_POST["prejmenovat_x"];
  $novy=$_POST["novy_x"];
  $smazat = $_POST["smazat_x"]; 
  $id=$_POST["idmenu"];
  $novynazev=$_POST["nazev".$id];
  $typ=$_POST["typ"];
  if ($novy) {
  $nazevn=$_POST["nazevn"];
  $poradi=$_POST["poradi"];   
  $sql = "INSERT INTO domy_Menu (id_dum,nazev,poradi,typ) VALUES ($iddum,'$nazevn',$poradi,'$typ')";
  $res = PrSql($spojeni,$sql);
  }
  
  if ($prejmenovat) {   
  $sql = "UPDATE domy_Menu SET nazev='$novynazev' where id_domy_Menu=$id";
  $res = PrSql($spojeni,$sql);
  }
  if ($smazat) {
  $sql = "DELETE from domy_Menu where id_domy_Menu=$id";
  $res = PrSql($spojeni,$sql);
  } 
  
  if ($nahoru || $dolu) {
    $poradi=$_POST["poradi"];
    if ($nahoru) {
    $sql = "SELECT * from domy_Menu where poradi<$poradi and id_dum=$iddum order by poradi DESC LIMIT 1";
    }
    else {
    $sql = "SELECT * from domy_Menu where poradi>$poradi and id_dum=$iddum order by poradi ASC LIMIT 1";
    }    
    $res = PrSQL($spojeni,$sql);
    $pocet = mysqli_num_rows($res);
    if ($pocet > 0) {
      $zaznam = mysqli_fetch_array($res);
      $idvrchni = $zaznam["id_domy_Menu"];
      $porvrchni = $zaznam["poradi"];
      $sql = "UPDATE domy_Menu SET poradi='$porvrchni' where id_domy_Menu=$id";
      $res = PrSql($spojeni,$sql);
      $sql = "UPDATE domy_Menu SET poradi='$poradi' where id_domy_Menu=$idvrchni";
      $res = PrSql($spojeni,$sql);
    }
  }

  
  zobrazDomyMenu($spojeni);
  
  
}


function zobrazDomyMenu($spojeni)
        {  
                    ZobrazUvod($spojeni,2,1);

          $iddum=$_SESSION["iddum"];                       
          $sql="SELECT * FROM domy_Menu where id_dum=$iddum order by poradi";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          ?>
            <table border="1" width="500">
            <tr>
              <th>Název</th>
              <th width="50">Upravit/<br>nový</th>
              <th>Pořadí</th>
              <th>Smazat</th>
              <th width="50">Typ</th>
              <th>Domy/Přidat údaje</th>
            </tr>
          <script language="JavaScript">
            function KontrolaNazvu(id)
                    {
                      var nazevform = "domy_Menu" + id;
                      var nazevpole = "nazev" + id;
                      var text_jmena = document.forms[nazevform][nazevpole].value;
                      var je_ok = text_jmena != "";
                      if (je_ok == false) alert('Nebyl zadán název menu!');
                      return je_ok; }         
           </script> 
          <? 
          if ($pocet>0) {
          $i=0;
          while ($zaznam = mysqli_fetch_array($res))
           {
           $poradi=$zaznam["poradi"];
            ?>
            <tr>
      	    <form name="domy_Menu<?echo $zaznam["id_domy_Menu"]?>" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prDomy_Menu" onsubmit="return KontrolaNazvu(<?echo $zaznam["id_domy_Menu"]?>);">
            <td><input id="idnaz<? echo $zaznam["id_domy_Menu"]?>" type="text" value="<?echo $zaznam["nazev"];?>" name="nazev<? echo $zaznam["id_domy_Menu"]?>"><input name="idmenu" type="hidden" value="<?echo $zaznam["id_domy_Menu"]?>"></td>
            <td><input name="prejmenovat" type ="image" src="images/b_edit.png" value="1" ></td>
            <td><input type="hidden" name="poradi" value="<?echo $zaznam["poradi"]?>">
            <? if ($i>0) {?><input style="margin-bottom:5px;" name="nahoru" type ="image" src="images/j_arrow_up.png" value="1"><?}
            if ($i<($pocet-1)) {?><input name="dolu" type ="image" src="images/j_arrow_down.png" value="1"><?}?>
            </td>
            <td><input name="smazat" type ="image" src="images/b_drop.png" value="1" onclick="return confirm('Budou tím smazány i veškeré data s touto položkou související, opravdu smazat tuto položku?')"></td>
            <td><?echo $zaznam["typ"]?></td>            
            <td><a href="?cmd=editdata_Domy&idm=<?echo $zaznam["id_domy_Menu"]?>">Editace dat</a></td>            
            </form>
            </tr>
            
            <?
            $i=$i+1;
          }           	
        } // END function ZobrazPrilohy

        ?>
         <tr>
      	    <form name="domy_Menun" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prDomy_Menu" onsubmit="return KontrolaNazvu('n');">
            <td><input type="text" value="" name="nazevn" value=""><input name="poradi" type="hidden" value="<?echo ($poradi+1)?>"></td>
            <td><input name="novy" type ="image" src="images/icon-16-new.png" value="1"></td>
            <td colspan="2">Typ: </td><td colspan="2"> <select name="typ">
                      <OPTION value="V">Visualizace - obrázky</OPTION>
                      <OPTION value="P">Půdorysy - obrázky + data</OPTION>
                      <OPTION value="D">Doporučujeme - text</OPTION>
                      <OPTION value="K">Ke stažení - text + soubory</OPTION>
            </td>
            </form>
        </tr>      
        </table>  
        
                 
        <?

}

function UlozObrazek($cesta,$nazev,$typmenu)
{
  $tmp_name = $_FILES["userfile"]["tmp_name"];
  if ($tmp_name) {
  $handle = new upload($_FILES['userfile']);
  $x=$handle->image_src_x;
  $y=$handle->image_src_y;
  $mratiox=0;
        // Only proceed if the file has been uploaded
  if($handle->uploaded) {
            // Set the new filename of the uploaded image
            $handle->file_new_name_body   = "nahled-".$nazev;
            // Make sure the image is resized
            switch ($typmenu) {
              case "V":
                $maxx=X_VISUAL_NAHLED;
                $maxy=Y_VISUAL_NAHLED;
              break;
              case "P":
                $maxx=X_PUDORYS_NAHLED;
                $maxy=Y_PUDORYS_NAHLED;
              break;
              case "M":
                $maxx=X_DUM_NAHLED;
                $maxy=Y_DUM_NAHLED;
              break;
              default:
                $maxx=X_DUM_NAHLED;
                $maxy=Y_DUM_NAHLED;
            }              
            if ((($x<>$maxx) || ($y<>$maxy))) {
            // Set the width of the image
            if ($mratiox) {
              $handle->image_resize         = true;
              $handle->image_x              = $maxx;
              $handle->image_ratio_y              = true;
              echo "OBRAZEK ZMENEN NA $maxx,$maxy : a ratiox:".$mratiox;
            }
            else {
            $handle->image_resize         = true;
            $handle->image_x              = $maxx;
            $handle->image_y        = $maxy;
            }
            $handle->jpeg_quality = 100;
            $handle->process($cesta);
            }
            else {
            $handle->image_resize         = false;
            $handle->process($cesta);
            }

      switch ($typmenu) {
        case "V":
          $ratiox=X_VISUAL_VELKE;
        break;
        case "P":
          $ratiox=X_PUDORYS_VELKE;
        break;
        case "M":
          $ratiox=0;
        default:
          $ratiox=0;
      }              
      
      if ($ratiox) {
        if ($x>$ratiox) {
        $handle->image_resize         = true;
        $handle->image_ratio_y = true;
        $handle->image_x              = $ratiox;
        }
        else {
        $handle->image_resize         = false;
        $handle->image_x              = $x;
        $handle->image_y        = $y;
        }
        
        $handle->file_new_name_body   = "obr-".$nazev;
        $handle->process($cesta);
      }
      if($handle->processed) {
          $nazevobr=$handle->file_dst_name;
          $handle->clean();
      }else{
          echo 'error : ' . $handle->error;
          return 0;
      }
    return $nazevobr;  
    }        
  }
}

function UlozSoubor($cesta)
{
  $tmp_name = $_FILES["userfile"]["tmp_name"];
  if ($tmp_name) {
  $handle = new upload($_FILES['userfile']);
  if($handle->uploaded) {
      $handle->process($cesta);
      if($handle->processed) {
          $nazevs=$handle->file_dst_name;
          $handle->clean();
      }else{
          echo 'error : ' . $handle->error;
          return 0;
      }
    return $nazevs;  
    }        
  }
}


function prData_Domy($spojeni){
  
    $id=$_POST["iddata"];
    $iddum=$_SESSION["iddum"];
    $idmenu=$_SESSION["iddomy_Menu"];
    if (!$idmenu) return 0;
    $datum=date('Y-m-d-H-i-s');    
    $nazevdomu=$_SESSION["nazevdomu"];
    $typ=$_GET["typ"];
    $typmenu = $_POST["typm"];
    $novy=$_POST["novy_x"] || $_POST["novy"];
    $nahoru=$_POST["nahoru_x"];
    $dolu =$_POST["dolu_x"];
    $smazat = $_POST["smazat_x"];
    $text=$_POST["text"];
    $prejmenovat=$_POST["prejmenovat_x"] || $_POST["prejmenovat"];
    if ($novy){ 
      switch ($typ) {
      case "O" :
        $poradi=$_POST["poradinove"];
        $nazevobr="$iddum-$idmenu-$nazevdomu-$datum";
        $cesta=CESTA_OBRAZKY;
        $nazevs=UlozObrazek($cesta,$nazevobr,$typmenu);   
        $nazevs = $cesta.$nazevs;
        $nazevnahl=str_replace("obr-","nahled-",$nazevs);
        $sql = "INSERT INTO domy_Data (id_domy_Menu,id_dum,soubor,nahled,typ,poradi) VALUES ($idmenu,$iddum,'$nazevs','$nazevnahl','O',$poradi)";
        $res = PrSql($spojeni,$sql);
        break;
        case "S" :
        $poradi=$_POST["poradinove"];
        $text=$_POST["textn"];
        $nazevs="soub-$iddum-$idmenu-$nazevdomu-$datum";
        $cesta=CESTA_SOUBORY;
        $nazevs=UlozSoubor($cesta);
        $nazevs = $cesta.$nazevs;
        $sql = "INSERT INTO domy_Data (id_domy_Menu,id_dum,soubor,text,typ,poradi) VALUES ($idmenu,$iddum,'$nazevs','$text','S',$poradi)";
        $res = PrSql($spojeni,$sql);
        break;
        case "T" :
        $text=$_POST["text"];
        $sql = "INSERT INTO domy_Data (id_domy_Menu,id_dum,text,typ) VALUES ($idmenu,$iddum,'$text','T')";
        $res = PrSql($spojeni,$sql);
        break;
      }
    }
    if ($prejmenovat) {   
    $sql = "UPDATE domy_Data SET text='$text' where id_domy_Data=$id";
    $res = PrSql($spojeni,$sql);
    }
    if ($smazat) {
      $sql="SELECT * from domy_Data where id_domy_Data=$id";
      $res = PrSql($spojeni,$sql);
      $zaznam = mysqli_fetch_array($res);
      $soubor = $zaznam["soubor"];
//      if ($soubor) unlink($soubor);
      $sql = "DELETE from domy_Data where id_domy_Data=$id";
      $res = PrSql($spojeni,$sql);
    } 
    if ($nahoru || $dolu) {
    $poradi=$_POST["poradi"];
    if ($nahoru) {
    $sql = "SELECT * from domy_Data where poradi<$poradi and id_dum=$iddum order by poradi DESC LIMIT 1";
    }
    else {
    $sql = "SELECT * from domy_Data where poradi>$poradi and id_dum=$iddum order by poradi ASC LIMIT 1";
    }    
    $res = PrSQL($spojeni,$sql);
    $pocet = mysqli_num_rows($res);
    if ($pocet > 0) {
      $zaznam = mysqli_fetch_array($res);
      $idvrchni = $zaznam["id_domy_Data"];
      $porvrchni = $zaznam["poradi"];
      $sql = "UPDATE domy_Data SET poradi=$porvrchni where id_domy_Data=$id";
      $res = PrSql($spojeni,$sql);
      $sql = "UPDATE domy_Data SET poradi=$poradi where id_domy_Data=$idvrchni";
      $res = PrSql($spojeni,$sql);
    }
  }    
  editData_Domy($spojeni);    
}

function editData_domy_obrazky($spojeni,$idmenu,$typ)
{
          $iddum=$_SESSION["iddum"];
          $poradi=0;
          ?>
          <script language="JavaScript">

            function KontrolaNove()
                    {
                      var nazevform = "dataMenuN";
                      var nazevpole = "userfile";
                      
                      var text_jmena = document.forms[nazevform][nazevpole].value;
                      var je_ok = text_jmena != "";
                      if (je_ok == false) alert('Nebyl zadán název obrazku!');
                      return je_ok ; }    
                     </script> 

          <table width="100%">
          <?
          $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu and typ='O' order by poradi";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          if ($pocet>0) {
          ?>
          <tr><td colspan="3">Nahrané obrázky</td></tr><tr>
          <?
           $i=0;
           $j=1;
           while ($zaznam = mysqli_fetch_array($res))
           {
             ?>
	          <form name="dataMenu" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prData_Domy&typ=O">
             <td>
             <a class="fancybox" rel="group" href="<?echo $zaznam["soubor"]?>"><img width="200" src="<?echo $zaznam["nahled"]?>" alt="nahled"/></a><br>
              <? if ($i>0) {?><input name="nahoru" type ="image" src="images/j_arrow_left.png" value="1"><?}
              if ($i<($pocet-1)) {?><input name="dolu" type ="image" src="images/j_arrow_right.png" value="1"><?}?>
              <input name="smazat" type ="image" src="images/b_drop.png" onclick="return confirm('Opravdu smazat?')" value="1"><input name="poradi" type="hidden" value="<?echo $zaznam["poradi"]?>"><input name="iddata" type="hidden" value="<?echo $zaznam["id_domy_Data"]?>">
              <input name="typm" type="hidden" value="<?echo $typ?>"></td>
              </form>
              <?
              $poradi=$zaznam["poradi"];
              $i=$i+1;
              $j=$j+1;
              if ($j>3) {echo "</tr><tr>";$j=1;}
            }
          ?></tr>
          <?}
          ?>
          <form name="dataMenuN" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prData_Domy&typ=O" onsubmit="return KontrolaNove();">
          <tr>
          <td colspan="3"><input name="novy" type ="image" src="images/icon-16-new.png" value="1"> Soubor obrázku : <input type="file" name="userfile" value="" ><input name="poradinove" type="hidden" value="<?echo ($poradi+1)?>"><input name="typm" type="hidden" value="<?echo $typ?>"></td>
          </tr>
          </form>            
          </table>
          <?
}

function editData_domy_soubory($spojeni,$idmenu)
{
          $iddum=$_SESSION["iddum"];
          $poradi=0;
          ?>
          <script language="JavaScript">
            function KontrolaNazvu(id)
                    {
                      var nazevform = "dataMenu" + id;
                      var nazevpole = "text" + id;
                      var text_jmena = document.forms[nazevform][nazevpole].value;
                      var je_ok = text_jmena != "";
                      if (je_ok == false) alert('Nebyl zadán název souboru!');
                      return je_ok; }         
           </script> 
          <table>
          <?
          $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu and typ='S' order by poradi";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          $poradi=0;
          if ($pocet>0) {
          ?>
          <tr><td colspan="3">Nahrané soubory</td></tr><tr>
          <?
           $i=0;
           $j=1;
           while ($zaznam = mysqli_fetch_array($res))
           {
             ?>
	          <form name="dataMenu<?echo $zaznam["id_domy_Data"]?>" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prData_Domy&typ=<?echo $typ?>" onsubmit="return KontrolaNazvu(<?echo $zaznam["id_domy_Data"]?>);">
             <td><input size="30" type="text" name="text" value="<?echo $zaznam["text"]?>"><br> 
             <a href="<?echo $zaznam["soubor"]?>"><?echo $zaznam["soubor"]?></a><br>
             <input name="prejmenovat" type ="image" src="images/b_edit.png" value="1" >
              <? if ($i>0) {?><input name="nahoru" type ="image" src="images/j_arrow_left.png" value="1"><?}
              if ($i<($pocet-1)) {?><input name="dolu" type ="image" src="images/j_arrow_right.png" value="1"><?}?>
              <input name="smazat" type ="image" src="images/b_drop.png" onclick="return confirm('Opravdu smazat?')" value="1"><input name="poradi" type="hidden" value="<?echo $zaznam["poradi"]?>"><input name="iddata" type="hidden" value="<?echo $zaznam["id_domy_Data"]?>"></td>
              </form>
              <?
              $poradi=$zaznam["poradi"];
              $i=$i+1;
              $j=$j+1;
              if ($j>3) {echo "</tr><tr>";$j=1;}
              
            }
          ?></tr>
          <?}
          ?>
          <form name="dataMenun" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prData_Domy&typ=S" onsubmit="return KontrolaNazvu('n');">
          <tr>
          <td><input name="novy" type ="image" src="images/icon-16-new.png" value="1"></td><td>Název souboru : <input type="text" value="" name="textn" value=""></td><td>Soubor : <input type="file" size="30" name="userfile" ><input name="poradinove" type="hidden" value="<?echo ($poradi+1)?>"></td>
          </tr>
          </form>            
          </table>
<?
}

function editData_domy_text($spojeni,$idmenu,$typ)
{
          $iddum=$_SESSION["iddum"];
          $sql="SELECT * FROM domy_Data where id_domy_Menu=$idmenu and typ='T'";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          if ($pocet>0) {
          $zaznam = mysqli_fetch_array($res);
          $text=$zaznam["text"];
          $butt="prejmenovat";
          }
          else {
            $butt="novy";
          }
          if (($typ=='P')&&($text=='')) {
            $text="
<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=357 colspan=2 valign=top style='width:267.65pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'>TOTAL MAISON<o:p></o:p></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=205 valign=top style='width:153.5pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'>Dispozition:<o:p></o:p></p>
  </td>
  <td width=152 valign=top style='width:114.15pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:right;line-height:normal'>0<o:p></o:p></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2'>
  <td width=205 valign=top style='width:153.5pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'>Surface habitable:<o:p></o:p></p>
  </td>
  <td width=152 valign=top style='width:114.15pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:right;line-height:normal'>0 m<sup>2</sup><o:p></o:p></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;mso-yfti-lastrow:yes'>
  <td width=205 valign=top style='width:153.5pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'>Surface bâtie:<o:p></o:p></p>
  </td>
  <td width=152 valign=top style='width:114.15pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:right;line-height:normal'>0 m<sup>2</sup><o:p></o:p></p>
  </td>
 </tr>
</table>

";
            } 
          
                 ?>
          <form name="dataMenuT" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prData_Domy&typ=T">
                <table>
                <td><textarea id="e1m1" name="text"><?echo $text ?></textarea></td>
                <tr>
                  <td align="center"><input type="submit" name="<?echo $butt?>" value="Uložit text"><input name="iddata" type="hidden" value="<?echo $zaznam["id_domy_Data"]?>"></td>
                </tr>
                </tr>
                </table>
            </form>
                <?

}
                                                                               

function editData_Domy($spojeni)
{      
            ZobrazUvod($spojeni,3,1);

          $iddum=$_SESSION["iddum"];
          $idmenu=$_SESSION["iddomy_Menu"];
          $sql="SELECT domy.obrazek, domy.nazev as nazevdomu, domy_Menu.nazev as nazevmenu, domy_Menu.typ FROM domy,domy_Menu where domy.id_dum=$iddum and id_domy_Menu=$idmenu";
          $res = PrSql($spojeni,$sql);
          $zaznam = mysqli_fetch_array($res);
          $nazevdomu=$zaznam["nazevdomu"];
          $_SESSION["nazevdomu"]=$nazevdomu;
          $nazevmenu=$zaznam["nazevmenu"];
          $typ=$zaznam["typ"];                 
          ?>
           
          <?
            switch ($typ) {
              case "V" :
                editData_domy_obrazky($spojeni,$idmenu,$typ);
              break;
              case "P" :
                editData_domy_obrazky($spojeni,$idmenu,$typ);
                echo "<p>&nbsp;Údaje k půdorysu : </p>";
                editData_domy_text($spojeni,$idmenu,$typ);
              break;
              case "D" :
                editData_domy_text($spojeni,$idmenu,$typ);
              break;
              case "K" :
                editData_domy_soubory($spojeni,$idmenu);
                editData_domy_text($spojeni,$idmenu,$typ);
            }
          
}           	



function editContent_Data($spojeni)
{      
           
          $idmenu=$_GET["idm"];
          if ($idmenu) {
            $_SESSION["idcmenu"]=$idmenu;
            ZobrazUvod($spojeni,2,2);
          $sql="SELECT * from content_Menu where id_content_Menu=$idmenu";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          $zaznam = mysqli_fetch_array($res);
          $text=$zaznam["text"];
          $butt="Uložit";
          ?>
          <form name="dataMenuT" ENCTYPE="multipart/form-data"  method="post" action="?cmd=editcontent_Data">
                <table>
                <td><textarea id="e1m1" name="text"><?echo $text ?></textarea></td>
                <tr>
                  <td align="center"><input type="submit" name="<?echo $butt?>" value="Uložit text"><input name="iddata" type="hidden" value="<?echo $zaznam["id_content_Menu"]?>"></td>
                </tr>
                </tr>
                </table>
            </form>
          <?
            }
          else {
          $text=$_POST["text"];
          $idm=$_POST["iddata"];
          $sql = "UPDATE content_Menu SET text='$text' where id_content_Menu=$idm";
          $res = PrSql($spojeni,$sql);
          zobrazContent_Menu($spojeni);
          
          }
          
}           	

function prContent_Menu($spojeni)

{
  $idhmenu=$_SESSION["idhmenu"];
  $nahoru=$_POST["nahoru_x"];
  $dolu =$_POST["dolu_x"];
  $prejmenovat =$_POST["prejmenovat_x"];
  $novy=$_POST["novy_x"];
  $smazat = $_POST["smazat_x"]; 
  $id=$_POST["idmenu"];
  $novynazev=$_POST["nazev".$id];
  if ($novy) {
  $nazevn=$_POST["nazevn"];
  $poradi=$_POST["poradi"];   
  $sql = "INSERT INTO content_Menu (nazev,poradi,id_hlavni_Menu) VALUES ('$nazevn',$poradi,$idhmenu)";
  $res = PrSql($spojeni,$sql);
  }
  
  if ($prejmenovat) {   
  $sql = "UPDATE content_Menu SET nazev='$novynazev' where id_content_Menu=$id";
  $res = PrSql($spojeni,$sql);
  }
  if ($smazat) {
  $sql = "DELETE from content_Menu where id_content_Menu=$id";
  $res = PrSql($spojeni,$sql);
  } 
  
  if ($nahoru || $dolu) {
    $poradi=$_POST["poradi"];
    if ($nahoru) {
    $sql = "SELECT * from content_Menu where poradi<$poradi order by poradi DESC LIMIT 1";
    }
    else {
    $sql = "SELECT * from content_Menu where poradi>$poradi order by poradi ASC LIMIT 1";
    }    
    $res = PrSQL($spojeni,$sql);
    $pocet = mysqli_num_rows($res);
    if ($pocet > 0) {
      $zaznam = mysqli_fetch_array($res);
      $idvrchni = $zaznam["id_content_Menu"];
      $porvrchni = $zaznam["poradi"];
      $sql = "UPDATE content_Menu SET poradi='$porvrchni' where id_content_Menu=$id";
      $res = PrSql($spojeni,$sql);
      $sql = "UPDATE content_Menu SET poradi='$poradi' where id_content_Menu=$idvrchni";
      $res = PrSql($spojeni,$sql);
    }
  }

  
  zobrazContent_Menu($spojeni);
  
  
}


function zobrazContent_Menu($spojeni)
        {  
                    ZobrazUvod($spojeni,1,2);
          $idhmenu=$_SESSION["idhmenu"];
          $sql="SELECT * FROM content_Menu where id_hlavni_menu=$idhmenu order by poradi";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          ?>
            <table border="1" width="500">
            <tr>
              <th>Název</th>
              <th width="50">Upravit/<br>nový</th>
              <th>Pořadí</th>
              <th>Smazat</th>
              <th>Přidat údaje</th>
            </tr>
          <script language="JavaScript">
            function KontrolaNazvu(id)
                    {
                      var nazevform = "content_Menu" + id;
                      var nazevpole = "nazev" + id;
                      var text_jmena = document.forms[nazevform][nazevpole].value;
                      var je_ok = text_jmena != "";
                      if (je_ok == false) alert('Nebyl zadán název menu!');
                      return je_ok; }         
           </script> 
          <? 
          if ($pocet>0) {
          $i=0;
          while ($zaznam = mysqli_fetch_array($res))
           {
           $poradi=$zaznam["poradi"];
            ?>
            <tr>
      	    <form name="content_Menu<?echo $zaznam["id_content_Menu"]?>" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prcontent_Menu" onsubmit="return KontrolaNazvu(<?echo $zaznam["id_content_Menu"]?>);">
            <td><input id="idnaz<? echo $zaznam["id_content_Menu"]?>" type="text" value="<?echo $zaznam["nazev"];?>" name="nazev<? echo $zaznam["id_content_Menu"]?>"><input name="idmenu" type="hidden" value="<?echo $zaznam["id_content_Menu"]?>"></td>
            <td><input name="prejmenovat" type ="image" src="images/b_edit.png" value="1" ></td>
            <td><input type="hidden" name="poradi" value="<?echo $zaznam["poradi"]?>">
            <? if ($i>0) {?><input name="nahoru" type ="image" src="images/j_arrow_up.png" value="1"><br><?}
            if ($i<($pocet-1)) {?><input name="dolu" type ="image" src="images/j_arrow_down.png" value="1"><?}?>
            </td>
            <td><input name="smazat" type ="image" src="images/b_drop.png" value="1" onclick="return confirm('Budou tím smazány i veškeré data s touto položkou související, opravdu smazat tuto položku?')"></td>
            <td><a href="?cmd=editcontent_Data&idm=<?echo $zaznam["id_content_Menu"]?>">Editace textu</a></td>            
            </form>
            </tr>
            
            <?
            $i=$i+1;
          }           	
        } // END function ZobrazPrilohy

        ?>
         <tr>
      	    <form name="content_Menun" ENCTYPE="multipart/form-data"  method="post" action="?cmd=prcontent_Menu" onsubmit="return KontrolaNazvu('n');">
            <td><input type="text" value="" name="nazevn" value=""><input name="poradi" type="hidden" value="<?echo ($poradi+1)?>"></td>
            <td><input name="novy" type ="image" src="images/icon-16-new.png" value="1"></td>
            </form>
        </tr>      
        </table>  
        
                 
        <?

}

function editHlavni_Data($spojeni)
{      
           
          $idmenu=$_GET["idm"];
          if ($idmenu) {
            ZobrazUvod($spojeni,1,2);
          $sql="SELECT * from hlavni_Menu where id_hlavni_Menu=$idmenu";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          $zaznam = mysqli_fetch_array($res);
          $text=$zaznam["text"];
          $butt="Uložit";
          ?>
          <form name="dataMenuT" ENCTYPE="multipart/form-data"  method="post" action="?cmd=edithlavni_Data">
                <table>
                <td><textarea id="e1m1" name="text"><?echo $text ?></textarea></td>
                <tr>
                  <td align="center"><input type="submit" name="<?echo $butt?>" value="Uložit text"><input name="iddata" type="hidden" value="<?echo $zaznam["id_hlavni_Menu"]?>"></td>
                </tr>
                </tr>
                </table>
            </form>
          <?
            }
          else {
          $text=mysqli_real_escape_string($spojeni,$_POST["text"]);
          $idm=$_POST["iddata"];
          $sql = "UPDATE hlavni_Menu SET text='$text' where id_hlavni_Menu=$idm";
          $res = PrSql($spojeni,$sql);
          zobrazHlavni_Menu($spojeni);
          
          }
          
}           	


function edit_Uvodni_Text($spojeni)
{      
           
          if (!$_POST) {
          ZobrazUvod($spojeni,1,3);
          $sql="SELECT * from nastaveni_webu where id=0";
          $res = PrSql($spojeni,$sql);
          $zaznam = mysqli_fetch_array($res);
          if (!$zaznam) {
            echo "Nebylo nalezeno nastavení webu!";
            return 0;
          }
          $text=$zaznam["uvod_text"];
          $butt="Uložit";
          ?>
          <form name="dataUvod" ENCTYPE="multipart/form-data"  method="post" action="?cmd=zobrazUvodniText">
                <table>
                <td><textarea id="e1m1" name="text"><?echo $text ?></textarea></td>
                <tr>
                  <td align="center"><input type="submit" name="<?echo $butt?>" value="Uložit text"><input name="iddata" type="hidden" value="1"></td>
                </tr>
                </tr>
                </table>
            </form>
          <?
            }
          else {
          $text=mysqli_real_escape_string($spojeni,$_POST["text"]);
          $idm=$_POST["iddata"];
          $sql = "UPDATE nastaveni_webu SET uvod_text='$text' where id=0";
          $res = PrSql($spojeni,$sql);
          zobrazAdministraci($spojeni);
          }
          
}      

function zobrazHlavni_Menu($spojeni)
        {  
           ZobrazUvod($spojeni,0,2);

          $sql="SELECT * FROM hlavni_Menu order by poradi";
          $res = PrSql($spojeni,$sql);
          $pocet = mysqli_num_rows($res);
          ?>
            <table border="1" width="500">
            <tr>
              <th>Názvy</th>
              <th>Typ</th>
              <th>Přidat údaje</th>
            </tr>
          <script language="JavaScript">
            function KontrolaNazvu(id)
                    {
                      var nazevform = "content_Menu" + id;
                      var nazevpole = "nazev" + id;
                      var text_jmena = document.forms[nazevform][nazevpole].value;
                      var je_ok = text_jmena != "";
                      if (je_ok == false) alert('Nebyl zadán název menu!');
                      return je_ok; }         
           </script> 
          <? 
          if ($pocet>0) {
          $i=0;
          while ($zaznam = mysqli_fetch_array($res))
           {
           $poradi=$zaznam["poradi"];
            ?>
            <tr>
            <td>
            <? echo $zaznam["nazevvetsi"]." ".$zaznam["nazevmensi"] ?>
            </td>
            <td>
            <? echo $zaznam["typ"]; ?>
            </td>
            <td>
            <?
            switch ($zaznam["typ"]) {
              case "M":
                ?><a href="?cmd=zobrazcontent_Menu&idm=<?echo $zaznam["id_hlavni_Menu"]?>">Editovat submenu</a><?
              break;
              case "G":
                ?><a href="?cmd=zobrazcontent_Menu&idm=<?echo $zaznam["id_hlavni_Menu"]?>">Editovat submenu</a> , <?
                ?><a href="../galerie/admin.php">Editovat galerii</a><?
              	break;
              case "T":
                ?><a href="?cmd=edithlavni_Data&idm=<?echo $zaznam["id_hlavni_Menu"]?>">Editovat text</a><?
              break;
              case "K":
              
              break;
            }
            ?>
            </td>
            </form>
            </tr>
            
            <?
            $i=$i+1;
          }           	
        } // END function ZobrazPrilohy

        ?>
        </table>  
        
                 
        <?

}




?>