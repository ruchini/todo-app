<template>
    <div class="auth-component">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input type="text" v-model="loginData.email" placeholder="Email" />
        <input type="password" v-model="loginData.password" placeholder="Password" />
        <button type="submit">Login</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        loginData: {
          email: '',
          password: '',
        },
      };
    },
    methods: {
      login() {
        axios.post('/api/login', this.loginData)
          .then(response => {
            console.log('Login success:', response.data);
            const token = response.data.data; // Assuming the token is available in the response
            localStorage.setItem('token', JSON.stringify(token)); // Save the token in localStorage
            console.log('login token:', token);
            this.$emit('login-success'); // Emit login-success event
          })
          .catch(error => {
            console.error('Login error:', error.response ? error.response.data : error);
          });
      },
    },
  };
  </script>
  
  <style scoped>
  .auth-component {
    margin: 20px;
  }
  
  .auth-component form {
    margin-bottom: 10px;
  }
  
  .auth-component input {
    display: block;
    margin-bottom: 10px;
  }
  
  .auth-component button {
    display: block;
    margin-top: 10px;
  }
  </style>
  