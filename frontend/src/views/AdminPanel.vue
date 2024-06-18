<template>
  <div class="container mt-5" v-if="isAdmin">
    <h2>Správa používateľov</h2>
    <input type="text" v-model="searchTerm" placeholder="Vyhľadávanie..." class="form-control mb-3" />
    <table class="table table-bordered mt-3">
      <thead>
      <tr>
        <th>ID</th>
        <th>Meno</th>
        <th>Priezvisko</th>
        <th>Email</th>
        <th>Admin</th>
        <th>Pridať/Odstrániť</th>
        <th>Odstrániť</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="user in filteredUsers" :key="user.ID">
        <td>{{ user.ID }}</td>
        <td>{{ user.Meno }}</td>
        <td>{{ user.Priezvisko }}</td>
        <td>{{ user.Email }}</td>
        <td>{{ user.Admin ? 'Áno' : 'Nie' }}</td>
        <td>
          <button class="btn btn-primary" @click="makeAdmin(user.ID)" v-if="!user.Admin">Pridať ako admina</button>
          <button class="btn btn-danger" @click="removeAdmin(user.ID)" v-if="user.Admin">Odstrániť admina</button>
        </td>
        <td>
          <button class="btn btn-danger" @click="deleteUser(user.ID)">Odstrániť</button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
  <div v-else>
    <p>Access Denied</p>
  </div>
</template>

<script>
import axios from '@/plugins/axios.js';

export default {
  name: 'AdminPanel',
  data() {
    return {
      users: [],
      searchTerm: '',
      isAdmin: false
    };
  },
  created() {
    this.checkAdminStatus();
  },
  computed: {
    filteredUsers() {
      return this.users.filter(user => {
        return (
            user.Meno.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
            user.Priezvisko.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
            user.Email.toLowerCase().includes(this.searchTerm.toLowerCase())
        );
      });
    }
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get('/users');
        if (response.headers['content-type'].includes('application/json')) {
          this.users = response.data;
        } else {
          console.error('Unexpected API response:', response.data);
        }
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    async makeAdmin(userId) {
      try {
        await axios.post('/make_admin', {user_id: userId});
        this.fetchUsers();
      } catch (error) {
        console.error('Error making admin:', error);
      }
    },
    async removeAdmin(userId) {
      try {
        await axios.post('/remove_admin', {user_id: userId});
        this.fetchUsers();
      } catch (error) {
        console.error('Error removing admin:', error);
      }
    },
    async deleteUser(userId) {
      try {
        await axios.delete('/user', {data: {user_id: userId}});
        this.fetchUsers();
      } catch (error) {
        console.error('Error deleting user:', error);
      }
    },
    async checkAdminStatus() {
      try {
        const response = await axios.get('/user');
        this.isAdmin = response.data.is_admin === 1;
        if (this.isAdmin) {
          this.fetchUsers();
        }
      } catch (error) {
        console.error('Error checking admin status:', error);
      }
    }
  }
};
</script>

<style scoped>
</style>
