function preguntaBorrar(id){
    if(confirm('¿Estás seguro que deseas borrar?' )){
        window.location.href = ('borrar_capitulo_basedatos', id);
        
    }
}