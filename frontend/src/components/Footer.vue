<template>
  <footer class="footer mt-auto py-5 bg-dark text-white">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <h5 class="fw-bold">EVEMAT</h5>
          <p>Evemat is a Responsive HTML Event Template based on material design language invented by google.</p>
          <div class="social-icons">
            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-pinterest"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-youtube"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-tumblr"></i></a>
          </div>
        </div>

        <div class="col-md-4">
          <h5 class="fw-bold">SUBSCRIBE ME!</h5>
          <form @submit.prevent="subscribe">
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Your Email" v-model="email" required>
              <button class="btn btn-primary" type="submit">GO</button>
            </div>
          </form>
          <p>Your Information is safe to us.</p>
        </div>

        <div class="col-md-4">
          <h5 class="fw-bold">MINI GALLERY</h5>
          <div class="d-flex flex-wrap">
            <div class="mini-gallery-item" v-for="image in miniGalleryImages" :key="image">
              <img :src="image" alt="Mini gallery image" class="img-fluid">
            </div>
          </div>
          <a href="#" class="text-white mt-3 d-block">More Images</a>
        </div>
      </div>
    </div>
    <div class="text-center py-3 mt-3" style="background-color: #111;">
      <small>Copyright 2015. Designed By <a href="#" class="text-white">BestPixels</a></small>
    </div>
  </footer>
</template>

<script>
export default {
  name: "FooterComponent",
  data() {
    return {
      email: '',
      miniGalleryImages: [
        'http://localhost:8888/zaverecnyProjektBT/backend/public/storage/images/image1.jpg',
        'http://localhost:8888/zaverecnyProjektBT/backend/public/storage/images/image1.jpg',
        'http://localhost:8888/zaverecnyProjektBT/backend/public/storage/images/image1.jpg'
      ]
    };
  },
  methods: {
    subscribe() {
      // Handle subscription logic
      alert(`Subscribed with email: ${this.email}`);
      this.email = '';
    }
  }
};
</script>

<style scoped>
.footer {
  background-color: #222;
  color: white;
}
.footer .social-icons a {
  font-size: 1.2rem;
}
.footer .mini-gallery-item {
  margin-right: 10px;
  margin-bottom: 10px;
}
.footer .mini-gallery-item img {
  width: 50px;
  height: 50px;
  object-fit: cover;
}
</style>
