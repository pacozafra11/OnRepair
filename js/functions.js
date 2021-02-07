


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Ocultar y mostrar menú
    $('#menu').css("width","250px");

    $(document).on("click", "#abrir_menu", function(){ 
        $('#menu').css("width","250px");
    });
      
    $(document).on("click", "#cerrar_menu", function(){ 
        $('#menu').css("width","0px");
    });










});