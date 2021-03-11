<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="5">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm>
                  <h1>Login</h1>
                  <p class="text-muted">Entre com a sua conta</p>
                  <CInput
                    v-mask="'###.###.###-##'"
                    placeholder="CPF"
                    type="text"
                    v-model="cpf"
                  >
                    <template #prepend-content
                      ><CIcon name="cil-user"
                    /></template>
                  </CInput>
                  <CInput placeholder="Senha" type="password" v-model="senha">
                    <template #prepend-content
                      ><CIcon name="cil-lock-locked"
                    /></template>
                  </CInput>
                  <CRow>
                    <CCol col="6" class="text-left">
                      <CButton @click="handleLogin" color="primary" class="px-4"
                        >Login</CButton
                      >
                    </CCol>
                    <CCol col="6" class="text-right">
                      <CButton color="link" class="px-0"
                        >Esqueceu sua senha?</CButton
                      >
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import swal from "sweetalert";
import { mapActions } from "vuex";

export default {
  name: "Login",
  data() {
    return {
      cpf: null,
      senha: null,
    };
  },
  methods: {
    ...mapActions("users", ["login"]),

    handleLogin() {
      const userLogin = {
        cpf: this.cpf.replace(/\./g, "").replace(/\-/g, ""),
        senha: this.senha
      };
      this.login(userLogin)
        .then(() => {
          this.$router.push("/home");
        })
        .catch((e) => {
          let text;

          if (e.response) {
            text = "Dados inválidos!";
          } else if (e.request) {
            text = "Erro de conexão. Tente novamente!";
          } else {
            text = e.message;
          }

          swal({
            title: "ERRO",
            text,
            icon: "warning",
            buttons: true,
            dangerMode: true,
          });
        });
    },
  },
};
</script>
