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
            </div>
          </div>
        </div>
        <div v-else>
          <p>No lectures available for this stage.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      stages: [],
      events: [],
      activeStage: null,
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
            console.log('Stages:', this.stages);
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
            console.log('Lectures raw response:', response);
            this.events = response.data;
            console.log('Events:', this.events);
          })
          .catch(error => {
            console.error('Error fetching lectures:', error);
          });
    },
    selectStage(stageId) {
      this.activeStage = stageId;
    },
    formatTime(timeString) {
      // Assumes timeString is in "HH:mm:ss" format, adjust accordingly
      const date = new Date(`1970-01-01T${timeString}Z`);
      return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    },
  },
  created() {
    this.fetchStages();
    this.fetchLectures();
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
</style>
