require('./bootstrap');
import { createApp } from 'vue';
import LoginComponent from './LoginComponent.vue';
import TodoNotesComponent from './TodoNotesComponent.vue';

const IDLE_TIME_LIMIT = 300000; // 5 minutes in milliseconds

const app = createApp({
  data() {
    return {
      isLoggedIn: false,
    };
  },
  mounted() {
    // Check if token exists in local storage
    const token = localStorage.getItem('token');
    if (token) {
      // Token exists, load TodoNotesComponent
      this.loadTodoNotes();
    } else {
      // Token does not exist, load LoginComponent
      this.isLoggedIn = false;
    }

    // Start idle timer
    this.startIdleTimer();
  },
  methods: {
    loadTodoNotes() {
      this.isLoggedIn = true;
    },
    resetIdleTimer() {
        // Clear existing idle timer
        clearTimeout(this.idleTimer);
        // Start idle timer again
        this.startIdleTimer();
    },
    startIdleTimer() {
        // Set a timeout to clear token after idle time limit
        this.idleTimer = setTimeout(() => {
            // Clear token from local storage
            localStorage.removeItem('token');
            // Redirect to login component
            this.isLoggedIn = false;
        }, IDLE_TIME_LIMIT);
    },
  },
});

app.component('login-component', LoginComponent);
app.component('todo-notes-component', TodoNotesComponent);

const mountApp = () => {
  const appContainer = document.getElementById('app');
  if (appContainer) {
    app.mount('#app');
  }
};

mountApp();
