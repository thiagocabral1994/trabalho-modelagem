import UserService from '@/services/UserService';
import apiClient from '@/services/apiClient';

export const constants = {
  USER_STORAGE_ITEM: 'loggedUser'
};

export const module = {
  namespaced: true,

  state() {
    return {
      loggedUser: null,
      users: []
    };
  },

  getters: {
    loggedIn(state) {
      return (
        !!localStorage.getItem(constants.USER_STORAGE_ITEM) ||
        !!state.loggedUser
      );
    }
  },

  mutations: {
    SET_USERS(state, payload) {
      state.users = payload;
    },

    SET_LOGGED_USER(state, payload) {
      state.loggedUser = payload;
      state.loggedUser.cpf = state.loggedUser.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    },

    SET_TOKENS(state, payload) {
      const loggedUser = {
        jwt: payload.tokens.jwt,
        refresh_token: payload.tokens.refresh_token
      };

      state.loggedUser = payload.usuario;
      state.loggedUser.cpf = state.loggedUser.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");

      localStorage.setItem(
        constants.USER_STORAGE_ITEM,
        JSON.stringify(loggedUser)
      );

      apiClient.defaults.headers.common[
        'Authorization'
      ] = `Bearer ${loggedUser.jwt}`;
    },

    REMOVE_BY_ID(state, id) {
      state.users = state.users.filter(user => user.id != id);
    },

    REMOVE_LOGGED_USER() {
      localStorage.removeItem(constants.USER_STORAGE_ITEM);
    }
  },

  actions: {

    fetchUsers({ commit }) {
      return UserService.getAll().then(({ data }) => {
        commit('SET_USERS', data);
      });
    },

    getUserById({}, id) {
      return UserService.getById(id);
    },

    saveUser({}, data) {
      return UserService.save(data);
    },

    deleteUser({ commit }, id) {
      return UserService.delete(id).then(() => {
        commit('REMOVE_BY_ID', id);
      });
    },

    login({ commit }, credentials) {
      return UserService.login(credentials).then(({ data }) => {
        commit('SET_TOKENS', data);
      });
    },

    loginJwt({ commit }) {
      const loggedUser = JSON.parse(
        localStorage.getItem(constants.USER_STORAGE_ITEM)
      );

      if(!loggedUser) {
        return;
      }

      apiClient.defaults.headers.common[
        'Authorization'
      ] = `Bearer ${loggedUser.jwt}`;
      return UserService.loginJwt().then(({ data }) => {
        commit('SET_LOGGED_USER', data);
      });
    },

    logout({ commit }) {
      commit('REMOVE_LOGGED_USER');
    }
  }
};
