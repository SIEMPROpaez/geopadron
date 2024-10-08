<!doctype html>
    <html lang="es" class="h-100" data-bs-theme="auto">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="Normalizador y geolocalizador para PADRON">
            <meta name="author" content="MAPA - UEICEE">
            <meta name="generator" content="Hugo 0.122.0">
            <title>GEO : PADRON</title>
            <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/cover/">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
            <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <meta name="theme-color" content="#712cf9">
            <style>
                @media (min-width: 768px) {
                    .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                    }
                }               
            </style>
            <link href="css/geotyle.css" rel="stylesheet">
        </head>
        <body class="d-flex h-100 text-center text-bg-dark">
            <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
                <header class="mb-auto">
                    <div>
                        <p class="float-md-start mb-0">GEO : PADRON</p>
                        <nav class="nav nav-masthead justify-content-center float-md-end">
                            <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="index.html">Portada</a>
                        </nav>
                     </div>
                </header>
                <main class="px-3">
                    <h1>Geolocalizador</h1>
                    <?php
                        // Tomo el post
                        $buscarCalle = $_POST['calle'];
                        $buscarAltura = $_POST['altura'];
                        // Lo mando a normalizar así https://ws.usig.buenosaires.gob.ar/rest/normalizar_direcciones?calle=julio%20roca&altura=782&desambiguar=1
                        $peticion1 = str_replace(" ","%20",'https://ws.usig.buenosaires.gob.ar/rest/normalizar_direcciones?'
                            . 'calle=' . $buscarCalle
                            . '&altura=' . $buscarAltura
                            . '&desambiguar=1');
                        // Tomo el json
                        $json1 = file_get_contents($peticion1, true);
                        $json1_output = json_decode($json1);
                        // Me fijo si trajo la direccion normalizada
                        if($json1_output->TipoResultado != 'DireccionNormalizada')
                            {
                                // Si no
                                echo "No se ha podido geolocalizar " . $buscarCalle . " " . $buscarAltura;
                            }else{
                                // Si si
                                // Guardo las variables 
                                $calleNormalizada = $json1_output->DireccionesCalleAltura->direcciones[0]->Calle;
                                $alturaNormalizada = $json1_output->DireccionesCalleAltura->direcciones[0]->Altura;
                                $codigoCalle = $json1_output->DireccionesCalleAltura->direcciones[0]->CodigoCalle;
                                // Y pido las calles laterales
                                $peticion3 = str_replace(" ", "%20", "https://ws.usig.buenosaires.gob.ar/rest/obtener_calles_adyacentes?cod_calle=" . $codigoCalle . "&altura=" . $alturaNormalizada);
                                $json3 = file_get_contents($peticion3, true);
                                $json3_output = json_decode($json3);
                                // Controlo si trajo algo
                                // Hago los controles para json vacío y actualizo las variables
                                if(empty($json3_output->calles[0]->Nombre)){$calleIzquierda = 'No se pudo encontrar';}else{$calleIzquierda = $json3_output->calles[0]->Nombre;};
                                if(empty($json3_output->calles[1]->Nombre)){$calleDerecha = 'No se pudo encontrar';}else{$calleDerecha = $json3_output->calles[1]->Nombre;};
                                // Y pido mas info así https://ws.usig.buenosaires.gob.ar/datos_utiles?calle=peru&altura=782
                                $peticion2 = str_replace(" ","%20",'https://ws.usig.buenosaires.gob.ar/datos_utiles?'
                                    . 'calle=' . $calleNormalizada 
                                    . '&altura=' . $alturaNormalizada);
                                $json2 = file_get_contents($peticion2, true);
                                $json2_output = json_decode($json2);
                                // Me fijo si el json vino vacío
                                if(empty($json2_output))
                                    {
                                        // Si si
                                        echo "No se ha podido geolocalizar " . $buscarCalle . " - " . $buscarAltura;
                                    }else{
                                        // Si no
                                        // Muestro los resultados
                                        echo "Para <b>'" . $buscarCalle . " " . $buscarAltura . "'</b> hemos encontrado los siguientes datos: <br><br>";
                                        echo "Calle: " . $calleNormalizada . "<br>";
                                        echo "Altura: " . $alturaNormalizada . "<br>";
                                        echo "Comuna: " . $json2_output->comuna . "<br>";
                                        echo "Barrio: " . $json2_output->barrio . "<br>";
                                        echo "Distrito Escolar: " . $json2_output->distrito_escolar . "<br>";
                                        echo "Calle Lateral Izquierda: " . $calleIzquierda . "<br>";
                                        echo "Código Lateral Derecha: " . $calleDerecha . "<br>";
                                        echo "Código Postal: " . $json2_output->codigo_postal . "<br>";                                        
                                    }
                            }
                    ?>
                </main>
                <footer class="mt-auto text-white-50">
                    <p>Desarrollado por MAPA</p>
                </footer>
            </div>
            <script src="js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </body>
    </html>