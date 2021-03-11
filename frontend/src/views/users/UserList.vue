<template>
  <list-view
  titulo="Usuários"
  v-bind:items="items"
  v-bind:fields="colunas"
  v-bind:routes="rotas"
  v-bind:deleteCall="deleteUser"
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
          sortDirection: "desc",
          class: "text-center",
        },
        {
          key: "cpf",
          label: "CPF",
          sortable: true,
          sortDirection: "desc",
          class: "text-center",
        },
        {
          key: "email",
          label: "Email",
          sortable: true,
          sortDirection: "desc",
          class: "text-center",
        },
        {
          key: "siape",
          label: "Siape",
          sortable: true,
          sortDirection: "desc",
          class: "text-center",
        },
      ],
      rotas: {
        new: "/admin/users/new",
        details: "/admin/users/detail",
        edit: "/admin/users/edit",
      }
    };
  },
  computed: mapState({
    items: (state) => state.users.users,
    loggedUser: (state) => state.users.loggedUser,
  }),
  async mounted() {
    await this.fetchUsers();
    this.items.forEach(item => {
      item.cpf = item.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    });
  },
  methods: {
    ...mapActions("users", ["fetchUsers", "deleteUser"]),
  },
};
</script>
