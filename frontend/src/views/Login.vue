<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div class="form-group">
        <input v-model="email" type="email" placeholder="Email" required />
      </div>
      <div class="form-group">
        <input v-model="password" type="password" placeholder="Password" required />
      </div>
      <button type="submit" class="btn-submit">Login</button>
    </form>

    <!-- Error Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" ref="errorToast">
        <div class="toast-header">
          <strong class="me-auto text-danger">Error</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          {{ errorMessage }}
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" ref="successModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">Login Successful</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            You have successfully logged in! Click OK to go to the home page.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="redirectToHome">OK</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/plugins/axios';
import { Toast, Modal } from 'bootstrap';

export default {
  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/login', {
          email: this.email,
          password: this.password,
        });
        console.log(response.data);
        localStorage.setItem('token', response.data.token);
        this.showSuccessModal();
      } catch (error) {
        if (error.response) {
          this.errorMessage = error.response.data.error;
          console.error('Response data:', error.response.data);
          console.error('Response status:', error.response.status);
          console.error('Response headers:', error.response.headers);
        } else if (error.request) {
          this.errorMessage = 'No response from server.';
          console.error('Request data:', error.request);
        } else {
          this.errorMessage = error.message;
          console.error('Error message:', error.message);
        }
        console.error('Error config:', error.config);

        const toastElement = this.$refs.errorToast;
        const toast = new Toast(toastElement);
        toast.show();
      }
    },
    showSuccessModal() {
      const modalElement = this.$refs.successModal;
      const modal = new Modal(modalElement);
      modal.show();
    },
    redirectToHome() {
      const modalElement = document.getElementById('successModal');
      const modal = Modal.getInstance(modalElement);
      modal.hide();
      this.$router.push({ name: 'speakers' });
      // Refresh the page
      window.location.reload();
    },
  },
};
</script>

<style scoped>
.login-container {
  max-width: 500px;
  margin: 0 auto;
  padding: 2rem;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h2 {
  margin-bottom: 1.5rem;
  color: #333;
  text-align: center;
}

.form-group {
  margin-bottom: 1.5rem;
}

input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 1rem;
  transition: border-color 0.3s;
}

input:focus {
  border-color: #7c4dff;
  outline: none;
}

.btn-submit {
  width: 100%;
  padding: 0.75rem;
  border: none;
  border-radius: 4px;
  background-color: #7c4dff;
  color: #fff;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-submit:hover {
  background-color: #6a4eb7;
}

.toast-container {
  position: absolute;
  top: 50%;
  left: 50%;
  margin-right: -50%;
  transform: translate(-50%, -50%);
}
</style>
