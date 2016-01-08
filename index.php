<?
global $glspojeni;

include("include/db.php");
include("include/funkce.php"); 
$glspojeni = MysqlSpojeni();
$GLOBALS["spojeni"]=$glspojeni;
if (!$_SESSION["id"]) InitSession();

?>

<!DOCTYPE html>                    
<html lang="fr">
  <head>    
    <title><?= $_GET["title"]?> constructions en madrier et ossature bois, accessoires en fer forgé </title>          
    <meta charset="UTF-8">
    <meta name="author" content="VV SOFT"/>          
    <meta name="keywords" content="<?= $_GET["title"]?> constructions, en madrier, et ossature, bois, fer forgé, chalet, maison"/>    
    <meta name="description" content="<?= $_GET["title"]?> constructions en madrier et ossature bois, accessoires en fer forgé"/>          
    <meta name="Robots" content="all, follow" />    
    <meta name="Googlebot" content="index,follow,archive" />        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
    <meta name="viewport" content="width=device-width; initial-scale=1.0" />	
    <!-- <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> -->    
    <link rel="stylesheet" href="css/reset.css" media="screen" />    
    <link rel="stylesheet" href="css/style.css" media="screen" />    
    <link rel="stylesheet" href="css/ui.totop.css" />    
    <link rel="stylesheet" href="css/caption.css" /> 
    <link rel="stylesheet" href="css/contactable.css"  />
       
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300italic&amp;subset=latin' rel='stylesheet' type='text/css'>         
    <link rel="stylesheet" type="text/css" href="fancy/fancybox/jquery.fancybox-1.3.4.css" media="screen" />    
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>    
<script type="text/javascript" src="fancy/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>	
<script type="text/javascript" src="fancy/fancybox/jquery.fancybox-1.3.4.js"></script>    
<script type="text/javascript" src="js/jquery.responsivemenu.js"></script>    
<script type="text/javascript" src="js/superfish.js"></script>    
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>      
<script type="text/javascript" src="js/jquery.ui.totop.js"></script>       
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>


     
<script type="text/javascript" src="js/slides.min.jquery.js"></script>     
<script type="text/javascript" src="js/FF-cash.js"></script>       
<script type="text/javascript" src="js/script.js"></script>     
<script type="text/javascript" src="js/script2.js"></script> <!-- menu pro kartu menu  -->
<script type="text/javascript" src="js/script3.js"></script> <!-- menu pro kartu menu  -->



<script type="text/javascript" src="js/jquery.hoverIntent.js"></script> 	
<script type="text/javascript" src="js/jcarousellite_1.0.1.js"></script>     
<script type="text/javascript" src="js/jquery.color.js"></script>     
<script type="text/javascript" src="js/jquery.backgroundPosition.js"></script>     

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
                                                   	
<script type="text/javascript">
		$(document).ready(function() {
			/*
			*   Examples - images
			*/
			$("a#example1").fancybox();

			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				
				
			});

		});
	</script>   
  
  
<script type="text/javascript">
	
	function CaptionTop() {
		if ($('#slides').width() == '940') {TopPos = '105px'}
			else {TopPos = '45px'}
		$(".caption").css({'top':TopPos});
	}
	
	$(function(){
		CaptionTop();
		$(".jCarouselLite").jCarouselLite({
			  btnNext: "#next",
			  btnPrev: "#prev",
			  speed: 300,		  
			  vertical: true,
			  circular: true,
			  visible: 2,
			  start: 0,
			  scroll: 1
		 });

		$('.close-button').click(
				function(){$(this).parents('#slides').find('.caption').css({'display':'none'})}
		);
	
	})
	
	
	$(window).resize(function(){
		CaptionTop();
	});
	
	</script>
         
          
          
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61386028-1', 'auto');
  ga('send', 'pageview');

</script>        
          
    	 	 
  </head>
  <body id="page1">	
  
  
       <!--start contactable -->
<div id="my-contact-div"><!-- contactable html placeholder --></div>

<div id="my-contact-div2"><!-- contactable html placeholder --></div>





<script type="text/javascript" src="css/contactable.js"></script>

<script>
	jQuery(function(){
		jQuery('#my-contact-div').contactable(
        {
            subject: 'feedback URL:'+location.href,
            url: 'mail.php',
            name: 'Nom',
            email: 'Email',   
            /*dropdownTitle: 'Issue',
            dropdownOptions: ['General', 'Website bug', 'Feature request'], */
            message : 'Votre message',
            submit : 'Envoyer',
            recievedMsg : 'Votre message a été envoyé avec succès',
            notRecievedMsg : '',
            disclaimer: '',
            hideOnSubmit: true
        });
        
 
	});
</script>




<!--end contactable -->
  
  
  
<?    

ZobrazHeader($spojeni);      

$cmd=$_GET["cmd"];
//print_r($_GET);

  switch ($cmd)     {
    case "zobrazdum":
       zobrazObsahDomu($spojeni);
    break;
    case "zobrazmenu":
      zobrazObsahDomu($spojeni);
      break;
    case "zobrazmmenu":
    $id=$_GET["idm"];
    $sql="SELECT * FROM hlavni_Menu where id_hlavni_Menu=$id";
    $res = PrSql($spojeni,$sql);
    $zaznam = mysqli_fetch_array($res);
    $typ=$zaznam["typ"];
    switch ($typ) {
      case "T":
       zobrazTextMenu($spojeni);
      break;
      case "K": 
        ZobrazKontakt($spojeni);
      break;
      case "G":
       zobrazContentMenu($spojeni);
      break;
      case "M":
       zobrazContentMenu($spojeni);
      break;
    }
    break;
    default:
      ZobrazUvod($spojeni);
}

zobrazlDolniMenu($spojeni);
ZobrazFooter();

?>          	
      
  
  </body>
</html>