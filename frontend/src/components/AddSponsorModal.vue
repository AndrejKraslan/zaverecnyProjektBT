<template>
  <div class="modal fade show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Sponsor</h5>
          <button type="button" class="close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="save">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" v-model="sponsor.Name" class="form-control" id="name" required>
            </div>
            <div class="form-group">
              <label for="url">URL</label>
              <input type="url" v-model="sponsor.URL" class="form-control" id="url" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea v-model="sponsor.Description" class="form-control" id="description" required></textarea>
            </div>
            <div class="form-group">
              <label for="image">Image</label>
              <input type="text" v-model="sponsor.Image" class="form-control" id="image">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sponsor: {
        Name: '',
        URL: '',
        Description: '',
        Image: '',
      },
    };
  },
  methods: {
    save() {
      const newSponsor = {
        Name: this.sponsor.Name,
        URL: this.sponsor.URL,
        Description: this.sponsor.Description,
        Image: this.sponsor.Image,
      };
      this.$emit('add-sponsor', newSponsor);
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

<style scoped>
.modal-backdrop {
  display: none;
}
</style>
