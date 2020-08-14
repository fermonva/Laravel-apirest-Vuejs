<template>
  <div class="container">
    <h1 class="display-3">TareasComponent</h1>
    <ul>
      <li v-for="tarea in tareasData" :key="tarea.id">{{tarea.title}}</li>
    </ul>
    <br />
    <pre>{{$data}}</pre>
  </div>
</template>

<script>
export default {
  props: ["tareas"],
  mounted() {
    return axios
      .get("https://jsonplaceholder.typicode.com/todos")
      .then((response) => {
        this.tareasData = response.data;
      });
  },
data() {
    return {
        tareasData: [],
    }
},
  methods: {},
};
</script>

<style>
</style>

