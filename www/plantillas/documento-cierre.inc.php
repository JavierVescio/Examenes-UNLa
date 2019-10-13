
<nav class="navbar-default navbar-fixed-bottom">
    <div class="container-fluid">
        <p class="navbar-text pull-left">&copy; 2019 Proyecto de Software</p>
        <?php 
        if (!ControlSesion::sesion_iniciada_alumno()){
        ?>
        <a href="#" class="btn navbar-btn btn-default pull-right">Área de administradores</a> 
        <?php }
        ?>
        
    </div>
</nav>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>