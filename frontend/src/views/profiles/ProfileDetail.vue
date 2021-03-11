<template>
  <CRow>
    <CCol sm="12" md="6">
      <detail-view 
      v-bind:id_item="id"
      titulo="Perfil" 
      v-bind:items="configForm"
      />
    </CCol>
    <CCol sm="12" md="6">
      <subscribe
        titulo="Permissões"
        v-bind:items_input="permissoesPerfil"
        v-bind:lista="permissoesLista"
        label="nome"
        v-bind:fields="[]"
        v-bind:view_only="true"

        @update-items="updatePermissoes"
      />
    </CCol>
    <CCol sm="12" md="6">
      <subscribe
        titulo="Usuários"
        v-bind:items_input="usuariosPerfil"
        v-bind:lista="usuariosLista"
        label="nome"
        v-bind:fields="[]"
        v-bind:view_only="true"

        @update-items="updateUsuarios"
      />
    </CCol>
  </CRow>
</template>

<script>
import Detail from "../_parent/Details.vue";
import Subscribe from "../_parent/Subscribe.vue";

import {
  required,
  minLength,
  maxLength,
  email,
  numeric,
  sameAs,
  alphaNum,
  maxValue,
} from "vuelidate/lib/validators";
import { mapActions, mapState } from "vuex";
import validaCPF from "../../js/cpf.check";

export default {
  components: {
    'detail-view': Detail,
    'subscribe': Subscribe
  },
  data() {
    return {
      id: null,
      nome: null,
      descricao: null,
      usuariosPerfil: [],
      permissoesPerfil: [],

      configForm: [
        [
          {
            model: "nome",
            type: "text",
            placeholder: "Nome",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "descricao",
            type: "textarea",
            placeholder: "Siape",
            icon: "cil-user",
          },
        ],
      ]
    };
  },
  validations: {
    nome: {
      required,
    },
    descricao: {
      required,
    },
  },
  computed: mapState({
    usuariosLista: (state) => state.users.users,
    permissoesLista: (state) => state.permissions.permissions,
  }),
  async mounted() {
    await this.fetchUsers();
    await this.fetchPermissions();

    if (this.$route.params.id) {
      this.id = this.$route.params.id;
      const res = await this.getProfileById(this.id);
      const profile = res.data;

      this.nome = profile.nome;
      this.descricao = profile.descricao;
      profile.permissoes.forEach((permissao) => this.permissoesPerfil.push(permissao));
      profile.usuarios.forEach((usuario) => this.usuariosPerfil.push(usuario));
    }
  },
  methods: {
    ...mapActions("profiles", ["saveProfile", "getProfileById"]),
    ...mapActions("users", ["fetchUsers"]),
    ...mapActions("permissions", ["fetchPermissions"]),

    updateUsuarios(items) {
      this.usuariosPerfil = items;
    },

    updatePermissoes(items) {
      this.permissoesPerfil = items;
    },
  },
};
</script>
