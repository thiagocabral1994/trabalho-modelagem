<template>
  <list-view
  titulo="Turmas"
  v-bind:items="items"
  v-bind:fields="colunas"
  v-bind:routes="rotas"
  v-bind:deleteCall="deleteClass"
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
          key: "id",
          label: "ID Turma",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "usuario.nome",
          label: "Responsável",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "curso.nome",
          label: "Curso",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "status.nome",
          label: "Status",
          sortable: true,
          sortDirection: "desc"
        }
      ],
      rotas: {
        new: "/classes/new",
        details: "/classes/detail",
        edit: "/classes/edit",
      }
    };
  },
  computed: mapState({
    items: (state) => state.classes.classes,
    loggedUser: (state) => state.users.loggedUser,
  }),
  async mounted() {
    await this.fetchClasses();
  },
  methods: {
    ...mapActions("classes", ["fetchClasses", "deleteClass"]),
  },
};
</script>
