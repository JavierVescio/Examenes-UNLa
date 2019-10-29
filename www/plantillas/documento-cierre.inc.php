
<nav class="navbar-default navbar-fixed-bottom">
    <div class="container-fluid">
        <p class="navbar-text pull-left">&copy; 2019 Proyecto de Software</p>       
    </div>
</nav>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
$panel = $_GET['panel'];
foreach ($paneles[$panel]['js'] as $js_doc)
    echo "<script src='/js/" . $js_doc . "' ></script>";
?>

</body>
</html>