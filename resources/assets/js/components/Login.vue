<template>
  <div class="ui two column centered grid">
    <div class="column">
      <form class="ui form" v-on:submit.prevent="login()">
        <h1>Connexion</h1>
        <div class="field">
          <label>Email</label>
          <input type="email" id="email" placeholder="user@example.com" v-model="email" required>
        </div>
        <div class="field">
          <label>Mot de passe</label>
          <input type="password" id="password" placeholder="******" v-model="password" required>
        </div>
        <div class="field">
          <div class="ui checkbox">
            <input type="checkbox" id="rememberMe" v-model="rememberMe"/>
            <label>Se souvenir de moi</label>
          </div>
        </div>
        <button class="ui button" type="submit">Se connecter</button>
        <div v-if="!!error" class="ui red message">Mauvais mot de passe ou email inconnu</div>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        email: null,
        password: null,
        rememberMe: false,
        fetchUser: false,
        error: ''
      };
    },

    mounted() {
      this.rememberMe = localStorage.getItem('rememberMe');
    },

    methods: {
      login() {
        localStorage.setItem('rememberMe', this.rememberMe);
        const redirect = this.$auth.redirect();
        ;
        const app = this;
        this.$auth.login({
          params: {
            email: app.email,
            password: app.password
          },
          success: () => {},
          error: () => {
            app.error = true;
          },
          rememberMe: app.rememberMe,
          redirect: {name: redirect ? 'users' : 'users'},
          fetchUser: true,
        });
      },
    }
  }
</script>
