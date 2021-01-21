<?php 
    /* Index o página de inicio, formulario de autentificación para acceder a la App Web
    *
    * @author Francisco José López Zafra
    */

    //Incluyo cabecera y db
    include("head.php");
?>    

    <!-- Menú -->
    <header>
        <nav class="navbar navbar-dark bg-info navbar-expand-sm">
            
            <a class="navbar-brand" href="../index.php"><img src="../images/logo_horizontal.png" class="img-responsive"  alt="Logotipo On Repair" width="25%" height="10%"></a>

            <div class="collapse navbar-collapse">
                <div class="navbar-nav mr-auto mt-lg-0">      
                </div>

                <div class="mt-md-2">
                    <div class="navbar-nav">
                    <a class="nav-item nav-link" href="../index.php">Inicio</a>
                    </div> 
                </div>
            </div>
        </nav>
    </header>


    <main role="main" class="container">
        <h2 class="mt-3">POLÍTICA DE COOKIES</h2>

        <h3 class="mt-4">¿Qué son las cookies?</h3>
        <p class="lead">Las cookies son pequeños archivos de texto que se descargan en tu navegador al acceder a una página web. Estos archivos recogen información con distintos fines, por ejemplo, 
            permitirte una navegación personalizada, desarrollar ciertas funcionalidades o recordar tus datos de usuario, entre otros.</p>
        <p class="lead">El Reglamento General de Protección de Datos (RGPD) describe las cookies como un tipo de “identificador en línea” por lo que, en ciertas ocasiones, éstas recogerán y 
            tratarán datos personales como, por ejemplo, las cookies de autenticación de usuario, que te permiten iniciar sesión en una página web.</p>
        <p class="lead">Las cookies se clasifican teniendo en cuenta varios factores, principalmente:
            <ul class="lead">
                <li>Por su <b>finalidad</b> y el tipo de información que recogen;</li>
                <li>Por su <b>persistencia</b> -esto es, el tiempo que permanecen instaladas en tu navegador-. Las cookies podrán instalarse únicamente durante el tiempo que dure la sesión, 
                o bien durante un periodo de tiempo más prolongado y preestablecido;</li>
                <li>Por su <b>origen</b>, puesto que las cookies pueden pertenecer a la página web, o bien a terceros que desarrollen anuncios u otros elementos o complementos en la misma. </li>
            </ul></p>
        <p class="lead">Además de las cookies, existen otras tecnologías similares de almacenamiento de información del usuario, por ejemplo, scripts, pixeles de seguimiento u otros complementos, 
            que cumplen la misma finalidad que las cookies.</p>
        <p class="lead">Por tanto, con el término “cookies” nos referiremos tanto a estas tecnologías similares, como a las cookies en sentido estricto.</p>

        <h3 class="mt-4">¿Durante cuánto tiempo permanecen instaladas las cookies?</h3>
        <p class="lead">Como regla general, la duración de las cookies depende de su propósito, pero en todo caso, éstas se conservarán durante un plazo determinado, proporcionado y limitado en relación a su finalidad.</p>
        <p class="lead">Dependiendo del tiempo que las cookies permanezcan instaladas en tu navegador, éstas se clasifican en cookies persistentes o cookies de sesión.
            <ul class="lead">
                <li><b>Cookies de sesión:</b> Son las cookies que caducan cuando abandonas la página web, momento en que las cookies se eliminan de tu navegador. 
                  Estas cookies se utilizan para vincular tus acciones en la página web durante la navegación.</li>
                <li><b>Cookies persistentes:</b> Estas cookies permanecen almacenadas una vez abandonas la página web, durante un periodo de tiempo más o menos prolongado,
                  y según el propósito de cada cookie. Por ejemplo, las cookies persistentes permiten al usuario recordar sus preferencias para mantenerlas la próxima vez que acceda a la página web.</li>
            </ul></p>

        <h3 class="mt-4">¿Qué tipos de Cookies utiliza On Repair?</h3>
        <p class="lead">Utilizamos cookies para mejorar tu experiencia de navegación, para ofrecerte una configuración personalizada de la página web y para desarrollar determinadas funcionalidades
          de la misma, en concreto, a través de las siguientes cookies:
            <ul class="lead">
                <li><b>Cookies técnicas o necesarias.</b> Las cookies técnicas o necesarias son esenciales para permitirte navegar a través de nuestra página web y utilizar las diferentes opciones 
                  o servicios ofrecidos correctamente. Además, pueden ofrecer funciones concretas, como la autenticación del usuario o garantizar la seguridad de la página web.
                  Puesto que estas cookies son necesarias para el propio funcionamiento de la página web, desactivarlas podría provocar que alguno de los servicios dejara de funcionar. 
                  Aun así, puedes bloquearlas o eliminarlas a través de la configuración de tu navegador en cualquier momento.</li>
            </ul></p>

    </main>


<?php
    //Incluyo pie
    include("footer.php");
?>