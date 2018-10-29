<template>
  <div class="ui relaxed divided list">
    <h1>Liste des utilisateurs</h1>
    <p v-if="!users">
      Chargement des utilisateurs...
    </p>
    <div v-else-if="users">
      <div class="ui search">
        <div class="ui icon input">
          <input class="prompt" placeholder="Rechercher..." type="text" v-model="query" @change="searchHandler">
          <i class="search icon"></i>
        </div>
      </div>
      <table class="ui sortable celled table">
        <thead>
        <tr>
          <th @click.prevent="getUsersSortedBy('name', !nameDirection)">
            Name <i class="caret down icon"></i> <i class="caret up icon"></i>
          </th>
          <th @click.prevent="getUsersSortedBy('email', !emailDirection)">
            Email <i class="caret down icon"></i> <i class="caret up icon"></i>
          </th>
          <th @click.prevent="getUsersSortedBy('created_at', !createdAtDirection)">
            Inscription <i class="caret down icon"></i> <i class="caret up icon"></i>
          </th>
          <th @click.prevent="getUsersSortedBy('created_at', !createdAtDirection)">
            Actions
          </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users">
          <td v-if="!user.edit">{{user.name}}</td>
          <td v-else-if="!!user.edit">
            <input type="hidden" v-model="user.id">
            <div class="ui input">
              <input type="text" v-model="user.name">
            </div>
          </td>
          <td v-if="!user.edit">{{user.email}}</td>
          <td v-else-if="!!user.edit">
            <div class="ui input">
              <input type="text" v-model="user.email">
            </div>
          </td>
          <td>{{user.created_at | formatDate}}</td>
          <td>
            <button v-if="!user.edit" @click.prevent="editUser(user.id)" class="ui primary button">
              <i class="edit icon"></i>
            </button>
            <div v-else-if="!!user.edit" class="ui buttons">
              <button @click.prevent="editUser(user.id, true)" class="ui button"><i class="undo icon"></i></button>
              <button @click.prevent="saveUser(user)" class="ui positive button"><i class="save icon"></i></button>
            </div>
          </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
          <th colspan="3">
            <div class="ui right floated pagination menu">
              <a v-if="currentPage > 1" @click.prevent="getUsers(currentPage - 1)" class="icon item">
                <i class="left chevron icon"></i>
              </a>
              <a v-if="currentPage > 3" @click.prevent="getUsers(1)" class="item">1</a>
              <a v-if="currentPage < 4 && currentPage > 2" @click.prevent="getUsers(currentPage - 1)" class="item">
                {{currentPage - 2}}
              </a>
              <a v-if="currentPage > 1" @click.prevent="getUsers(currentPage - 1)" class="item">{{currentPage - 1}}</a>
              <a v-if="currentPage > lastPage - 2 && lastPage > 3" @click.prevent="getUsers(currentPage - 2)"
                 class="item">
                {{currentPage - 2}}
              </a>
              <a v-if="currentPage == lastPage && lastPage > 3" @click.prevent="getUsers(currentPage - 1)" class="item">
                {{currentPage - 1}}
              </a>
              <a class="item active">{{currentPage}}</a>
              <a v-if="(lastPage > 5 || currentPage < 2) && currentPage != lastPage"
                 @click.prevent="getUsers(currentPage + 1)" class="item">{{currentPage + 1}}</a>
              <a v-if="currentPage == 1" @click.prevent="getUsers(3)" class="item">3</a>
              <a v-if="currentPage < 3" @click.prevent="getUsers(4)" class="item">4</a>
              <a v-if="lastPage > 1 && currentPage < lastPage - 1" @click.prevent="getUsers(lastPage)" class="item">
                {{lastPage}}
              </a>
              <a v-if="currentPage < lastPage" @click.prevent="getUsers(currentPage + 1)" class="icon item">
                <i class="right chevron icon"></i>
              </a>
            </div>
          </th>
        </tr>
        </tfoot>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        users: null,
        currentPage: null,
        firstPage: null,
        lastPage: null,
        nextPage: null,
        nameDirection: null,
        emailDirection: null,
        createdAtDirection: null,
        query: '',
        currentUser: null
      };
    },

    mounted() {
      this.getUsers();
    },

    methods: {
      updateData(data) {
        this.users = data.data;
        this.currentPage = data.current_page;
        this.firstPage = data.first_page;
        this.lastPage = data.last_page;
        this.nextPage = data.next_page;
      },

      getUsers(p = null) {
        let sort = '';
        if (null !== this.nameDirection) {
          const dir = this.nameDirection ? 'asc' : 'desc';
          sort = '&name=' + dir;
        } else if (null !== this.emailDirection) {
          const dir = this.emailDirection ? 'asc' : 'desc';
          sort = '&email=' + dir;
        } else if (null !== this.createdAtDirection) {
          const dir = this.createdAtDirection ? 'asc' : 'desc';
          sort = '&created_at=' + dir;
        }

        let page = p || '1';

        this.$http({
          url: 'users?page=' + page + sort + '&queryString=' + this.query,
          method: 'GET'
        }).then(({data}) => {
          this.updateData(data);
        }, (res) => {
          console.log('Error:', res);
        });
      },

      getUsersSortedBy(column, direction) {
        const dir = direction ? 'asc' : 'desc';

        if (column === 'name') {
          this.nameDirection = direction;
          this.emailDirection = null;
          this.createdAtDirection = null;
        } else if (column === 'email') {
          this.emailDirection = direction;
          this.nameDirection = null;
          this.createdAtDirection = null;
        } else {
          this.createdAtDirection = direction;
          this.emailDirection = null;
          this.nameDirection = null;
        }

        this.$http({
          url: 'users?page=' + this.currentPage + '&' + column + '=' + dir + '&queryString=' + this.query,
          method: 'GET'
        }).then(({data}) => {
          this.updateData(data);
        }, (res) => {
          console.log('Error:', res);
        });
      },
      searchHandler(e) {
        this.query = e.target.value;
        this.$http({
          url: 'users?queryString=' + e.target.value,
          method: 'GET'
        }).then(({data}) => {
          this.updateData(data);
        }, (res) => {
          console.log('Error:', res);
        });
      },
      editUser(id, cancel = false) {
        this.users.map(user => {
          if (user.id === id) {
            this.currentUser = {...user};
            user.edit = !user.edit
          } else {
            user.edit = false
          }
        });
        if (cancel) {
          this.users.map(user => user.id === id ? this.currentUser : user)
        }
        this.$forceUpdate();
      },
      saveUser(user) {
        this.$http({
          url: 'user',
          method: 'PUT',
          data: user
        }).then(({data}) => {
          this.users.map(user => user.edit = false);
          this.$forceUpdate();
        }, (res) => {
          console.log('Error: ', res);
        });
      }
    }
  }
</script>