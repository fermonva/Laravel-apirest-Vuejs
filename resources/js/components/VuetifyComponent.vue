<template>
  <v-app>
    <v-container grid-list-xs>
      <h1 class="display-3">Vuetify Component</h1>
      <v-card>
        <div>
          <strong>Gestión de Productos</strong>
        </div>
        <br />

        <v-row class="ml-4 mr-4" no-gutters>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Ingrese la busqueda"
            single-line
            hide-details
          ></v-text-field>
          <v-spacer></v-spacer>

          <v-checkbox v-model="filterActivos" label="Activos"></v-checkbox>
          <v-checkbox v-model="filterInactivos" label="Inactivos"></v-checkbox>
          <v-checkbox v-model="filterPendiente" label="Pendiente"></v-checkbox>
        </v-row>

        <v-data-table :headers="headers" :items="filtrosCheck" sort-by="Nombre" :search="search">
          <template v-slot:top>
            <v-toolbar flat color="white">
              <v-spacer></v-spacer>

              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn rounded color="primary" v-bind="attrs" v-on="on">Crear Producto</v-btn>
                </template>

                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model.trim="$v.editedItem.nombre.$model"
                            @v-text-field="$v.editedItem.nombre.$reset()"
                            @blur="$v.editedItem.nombre.$touch()"
                            label="*Nombre"
                          ></v-text-field>
                          <div v-if="$v.editedItem.nombre.$error">
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.nombre.required"
                            >*Nombre es requerido</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.nombre.minLength"
                            >Nombre debe tener {{$v.editedItem.nombre.$params.minLength.min}} caracteres minimo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.nombre.maxLength"
                            >Nombre debe tener {{$v.editedItem.nombre.$params.maxLength.max}} caracteres maximo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.nombre.alpha"
                            >No se aceptan números.</p>
                          </div>
                        </v-col>

                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model.trim="$v.editedItem.codigo.$model"
                            @v-text-field="$v.editedItem.codigo.$reset()"
                            @blur="$v.editedItem.codigo.$touch()"
                            label="*Código"
                          ></v-text-field>
                          <div v-if="$v.editedItem.codigo.$error">
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.codigo.required"
                            >*Código es requerido</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.codigo.minLength"
                            >Código debe tener {{$v.editedItem.codigo.$params.minLength.min}} caracteres minimo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.codigo.maxLength"
                            >Código debe tener {{$v.editedItem.codigo.$params.maxLength.max}} caracteres maximo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.codigo.alphaNum"
                            >Solo valores alfa númericos.</p>
                          </div>
                        </v-col>

                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model.trim="$v.editedItem.existencia.$model"
                            @v-text-field="$v.editedItem.existencia.$reset()"
                            @blur="$v.editedItem.existencia.$touch()"
                            label="*Existencia"
                          ></v-text-field>
                          <div v-if="$v.editedItem.existencia.$error">
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.existencia.required"
                            >*Existencia es requerido</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.existencia.minLength"
                            >Existencia debe tener {{$v.editedItem.existencia.$params.minLength.min}} caracteres minimo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.existencia.maxLength"
                            >Existencia debe tener {{$v.editedItem.existencia.$params.maxLength.max}} caracteres maximo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.existencia.numeric"
                            >Solo se aceptan números.</p>
                          </div>
                        </v-col>

                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model.trim="$v.editedItem.bodega.$model"
                            @v-text-field="$v.editedItem.bodega.$reset()"
                            @blur="$v.editedItem.bodega.$touch()"
                            label="*Bodega"
                          ></v-text-field>
                          <div v-if="$v.editedItem.bodega.$error">
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.bodega.required"
                            >*Bodega es requerido</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.bodega.minLength"
                            >Bodega debe tener {{$v.editedItem.bodega.$params.minLength.min}} caracteres minimo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.bodega.maxLength"
                            >Bodega debe tener {{$v.editedItem.bodega.$params.maxLength.max}} caracteres maximo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.bodega.alpha"
                            >No se aceptan números.</p>
                          </div>
                        </v-col>

                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model.trim="$v.editedItem.descripcion.$model"
                            @v-text-field="$v.editedItem.descripcion.$reset()"
                            @blur="$v.editedItem.descripcion.$touch()"
                            label="*Descripción"
                          ></v-text-field>
                          <div v-if="$v.editedItem.descripcion.$error">
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.descripcion.minLength"
                            >Descripción debe tener {{$v.editedItem.descripcion.$params.minLength.min}} caracteres minimo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.descripcion.maxLength"
                            >Descripción debe tener {{$v.editedItem.descripcion.$params.maxLength.max}} caracteres maximo.</p>
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.descripcion.alpha"
                            >No se aceptan números.</p>
                          </div>
                        </v-col>

                        <v-col cols="12" sm="6" md="4">
                          <v-select
                            v-model.trim="$v.editedItem.id_estado.$model"
                            @v-text-field="$v.editedItem.id_estado.$reset()"
                            @blur="$v.editedItem.id_estado.$touch()"
                            :items="estados"
                            item-text="nombre"
                            item-value="id_estado"
                            label="*Estado"
                          ></v-select>
                          <div v-if="$v.editedItem.id_estado.$error">
                            <p
                              class="red--text text--lighten-1"
                              v-if="!$v.editedItem.id_estado.required"
                            >*Estado es requerido</p>
                          </div>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
                    <v-btn color="blue darken-1" text @click="save" :disabled="$v.$invalid">Guardar</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
          </template>

          <template v-slot:no-data>
            <v-btn color="primary" @click="consultarProductos">Recargar</v-btn>
          </template>
        </v-data-table>
        <p>Un producto registrado.[productos activos: {{contarActivos}}] - [Productos pendientes por activar: {{contarPendientes}}] - [productos inactivos: {{contarInactivos}}]</p>
      </v-card>
      <v-snackbar v-model="snackbar.show" :timeout="5000" top :color="snackbar.color">
        <span>{{snackbar.message}}. {{snackbar.errors}}</span>
        <v-btn dark text @click="snackbar = false">Close</v-btn>
      </v-snackbar>
    </v-container>
  </v-app>
</template>
<script>
import ProductoService from "../services/ProductoService";
import {
  required,
  minLength,
  maxLength,
  alpha,
  alphaNum,
  numeric,
} from "vuelidate/lib/validators";
export default {
  data: () => ({
    dialog: false,
    headers: [
      {
        text: "Nombre del producto",
        value: "nombre",
      },
      { text: "Código", value: "codigo" },
      { text: "Existencia", value: "existencia" },
      { text: "Bodega", value: "bodega" },
      { text: "Descripción", value: "descripcion" },
      { text: "Acciones", value: "actions", sortable: false, align: "center" },
      { text: "Estado", value: "estado" },
    ],
    search: "",
    productos: [],
    estados: [],
    editedIndex: -1,
    editedItem: {
      nombre: "",
      codigo: "",
      existencia: "",
      bodega: "",
      descripcion: "",
      id_estado: "",
      estado: "",
    },
    defaultItem: {
      nombre: "",
      codigo: "",
      existencia: "",
      bodega: "",
      descripcion: "",
      id_estado: "",
      estado: "",
    },
    filterActivos: false,
    filterInactivos: false,
    filterPendiente: false,
    snackbar: {
      show: false,
      message: null,
      errors: null,
      color: null,
    },
  }),
  validations: {
    editedItem: {
      nombre: {
        required,
        alpha,
        minLength: minLength(3),
        maxLength: maxLength(15),
      },
      codigo: {
        required,
        alphaNum,
        minLength: minLength(3),
        maxLength: maxLength(15),
      },
      existencia: {
        required,
        numeric,
        minLength: minLength(1),
        maxLength: maxLength(15),
      },
      bodega: {
        required,
        alpha,
        minLength: minLength(3),
        maxLength: maxLength(15),
      },
      descripcion: {
        alpha,
        minLength: minLength(3),
        maxLength: maxLength(15),
      },
      id_estado: {
        required,
      },
    },
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo producto" : "Editar producto";
    },
    filtrosCheck() {
      if (this.filterActivos === true) {
        return this.productos.filter((producto) => producto.id_estado == 1);
      }
      if (this.filterInactivos == true) {
        return this.productos.filter((producto) => producto.id_estado == 2);
      }
      if (this.filterPendiente == true) {
        return this.productos.filter((producto) => producto.id_estado == 3);
      } else {
        return this.productos;
      }
    },
    contarActivos() {
      const activos = this.productos.filter(
        (producto) => producto.id_estado == 1
      );
      return activos.length;
    },
    contarInactivos() {
      const inactivos = this.productos.filter(
        (producto) => producto.id_estado == 2
      );
      return inactivos.length;
    },
    contarPendientes() {
      const pendientes = this.productos.filter(
        (producto) => producto.id_estado == 3
      );
      return pendientes.length;
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.ProductoService = new ProductoService();
  },
  mounted() {
    this.loading = true;
    this.consultarProductos();
    this.consultarEstados();
  },

  methods: {
    consultarProductos() {
      this.loading = true;
      this.ProductoService.getProductos().then(
        (productos) => (
          (this.productos = productos), (this.productosbuscar = this.productos)
        )
      );
      this.loading = false;
    },
    consultarEstados() {
      this.ProductoService.getEstados().then(
        (estados) => (this.estados = estados)
      );
    },
    editItem(item) {
      this.editedIndex = this.productos.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.productos[this.editedIndex], this.editedItem);
        this.ProductoService.editProducto({
          id_producto: this.editedItem.id_producto,
          nombre: this.editedItem.nombre,
          codigo: this.editedItem.codigo,
          existencia: this.editedItem.existencia,
          bodega: this.editedItem.bodega,
          descripcion: this.editedItem.descripcion,
          id_estado: this.editedItem.id_estado,
        }).then(
          (data) =>
            (this.snackbar = {
              message: data.message,
              errors: data.errors ? data.errors.descripcion : "",
              color: data.status,
              show: true,
            })
        );
      } else {
        this.productos.push(this.editedItem);
        this.ProductoService.addProducto({
          nombre: this.editedItem.nombre,
          codigo: this.editedItem.codigo,
          existencia: this.editedItem.existencia,
          bodega: this.editedItem.bodega,
          descripcion: this.editedItem.descripcion,
          id_estado: this.editedItem.id_estado,
        }).then(
          (data) =>
            (this.snackbar = {
              message: data.message,
              errors: data.errors ? data.errors.descripcion : "",
              color: data.status,
              show: true,
            })
        );
      }
      this.consultarProductos();
      this.close();
    },
  },
};
</script>
