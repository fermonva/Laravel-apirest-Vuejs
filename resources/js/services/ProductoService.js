import axios from "axios";

export default class ProductoService {
    getProductos() {
        return axios
            .post("productos/consultarProductos")
            .then(response => response.data.productos);
    }

    getEstados() {
        return axios
            .post("productos/consultarEstados")
            .then(response => response.data.estados);
    }

    editProductos() {
        return axios
            .post("productos/editarProducto")
            .then(response => response.data.productos);
    }
}
