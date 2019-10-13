<?php

include_once APP_PATH . '/Conexion.inc.php';
include_once APP_PATH . '/Repository/RepositorioAlumnos.inc.php';
include_once APP_PATH . '/ControlSesion.inc.php';
include_once APP_PATH . '/config.inc.php';

Conexion :: abrir_conexion();
?>

<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Este botón despliega la barra de navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo SERVIDOR ?>">Gestor de Exámenes</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="#"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Tomar exámen</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Ver turnos</a></li>
            </ul> <!-- lista desordenada -->
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (ControlSesion::sesion_iniciada_alumno()) {?>
                    <li>
                        <a href="#">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <?php echo ' ' . $_SESSION['nombre_alumno'] . ' (Alumno)'; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo RUTA_LOGOUT ?>">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Cerrar sesión
                        </a>
                    </li>

                    <?php
                } else {
                    ?>
                    <li><a href="<?php echo RUTA_LOGIN ?>"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Iniciar sesión</a></li>
                    <?php }
                    ?>
            </ul>
        </div>
    </div>
</nav>
