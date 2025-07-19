const calendario = document.getElementById("calendario");
const selectorMes = document.getElementById("mes");
let diasEnElMes = 0;

selectorMes.addEventListener("change", () =>{

  const mes = parseInt(selectorMes.value);
  const añoActual = new Date().getFullYear;
  switch(mes){
    case 1: case 3: case 5:  case 7: case 8: case 10: case 12: 
      diasEnElMes = 31;
    break;
    case 4: case 6: case 9: case 11: 
      diasEnElMes = 30;
    break;
    case 2:
      diasEnElMes = (añoActual % 4 === 0 && (añoActual % 100 !== 0 || añoActual % 400 === 0)) ? 29 : 28;
    break;
  }

  calendario.innerHTML= "";

  for (let i = 1; i <= diasEnElMes; i++) {
    const dia = document.createElement("div");
    dia.className = "dia disponible";
    dia.textContent = i;

    dia.addEventListener("click", () => {
      dia.classList.toggle("disponible");
      dia.classList.toggle("reservado");
    });

    calendario.appendChild(dia);
  }

})

selectorMes.value = "1";
selectorMes.dispatchEvent(new Event("change"));









