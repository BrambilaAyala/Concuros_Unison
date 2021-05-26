function buscadorPorNombre() {

    let input, filter, tr, td;
    input = document.getElementById("inputBuscadorNombre");
    filter = input.value.toUpperCase();
    tr = document.querySelectorAll("#tablaTR");
    for (let i = 0; i < tr.length; i++) {
      td = tr[i];
      /**
       * valores de la que tiene cada celda de la tabla
       */
      nombre = td.getElementsByTagName("p")[0];
      folio = td.getElementsByTagName("p")[1];
      concursos = td.getElementsByTagName('p')[2];
      estado = td.getElementsByTagName('p')[3];

      valorNombre = nombre.textContent || nombre.innerText;
      valorFolio = folio.textContent || folio.innerText;
      valorConcursos = concursos.textContent || concursos.innerText;
      valorEstado = estado.textContent || estado.innerText;
      /**FIN  */

      /**
       * condicional para filtrar los valores que se escriban en el input "filter"
       * si se sale del indice regresa -1, por lo tanto si el valor da igual a -1 se esconde el TR de la tabla
       * si es mayor a -1 se sigue mostrando 
       */
      if (valorNombre.toUpperCase().indexOf(filter) > -1 || valorFolio.toUpperCase().indexOf(filter) > -1 
          || valorConcursos.toUpperCase().indexOf(filter) > -1 || valorEstado.toUpperCase().indexOf(filter) > -1) {
          
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
    
  }