<template>
  <CCard>
    <CCardHeader
      >Detalhes de
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
            <!-- Caixa de Texto - Somente Visualização -->
            <CTextarea
              disabled
              v-if="col.type == 'textarea'"
              :placeholder="col.placeholder"
              horizontal
              :rows="col.rows ? col.rows : 3"
              v-model="col.value"
            >
              <template #prepend-content>
                <CIcon :name="col.icon" />
              </template>
            </CTextarea>

            <!-- Somente Visualização -->
            <CInput v-else disabled type="text" :value="col.value">
              <template #prepend-content>
                <CIcon :name="col.icon" />
              </template>
            </CInput>

              <template #prepend-content>
                <CIcon :name="col.icon" />
              </template>
            </CInput>
          </CCol>
        </CRow>

        <CRow>
          <CCol>
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
export default {
  props: {
    id_item: String,
    titulo: String,
    items: Array
  },
  mounted() {
  },
  methods: {
    goBack() {
      this.$router.go(-1);
    },
  },
};
</script>
