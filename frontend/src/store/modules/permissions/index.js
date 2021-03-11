import PermissionService from '../../../services/PermissionService';

export const module = {
  namespaced: true,

  state() {
    return {
      permissions: []
    };
  },

  mutations: {
    SET_PERMISSIONS(state, payload) {
      state.permissions = payload;
    }
  },

  actions: {
    fetchPermissions({ commit }) {
      return PermissionService.getAll().then(({ data }) => {
        commit('SET_PERMISSIONS', data);
      });
    }
  }
};
