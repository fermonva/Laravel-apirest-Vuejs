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

    addProducto(data) {
        return axios
            .post("productos/crearProducto", data)
            .then(response => response.data.msg);
    }

    editProducto(data) {
        return axios
            .post("productos/editarProducto", data)
            .then(response => response.data.msg);
    }
}
