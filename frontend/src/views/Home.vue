<template>
  <CContainer>
    <p>Bem Vindo!</p>
  </CContainer>
</template>

<script>
import { mapState } from "vuex";
export default {
  name: "Home",
  computed: mapState({
    itemStoraged: (state) => state.users.loggedUser,
  }),
};
</script>
