<template>
  <div>
    <!-- Top Navbar -->
    <div class="bg-primary text-white py-2">
      <div class="container d-flex justify-content-between align-items-center">
        <div>
          <i class="fas fa-map-marker-alt me-2"></i> 49 West 32nd Street, New York
        </div>
        <div>
          <i class="fas fa-phone me-2"></i> +02 525 486 232
          <i class="fas fa-envelope ms-4 me-2"></i> eelias.cse@gmail.com
        </div>
      </div>
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
      <div class="container">
        <router-link class="navbar-brand" to="/">
          <span class="fw-bold">EVE<span class="text-primary">MAT</span></span>
        </router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/') }" to="/">Home</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/speakers') }" to="/speakers">Speakers</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/schedule') }" to="/schedule">Schedule</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/sponsors') }" to="/sponsors">Sponsors</router-link>
            </li>
            <li v-if="isAdmin" class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/admin') }" to="/admin">User Management</router-link>
            </li>
            <li v-if="isAdmin" class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/attendeelist') }" to="/attendeelist">Attendee List</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/gallery') }" to="/gallery">Gallery</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/comments') }" to="/comments">Comments</router-link>
            </li>
          </ul>
          <div v-if="isAuthenticated">
            <router-link class="btn btn-primary me-2" to="/schedule">Reserve Seat</router-link>
            <button class="btn btn-primary" @click="handleLogout">Log Out</button>
          </div>
          <div v-else>
            <router-link class="btn btn-primary me-2" to="/login">Login</router-link>
            <router-link class="btn btn-primary" to="/register">Register</router-link>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import axios from "@/plugins/axios.js";

export default {
  name: 'Navbar',
  data() {
    return {
      isAdmin: false,
    };
  },
  computed: {
    ...mapGetters(['isAuthenticated', 'user']),
  },
  watch: {
    user(newUser) {
      this.isAdmin = newUser && newUser.isAdmin;
    },
    isAuthenticated(newValue) {
      if (newValue) {
        this.checkAdminStatus();
      } else {
        this.isAdmin = false;
        this.$router.push('/');
      }
    }
  },
  methods: {
    ...mapActions(['logout']),
    isActive(path) {
      return this.$route.path === path;
    },
    async handleLogout() {
      await this.logout();
      this.$router.push('/');
      // Refresh the page to update the navbar
      window.location.reload();
    },
    async checkAdminStatus() {
      try {
        const response = await axios.get('/user');
        this.isAdmin = response.data.is_admin === 1;
      } catch (error) {
        console.error('Error checking admin status:', error);
      }
    }
  },
  created() {
    if (this.isAuthenticated) {
      this.checkAdminStatus();
    }
  },
}
</script>

<style scoped>
body {
  margin: 0;
  padding: 0;
}

.nav-link:hover, .nav-link.active {
  background-color: #8666f6;
  color: white !important;
  border-radius: 0.25rem;
}

.navbar-nav .nav-item + .nav-item {
  margin-left: 1rem;
}

.btn-primary {
  background-color: #8666f6;
  border: none;
}

.btn-primary:hover {
  background-color: #6a4eb7;
}
</style>
