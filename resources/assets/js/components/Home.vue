<template>
  <div class="ui relaxed divided list">
    <div class="ui segment">
      <h1>Bienvenue <span v-if="$auth.user()">{{$auth.user().name}}</span></h1>
      <p v-if="!$auth.check()">
        Veuillez vous <router-link :to="{name: 'login'}" class="item">connecter</router-link>
      </p>
      <p v-else-if="$auth.check()">
        Consuter la liste des <router-link :to="{name: 'users'}" class="item">utilisateurs</router-link>
      </p>
    </div>
  </div>
</template>