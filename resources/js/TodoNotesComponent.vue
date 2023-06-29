<template>
    <div class="todo-notes-component">
      <!-- Form to add a new todo note -->
      <form @submit.prevent="addNote">
        <input type="text" v-model="newNoteTitle" placeholder="Enter a new note title" />
        <textarea v-model="newNoteDescription" placeholder="Enter a new note description"></textarea>
        <button type="submit">Add Note</button>
      </form>

      <!-- Display the list of todo notes -->
      <ul v-if="notes.length > 0">
        <li v-for="note in notes" :key="note.id">
          <h3>{{ note.title }}</h3>
          <p>{{ note.description }}</p>
          <button @click="deleteNote(note.id)">Delete</button>
        </li>
      </ul>
      <p v-else>No notes available.</p>

    </div>
  </template>
  
  <script>
  import { fetchNotes, addNote, deleteNote } from './api.js';
  
  export default {
    data() {
      return {
        notes: [], // Array to store todo notes
        newNoteTitle: '', // Variable to hold the new note title
        newNoteDescription: '', // Variable to hold the new note description
      };
    },
    mounted() {
      this.fetchNotes();
      this.getToken();
    },
    methods: {
        // Method to fetch the list of notes
        fetchNotes() {
            fetchNotes()
            .then(notes => {
                this.notes = notes;
            })
            .catch(error => {
                console.error(error);
            });
        },
        // Method to get the token from localStorage
        getToken() {
            const token = localStorage.getItem('token');
            if (token) {
                try {
                    const storedToken = JSON.parse(localStorage.getItem('token'));
                    console.log('token:', storedToken);
                    console.log('userId:', storedToken.tokenable_id);
                    return storedToken; // Return the token object
                } catch (error) {
                    console.error('Error parsing token:', error);
                }
            } else {
                return null;
            }
            
        },
        // Method to add a new note
        addNote() {
            const token = this.getToken();
            const newNote = {
                title: this.newNoteTitle,
                description: this.newNoteDescription,
                user_id: token.tokenable_id,
            };
    
            addNote(newNote)
            .then(note => {
                this.notes.push(note);
                this.newNoteTitle = '';
                this.newNoteDescription = '';
            })
            .catch(error => {
                console.error(error);
            });
        },
        // Method to delete a note
        deleteNote(noteId) {
            deleteNote(noteId)
            .then(() => {
                const noteIndex = this.notes.findIndex(note => note.id === noteId);
                if (noteIndex !== -1) {
                this.notes.splice(noteIndex, 1);
                }
            })
            .catch(error => {
                console.error(error);
            });
        },
    },
  };
  </script>