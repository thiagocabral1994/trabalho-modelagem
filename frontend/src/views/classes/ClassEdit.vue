<template>
  <CRow>
    <CCol sm="12" md="6">
      <edit-view 
      v-bind:id_item="id"
      titulo="Turma" 
      v-bind:items="configForm" 
      v-bind:validator="$v"
      v-bind:saveCall="save"
      returnRoute="/admin/classes"
      />
    </CCol>
  </CRow>
</template>

<script>
import Edit from "../_parent/Edit.vue";
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
    'edit-view': Edit,
    'subscribe': Subscribe
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
            model: "usuario",
            type: "select",
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
            model: "curso",
            type: "select",
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
            model: "status",
            type: "select",
            lista: {
              model: this.statusLista,
              placeholder: "nome"
            },
            placeholder: "Status",
            icon: "cil-user",
          },
        ],
      ]
    };
  },
  validations: {
    qtd_alunos: { required },
    usuario: { required },
    curso: { required },
    status: {},
  },
  computed: mapState({
    usuarioLista: (state) => state.users.users,
    cursoLista: (state) => state.courses.courses,
    statusLista: (state) => state.status.status,
  }),
  async mounted() {
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
    ...mapActions("classes", ["saveClass", "getClassById"]),

    save() {
      const dadosTurma = {
        id: this.id,
        quantidade_alunos: this.qtd_alunos,
        usuario: this.usuario.id,
        curso: this.curso.id,
        status: this.status.id,
      };

      return this.saveClass(dadosUsuario);
    }
  },
};
</script>
