<template>
  <div class="container py-5">
    <h2 class="mb-4">Speakers</h2>
    <div class="row">
      <div class="col-md-3 mb-4" v-for="speaker in firstFourSpeakers" :key="speaker.ID">
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
      </div>
    </div>
    <SpeakerModal v-if="selectedSpeaker" :speaker="selectedSpeaker" @close="selectedSpeaker = null" />
  </div>
</template>

<script setup>
import {ref, computed} from 'vue';
import axios from '@/plugins/axios';
import SpeakerModal from './SpeakerModal.vue';

const speakers = ref([]);
const selectedSpeaker = ref(null);

const fetchSpeakers = async () => {
  try {
    const response = await axios.get('http://localhost/zaverecnyProjektBT/backend/public/api/speakers');
    speakers.value = response.data;
  } catch (error) {
    console.error('Error fetching speakers:', error);
  }
};


const showSpeakerDetails = (id) => {
  selectedSpeaker.value = speakers.value.find(speaker => speaker.ID === id);
};

const firstFourSpeakers = computed(() => {
  return speakers.value.slice(0, 4);
});

const getImageUrl = (imagePath) => {
  return `http://localhost/zaverecnyProjektBT/backend/public/${imagePath}`;
};

fetchSpeakers();
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
</style>
