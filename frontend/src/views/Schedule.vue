<template>
  <div class="schedule">
    <div class="header">
      <h1>PROGRAM</h1>
    </div>
    <div class="content">
      <div class="stage-selector">
        <div
            v-for="stage in stages"
            :key="stage.ID"
            :class="{'active': activeStage === stage.ID}"
            @click="selectStage(stage.ID)"
        >
          {{ stage.Name }}
        </div>
      </div>
      <div class="schedule-details">
        <div v-if="filteredEvents.length">
          <div v-for="event in filteredEvents" :key="event.ID" class="event">
            <div class="time">{{ formatTime(event.Start) }} - {{ formatTime(event.End) }}</div>
            <div class="details">
              <h3>{{ event.Name }}</h3>
              <p>{{ event.Description }}</p>
              <div class="speakers" v-if="event.Speaker">
                <div class="speaker" @click="showSpeakerDetails(event.Speaker)">
                  <img :src="getImageUrl(event.Speaker.Image)" class="img-fluid" :alt="event.Speaker.Name">
                  <div class="speaker-details">
                    <h5>{{ event.Speaker.Name }}</h5>
                    <p>{{ event.Speaker.Description_Short }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <p>No lectures available for this stage.</p>
        </div>
      </div>
    </div>
    <SpeakerModal v-if="selectedSpeaker" :speaker="selectedSpeaker" @close="closeModal" />
  </div>
</template>

<script>
import axios from 'axios';
import SpeakerModal from '@/components/SpeakerModal.vue';  // upravená cesta

export default {
  data() {
    return {
      stages: [],
      events: [],
      speakers: {},
      activeStage: null,
      selectedSpeaker: null,
    };
  },
  computed: {
    filteredEvents() {
      return this.events.filter(event => event.StageID === this.activeStage);
    },
  },
  methods: {
    fetchStages() {
      axios.get('http://localhost:/zaverecnyProjektBT/backend/public/api/stages')
          .then(response => {
            this.stages = response.data;
            if (this.stages.length > 0) {
              this.activeStage = this.stages[0].ID;
            }
          })
          .catch(error => {
            console.error('Error fetching stages:', error);
          });
    },
    fetchLectures() {
      axios.get('http://localhost:/zaverecnyProjektBT/backend/public/api/lectures')
          .then(response => {
            this.events = response.data;
            this.events.forEach(event => {
              if (event.SpeakerID) {
                this.fetchSpeaker(event.SpeakerID);
              }
            });
          })
          .catch(error => {
            console.error('Error fetching lectures:', error);
          });
    },
    fetchSpeaker(speakerId) {
      if (!this.speakers[speakerId]) {
        axios.get(`http://localhost:8888/zaverecnyProjektBT/backend/public/api/speakers/${speakerId}`)
            .then(response => {
              this.$set(this.speakers, speakerId, response.data);
              this.updateEventSpeakers();
            })
            .catch(error => {
              console.error(`Error fetching speaker with ID ${speakerId}:`, error);
            });
      }
    },
    updateEventSpeakers() {
      this.events = this.events.map(event => {
        if (event.SpeakerID) {
          event.Speaker = this.speakers[event.SpeakerID] || null;
        }
        return event;
      });
    },
    selectStage(stageId) {
      this.activeStage = stageId;
    },
    showSpeakerDetails(speaker) {
      this.selectedSpeaker = speaker;
    },
    closeModal() {
      this.selectedSpeaker = null;
    },
    formatTime(timeString) {
      const date = new Date(`1970-01-01T${timeString}Z`);
      return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    },
    getImageUrl(imagePath) {
      return `http://localhost:8888/zaverecnyProjektBT/backend/public/${imagePath}`;
    }
  },
  created() {
    this.fetchStages();
    this.fetchLectures();
  },
  components: {
    SpeakerModal,
  },
};
</script>

<style scoped>
.schedule {
  font-family: Arial, sans-serif;
}
.header {
  background-color: #2c3e50;
  color: white;
  padding: 10px;
}
.content {
  display: flex;
}
.stage-selector {
  width: 20%;
  background-color: #34495e;
}
.stage-selector div {
  padding: 10px;
  color: white;
  cursor: pointer;
}
.stage-selector .active {
  background-color: #1abc9c;
}
.schedule-details {
  width: 80%;
  padding: 20px;
}
.event {
  margin-bottom: 20px;
}
.event .time {
  font-weight: bold;
}
.event .details h3 {
  margin: 5px 0;
}
.speakers {
  display: flex;
  flex-wrap: wrap;
  cursor: pointer;
}
.speaker {
  margin-right: 20px;
  margin-bottom: 20px;
  text-align: center;
}
.speaker img {
  max-width: 100px;
  border-radius: 50%;
}
.speaker-details {
  margin-top: 10px;
}
</style>
