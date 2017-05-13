<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LO07</title>
    	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script>
        /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
            /* test12 */
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("content").style.marginLeft = "250px";
        }

        /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("content").style.marginLeft = "0";
        }
        </script>
    
    </head>
    
    <body>
        <!--menu de navigation-->
        <div id="mySidenav" class="sidenav">
          <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
          <a href="accueil.php">Accueil</a>
          <a href="page/cursus.php">Voir Cursus</a>
          <a href="page/addcursus.php">Ajouter Cursus</a>
          <a href="page/contact.php">Contact</a>
        </div>
        
        <!--barre en haut avec logo et icon menu de nav-->
        <nav id="nav">
            <div class="topbar">
                <!-- Use any element to open the sidenav -->
                <span onclick="openNav()">
                     <div class="container">
                      <div class="baricon"></div>
                      <div class="baricon"></div>
                      <div class="baricon"></div>
                    </div>
                </span>
                Gestion de Cursus
                <img src="image/UTTlogo.png" alt="" title="logo UTT" >
            </div>
        </nav>
        
        <div id="content">
            
        </div>
    </body>
</html>
