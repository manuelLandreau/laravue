<template>
  <div>
    <div v-if="authReadyLoaded">
      <div class="ui menu">
        <div class="header item">
          <a href="/">📄 MyGoodTest</a>
        </div>
        <div v-if="$auth.check()" class="right menu">
          <a @click.prevent="$auth.logout()" class="item">
            Logout
          </a>
        </div>
        <div v-else-if="!$auth.check()" class="right menu">
          <router-link :to="{name: 'login'}" class="item">Se connecter</router-link>
        </div>
      </div>
      <div class="ui container">
        <router-view></router-view>
      </div>
    </div>
    <div v-else-if="!authReadyLoaded">
      <p>Chargement...</p>
    </div>
  </div>
</template>

<script>
  const mixinAuthReady = {
    data() {
      return {loaded: false}
    },
    mounted() {
      setTimeout(() => {
        this.loaded = true;
      }, 500);
    },
    computed: {
      authReadyLoaded() {
        return (this.loaded && this.$auth.ready());
      }
    }
  };

  export default {
    mixins: [mixinAuthReady]
  }

</script>
