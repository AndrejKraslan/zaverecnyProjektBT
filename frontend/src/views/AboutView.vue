<template>
  <div>
    <h1>Home</h1>
    <div v-if="isAuthenticated">
      <p>Welcome, {{ user.first_name }}!</p>
      <button @click="logout">Logout</button>
    </div>
    <div v-else>
      <p>Please log in to see the content.</p>
    </div>
  </div>
</template>
<script>
import axios from '@/plugins/axios';

export default {
  data() {
    return {
      user: null,
      isAuthenticated: !!localStorage.getItem('token'),
    };
  },
  methods: {
    async fetchUser() {
      try {
        const response = await axios.get('/user');
        this.user = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    logout() {
      localStorage.removeItem('token');
      this.isAuthenticated = false;
      this.user = null;
      this.$router.push({ name: 'login' });
    }
  },
  created() {
    if (this.isAuthenticated) {
      this.fetchUser();
    }
  }
};
</script>
<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
