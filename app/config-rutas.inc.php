<?php

//rutas de la web
define('RUTA_ABM_ADMINS',"/html/abm-admins.html");
define('RUTA_ABM_CURSOS',"/html/abm-cursos.html");
define('RUTA_ABM_PAISES',"/html/abm-paises.html");
define('RUTA_ABM_SEDES',"/html/abm-sedes.html");
define('RUTA_ABM_OPCIONES',"/html/abm-preguntas.html");


$paneles = array(
    'abm_admins' =>
        array(
            'home' => RUTA_ABM_ADMINS,
            'js'   =>
                array(
                    'jquery.dataTables.min.js',
                    'jquery-form-serializer.js',
                    'abm-admins.js'
                ),
            'css'  =>
                array(
                    'jquery.dataTables.min.css',
                )
        ),
    'abm_cursos' =>
        array(
            'home' => RUTA_ABM_CURSOS,
            'js'   =>
                array(
                    'jquery.dataTables.min.js',
                    'jquery-form-serializer.js',
                    'abm-cursos.js'
                ),
            'css'  =>
                array(
                    'jquery.dataTables.min.css',
                )
        ),
    'abm_paises' =>
        array(
            'home' => RUTA_ABM_PAISES,
            'js'   =>
                array(
                    'jquery.dataTables.min.js',
                    'jquery-form-serializer.js',
                    'abm-paises.js'
                ),
            'css'  =>
                array(
                    'jquery.dataTables.min.css',
                )
        ),
    'abm_preguntas' =>
        array(
            'home' => RUTA_ABM_OPCIONES,
            'js'   =>
                array(
                    'jquery.dataTables.min.js',
                    'jquery-form-serializer.js',
                    'abm-preguntas.js'
                ),
            'css'  =>
                array(
                    'jquery.dataTables.min.css',
                )
        ),
    'abm_sedes' =>
        array(
            'home' => RUTA_ABM_SEDES,
            'js'   =>
                array(
                    'jquery.dataTables.min.js',
                    'jquery-form-serializer.js',
                    'abm-sedes.js'
                ),
            'css'  =>
                array(
                    'jquery.dataTables.min.css',
                )
        ),

);