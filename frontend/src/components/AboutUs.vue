<template>
  <div class="container py-5 bg-light">

    <div class="row">
      <div class="col-md-4">
        <img class="img-fluid" src="@/assets/about-logo.jpg" alt="About Logo">
      </div>
      <div class="col-md-8">
        <h2>About us</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ad, consequuntur corporis debitis doloremque est id in, itaque maxime minus molestiae nesciunt nobis, obcaecati omnis perspiciatis quia quo ratione sapiente?</p>
        <div class="row">
          <div class="col-sm-6 mb-3">
            <div class="p-4 bg-white shadow-sm p-3 mb-5">
              <h5>Lorem ipsum</h5>
              <p>Lorem ipsum dolor sit amet</p>
            </div>
          </div>
          <div class="col-sm-6 mb-3">
            <div class="p-4 bg-white shadow-sm p-3 mb-5">
              <h5>Lorem ipsum</h5>
              <p>Lorem ipsum dolor sit amet</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>

</script>

<style scoped>
.container {
  background-color: rgb(241, 243, 245);
  max-width: 100%;
  color: rgb(118, 118, 118);
}

.row {
  margin: 0; /* Remove margins from the row */
  padding: 0; /* Remove padding from the row */
}


.bg-white {
  background-color: white;
  margin: 0;
  padding: 0;
  border: none;
}
</style>
