function mostrarCanasta() {
	if(document.oferta.botonDeCanasta.checked) {
		document.getElementById("canasta").style.visibility="visible";
		document.getElementById("renglones").style.visibility="visible";
	}else{
		document.getElementById("canasta").style.visibility="hidden";
		document.getElementById("renglones").style.visibility="hidden";
	}
	 renglones="<table><th width='120'>Título</th>" +
				"<th>Artista</th><th>Género</th><th>Precio</th>" +
				"<th>Cantidad</th><th>Eliminar</th>";
	renglon = "";
	iteracion = document.getElementById("iteracion").value;
	for(x=0; x<iteracion;x++){
		if(document.getElementById("cantidad["+ x +"]").value==0)
		continue;
    renglon="<tr>";
    titulo = document.getElementById("titulo["+ x + "]").value;
    artista = document.getElementById("artista["+ x + "]").value;
	genero = document.getElementById("genero["+ x + "]").value;
	precio = document.getElementById("precio["+ x + "]").value;
	cantidad = document.getElementById("cantidad["+ x + "]").value;
	renglon += "<td width='120'>" + titulo+"</td>" +
				"<td>" + artista + "</td>" +"<td>" + genero + "</td>" +
				"<td>" + precio + "</td>" + "<td>" + cantidad + "</td>" +
				"<td onclick='eliminarRenglon(" + x + ");'>&#10008;</td></tr>";
				renglones += renglon; 
	}  
	 renglones += "</table>";
	document.getElementById("renglones").innerHTML = renglones;
}
function eliminarRenglon(id){
	eliminar = confirm("Deseas eliminar " + titulo + "?");
	if(eliminar){
		document.getElementById("cantidad["+ id + "]").value = 0;
		mostrarCanasta();
	}
}