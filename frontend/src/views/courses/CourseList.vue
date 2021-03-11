<template>
  <list-view
  titulo="Curso"
  v-bind:items="items"
  v-bind:fields="colunas"
  v-bind:routes="rotas"
  v-bind:deleteCall="deleteCourse"
  />
</template>

<script>
import List from "../_parent/List.vue";

import { mapActions, mapState } from "vuex";

export default {
  components: {
    'list-view': List
  },
  data() {
    return {
      colunas: [
        {
          key: "nome",
          label: "Nome",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "descricao",
          label: "Descrição",
          sortable: true,
          sortDirection: "desc"
        }
      ],
      rotas: {
        new: "/admin/courses/new",
        details: "/admin/courses/detail",
        edit: "/admin/courses/edit",
      }
    };
  },
  computed: mapState({
    items: (state) => state.courses.courses,
    loggedUser: (state) => state.users.loggedUser,
  }),
  async mounted() {
    await this.fetchCourses();
  },
  methods: {
    ...mapActions("courses", ["fetchCourses", "deleteCourse"]),
  },
};
</script>
