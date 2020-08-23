<template>
  <div class="container">
    <h1 class="display-3">ViewUI Component</h1>
    <div class="row justify-content-center">
      <div>
        <div class="card">
          <div class="card-body" style="width: 1080px;background-color: #F6F6F6;">
            <div>
              <div>
                <strong>Gestión de Productos</strong>
                <Button
                  color="#638695"
                  style="float: right;background-color: #06C4BD;color: white;"
                  shape="circle"
                  @click="modalCrearProducto=true"
                >Crear producto</Button>
              </div>
              <br />

              <div>
                <label>Nombre del producto</label>
                <Input
                  type="text"
                  @on-enter="filtro"
                  v-model="filtro_nombre"
                  placeholder="Ingrese su busqueda..."
                  style="width: 200px"
                />
                <Button
                  v-on:click="filtro"
                  color="#638695"
                  style="background-color: #6DAEC7;color: white;"
                >Buscar</Button>
                <CheckboxGroup style="float: right;">
                  <Checkbox label="Mostrar todos">Mostrar todos</Checkbox>
                  <Checkbox label="Activos" v-model="filterActivos" v-bind="productos">
                    <span>Activos</span>
                  </Checkbox>
                  <Checkbox label="Inactivos" v-model="filterInactivos">
                    <span>Inactivos</span>
                  </Checkbox>
                  <Checkbox label="Pendiente" v-model="filterPendiente">
                    <span>Pendiente</span>
                  </Checkbox>
                </CheckboxGroup>
              </div>

              <!-- INICIO TABLA DATA -->
              <Table stripe :loading="loading" :columns="column" :data="mostrarActivos">
                <template slot-scope="{ row }" slot="nombre">
                  <Icon type="md-checkmark-circle" style="width: 30px;" size="24" color="#06C4BD" />
                  {{ row.nombre }}
                </template>
                <template slot-scope="{ index }" slot="action">
                  <Icon type="md-create" color="#638695" size="24" @click="asignarProducto(index)" />
                  <!-- <Button type="error" size="small" @click="remove(index)">Delete</Button> -->
                </template>

                <template slot-scope="{ row }" slot="estado" style="width: 30px;">
                  <p style="background-color:#00CF00;">{{row.estado}}</p>
                </template>
              </Table>
              <p
                style="background-color: #017AAF;color: white;"
              >Un producto registrado.[productos activos:] - [Productos pendientes por activar:0] - [productos inactivos:0]</p>
            </div>

            <!-- MODAL CREAR PRODUCTO -->
            <Modal v-model="modalCrearProducto" title="Agregar Producto">
              <Form ref="formValidate" :model="objetoProducto" :label-width="80">
                <FormItem label="Nombre" prop="name">
                  <Input v-model="objetoProducto.nombre" placeholder="Ingrese el nombre" />
                </FormItem>
                <FormItem label="Código" prop="name">
                  <Input v-model="objetoProducto.codigo" placeholder="Ingrese el código" />
                </FormItem>
                <FormItem label="Existencia" prop="name">
                  <Input v-model="objetoProducto.existencia" placeholder="Ingrese la existencia" />
                </FormItem>
                <FormItem label="Bodega" prop="name">
                  <Input v-model="objetoProducto.bodega" placeholder="Ingrese la bodega" />
                </FormItem>
                <FormItem label="Descripción" prop="name">
                  <Input v-model="objetoProducto.descripcion" placeholder="Ingrese la descripción" />
                </FormItem>

                <FormItem label="Estado">
                  <Select v-model="objetoProducto.id_estado">
                    <Option
                      v-for="option in estados"
                      :value="option.id_estado"
                      :key="option.id_estado"
                    >{{ option.nombre }}</Option>
                  </Select>
                </FormItem>
              </Form>

              <div slot="footer">
                <Button type="error" @click="modalCrearProducto=false">Cancelar</Button>
                <Button type="primary" @click="crearProducto(), modalCrearProducto=false;">Guardar</Button>
              </div>
            </Modal>

            <!-- MODAL EDITAR PRODUCTO -->
            <Modal v-model="modalEditarProducto" title="Editar Producto">
              <Form ref="formValidate" :model="objetoProducto" :label-width="80">
                <FormItem label="Nombre" prop="name">
                  <Input v-model="objetoProducto.nombre" placeholder="Ingrese el nombre" />
                </FormItem>
                <FormItem label="Código" prop="name">
                  <Input v-model="objetoProducto.codigo" placeholder="Ingrese el código" />
                </FormItem>
                <FormItem label="Existencia" prop="name">
                  <Input v-model="objetoProducto.existencia" placeholder="Ingrese la existencia" />
                </FormItem>
                <FormItem label="Bodega" prop="name">
                  <Input v-model="objetoProducto.bodega" placeholder="Ingrese la bodega" />
                </FormItem>
                <FormItem label="Descripción" prop="name">
                  <Input v-model="objetoProducto.descripcion" placeholder="Ingrese la descripción" />
                </FormItem>

                <FormItem label="Estado">
                  <Select v-model="objetoProducto.id_estado">
                    <Option
                      v-for="option in estados"
                      :value="option.id_estado"
                      :key="option.id_estado"
                    >{{ option.nombre }}</Option>
                  </Select>
                </FormItem>
              </Form>

              <div slot="footer">
                <Button type="error" @click="modalEditarProducto=false">Cancelar</Button>
                <Button type="primary" @click="editarProducto(), modalEditarProducto=false;">Guardar</Button>
              </div>
            </Modal>
            <br />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- </div> -->
</template>

<script>
import ProductoService from "../services/ProductoService";

export default {
  created() {
    this.ProductoService = new ProductoService();
  },
  mounted() {
    this.consultarProductos();
    this.consultarEstados();
  },
  data() {
    return {
      loading: false,
      column: [
        {
          title: "Nombre del producto",
          key  : "nombre",
          slot : "nombre",
          width: 200,
        },
        {
          title: "Código",
          key  : "codigo",
        },
        {
          title: "Existencia",
          key  : "existencia",
          align: "center",
          width: 150,
        },
        {
          title: "Bodega",
          key  : "bodega",
        },
        {
          title: "Descripción",
          key  : "descripcion",
          width: 150,
        },
        {
          title: "Editar",
          slot : "action",
          align: "center",
        },
        {
          title: "Estado",
          key  : "estado",
          align: "center",
          slot : "estado",
        },
      ],
      productosbuscar: [],
      productos      : [],
      filterActivos  : false,
      filterInactivos: false,
      filterPendiente: false,
      filtro_nombre  : "",
      objetoProducto : {
        id_producto: null,
        nombre     : null,
        codigo     : null,
        existencia : null,
        bodega     : null,
        descripcion: null,
        id_estado  : null,
        estado     : null,
      },
      estados            : [],
      modalCrearProducto : false,
      modalEditarProducto: false,
    };
  },
  computed: {
    mostrarActivos() {
      if (this.filterActivos == true) {
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
    // filtroBuscar() {
    //   return this.productos.filter(
    //     (producto) =>
    //       producto.nombre.toLowerCase() === this.filtro_nombre.toLowerCase()
    //   );
    // },
  },
  methods: {
    filtro() {
      if (this.filtro_nombre === "") {
        this.productos = this.productosbuscar;
      } else {
        this.productos = this.productosbuscar;
        this.productos = this.productos.filter((producto) => {
          return (
            producto.nombre.toLowerCase() === this.filtro_nombre.toLowerCase()
          );
        });
      }
    },
    consultarProductos() {
      this.loading = true;
      this.ProductoService.getProductos().then(
        (productos) => (
          (this.productos = productos), (this.productosbuscar = this.productos)
        )
      );
      this.loading = false;
    },
    consultarEstados(param) {
      this.ProductoService.getEstados().then(
        (estados) => (this.estados = estados)
      );
    },
    crearProducto() {
      this.ProductoService.addProducto({
        nombre     : this.objetoProducto.nombre,
        codigo     : this.objetoProducto.codigo,
        existencia : this.objetoProducto.existencia,
        bodega     : this.objetoProducto.bodega,
        descripcion: this.objetoProducto.descripcion,
        id_estado  : this.objetoProducto.id_estado,
      });
      this.consultarProductos();
      this.limpiarCampos();
    },
    asignarProducto(index) {
      this.objetoProducto.id_producto = this.productos[index].id_producto;
      this.objetoProducto.nombre      = this.productos[index].nombre;
      this.objetoProducto.codigo      = this.productos[index].codigo;
      this.objetoProducto.existencia  = this.productos[index].existencia;
      this.objetoProducto.bodega      = this.productos[index].bodega;
      this.objetoProducto.descripcion = this.productos[index].descripcion;
      this.objetoProducto.id_estado   = this.productos[index].id_estado;
      this.modalEditarProducto        = true;
    },
    editarProducto() {
        this.ProductoService.editProducto({
          id_producto: this.objetoProducto.id_producto,
          nombre     : this.objetoProducto.nombre,
          codigo     : this.objetoProducto.codigo,
          existencia : this.objetoProducto.existencia,
          bodega     : this.objetoProducto.bodega,
          descripcion: this.objetoProducto.descripcion,
          id_estado  : this.objetoProducto.id_estado,
        })
        .then((response) => {
          this.consultarProductos();
          this.limpiarCampos();
          return response;
        })

        .catch((error) => {});
    },
    // remove(index) {
    //   this.productos.splice(index, 1);
    // },

    limpiarCampos() {
      this.objetoProducto.id_producto = null;
      this.objetoProducto.nombre = null;
      this.objetoProducto.codigo = null;
      this.objetoProducto.existencia = null;
      this.objetoProducto.bodega = null;
      this.objetoProducto.descripcion = null;
      this.objetoProducto.id_estado = null;
    },
  },
};
</script>

<style>
.ivu-table th {
  background-color: #017aaf;
  color: white;
}
.ivu-table-wrapper {
  margin-top: 10px;
}
</style>


