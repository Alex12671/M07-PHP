function modificarFoto() {

    var parentDiv = document.getElementById('divFoto');
    var checkbox = document.getElementById('Foto');
    if(checkbox.checked) {
        if(document.getElementById('mod_foto') == null) {

            var label = document.createElement('label');
            var input = document.createElement('input');
            label.setAttribute ('for','mod_foto');
            label.setAttribute ('id','mod_foto');
            label.innerHTML = "Nueva foto: "; 
            input.setAttribute('type','file');
            input.id="ModificarFoto";
            input.setAttribute('name', 'Foto'); 
            parentDiv.appendChild(label);
            parentDiv.appendChild(input);

        }

        document.getElementById("mod_foto").style.display = "inline";
        document.getElementById("ModificarFoto").style.display = "inline";

    }
    else {  

        document.getElementById("mod_foto").style.display = "none";
        document.getElementById("ModificarFoto").style.display = "none";

    }

}