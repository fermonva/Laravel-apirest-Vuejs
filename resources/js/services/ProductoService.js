import axios from "axios";

export default class ProductoService {
    getProductos() {
        return axios
            .post("productos/consultarDatos")
            .then(response => response.data.productos);
    }

    editProductos() {
        return axios
            .post("productos/editarProducto")
            .then(response => response.data.productos);
    }
}
