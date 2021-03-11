<template>
  <CSidebar
    fixed
    :minimize="minimize"
    :show="show"
    @update:show="(value) => $store.commit('set', ['sidebarShow', value])"
  >
    <CSidebarBrand class="d-md-down-none" to="/">
      <CIcon
        class="c-sidebar-brand-full"
        name="logo"
        size="custom-size"
        :height="35"
        viewBox="0 0 556 134"
      />
      <CIcon
        class="c-sidebar-brand-minimized"
        name="logo"
        size="custom-size"
        :height="35"
        viewBox="0 0 110 134"
      />
    </CSidebarBrand>

    <CRenderFunction flat :content-to-render="nav" />

    <CSidebarMinimizer
      class="d-md-down-none"
      @click.native="$store.commit('set', ['sidebarMinimize', !minimize])"
    />
  </CSidebar>
</template>

<style lang="scss">
.c-sidebar-nav-dropdown-items {
  .c-sidebar-nav-item {
    a.c-sidebar-nav-link {
      padding-left: 80px;
    }
  }
}
</style>

<script>
import { mapState } from "vuex";
import store from "../store";
export default {
  name: "TheSidebar",
  data() {
    return {
      nav: [],
      loggedUser: null,

      /**
       * ITENS BASICOS
       */
      homepage: {
        _name: "CSidebarNavItem",
        name: "Home",
        to: "/home",
        icon: "cil-home",
      },

      logout: {
        _name: "CSidebarNavItem",
        name: "Logout",
        to: "/logout",
        icon: "cil-account-logout",
      },

      /**
       * ADMINISTRACAO
       */
      administradorMenu: {
        _name: "CSidebarNavDropdown",
        name: "Administração",
        icon: "cil-notes",
        route: "/admin",
        items: [],
      },

      usuarios: {
        name: "Usuários",
        icon: "cil-user",
        to: "/admin/users",
      },

      permissoes: {
        name: "Permissões",
        icon: "cil-lock-unlocked",
        to: "/admin/permissions",
      },

      perfis: {
        name: "Perfis",
        icon: "cil-people",
        to: "/admin/profiles",
      },

      cursos: {
        name: "Cursos",
        icon: "cil-monitor",
        to: "/admin/courses",
      },

      /**
       * Turmas
       */
      classes: {
        _name: "CSidebarNavItem",
        name: "Turmas",
        to: "/classes",
        icon: "cil-monitor",
      },

      /**
       * Ocorrências
       */
      events: {
        _name: "CSidebarNavItem",
        name: "Ocorrências",
        to: "/events",
        icon: "cil-home",
      },
    };
  },
  created() {

    /**
     * HOMEPAGE
     */
    var navItens = [this.homepage];

    /**
     * ADMINISTRACAO
     */
    {
      if (true) {
        this.administradorMenu.items.push(this.usuarios);
      }

      if (true) {
        this.administradorMenu.items.push(this.permissoes);
      }

      if (true) {
        this.administradorMenu.items.push(this.perfis);
      }

      if (true) {
        this.administradorMenu.items.push(this.cursos);
      }

      if (this.administradorMenu.items.length > 0) {
        navItens.push(this.administradorMenu);
      }
    }

    /**
     * TURMA
     */
    if (true) {
      navItens.push(this.classes);
    }

    /**
     * OCORRÊNCIAS
     */
    if (true) {
      navItens.push(this.events);
    }

    /**
     * LOGOUT
     */
    navItens.push(this.logout);

    const nav = [
      {
        _name: "CSidebarNav",
        dropdownMode: "openActive",
        _children: navItens,
      },
    ];
    this.nav = nav;
    return;


    this.loggedUser = store.state.users.loggedUser;
    const userPermissions = this.loggedUser.permissoes;

    // /**
    //  * HOMEPAGE
    //  */
    // var navItens = [this.homepage];

    // /**
    //  * ADMINISTRACAO
    //  */
    // {
    //   if (
    //     userPermissions.some(
    //       (permission) =>
    //         permission.nome == "USUARIO" || permission.nome == "ADMIN_USUARIO"
    //     )
    //   ) {
    //     this.administradorMenu.items.push(this.usuarios);
    //   }

    //   if (
    //     userPermissions.some((permission) => permission.nome == "PERMISSAO")
    //   ) {
    //     this.administradorMenu.items.push(this.permissoes);
    //   }

    //   if (
    //     userPermissions.some(
    //       (permission) =>
    //         permission.nome == "GRUPO" || permission.nome == "ADMIN_GRUPO"
    //     )
    //   ) {
    //     this.administradorMenu.items.push(this.grupos);
    //   }

    //   if (userPermissions.some((permission) => permission.nome == "PRODUTO")) {
    //     this.administradorMenu.items.push(this.produtos);
    //   }

    //   if (
    //     userPermissions.some(
    //       (permission) =>
    //         permission.nome == "EMPRESA" || permission.nome == "ADMIN_EMPRESA"
    //     )
    //   ) {
    //     this.administradorMenu.items.push(this.empresas);
    //   }

    //   if (
    //     userPermissions.some(
    //       (permission) =>
    //         permission.nome == "SETOR" || permission.nome == "ADMIN_SETOR"
    //     )
    //   ) {
    //     this.administradorMenu.items.push(this.setores);
    //   }

    //   if (this.administradorMenu.items.length > 0) {
    //     navItens.push(this.administradorMenu);
    //   }
    // }

    // /**
    //  * PEDIDOS
    //  */
    // {
    //   if (
    //     userPermissions.some(
    //       (permission) =>
    //         permission.nome == "PEDIDO" || permission.nome == "ADMIN_PEDIDO"
    //     )
    //   ) {
    //     this.pedidosMenu.items.push(this.pedidos);
    //   }

    //   if (
    //     userPermissions.some((permission) => permission.nome == "ADMIN_PEDIDO")
    //   ) {
    //     this.pedidosMenu.items.push(this.aprovacao);
    //   }

    //   if (this.pedidosMenu.items.length > 0) {
    //     navItens.push(this.pedidosMenu);
    //   }
    // }

    // /**
    //  * PREGAO
    //  */
    // if (
    //   userPermissions.some(
    //     (permission) =>
    //       permission.nome == "ADMIN_PREGAO" || permission.nome == "PREGAO"
    //   )
    // ) {
    //   navItens.push(this.pregoes);
    // }

    // /**
    //  * ENTREGA
    //  */
    // if (
    //   userPermissions.some(
    //     (permission) =>
    //       permission.nome == "ADMIN_ENTREGA" || permission.nome == "ENTREGA"
    //   )
    // ) {
    //   navItens.push(this.entregas);
    // }

    // /**
    //  * LOGOUT
    //  */
    // navItens.push(this.logout);

    // const nav = [
    //   {
    //     _name: "CSidebarNav",
    //     dropdownMode: "openActive",
    //     _children: navItens,
    //   },
    // ];
    // this.nav = nav;
  },
  computed: {
    show() {
      return this.$store.state.sidebarShow;
    },
    minimize() {
      return this.$store.state.sidebarMinimize;
    },
  },
};
</script>
