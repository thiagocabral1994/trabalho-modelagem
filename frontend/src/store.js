import Vue from 'vue';
import Vuex from 'vuex';
import { module as users } from '@/store/modules/users';
import { module as permissions } from '@/store/modules/permissions';
import { module as profiles } from '@/store/modules/profiles';
import { module as activities } from '@/store/modules/activities';
import { module as classes } from '@/store/modules/classes';
import { module as courses } from '@/store/modules/courses';
import { module as events } from '@/store/modules/events';

Vue.use(Vuex);

const state = {
  sidebarShow: 'responsive',
  sidebarMinimize: false
}

const mutations = {
  toggleSidebarDesktop (state) {
    const sidebarOpened = [true, 'responsive'].includes(state.sidebarShow)
    state.sidebarShow = sidebarOpened ? false : 'responsive'
  },
  toggleSidebarMobile (state) {
    const sidebarClosed = [false, 'responsive'].includes(state.sidebarShow)
    state.sidebarShow = sidebarClosed ? true : 'responsive'
  },
  set (state, [variable, value]) {
    state[variable] = value
  }
}

export default new Vuex.Store({
  state,
  mutations,
  modules: {
    users,
    permissions,
    profiles,
    events,
    activities,
    classes,
    courses
  }
});