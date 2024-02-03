document.addEventListener('DOMContentLoaded', () =>{
    const cookies = document.cookie.split(';');
    let cookie = null;
    cookies.forEach(item =>{
        if(item.indexOf('items') > -1){
            cookie = item;
        }
    });
    
    if(cookie != null){
        const count = cookie.split('=')[1];
        console.log(count);
        document.querySelector('.btn-carrito').innerHTML = `(${count}) Carrito`;
    }
});

const bCarrito = document.querySelector('.btn-carrito');

bCarrito.addEventListener('click', event =>{
    const carritoContainer = document.querySelector('#carrito-container');
    
    if(carritoContainer.style.display == ''){
        carritoContainer.style.display = 'block';

        actualizarCarritoUI();
    }else{
        carritoContainer.style.display = '';
    }
});

function actualizarCarritoUI(){
    fetch('https://cafeteriamineral.000webhostapp.com/Usuario/api/carrito/api-carrito.php?action=mostrar')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        let tablaCont = document.querySelector('#tabla');
        let precioTotal = '';
        let html = '';
        let enviarPedido = '';
        
        data.items.forEach(element =>{
            html += `
                <div class='fila'>
                    <div class='imagen'></div>
                        <img src='../${element.imagen}' width='100' />
                    </div>
                    <div class='info'>
                        <input type='hidden' value='${element.id}' />
                        <div class='nombre'>${element.nombre}</div>
                        <div>${element.cantidad} items de $${element.precio}</div>
                        <div>Subtotal: $${element.subtotal}</div>
                        <div class='botones'><button class='btn-remove'>Quitar 1 del carrito</button></div>
                    </div>
                </div>
            `;
        });
        // Añade un botón "Realizar pedido" si hay elementos en el carrito
        if (data.info.total > 0) {
            const carritoJSON = JSON.stringify(data.items);
            enviarPedido = `
                <div class='enviarPedido'>
                    <form action='enviarPedido.php' method='POST'>
                        <input type='hidden' name='carrito' value='${carritoJSON}' />
                        <button class='btn-enviar' id='btn-enviar' onclick='eliminarItems()'>Enviar Pedido</button>
                    </form>
                </div>
            `;
        }
                        
        precioTotal = `<p>Total: $${data.info.total}</p>`;
        tablaCont.innerHTML =   precioTotal + html + enviarPedido;
        
        document.cookie = `items=${data.info.count}`;
        bCarrito.innerHTML = `(${data.info.count}) Carrito`;

        
        
        document.querySelectorAll('.btn-remove').forEach(boton =>{
            boton.addEventListener('click', e => {
                const id = boton.parentElement.parentElement.children[0].value;
                removeItemFromCarrito(id);
            });
        });
    });
}


function eliminarItems() {
    fetch('https://cafeteriamineral.000webhostapp.com/Usuario/api/carrito/api-carrito.php?action=removeAll', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        actualizarCarritoUI();
        document.cookie = `items=${data.info.count}`;
        bCarrito.innerHTML = `(${data.info.count}) Carrito`;
    });
}


const botones = document.querySelectorAll('.btn-add');

botones.forEach(boton =>{
    const id = boton.parentElement.parentElement.children[0].value;
    
    boton.addEventListener('click', e =>{
        addItemToCarrito(id);
    });
});

function removeItemFromCarrito(id){
    fetch('https://cafeteriamineral.000webhostapp.com/Usuario/api/carrito/api-carrito.php?action=remove&id=' + id)
    .then(res => res.json())
    .then(data =>{
        console.log(data.status);
        actualizarCarritoUI();
    });
}

function addItemToCarrito(id){
    fetch('https://cafeteriamineral.000webhostapp.com/Usuario/api/carrito/api-carrito.php?action=add&id=' + id)
    .then(res => res.json())
    .then(data =>{
        console.log(data.status);
        actualizarCarritoUI();
    });
}


