<template>
  <div class="container mt-5">
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
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminPanel',
  data() {
    return {
      users: [],
      searchTerm: ''
    };
  },
  created() {
    this.fetchUsers();
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
        const response = await axios.get('http://localhost/zaverecnyProjektBT/backend/public/api/users');
        console.log('API Response:', response.data);
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
      console.log('Making user admin:', userId);
      try {
        const response = await axios.post('http://localhost/zaverecnyProjektBT/backend/public/api/make_admin', { user_id: userId });
        console.log('Make Admin Response:', response.data);
        this.fetchUsers();
      } catch (error) {
        console.error('Error making admin:', error);
      }
    },
    async removeAdmin(userId) {
      console.log('Removing admin:', userId);
      try {
        const response = await axios.post('http://localhost/zaverecnyProjektBT/backend/public/api/remove_admin', { user_id: userId });
        console.log('Remove Admin Response:', response.data);
        this.fetchUsers(); // Refresh
      } catch (error) {
        console.error('Error removing admin:', error);
      }
    }
  }
};
</script>

<style scoped>

</style>
