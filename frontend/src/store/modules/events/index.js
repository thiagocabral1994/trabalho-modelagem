import EventService from '@/services/EventService';

export const module = {
  namespaced: true,

  state() {
    return {
      events: []
    };
  },

  mutations: {
    SET_EVENTS(state, payload) {
      state.events = payload;
    },

    REMOVE_BY_ID(state, id) {
      state.events = state.events.filter(event => event.id != id);
    }
  },

  actions: {

    fetchEvents({ commit }) {
      return EventService.getAll().then(({ data }) => {
        commit('SET_EVENTS', data);
      });
    },

    getEventById({ commit }, id) {
      return EventService.getById(id);
    },

    saveEvent({}, data) {
      return EventService.save(data);
    },

    deleteEvent({ commit }, id) {
      return EventService.delete(id).then(() => {
        commit('REMOVE_BY_ID', id);
      });
    }
  }
};
