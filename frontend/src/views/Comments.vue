<template>
  <div class="container mt-5">
    <h2>Add Comment</h2>
    <form @submit.prevent="addComment">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" v-model="newComment.name" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" v-model="newComment.description" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div class="mt-5">
      <h2>Comments</h2>
      <ul class="list-group">
        <li class="list-group-item" v-for="comment in comments" :key="comment.ID">
          <h5>{{ comment.Name }}</h5>
          <p>{{ comment.Description }}</p>
          <small class="text-muted">{{ comment.CreatedAt }}</small>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost/zaverecnyProjektBT/backend/public/api';

export default {
  name: "Comments",
  data() {
    return {
      newComment: {
        name: '',
        description: ''
      },
      comments: []
    };
  },
  methods: {
    async fetchComments() {
      try {
        const response = await axios.get('/comments');
        this.comments = response.data;
      } catch (error) {
        console.error('Error fetching comments:', error);
      }
    },
    async addComment() {
      try {
        const response = await axios.post('/create_comment', this.newComment);
        this.newComment.name = '';
        this.newComment.description = '';
        this.fetchComments();
      } catch (error) {
        console.error('Error adding comment:', error);
      }
    }
  },
  created() {
    this.fetchComments();
  }
};
</script>

<style scoped>
</style>
