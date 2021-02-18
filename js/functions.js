


$(function() {  //Con esta línea espera el archivo JS a que se cargue toda la página(HTML5 y CSS3) para ser ejecutado.

    //Botón ocultar/mostrar menú lateral
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });

    
    //funcion para mostrar todos los Anuncios y sus datos en una tabla en la página "Escaparate"
    function mostrarAnuncios(){
      let anuncios = "";

      //Petición ajax
      $.ajax({
          url:'include/funciones.php',
          type: 'POST',
          data: { anuncios },
          success: function(respuesta){
              let info = JSON.parse(respuesta);
              let resultado = '';
              let id = "";
              info.forEach(buscado => {
                  id = buscado.id_anuncio;
                  resultado +=`<tr id="${id}">
                                  <td>${buscado.autor}</td>
                                  <td>${buscado.fecha}</td>
                                  <td>${buscado.moroso}</td>
                                  <td>${buscado.localidad}</td>
                                  <td>${buscado.descripcion}</td>`;

                          if($('#datConLog').text()!="Invitado" && $('#datConLog').text()==buscado.autor){
                              resultado +=`<td><ion-icon name="reload-outline" class="actualizar text-info"></ion-icon></td>
                                  <td><ion-icon name="trash-outline" class="borrar text-danger"></ion-icon></td>`;
                          }
                          resultado += `<td><ion-icon name="map-outline" class="mapa text-success" data-target="#modal3"></ion-icon></td>
                              </tr>`;  
              });

              $("#cuerpoTablaAnuncios").html(resultado);
              

          },
          // Si la petición falla, devuelve en consola el error producido y el estado
          error: function(estado, error) {
              console.log("-Error producido: " + error + ". -Estado: " + estado)

          }
      });
  }





});