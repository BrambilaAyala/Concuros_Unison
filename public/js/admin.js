function buscadorPorNombre() {

    let input, filter, tr, td, a, i, valorTxt;
    input = document.getElementById("inputBuscadorNombre");
    filter = input.value.toUpperCase();
    tr = document.querySelectorAll("#tablaTR");
    for (let i = 0; i < tr.length; i++) {
      td = tr[i].firstElementChild;
      p = td.getElementsByTagName("p")[0]
      valorTxt = p.textContent || p.innerText;
      if (valorTxt.toUpperCase().indexOf(filter) > -1) {
          
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
    
  }