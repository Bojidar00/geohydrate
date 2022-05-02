import { defineStore } from 'pinia';



export const useMainStore = defineStore({ 
    id: 'Main',

    state: () => ({
        username: '',
        password: '',
        access:0
      }),
      getters: {
        getUsername: (state) => state.username,
        getPassword: (state) => state.password,
        getAccess: (state) => state.access,
      },
      actions: {
        setUsername(name) {
            this.username=name;
        },
        setPassword(pass) {
          this.password = pass;
        },
        setAccess(access) {
          this.access = access;
        },
        
        
      }
})