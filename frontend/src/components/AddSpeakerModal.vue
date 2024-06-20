<template>
  <b-modal v-model="isVisible" title="Add Speaker" @hidden="resetForm">
    <b-form @submit.prevent="addSpeaker">
      <div class="mb-3">
        <label for="speakerName" class="form-label">Name</label>
        <input type="text" class="form-control" id="speakerName" v-model="formData.Name" required>
      </div>
      <div class="mb-3">
        <label for="speakerDescriptionShort" class="form-label">Short Description</label>
        <textarea class="form-control" id="speakerDescriptionShort" v-model="formData.Description_Short" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label for="speakerDescriptionLong" class="form-label">Long Description</label>
        <textarea class="form-control" id="speakerDescriptionLong" v-model="formData.Description_Long" rows="6" required></textarea>
      </div>
      <div class="mb-3">
        <label for="speakerImage" class="form-label">Image URL</label>
        <input type="text" class="form-control" id="speakerImage" v-model="formData.Image" required>
      </div>
      <div class="mb-3">
        <label for="speakerFacebook" class="form-label">Facebook</label>
        <input type="text" class="form-control" id="speakerFacebook" v-model="formData.Facebook">
      </div>
      <div class="mb-3">
        <label for="speakerInstagram" class="form-label">Instagram</label>
        <input type="text" class="form-control" id="speakerInstagram" v-model="formData.Instagram">
      </div>
      <div class="mb-3">
        <label for="speakerTwitter" class="form-label">Twitter</label>
        <input type="text" class="form-control" id="speakerTwitter" v-model="formData.Twitter">
      </div>
      <div class="mb-3">
        <label for="speakerWeb" class="form-label">Website</label>
        <input type="text" class="form-control" id="speakerWeb" v-model="formData.Web">
      </div>

      <b-button type="submit" variant="primary">Add Speaker</b-button>
      <b-button variant="secondary" @click="closeModal">Cancel</b-button>
    </b-form>
  </b-modal>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    isModalVisible: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      formData: {
        Name: '',
        Description_Short: '',
        Description_Long: '',
        Image: '',
        Facebook: '',
        Instagram: '',
        Twitter: '',
        Web: ''
      }
    };
  },
  computed: {
    isVisible: {
      get() {
        return this.isModalVisible;
      },
      set(value) {
        this.$emit('update:isModalVisible', value);
      }
    }
  },
  methods: {
    addSpeaker() {
      console.log('Adding speaker:', this.formData);
      axios.post('http://localhost:8888/zaverecnyProjektBT/backend/public/api/create_speaker', {
        name: this.formData.Name,
        description_short: this.formData.Description_Short,
        description_long: this.formData.Description_Long,
        image: this.formData.Image,
        facebook_url: this.formData.Facebook,
        instagram_url: this.formData.Instagram,
        twitter_url: this.formData.Twitter,
        web_url: this.formData.Web,
      })
          .then(response => {
            console.log('Speaker added successfully:', response.data);
            this.$emit('refreshSpeakers');
            this.closeModal();
          })
          .catch(error => {
            console.error("There was an error adding the speaker!", error);
          });
    },
    closeModal() {
      this.isVisible = false;
    },
    resetForm() {
      this.formData = {
        Name: '',
        Description_Short: '',
        Description_Long: '',
        Image: '',
        Facebook: '',
        Instagram: '',
        Twitter: '',
        Web: ''
      };
    }
  }
};
</script>

<style scoped>

</style>