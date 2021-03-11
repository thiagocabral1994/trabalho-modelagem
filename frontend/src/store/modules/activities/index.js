import ActivityService from '@/services/ActivityService';

export const module = {
  namespaced: true,

  state() {
    return {
      activities: []
    };
  },

  mutations: {
    SET_ACTIVITIES(state, payload) {
      state.activities = payload;
    },

    REMOVE_BY_ID(state, id) {
      state.activities = state.activities.filter(activity => activity.id != id);
    }
  },

  actions: {

    fetchActivities({ commit }) {
      return ActivityService.getAll().then(({ data }) => {
        commit('SET_ACTIVITIES', data);
      });
    },

    fetchActivitiesByClassId({ commit }, id) {
      return ActivityService.getByClassId(id).then(({ data }) => {
        commit('SET_ACTIVITIES', data);
      });
    },

    getActivityById({ commit }, id) {
      return ActivityService.getById(id);
    },

    saveActivity({}, data) {
      return ActivityService.save(data);
    },

    deleteActivity({ commit }, id) {
      return ActivityService.delete(id).then(() => {
        commit('REMOVE_BY_ID', id);
      });
    }
  }
};
