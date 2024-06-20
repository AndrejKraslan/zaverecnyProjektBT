<template>
  <div class="container py-5">
    <h2 class="mb-4">Speakers</h2>
    <button v-if="isAdmin" @click="showAddSpeakerModal" class="btn btn-primary mb-4">Add Speaker</button>
    <div class="row">
      <div class="col-md-3 mb-4" v-for="speaker in speakers" :key="speaker.ID">
        <div class="card speaker-card">
          <img :src="getImageUrl(speaker.Image)" class="card-img-top" :alt="speaker.Name">
          <div class="card-body text-center">
            <h5 class="card-title">{{ speaker.Name }}</h5>
          </div>
          <div class="overlay">
            <div class="text">
              <p>{{ speaker.Description_Short }}</p>
              <button class="btn btn-link" @click="showSpeakerDetails(speaker.ID)">Viac o mne</button>
            </div>
          </div>
        </div>
        <div v-if="isAdmin" class="admin-actions">
          <button @click="openEditModal(speaker)" class="btn btn-warning">Edit</button>
          <button @click="deleteSpeaker(speaker.ID)" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
    <SpeakerModal v-if="selectedSpeaker" :speaker="selectedSpeaker" @close="selectedSpeaker = null" />
    <EditSpeakerModal v-if="editingSpeaker" :speaker="editingSpeaker" @close="closeEditModal" @save="saveSpeaker" />
    <AddSpeakerModal :isModalVisible="isAddSpeakerModalVisible" @update:isModalVisible="isAddSpeakerModalVisible = $event" @refreshSpeakers="fetchSpeakers" />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from '@/plugins/axios';
import SpeakerModal from '@/components/SpeakerModal.vue';
import EditSpeakerModal from '@/components/EditSpeakerModal.vue';
import AddSpeakerModal from '@/components/AddSpeakerModal.vue';

const speakers = ref([]);
const selectedSpeaker = ref(null);
const editingSpeaker = ref(null);
const isAdmin = ref(false); // Set this based on your authentication logic
const isAddSpeakerModalVisible = ref(false);

const fetchSpeakers = async () => {
  try {
    const response = await axios.get('/speakers');
    speakers.value = response.data;
  } catch (error) {
    console.error('Error fetching speakers:', error);
  }
};

const showSpeakerDetails = (id) => {
  selectedSpeaker.value = speakers.value.find(speaker => speaker.ID === id);
};

const deleteSpeaker = async (id) => {
  try {
    console.log(`Deleting speaker with ID: ${id}`);
    const response = await axios.delete(`/delete_speaker/${id}`);
    console.log('Response:', response);
    speakers.value = speakers.value.filter(speaker => speaker.ID !== id);
  } catch (error) {
    console.error('Error deleting speaker:', error);
    if (error.response) {
      console.error('Response data:', error.response.data);
      console.error('Response status:', error.response.status);
      console.error('Response headers:', error.response.headers);
    } else if (error.request) {
      console.error('Request data:', error.request);
    } else {
      console.error('Error message:', error.message);
    }
  }
};

const getImageUrl = (imagePath) => {
  return `http://localhost:8888/zaverecnyProjektBT/backend/public/${imagePath}`;
};

const openEditModal = (speaker) => {
  editingSpeaker.value = { ...speaker };
};

const closeEditModal = () => {
  editingSpeaker.value = null;
};

const saveSpeaker = async (updatedSpeaker) => {
  try {
    const payload = {
      name: updatedSpeaker.Name,
      description_short: updatedSpeaker.Description_Short,
      description_long: updatedSpeaker.Description_Long,
      image: updatedSpeaker.Image,
      facebook_url: updatedSpeaker.Facebook,
      instagram_url: updatedSpeaker.Instagram,
      twitter_url: updatedSpeaker.Twitter,
      web_url: updatedSpeaker.Web,
    };
    console.log('Payload to Save:', payload); // Log the payload before sending
    const response = await axios.put(`/update_speaker/${updatedSpeaker.ID}`, payload);
    console.log('Response:', response.data); // Log the response data
    fetchSpeakers();
    const index = speakers.value.findIndex(speaker => speaker.ID === updatedSpeaker.ID);
    if (index !== -1) {
      speakers.value[index] = response.data;
    }
    closeEditModal();
  } catch (error) {
    console.error('Error updating speaker:', error);
    if (error.response) {
      console.error('Response data:', error.response.data); // Log the response data
    }
  }
};

const showAddSpeakerModal = () => {
  console.log('Show Add Speaker Modal'); // Debugging log
  isAddSpeakerModalVisible.value = true;
};

// Check if the user is admin
const checkAdminStatus = async () => {
  try {
    const response = await axios.get('/user');
    isAdmin.value = response.data.is_admin === 1;
  } catch (error) {
    console.error('Error checking admin status:', error);
  }
};

fetchSpeakers();
checkAdminStatus();
</script>

<style scoped>
.container {
  background-color: rgb(241, 243, 245);
}

.speaker-card {
  position: relative;
  border: none;
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s;
}

.speaker-card:hover {
  transform: translateY(-10px);
}

.card-img-top {
  object-fit: cover;
  height: 300px;
}

.card-body {
  padding: 1em;
}

.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: opacity 0.3s ease;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
}

.speaker-card:hover .overlay {
  opacity: 1;
}

.text {
  color: white;
  text-align: center;
}

.btn-link {
  color: #fff;
  text-decoration: underline;
}

.admin-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 10px;
}

.btn-warning, .btn-danger {
  width: 48%;
}
</style>
