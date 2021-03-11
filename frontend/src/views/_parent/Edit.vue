<template>
  <CCard>
    <CCardHeader
      >{{ id_item == null ? "Cadastro" : "Edição" }} de
      {{ titulo }}</CCardHeader
    >
    <CCardBody>
      <CForm>
        <CRow v-for="row in items" :key="items.indexOf(row)">
          <CCol
            v-for="col in row"
            :key="col.model"
            sm="12"
            :md="12 / row.length"
          >
            <CRow v-if="col.type == 'multiselect'">
              <CCol>
                <label class="typo__label">{{col.placeholder}}</label>
                <multiselect
                  v-model="validator[col.model].$model"
                  placeholder="Procurar"
                  selectLabel="Pressione Enter para escolher"
                  deselectLabel="Pressione Enter para remover"
                  selectGroupLabel="Pressione Enter para escolher"
                  deselectGroupLabel="Pressione Enter para remover"
                  selectedLabel="Selecionado"
                  label="nome"
                  track-by="id"
                  :options="col.lista.model"
                  :multiple="true"
                ></multiselect>
              </CCol>
            </CRow>
            <!-- Select Form -->
            <div v-else-if="col.type == 'select'" class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <CIcon :name="col.icon" />
                  </span>
                </div>
                <select
                  class="custom-select"
                  v-bind:class="[
                    validator[col.model].$dirty || id_item
                      ? !validator[col.model].$invalid
                        ? 'is-valid'
                        : 'is-invalid'
                      : null,
                  ]"
                  v-model="validator[col.model].$model"
                >
                  <option selected :value="null" disabled>
                    {{ col.placeholder }}
                  </option>
                  <option
                    v-for="item in col.lista.model"
                    :key="item.id"
                    :value="item"
                  >
                    {{ col.lista[item].placeholder }}
                  </option>
                </select>
                <div
                  v-if="
                    (validator[col.model].$dirty || id) &&
                    validator[col.model].$invalid
                  "
                  class="errorMessage"
                >
                  {{ throwErrorMessage(validator[col.model]) }}
                </div>
              </div>
            </div>

            <!-- Somente Visualização -->
            <CInput
              v-else-if="col.type == 'disabled'"
              disabled
              type="text"
              :value="col.value ? col.value : validator[col.model].$model"
            >
              <template #prepend-content>
                <CIcon :name="col.icon" />
              </template>
            </CInput>

            <!-- Caixa de Texto -->
            <CTextarea
              v-else-if="col.type == 'textarea'"
              :placeholder="col.placeholder"
              horizontal
              :rows="col.rows ? col.rows : 3"
              v-model="validator[col.model].$model"
              :invalid-feedback="throwErrorMessage(validator[col.model])"
              :is-valid="
                validator[col.model].$dirty || id_item
                  ? !validator[col.model].$invalid
                  : null
              "
            >
              <template #prepend-content>
                <CIcon :name="col.icon" />
              </template>
            </CTextarea>

            <!-- Input Normal -->
            <CInput
              v-else
              v-mask="col.mask ? col.mask : 'X'.repeat(100)"
              :placeholder="col.placeholder"
              :type="col.type"
              v-model="validator[col.model].$model"
              :invalid-feedback="throwErrorMessage(validator[col.model])"
              :is-valid="
                validator[col.model].$dirty || id_item
                  ? !validator[col.model].$invalid
                  : null
              "
            >
              <template #prepend-content>
                <CIcon :name="col.icon" />
              </template>
            </CInput>
          </CCol>
        </CRow>

        <CRow>
          <CCol>
            <CButton
              class="mr-1"
              :disabled="validator.$invalid"
              @click="save"
              size="sm"
              :color="id_item == null ? 'success' : 'warning'"
              >{{ id_item == null ? "Cadastrar" : "Salvar" }}</CButton
            >

            <CButton class="mr-1" @click="goBack" size="sm" color="secondary"
              >Voltar</CButton
            >
          </CCol>
        </CRow>
      </CForm>
    </CCardBody>
  </CCard>
</template>

<script>
import swal from "sweetalert";
export default {
  props: {
    id_item: String,
    titulo: String,
    items: Array,
    validator: Object,
    saveCall: Function,
    returnRoute: String,
  },
  mounted() {},
  methods: {
    async save() {
      if (this.validator.$invalid) {
        return;
      }

      try {
        await this.saveCall();

        swal(
          this.id == null
            ? "Cadastro realizado com sucesso!"
            : "Alteração realizada com sucesso!",
          {
            icon: "success",
          }
        ).then(() => {});
        this.$router.push(this.returnRoute);
      } catch (error) {
        swal("Falha na operação. Tente novamente!", {
          icon: "warning",
          dangerMode: false,
        });
      }
    },

    throwErrorMessage(field) {
      if (field.required != null && field.required == false)
        return "Campo obrigatório!";
      else if (field.alphaNum != null && field.alphaNum == false)
        return "Apenas caracteres alfanuméricos permitidos!";
      else if (field.maxValue != null && field.maxValue == false)
        return "Número ultrapassou o valor máximo!";
      else if (field.minValue != null && field.minValue == false)
        return "Número menor que o valor máximo!";
      else if (field.maxLength != null && field.maxLength == false)
        return "Quantidade máxima de dígitos ultrapassada!";
      else if (field.minLength != null && field.minLength == false)
        return "Quantidade mínima de dígitos não atingida!";
      else if (field.numeric != null && field.numeric == false)
        return "Apenas dígitos permitidos";
      else if (field.validaCpf != null && field.validaCpf == false)
        return "CPF Inválido!";
      else if (field.email != null && field.email == false)
        return "Formato de email inválido!";
      else if (field.sameAs != null && field.sameAs == false)
        return "Senha precisa ser idêntica!";
      else return "Campo Inválido";
    },

    goBack() {
      this.$router.go(-1);
    },
  },
};
</script>
