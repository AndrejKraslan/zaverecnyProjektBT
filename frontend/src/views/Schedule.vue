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
            :class="{ 'active': activeStage === stage.ID }"
            @click="selectStage(stage.ID)"
        >
          {{ stage.Name }} - {{ formatStageDate(stage.Date) }} (Room: {{ stage.Room }})
          <button v-if="isAdmin" @click.stop="deleteStage(stage.ID)" class="btn btn-danger btn-sm">Delete</button>
        </div>
        <div v-if="isAdmin">
          <button @click="showAddStageModal = true" class="btn btn-primary btn-sm">Add Stage</button>
        </div>
      </div>
      <div class="schedule-details">
        <div v-if="filteredEvents.length">
          <div
              v-for="event in filteredEvents"
              :key="event.ID"
              class="event"
              @click="selectEvent(event)"
          >
            <div class="time">
              {{ event.Start }} - {{ event.End }}
            </div>
            <div class="details">
              <h3>{{ event.Name }}</h3>
              <div v-if="selectedEvent && selectedEvent.ID === event.ID">
                <p>{{ event.Description }}</p>
                <div class="speakers" v-if="event.Speakers && event.Speakers.length">
                  <div
                      class="speaker"
                      v-for="speaker in event.Speakers"
                      :key="speaker.ID"
                      @click.stop="showSpeakerDetails(speaker)"
                  >
                    <img
                        :src="getImageUrl(speaker.Image)"
                        class="img-fluid"
                        :alt="speaker.Name"
                    />
                    <div class="speaker-details">
                      <h5>{{ speaker.Name }}</h5>
                      <p>{{ speaker.DescriptionShort }}</p>
                      <button v-if="isAdmin" @click.stop="removeSpeakerFromLecture(speaker.ID, event.ID)" class="btn btn-danger btn-sm">Remove</button>
                    </div>
                  </div>
                </div>
                <div v-if="isLoggedIn">
                  <div v-if="isUserRegistered(event.ID)">
                    <button @click="unregisterFromLecture(event.ID)" class="btn btn-warning btn-sm">Unregister</button>
                  </div>
                  <div v-else>
                    <button @click="registerForLecture(event.ID)" class="btn btn-success btn-sm">Register</button>
                  </div>
                </div>
                <div v-if="isAdmin">
                  <button @click.stop="editLecture(event)" class="btn btn-secondary btn-sm">Edit</button>
                  <button @click.stop="deleteLecture(event.ID)" class="btn btn-danger btn-sm">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <p>No lectures available for this stage.</p>
        </div>
        <div v-if="isAdmin">
          <button @click="showAddLectureModal = true" class="btn btn-primary btn-sm">Add Lecture</button>
        </div>
      </div>
    </div>
    <AddStageModal
        v-if="showAddStageModal"
        @close="showAddStageModal = false"
        @add-stage="addStage"
    />
    <AddLectureModal
        v-if="showAddLectureModal"
        :stages="stages"
        :speakers="speakers"
        @close="showAddLectureModal = false"
        @add-lecture="addLecture"
    />
    <EditLectureModal
        v-if="showEditLectureModal"
        :dialog="showEditLectureModal"
        :lecture="currentLecture"
        :speakers="speakers"
        :stages="stages"
        @update:dialog="showEditLectureModal = $event"
        @close="showEditLectureModal = false"
        @edit-lecture="updateLecture"
    />
    <SpeakerModal
        v-if="selectedSpeaker"
        :speaker="selectedSpeaker"
        @close="closeModal"
    />
    <div v-if="message" class="alert alert-danger">{{ message }}</div>
  </div>
</template>

<script>
import axios from '@/plugins/axios.js';
import SpeakerModal from '@/components/SpeakerModal.vue';
import AddStageModal from '@/components/AddStageModal.vue';
import AddLectureModal from '@/components/AddLectureModal.vue';
import EditLectureModal from '@/components/EditLectureModal.vue';

export default {
  data() {
    return {
      stages: [],
      events: [],
      speakers: [],
      speakersMap: {},
      activeStage: null,
      selectedEvent: null,
      selectedSpeaker: null,
      isAdmin: false,
      isLoggedIn: false,
      showAddStageModal: false,
      showAddLectureModal: false,
      showEditLectureModal: false,
      currentLecture: null,
      userLectures: [],
      message: null,
    };
  },
  computed: {
    filteredEvents() {
      return this.events.filter((event) => event.StageID === this.activeStage);
    },
  },
  methods: {
    fetchStages() {
      axios
          .get('/stages')
          .then((response) => {
            this.stages = response.data;
            if (this.stages.length > 0) {
              this.activeStage = this.stages[0].ID;
            }
          })
          .catch((error) => {
            console.error('Error fetching stages:', error);
          });
    },
    fetchLectures() {
      axios
          .get('/lectures')
          .then((response) => {
            this.events = response.data;
            // Map speakers to events
            this.events.forEach((event) => {
              event.Speakers = event.Speakers || []; // Ensure Speakers is an array
            });
          })
          .catch((error) => {
            console.error('Error fetching lectures:', error);
          });
    },
    fetchSpeakers() {
      axios
          .get('/speakers')
          .then((response) => {
            this.speakers = response.data;
          })
          .catch((error) => {
            console.error('Error fetching speakers:', error);
          });
    },
    fetchUserLectures() {
      axios
          .get('/users-has-lectures')
          .then((response) => {
            this.userLectures = response.data.map((lecture) => lecture.lecture_id); // Update to store only lecture IDs
          })
          .catch((error) => {
            console.error('Error fetching user lectures:', error);
          });
    },
    selectStage(stageId) {
      this.activeStage = stageId;
      this.selectedEvent = null;
    },
    selectEvent(event) {
      this.selectedEvent = this.selectedEvent && this.selectedEvent.ID === event.ID ? null : event;
    },
    showSpeakerDetails(speaker) {
      this.selectedSpeaker = speaker;
    },
    closeModal() {
      this.selectedSpeaker = null;
    },
    getImageUrl(imagePath) {
      return `http://localhost:8888/zaverecnyProjektBT/backend/public/${imagePath}`;
    },
    formatStageDate(datetime) {
      const date = new Date(datetime);
      return `${date.getDate()}.${date.getMonth() + 1}.${date.getFullYear()}`;
    },
    addStage(stage) {
      axios
          .post('/create_stage', stage)
          .then(() => {
            this.fetchStages();
          })
          .catch((error) => {
            console.error('Error adding stage:', error);
          });
    },
    deleteStage(id) {
      axios
          .delete(`/delete_stage/${id}`)
          .then(() => {
            this.fetchStages();
          })
          .catch((error) => {
            console.error('Error deleting stage:', error);
          });
    },
    addLecture(lecture) {
      const payload = {
        name: lecture.Name,
        description: lecture.Description,
        image: lecture.Image,
        capacity: lecture.Capacity,
        max_capacity: lecture.MaxCapacity,
        start: lecture.Start,
        end: lecture.End,
        stage_id: lecture.StageID
      };
      axios
          .post('/create_lecture', payload)
          .then((response) => {
            const lectureId = response.data.id;
            if (lecture.SpeakerID) {
              this.assignSpeakerToLecture(lecture.SpeakerID, lectureId);
            }
            this.fetchLectures();
            this.showAddLectureModal = false; // Zavrieť modal po úspešnom pridaní
          })
          .catch((error) => {
            console.error('Error adding lecture:', error);
            if (error.response) {
              this.message = error.response.data.message;
              setTimeout(() => { this.message = null; }, 5000); // Clear the message after 5 seconds
            }
          });
    },
    updateLecture(lecture) {
      const payload = {
        name: lecture.Name,
        description: lecture.Description,
        image: lecture.Image,
        capacity: lecture.Capacity,
        max_capacity: lecture.MaxCapacity,
        start: lecture.Start,
        end: lecture.End,
        stage_id: lecture.StageID
      };
      axios
          .put(`/update_lecture/${lecture.ID}`, payload)
          .then(() => {
            this.fetchLectures();
            if (lecture.SpeakerID) {
              this.assignSpeakerToLecture(lecture.SpeakerID, lecture.ID);
            }
            this.showEditLectureModal = false; // Zavrieť modal po úspešnej aktualizácii
          })
          .catch((error) => {
            console.error('Error updating lecture:', error);
            if (error.response) {
              this.message = error.response.data.message;
              setTimeout(() => { this.message = null; }, 5000); // Clear the message after 5 seconds
            }
          });
    },
    deleteLecture(id) {
      axios
          .delete(`/delete_lecture/${id}`)
          .then(() => {
            this.fetchLectures();
          })
          .catch((error) => {
            console.error('Error deleting lecture:', error);
          });
    },
    registerForLecture(lectureId) {
      const payload = {
        lecture_id: lectureId,
      };
      axios
          .post('/register_lecture_user', payload)
          .then(() => {
            console.log('Registered successfully');
            this.userLectures.push(lectureId); // Immediately update the userLectures array
          })
          .catch((error) => {
            console.error('Error registering for lecture:', error);
            if (error.response) {
              this.message = error.response.data.message;
              setTimeout(() => { this.message = null; }, 5000); // Clear the message after 5 seconds
            }
          });
    },
    unregisterFromLecture(lectureId) {
      const payload = {
        lecture_id: lectureId,
      };
      axios
          .post('/cancel_lecture_user', payload)
          .then(() => {
            console.log('Unregistered successfully');
            this.userLectures = this.userLectures.filter(id => id !== lectureId); // Update the userLectures array
          })
          .catch((error) => {
            console.error('Error unregistering from lecture:', error);
            if (error.response) {
              this.message = error.response.data.message;
              setTimeout(() => { this.message = null; }, 5000); // Clear the message after 5 seconds
            }
          });
    },
    isUserRegistered(lectureId) {
      return this.userLectures.includes(lectureId); // Check if lecture ID is in the userLectures array
    },
    assignSpeakerToLecture(speakerId, lectureId) {
      const payload = {
        speaker_id: speakerId,
        lecture_id: lectureId,
      };
      axios
          .post('/register_lecture_speaker', payload)
          .then(() => {
            console.log('Speaker assigned successfully');
            this.fetchLectures(); // Refresh lectures after assigning speaker
          })
          .catch((error) => {
            console.error('Error assigning speaker:', error);
            if (error.response) {
              this.message = error.response.data.message;
              setTimeout(() => {
                this.message = null;
              }, 5000); // Clear the message after 5 seconds
            }
          });
    },
    removeSpeakerFromLecture(speakerId, lectureId) {
      const payload = {
        speaker_id: speakerId,
        lecture_id: lectureId,
      };
      axios
          .post('/cancel_lecture_speaker', payload)
          .then(() => {
            console.log('Speaker removed successfully');
            this.fetchLectures(); // Refresh lectures after removing speaker
          })
          .catch((error) => {
            console.error('Error removing speaker:', error);
          });
    },
    editLecture(lecture) {
      this.currentLecture = { ...lecture }; // Ensure we pass a copy to avoid direct mutations
      this.showEditLectureModal = true;
    },
    checkAdminStatus() {
      axios
          .get('/user')
          .then((response) => {
            this.isAdmin = response.data.is_admin === 1;
            this.isLoggedIn = true; // Assuming that if we get a user response, the user is logged in
            this.fetchUserLectures(); // Fetch user lectures after confirming login
          })
          .catch((error) => {
            console.error('Error checking admin status:', error);
          });
    },
  },
  created() {
    this.fetchStages();
    this.fetchLectures();
    this.fetchSpeakers();
    this.checkAdminStatus();
  },
  components: {
    SpeakerModal,
    AddStageModal,
    AddLectureModal,
    EditLectureModal,
  },
};
</script>



<style scoped>
.schedule {
  font-family: Arial, sans-serif;
}

.header {
  background-color: #00535D;
  color: white;
  padding: 20px;
  text-align: left;
}

.content {
  display: flex;
}

.stage-selector {
  width: 25%;
  background-color: #062B34;
  padding: 20px;
}

.stage-selector div {
  padding: 15px;
  color: white;
  cursor: pointer;
  margin-bottom: 5px;
  font-size: 16px;
}

.stage-selector .active {
  background-color: #1abc9c;
  font-weight: bold;
}

.schedule-details {
  width: 75%;
  padding: 20px;
  background-color: #F7F7F7;
}

.event {
  margin-bottom: 20px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
  cursor: pointer;
}

.event .time {
  font-weight: bold;
  font-size: 16px;
  color: #333;
}

.event .details h3 {
  margin: 5px 0;
  font-size: 18px;
  color: #00535D;
}

.event .details p {
  color: #555;
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

.speaker-details h5 {
  margin: 0;
  font-size: 16px;
  color: #333;
}

.speaker-details p {
  margin: 0;
  color: #777;
  font-size: 14px;
}

.alert {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
}
</style>
