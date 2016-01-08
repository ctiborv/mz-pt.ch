<?
error_reporting(E_ALL);
include ("db.php");
//Header("Pragma: no-cache"); 
//Header("Cache-control: no-cache"); 
//Header("Expires: ".GMDate("D, d m Y H:i:s")." GMT");

//setlocale(LC_TIME, 'cs_CZ.utf-8');

?>



<?

$spojeni= mysqli_connect(SQL_HOST, SQL_USERNAME, SQL_PASSWORD); 
$db=mysqli_select_db($spojeni,SQL_DBNAME);
$prikaz = $_GET["sekce"];
PrSql($spojeni,"SET NAMES utf8");
$sqlg="SELECT * FROM galerie order by priorita";  
$resg = PrSql($spojeni,$sqlg);

while ($zaznam = mysqli_fetch_array($resg)) {
    $inc=$inc."<div class=\"galerka\"><h3>".$zaznam["nazev"]."</h3><div class=\"galerie\">";
    $sqlf="SELECT * FROM foto where id_galerie=".$zaznam["id_galerie"];  
    $resf = PrSql($spojeni,$sqlf);
    while ($zaznamf = mysqli_fetch_array($resf)) {
      $inc=$inc."<a data-fancy=\"example_group\" href=\"galerie/".$zaznamf["soubor"]."\">";
      $inc=$inc."<div style=\"border: 1px solid #000; margin: 5px; float: left; width: 75px; height: 60px; background: url('galerie/".$zaznamf["soubormale"]."') no-repeat center;\" ></div></a>";
    }
   $inc=$inc."</div></div>";
  
}


/*$newfile="galerka.php";
$file = fopen ($newfile, "w");
fwrite($file, $hlavni_include);
fclose ($file); 
*/    






?>

