<template>
  <div class="container mt-5" v-if="isAdmin">
    <h2>Zoznam registrovaných účastníkov</h2>
    <input type="text" v-model="searchTerm" placeholder="Vyhľadávanie..." class="form-control mb-3" />
    <table class="table table-bordered mt-3">
      <thead>
      <tr>
        <th>ID</th>
        <th>Meno</th>
        <th>Priezvisko</th>
        <th>Email</th>
        <th>Konferencia</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="attendee in filteredAttendees" :key="attendee.ID">
        <td>{{ attendee.ID }}</td>
        <td>{{ attendee.Meno }}</td>
        <td>{{ attendee.Priezvisko }}</td>
        <td>{{ attendee.Email }}</td>
        <td>{{ attendee.ConferenceName }}</td>
      </tr>
      </tbody>
    </table>
  </div>
  <div v-else>
    <p>Access Denied</p>
  </div>
</template>

<script>
import axios from '@/plugins/axios.js';

export default {
  name: 'AttendeeList',
  data() {
    return {
      attendees: [],
      searchTerm: '',
      isAdmin: false
    };
  },
  created() {
    this.checkAdminStatus();
  },
  computed: {
    filteredAttendees() {
      return this.attendees.filter(attendee => {
        return (
            (attendee.Meno && attendee.Meno.toLowerCase().includes(this.searchTerm.toLowerCase())) ||
            (attendee.Priezvisko && attendee.Priezvisko.toLowerCase().includes(this.searchTerm.toLowerCase())) ||
            (attendee.Email && attendee.Email.toLowerCase().includes(this.searchTerm.toLowerCase())) ||
            (attendee.ConferenceName && attendee.ConferenceName.toLowerCase().includes(this.searchTerm.toLowerCase()))
        );
      });
    }
  },
  methods: {
    async fetchAttendees() {
      try {
        const registrationsResponse = await axios.get('/users-has-lectures');
        const usersResponse = await axios.get('/users');
        const lecturesResponse = await axios.get('/lectures');

        const usersMap = {};
        usersResponse.data.forEach(user => {
          usersMap[user.ID] = user;
        });

        const lecturesMap = {};
        lecturesResponse.data.forEach(lecture => {
          lecturesMap[lecture.ID] = lecture.Name;
        });

        const attendees = registrationsResponse.data.map(registration => {
          const user = usersMap[registration.user];
          const lectureName = lecturesMap[registration.lecture];
          return {
            ID: registration.ID,
            Meno: user ? user.Meno : '',
            Priezvisko: user ? user.Priezvisko : '',
            Email: user ? user.Email : '',
            ConferenceName: lectureName ? lectureName : 'N/A',
          };
        });

        this.attendees = attendees;
      } catch (error) {
        console.error('Error fetching attendees:', error);
      }
    },
    async checkAdminStatus() {
      try {
        const response = await axios.get('/user');
        this.isAdmin = response.data.is_admin === 1;
        if (this.isAdmin) {
          this.fetchAttendees();
        }
      } catch (error) {
        console.error('Error checking admin status:', error);
      }
    }
  }
};
</script>

<style scoped>
</style>
