document.addEventListener('DOMContentLoaded', () =>{

});

const bCarrito = document.querySelector('.btn-carrito');

bCarrito.addEventListener('click', event =>{
    const carritoContainer = document.querySelector('#carrito-container');
    
    if(carritoContainer.style.display == ''){
        carritoContainer.style.display = 'block';
        actualizarNotificacionUI();
    }else{
        carritoContainer.style.display = '';
    }
});


function actualizarNotificacionUI(){
    fetch('https://cafeteriamineral.000webhostapp.com/Usuario/notificacion.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        let tablaCont = document.querySelector('#tabla');
        let html = '';
        let estado;
        data.forEach(item => {
            //Aquí puedes acceder a las propiedades de cada objeto
            if(item.estado == 0)
                estado = 'En Espera';
            else
                estado = 'Se esta realizando el pedido';
            html += `
                <div class='fila1'>
                    <div style="width: 100%; overflow-x: scroll;">
                        <table>
                            <tr><th>Numero de pedido</th><th>fecha de Pedido</th><th>Nombre</th><th>Estado del Pedido</th><th>Ver Pedidos</th></tr>
                                <tr>
                                <td>${item.id}</td>
                                <td>${item.fechaPublicacion}</td>
                                <td>${item.nombre}</td>
                                <td>${estado}</td>
                                <td><a href="abrirPedido.php?id=${item.id}">Abrir Pedido</a></td>
                                </tr>
                        </table>
                    </div>
                </div>
            `;
        });
    
    tablaCont.innerHTML =   html;
    //bCarrito.innerHTML = `(${data.info.count}) Carrito`;
    
    });

}