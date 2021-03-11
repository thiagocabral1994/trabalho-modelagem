<template>
  <CRow>
    <CCol sm="12" md="6">
      <detail-view
        v-bind:id_item="id"
        titulo="Usuário"
        v-bind:items="configForm"
      />
    </CCol>
    <CCol sm="12" md="6">
      <subscribe
        titulo="Perfis"
        v-bind:items_input="gruposUsuario"
        v-bind:lista="gruposLista"
        label="nome"
        v-bind:fields="[]"
        v-bind:view_only="true"
        @update-items="updateGrupos"
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
    "detail-view": Detail,
    subscribe: Subscribe,
  },
  data() {
    return {
      id: null,
      rg: null,
      cep: null,
      numero: null,
      complemento: null,
      bairro: null,
      estado: null,
      pais: null,
      cidade: null,
      telefone: null,
      logradouro: null,
      cpf: null,
      nome: null,
      email: null,
      senha: null,
      confirma_senha: null,
      gruposUsuario: [],

      configForm: [
        [
          {
            model: "cpf",
            type: "text",
            mask: "###.###.###-##",
            placeholder: "CPF",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "rg",
            type: "text",
            mask: "###.###.###",
            placeholder: "RG",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "cep",
            type: "text",
            mask: "#####-###",
            placeholder: "CEP",
            icon: "cil-user",
          },
        ],
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
            model: "logradouro",
            type: "text",
            placeholder: "Logradouro",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "numero",
            type: "text",
            placeholder: "Número",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "complemento",
            type: "text",
            placeholder: "Complemento",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "bairro",
            type: "text",
            placeholder: "Bairro",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "cidade",
            type: "text",
            placeholder: "Cidade",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "estado",
            type: "text",
            placeholder: "Estado",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "pais",
            type: "text",
            placeholder: "País",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "telefone",
            type: "text",
            mask: "(##)#####-####",
            placeholder: "telefone",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "email",
            type: "text",
            placeholder: "E-mail",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "senha",
            type: "password",
            placeholder: "Senha",
            icon: "cil-user",
          },
          {
            model: "confirma_senha",
            type: "password",
            placeholder: "Confirma Senha",
            icon: "cil-user",
          },
        ],
      ],
    };
  },
  validations: {
    rg: { required },
    cep: { required },
    numero: { required },
    complemento: { required },
    bairro: { required },
    estado: { required },
    pais: { required },
    cidade: { required },
    telefone: { required },
    logradouro: { required },
    cpf: {
      required,
      validaCpf: (cpf) => validaCPF.validaCPF(cpf),
      minLength: minLength(14),
      maxLength: maxLength(14),
    },
    siape: {
      required,
      minLength: minLength(7),
      maxLength: maxLength(15),
      alphaNum,
    },
    nome: {
      required,
      validLetters: (name) => !!name.match(/^[A-Za-z ']*$/),
    },
    email: {
      required,
      email,
    },
    id_siga: {
      required,
      maxValue: maxValue(999999999),
      numeric,
    },
    senha: {
      minLength: minLength(6),
      maxLength: maxLength(45),
    },
    confirma_senha: {
      minLength: minLength(6),
      maxLength: maxLength(45),
      sameAs: sameAs(function () {
        return this.senha;
      }),
    },
  },
  computed: mapState({
    gruposLista: (state) => state.profiles.profiles,
  }),
  async mounted() {
    await this.fetchProfiles();

    if (this.$route.params.id) {
      this.id = this.$route.params.id;
      const res = await this.getUserById(this.id);

      const user = res.data;
      this.rg = user.rg;
      this.cep = user.cep;
      this.numero = user.numero;
      this.complemento = user.complemento;
      this.bairro = user.bairro;
      this.estado = user.estado;
      this.pais = user.pais;
      this.cidade = user.cidade;
      this.telefone = user.telefone;
      this.logradouro = user.logradouro;
      this.cpf = user.cpf
        .toString()
        .replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
      this.siape = user.siape;
      this.nome = user.nome;
      this.email = user.email;
      this.id_siga = user.id_siga;
      user.grupos.forEach((grupo) => this.gruposUsuario.push(grupo));
      user.setores.forEach((setor) => this.setoresUsuario.push(setor));
    }
  },
  methods: {
    ...mapActions("users", ["saveUser", "getUserById"]),
    ...mapActions("profiles", ["fetchProfiles"]),

    updateGrupos(items) {
      this.gruposUsuario = items;
    },
  },
};
</script>
