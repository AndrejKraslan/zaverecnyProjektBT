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
            <li class="nav-item dropdown">
              <router-link class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Pages
              </router-link>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><router-link class="dropdown-item" to="/about">About</router-link></li>
                <li><router-link class="dropdown-item" to="/accommodation">Accommodation</router-link></li>
                <li><router-link class="dropdown-item" to="/gallery">Gallery</router-link></li>
                <li><router-link class="dropdown-item" to="/price-table">Price Table</router-link></li>
                <li><router-link class="dropdown-item" to="/blog">Blog</router-link></li>
                <li><router-link class="dropdown-item" to="/blog-single">Blog Single</router-link></li>
                <li><router-link class="dropdown-item" to="/404">404 Error</router-link></li>
              </ul>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :class="{ active: isActive('/contact') }" to="/contact">Contact</router-link>
            </li>
          </ul>
          <router-link class="btn btn-primary me-2" to="/login">Login</router-link>
          <router-link class="btn btn-primary" to="/register">Register</router-link>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'Navbar',
  methods: {
    isActive(path) {
      return this.$route.path === path;
    }
  }
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
