<template>
  <CRow>
    <CCol sm="12" md="6">
      <detail-view
        v-bind:id_item="id"
        titulo="Turma"
        v-bind:items="configForm"
      />
    </CCol>
    <CCol sm="12" md="12">
      <list-view
        titulo="Atividades"
        v-bind:items="items"
        v-bind:fields="colunas"
        v-bind:routes="rotas"
        v-bind:deleteCall="deleteActivity"
      />
    </CCol>
  </CRow>
</template>

<script>
import Detail from "../_parent/Details.vue";
import Subscribe from "../_parent/Subscribe.vue";
import List from "../_parent/List.vue";

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
    "detail-view": Detail,
    'list-view': List,
    subscribe: Subscribe,
  },
  data() {
    return {
      id: null,
      qtd_alunos: null,
      usuario: null,
      curso: null,
      status: null,

      configForm: [
        [
          {
            model: "qtd_alunos",
            type: "text",
            placeholder: "Quantidade de Alunos",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "usuario.nome",
            type: "text",
            lista: {
              model: this.usuarioLista,
              placeholder: "nome"
            },
            placeholder: "Instrutor",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "curso.nome",
            type: "text",
            lista: {
              model: this.cursoLista,
              placeholder: "nome"
            },
            placeholder: "Curso",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "status.nome",
            type: "text",
            lista: {
              model: this.statusLista,
              placeholder: "nome"
            },
            placeholder: "Status",
            icon: "cil-user",
          },
        ],
      ],

      colunas: [
        {
          key: "id",
          label: "ID",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "titulo",
          label: "Titulo",
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
        new: `/classes/detail/${this.id}/new`,
        details: `/classes/detail/${this.id}/detail`,
        edit: `/classes/detail/${this.id}/id`,
      }
    };
  },
  computed: mapState({
    items: (state) => state.activities.activities,
    loggedUser: (state) => state.users.loggedUser,
  }),
  validations: {
    qtd_alunos: { required },
    usuario: { required },
    curso: { required },
    status: {},
  },
  async mounted() {
    await this.fetchActivitiesByClassId(this.id);

    await this.fetchUsers();
    await this.fetchCourses();
    await this.fetchStatus();

    if (this.$route.params.id) {
      this.id = this.$route.params.id;
      const res = await this.getClassById(this.id);

      const clazz = res.data;
      this.qtd_alunos = clazz.quantidade_alunos;
      this.usuarioLista.forEach(user => {
        if (user.id == clazz.id_usuario)
          this.usuario = user;
      });
      this.cursoLista.forEach(curso => {
        if (curso.id == clazz.id_curso)
          this.curso = user;
      });
      this.statusLista.forEach(status => {
        if (status.id == clazz.id_status)
          this.status = user;
      });
    }
  },
  methods: {
    ...mapActions("status", ["fetchStatus"]),
    ...mapActions("courses", ["fetchCourses"]),
    ...mapActions("users", ["fetchUsers"]),
    ...mapActions("classes", ["saveClass"]),
    ...mapActions("activities", ["fetchActivitiesByClassId", "deleteActivity"])
  },
};
</script>
