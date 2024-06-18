<template>
  <div class="sponsors">
    <div class="header bg-secondary text-white p-4">
      <h1>PARTNERI</h1>
    </div>
    <div class="content container mt-4">
      <div class="row">
        <div
            v-for="sponsor in sponsors"
            :key="sponsor.ID"
            class="col-md-3 mb-4"
        >
          <div class="card">
            <img
                :src="getImageUrl(sponsor.Image)"
                class="card-img-top"
                :alt="sponsor.Name"
            />
            <div class="card-body">
              <h5 class="card-title">{{ sponsor.Name }}</h5>
              <p class="card-text">{{ sponsor.Description }}</p>
              <a :href="sponsor.URL" target="_blank" class="btn btn-primary">Visit</a>
              <div v-if="isAdmin" class="mt-2">
                <button @click="editSponsor(sponsor)" class="btn btn-secondary btn-sm">Edit</button>
                <button @click="deleteSponsor(sponsor.ID)" class="btn btn-danger btn-sm">Delete</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="isAdmin" class="text-center mt-4">
        <button @click="showAddSponsorModal = true" class="btn btn-primary">Add Sponsor</button>
      </div>
    </div>
    <AddSponsorModal
        v-if="showAddSponsorModal"
        @close="showAddSponsorModal = false"
        @add-sponsor="addSponsor"
    />
    <EditSponsorModal
        v-if="showEditSponsorModal"
        :sponsor="currentSponsor"
        @close="showEditSponsorModal = false"
        @edit-sponsor="updateSponsor"
    />
  </div>
</template>

<script>
import axios from '@/plugins/axios.js';
import AddSponsorModal from '@/components/AddSponsorModal.vue';
import EditSponsorModal from '@/components/EditSponsorModal.vue';

export default {
  data() {
    return {
      sponsors: [],
      isAdmin: false,
      showAddSponsorModal: false,
      showEditSponsorModal: false,
      currentSponsor: null,
    };
  },
  methods: {
    fetchSponsors() {
      axios
          .get('/sponsors')
          .then((response) => {
            this.sponsors = response.data;
          })
          .catch((error) => {
            console.error('Error fetching sponsors:', error);
          });
    },
    getImageUrl(imagePath) {
      return `http://localhost:8888/zaverecnyProjektBT/backend/public/${imagePath}`;
    },
    addSponsor(sponsor) {
      const payload = {
        name: sponsor.Name,
        url: sponsor.URL,
        description: sponsor.Description,
        image: sponsor.Image,
      };
      axios
          .post('/create_sponsor', payload)
          .then(() => {
            this.fetchSponsors();
            this.showAddSponsorModal = false;
          })
          .catch((error) => {
            console.error('Error adding sponsor:', error);
          });
    },
    updateSponsor(sponsor) {
      const payload = {
        name: sponsor.Name,
        url: sponsor.URL,
        description: sponsor.Description,
        image: sponsor.Image,
      };
      axios
          .put(`/update_sponsor/${sponsor.ID}`, payload)
          .then(() => {
            this.fetchSponsors();
            this.showEditSponsorModal = false;
          })
          .catch((error) => {
            console.error('Error updating sponsor:', error);
          });
    },
    deleteSponsor(id) {
      axios
          .delete(`/delete_sponsor/${id}`)
          .then(() => {
            this.fetchSponsors();
          })
          .catch((error) => {
            console.error('Error deleting sponsor:', error);
          });
    },
    editSponsor(sponsor) {
      this.currentSponsor = { ...sponsor };
      this.showEditSponsorModal = true;
    },
    checkAdminStatus() {
      axios
          .get('/user')
          .then((response) => {
            this.isAdmin = response.data.is_admin === 1;
          })
          .catch((error) => {
            console.error('Error checking admin status:', error);
          });
    },
  },
  created() {
    this.fetchSponsors();
    this.checkAdminStatus();
  },
  components: {
    AddSponsorModal,
    EditSponsorModal,
  },
};
</script>

<style scoped>
.sponsors {
  font-family: Arial, sans-serif;
}
.header {
  background-color: #00535D;
  color: white;
}
</style>
